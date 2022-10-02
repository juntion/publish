<?php


namespace Modules\Finance\Services;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Modules\Admin\Contracts\AdminService;
use Modules\Admin\Entities\Admin;
use Modules\Base\Contracts\Company\CompanyRepository;
use Modules\ERP\Contracts\CustomerCompanyRepository;
use Modules\ERP\Contracts\CustomerRepository;
use Modules\ERP\Contracts\InstockShippingRepository;
use Modules\ERP\Contracts\OrderCustomerCompanyService;
use Modules\Finance\Entities\PaymentVoucher;
use Modules\Finance\Entities\Traits\CompanyNameTrait;
use Modules\Finance\Entities\Traits\CustomerTrait;
use Modules\Finance\Http\Requests\Voucher\VoucherListDownloadRequest;
use Modules\Finance\Services\Traits\DownloadServiceTrait;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class VoucherListDownloadService implements WithTitle, WithEvents
{
    use Exportable, DownloadServiceTrait, CompanyNameTrait, CustomerTrait;

    protected $request;
    protected $type;
    protected $totalPage = 1;
    protected $currentPage = 1;
    protected $permissionType;
    protected $key;
    protected $filter;
    protected $sort;
    protected $admins;
    protected $lastColumn;
    protected $count = 1;
    protected $esQuery;

    protected $companyService;
    protected $customerRepository;
    protected $companyRepository;
    protected $instockShippingRepository;
    protected $orderCompanyRepository;

    protected $headers
        = [
            '凭证编号', '申请时间', '申请人', '订单编号', '发货主体', '到款编号', '凭证类型', '到款主体', '客户公司编号', '客户编号',
            '客户名称', '邮箱', '订单币制', '订单金额', '到款支出金额', '返还金额', '备注'
        ];

    protected const type
        = [
            1 => '真实到款',
            2 => '账期额度',
            3 => '临时额度',
            4 => '部分额度(存款优先)'
        ];


    public function __construct(
        Admin $admin,
        AdminService $service,
        array $requestData,
        OrderCustomerCompanyService $companyService,
        CustomerRepository $customerRepository,
        CustomerCompanyRepository $companyRepository,
        InstockShippingRepository $instockShippingRepository,
        CompanyRepository $orderCompanyRepository
    )
    {
        $filter = $requestData['filter'] ?? [];
        $sort = $requestData['sort'] ?? [];
        $this->request = new VoucherListDownloadRequest();
        if ($admin->hasPermissionTo('finance.receipt.receipts.all')) {
            $this->admins = [];
            $this->permissionType = 1;
        } else {
            if ($admin->hasPermissionTo('finance.receipt.receipts.group')) {
                $this->admins = $service->getGroupAdmins($admin)->pluck('uuid')->all();
                $this->permissionType = 2;
            } else {
                $this->permissionType = 3;
                $this->admins = $admin->uuid;
            }
        }
        $this->filter = $filter;
        $this->sort = $sort;
        if ($filter && isset($filter['key']) && $filter['key']) { // 走es查询逻辑
            $this->key = $filter['key'];
            $this->type = 2;
        } else {
            $this->type = 1;
        }
        $this->lastColumn = $this->getLetterColumn(count($this->headers) - 1);
        $this->companyService = $companyService;
        $this->customerRepository = $customerRepository;
        $this->companyRepository = $companyRepository;
        $this->instockShippingRepository = $instockShippingRepository;
        $this->orderCompanyRepository = $orderCompanyRepository;
    }

    public function title(): string
    {
        return '凭证列表.xlsx';
    }

    protected function headLine(): int
    {
        return 1;
    }

    public function registerEvents(): array
    {
        return [
            // 数据填充
            BeforeSheet::class => function (BeforeSheet $event) {
                $workSheet = $event->getSheet()->getDelegate();

                $this->setHeaders($workSheet, $this->lastColumn);
                // 正文
                $currentLine = $this->headLine() + 1;
                $builder = $this->getQueryBuilder();

                if ($builder instanceof Builder) {
                    $this->chunkExportBuilder($builder, $workSheet, $currentLine);
                } else {
                    $this->chunkExportEs($builder, $workSheet, $currentLine);
                }
            },

            // 样式调整
            AfterSheet::class  => function (AfterSheet $event) {
                $workSheet = $event->sheet->getDelegate();
                $length = $this->headLine() + $this->count;
                for ($i = $this->headLine(); $i <= $length; $i++) {
                    $workSheet->getRowDimension($i)->setRowHeight(30);
                }
                $workSheet->getStyle('A1:'.$this->lastColumn.$length)->getAlignment()->setWrapText(true)->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $workSheet->getStyle('A'.($this->headLine() + 1).':'.$this->lastColumn.$length)->getFont()->setName('微软雅黑')->setSize(9);
                // 边框
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color'       => ['argb' => '000'],
                        ],
                    ],
                ];
                $workSheet->getStyle('A'.$this->headLine().':'.$this->lastColumn.$length)->applyFromArray($styleArray);

                // 列宽
                for ($i = 0; $i < count($this->headers); $i++) {
                    $workSheet->getColumnDimension($this->getLetterColumn($i))->setWidth(25);
                }
            }
        ];
    }

    protected function getQueryBuilder()
    {
        if ($this->type == 2) { // es
            $search = $this->getEsQuery();
            $model = $this->getListBySearch($search);
        } else {
            $model = PaymentVoucher::query();
            $model = $this->apply($model);
            $model = $this->getPermissionTypeQueryBuilder($model);
        }
        return $model;
    }

    protected function getPermissionTypeQueryBuilder(Builder $builder)
    {
        switch ($this->permissionType) {
            case 1:
                return $builder->with('receiptsToVoucher')
                    ->with(['receiptsToVoucher' => function($query){
                        $query->with('receipt');
                    }, 'details'])
                    ->orderBy('number', "DESC");
                break;
            case 2:
                return $builder->whereIn('creator_uuid', $this->admins)
                    ->with(['receiptsToVoucher' => function($query){
                        $query->with('receipt');
                    }, 'details'])
                    ->orderBy('number', "DESC");
                break;
            case 3:
                return $builder->where('creator_uuid', $this->admins)
                    ->with(['receiptsToVoucher' => function($query){
                        $query->with('receipt');
                    }, 'details'])
                    ->orderBy('number', "DESC");
                break;
        }
    }

    protected function chunkExportBuilder(Builder $builder, $workSheet, $currentLine)
    {
        $builder->chunk(100, function ($models) use (&$workSheet, &$currentLine) {
            $this->writeIntoExcel($models, $workSheet, $currentLine);
        });
    }


    protected function chunkExportEs($builder, $workSheet, $currentLine)
    {
        $this->writeIntoExcel($builder, $workSheet, $currentLine);
        if ($this->currentPage < $this->totalPage) {
            for ($i = 2; $i <= $this->totalPage; $i++) {
                \request()->query->set('page', $i);
                $list = $this->getListBySearch($this->esQuery);
                $this->writeIntoExcel($list, $workSheet, $currentLine);
            }
        }
    }

    protected function getEsQuery()
    {
        $key = strtolower($this->key);
        $must =  [
            [
                'match_phrase' => [
                    'number' => $key // 到款编号
                ]
            ],
            [
                'prefix' => [
                    'number' => $key // 到款编号
                ]
            ],
            [
                'match_phrase' => [
                    'order_number' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'remark' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'customer_number' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'company_number' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'customer_email' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'DK_number' => $key
                ]
            ]
        ];
        if (is_numeric($key) && $key < 21474836 ) {
            $must[] =
                [
                    'term' => [
                        'usable' =>  $key * 100// 到款金额 防止大于 2^32-1
                    ]
                ];
        }
        $query['bool']['must'][]= [
            'bool' => [
                'should' => $must
            ]
        ];
        if ($this->permissionType == 2) { // 同组
            $query['bool']['must'][] = [
                'terms' => [
                    'creator_uuid' => $this->admins
                ]
            ];
        } elseif ($this->permissionType == 3) {
            $query['bool']['must'][] =
                [
                    'term' => [
                        'creator_uuid' => $this->admins
                    ]
                ];
        }

        $query = json_encode($query);
        $this->esQuery = $query;
        return $query;
    }

    protected function getListBySearch($search)
    {
        $model = PaymentVoucher::search($search)->orderBy('created_at', $this->sort['created_at'])->paginate(100);
        $this->totalPage = $model->lastPage();
        $model = $model->getCollection()->load(['receiptsToVoucher' => function($q){
            $q->with('receipt');
        }, 'details']);
        return $model;
    }

    protected function writeIntoExcel($models, &$workSheet, &$currentLine)
    {
        foreach ($models as $model) {
            $orderNumber = $model->order_number;

            if ($model->customer_number) {
                $customer_number = $model->customer_number;
                $company_number = $model->customer_company_number;
                $company_name = $model->customer_company_name;
                $customer_email = "";
                $customer = $this->getCustomerInfoByPool($model->customer_number);
                if($customer) {
                    $customer_email = $customer->customers_email_address;
                }
            } else {
                // 获取客户编号
                $orderInfo = $this->companyService->getCustomerAndCompanyInfoByOrderNumber($orderNumber);

                $customerNumber = $orderInfo->customerNumber;
                if (empty($customerNumber)) {
                    $customer_number = "";
                    $company_number = "";
                    $customer_email = "";
                    $company_name = "";
                } else {
                    $customerData = $this->getCustomerFormPool($customerNumber, $orderInfo);

                    // 获取客户信息
                    $customer_number = $customerData['customer_number'];
                    $company_number = $customerData['company_number'];
                    $customer_email = $customerData['customer_email'];
                    $company_name = $customerData['company_name'];
                }
            }

            $orderCompanyName = "";

            $details = $model->details->first();

            if ($details) {
                $productsInstockId = $details->order_id;
                $productsInstock = $this->instockShippingRepository->getOrderInfoByProductsInstockId($productsInstockId);
            } else {
                $productsInstock = $this->instockShippingRepository->getOrderInfoByOrderNumber($model->order_number);
            }

            if(!is_null($productsInstock)) {
                $orderCompanyName = $this->getCompanyName($productsInstock);
            }

            $column = 0;
            $workSheet->setCellValue($this->getLetterColumn($column++).$currentLine, $model->number);
            $workSheet->setCellValue($this->getLetterColumn($column++).$currentLine, Carbon::parse($model->created_at)->toJSON());
            $workSheet->setCellValue($this->getLetterColumn($column++).$currentLine, $model->creator_name);
            $workSheet->setCellValue($this->getLetterColumn($column++).$currentLine, $model->order_number);
            $workSheet->setCellValue($this->getLetterColumn($column++).$currentLine, $orderCompanyName);
            $DK = $model->receiptsToVoucher ? implode("\r", $model->receiptsToVoucher->pluck('receipt_number')->all()) : "";
            $workSheet->setCellValue($this->getLetterColumn($column++).$currentLine, $DK); // DK 编号
            $workSheet->setCellValue($this->getLetterColumn($column++).$currentLine, self::type[$model->type]);
            $receiptCompanyName = $model->receiptsToVoucher->isNotEmpty() ? $model->receiptsToVoucher->first()->receipt->company_name : "";
            $workSheet->setCellValue($this->getLetterColumn($column++).$currentLine, $receiptCompanyName);
            $workSheet->setCellValue($this->getLetterColumn($column++).$currentLine, $company_number);
            $workSheet->setCellValue($this->getLetterColumn($column++).$currentLine, $customer_number);
            $workSheet->setCellValue($this->getLetterColumn($column++).$currentLine, $company_name);
            $workSheet->setCellValue($this->getLetterColumn($column++).$currentLine, $customer_email); // 邮箱
            $workSheet->setCellValue($this->getLetterColumn($column++).$currentLine, $model->currency);
            $workSheet->setCellValue($this->getLetterColumn($column++).$currentLine, round($model->usable/100, 2));
            $workSheet->setCellValue($this->getLetterColumn($column++).$currentLine, round($model->used/100, 2));
            $workSheet->setCellValue($this->getLetterColumn($column++).$currentLine, round(($model->usable - $model->used)/100, 2));
            $workSheet->setCellValue($this->getLetterColumn($column++).$currentLine, $model->remark);
            $currentLine++;
            $this->count++;
        }
    }
}
