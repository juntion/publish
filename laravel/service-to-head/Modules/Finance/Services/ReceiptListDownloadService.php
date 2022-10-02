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
use Modules\ERP\Repositories\InstockShippingRepository;
use Modules\Finance\Entities\PaymentReceipt;
use Modules\Finance\Entities\Traits\CompanyNameTrait;
use Modules\Finance\Http\Requests\Receipt\ReceiptDownloadListRequest;
use Modules\Finance\Services\Traits\DownloadServiceTrait;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReceiptListDownloadService implements WithTitle, WithEvents
{
    use Exportable, DownloadServiceTrait,CompanyNameTrait;

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
    protected $instockShippingRepository;

    protected $headers = [
        '录入时间','到款时间', '到款时间(CST)', '到款编号', '到款来源', '到款流水号', '到款方式', '到款主体', '到款币种', '到款金额', '财务手续费', '销售手续费', '币种转换增溢', '币种转换亏损',
        '客户G编号', '客户编号', '客户邮箱', '客户名称', '到款备注', 'FS单号', '认领人', '认领时间', '认领备注', '审核人',
        '美东主体用款金额', '德国主体用款金额', '澳洲主体用款金额', '宇轩主体用款金额', '新加坡主体用款金额', '俄罗斯主体用款金额',
        '到款驳回G编号', '驳回次数', '驳回原因'
    ];

    protected const match = [
        0 => '不匹配',
        1 => '匹配'
    ];

    protected const createForm = [
        0 => '手动新增',
        1 => '表格导入',
        2 => '自动导入',
        3 => '客户垫付',
    ];

    protected const applyStatus = [
        0 => '未认领',
        1 => '申请中',
        2 => '已认领',
    ];

    protected const checkStatus = [
        0 => '待审核',
        1 => '审核通过',
        2 => '审核驳回',
    ];

    public function __construct(Admin $admin, AdminService $service, array $requestData, InstockShippingRepository $instockShippingRepository)
    {
        $filter = $requestData['filter'] ?? [];
        $sort = $requestData['sort'] ?? [];
        $this->request = new ReceiptDownloadListRequest();
        if ($admin->hasPermissionTo('finance.receipt.receipts.all')){
            $this->admins = [];
            $this->permissionType = 1;
        } else if ($admin->hasPermissionTo('finance.receipt.receipts.group')){
            $this->admins = $service->getGroupAdmins($admin)->pluck('uuid')->all();
            $this->permissionType = 2;
        } else {
            $this->permissionType = 3;
            $this->admins = $admin->uuid;
        }
        $this->filter = $filter;
        $this->sort = $sort;
        if($filter && isset($filter['key']) && $filter['key']){ // 走es查询逻辑
            $this->key =  $filter['key'];
            $this->type = 2;
        } else {
            $this->type = 1;
        }
        $this->lastColumn = $this->getLetterColumn(count($this->headers)-1);
        $this->instockShippingRepository = $instockShippingRepository;
    }

    public function title(): string
    {
        return '到款列表.xlsx';
    }

    protected function headLine(): int
    {
        return 3;
    }


    protected function setTitles(Worksheet $workSheet, $lastColumn)
    {
        $workSheet->getStyle("A1:{$lastColumn}1")->getFont();
        $workSheet->mergeCells("A1:{$lastColumn}1");
        $workSheet->setCellValue("A1", '深圳市宇轩网络技术有限公司');

        $workSheet->getStyle("A2:{$lastColumn}2")->getFont();
        $workSheet->mergeCells("A2:{$lastColumn}2");
        $workSheet->setCellValue("A2", '真实到款统计表');
    }

    public function registerEvents(): array
    {
        return [
            // 数据填充
            BeforeSheet::class => function (BeforeSheet $event) {
                $workSheet = $event->getSheet()->getDelegate();

                $this->setTitles($workSheet,$this->lastColumn);

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
            AfterSheet::class => function (AfterSheet $event) {
                $workSheet = $event->sheet->getDelegate();
                $length = $this->headLine() + $this->count;
                for ($i = $this->headLine(); $i <= $length; $i++) {
                    $workSheet->getRowDimension($i)->setRowHeight(30);
                }
                $workSheet->getStyle('A1:' . $this->lastColumn . $length)->getAlignment()->setWrapText(true)->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $workSheet->getStyle('A' . ($this->headLine() + 1) . ':' . $this->lastColumn . $length)->getFont()->setName('微软雅黑')->setSize(9);
                // 边框
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000'],
                        ],
                    ],
                ];
                $workSheet->getStyle('A1' . ':' . $this->lastColumn . $length)->applyFromArray($styleArray);

                // 列宽
                for ($i = 0; $i < count($this->headers); $i ++) {
                    $workSheet->getColumnDimension($this->getLetterColumn($i))->setWidth(30);
                }
            }
        ];
    }

    protected function getQueryBuilder()
    {
        if($this->type == 2) { // es
            $search = $this->getEsQuery();
            $model = $this->getListBySearch($search);
        } else {
            $model = PaymentReceipt::query();
            $model = $this->apply($model);
            $model = $this->getPermissionTypeQueryBuilder($model);
        }
        return $model;
    }

    protected function getPermissionTypeQueryBuilder(Builder $builder)
    {
        switch ($this->permissionType) {
            case 1:
                return $builder->withTrashed()->with('application')
                    ->with(['claims' => function($q1){
                        $q1->where('apply_type', 1)->where('check_status', 2);
                    }])
                    ->with('details')
                    ->orderBy('number', "DESC");
                break;
            case 2:
                return $builder->withTrashed()->where(function ($q) {
                    $q->whereIn('claim_uuid', $this->admins)->orWhere('claim_status', '!=', 2);
                })
                    ->with('application')
                    ->with(['claims' => function($q1){
                        $q1->where('apply_type', 1)->where('check_status', 2);
                    }])
                    ->with('details')
                    ->orderBy('number', "DESC");
                break;
            case 3:
                return $builder->withTrashed()->where(function ($q) {
                    $q->where('claim_uuid', $this->admins)->orWhere('claim_status', '!=', 2);
                })
                    ->with('application')
                    ->with(['claims' => function($q1){
                        $q1->where('apply_type', 1)->where('check_status', 2);
                    }])
                    ->with('details')
                    ->orderBy('number', "DESC");
                break;
        }
    }

    protected function chunkExportBuilder(Builder $builder, $workSheet, $currentLine)
    {
        $builder->chunk(100, function ($models)use(&$workSheet, &$currentLine){
            $this->writeIntoExcel($models, $workSheet, $currentLine);
        });
    }


    protected function chunkExportEs($builder, $workSheet, $currentLine)
    {
        $this->writeIntoExcel($builder, $workSheet, $currentLine);
        if ($this->currentPage < $this->totalPage) {
            for ($i= 2; $i <= $this->totalPage; $i++) {
                \request()->query->set('page', $i);
                $list = $this->getListBySearch($this->esQuery);
                $this->writeIntoExcel($list, $workSheet, $currentLine);
            }
        }
    }

    protected function getEsQuery()
    {
        $key = strtolower($this->key);
        $must = [
            [
                'match_phrase' => [
                    'number' => $key // 到款编号
                ]
            ],
            [
                'prefix' => [
                    'number' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'transaction_serial_number' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'customer_company_number' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'customer_company_name' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'customer_number' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'payer_name' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'payer_email' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'order_number' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'payment_remark' => $key
                ]
            ]
        ];
        if ((is_numeric($key) && $key < 21474836)) {
            $must[] = [
                'term' => [
                    'amount' =>  $key * 100
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
                'bool' => [
                    'should' => [
                        [
                            'terms' => [
                                'claim_uuid' => $this->admins
                            ]
                        ],
                        [
                            'term' => [
                                'claim_status' => 0
                            ]
                        ]
                    ]
                ]
            ];
        } elseif ($this->permissionType == 3) {
            $query['bool']['must'][] = [
                'bool' => [
                    'should' => [
                        [
                            'term' => [
                                'claim_uuid' => $this->admins
                            ]
                        ],
                        [
                            'term' => [
                                'claim_status' => 0
                            ]
                        ]
                    ]
                ]
            ];
        }
        $query = json_encode($query);
        $this->esQuery = $query;
        return $query;
    }

    protected function getListBySearch($search)
    {
        $model = PaymentReceipt::search($search)->orderBy('created_at', $this->sort['created_at'])->paginate(100);
        $this->totalPage = $model->lastPage();
        $model = $model->getCollection()
            ->load('application')
            ->load(['claims' => function($q1){
                $q1->where('apply_type', 1)->where('check_status', 2);
            }])
            ->load('details');
        return $model;
    }

    protected function writeIntoExcel($models, &$workSheet, &$currentLine)
    {
        foreach ($models as $model) {
            $column = 0;
            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, Carbon::parse($model->created_at)->toJSON()); // 录入时间
            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $model->payment_time ? Carbon::parse($model->payment_time)->toJSON() : ""); // 到款时间

            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $model->payment_time ? Carbon::createFromTimeString($model->payment_time, 'UTC')->tz('CST')->toDateTimeString() : ""); // 到款时间(CST)

            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $model->number);

            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, self::createForm[$model->create_from]); // 到款来源

            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $model->transaction_serial_number); // 流水号

            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $model->payment_method_name); // 到款方式

            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $model->company_name); // 到款主体

            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $model->currency); // 到款币种

            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, round($model->amount/100, 2)); // 到款金额

            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, round($model->fee_fs/100,2)); // 财务手续费
            $fee = $model->fee - $model->fee_fs;
            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $fee ? round($fee/100,2) : 0); // 销售手续费


            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $model->float >= 0 ? round($model->float/100, 2) : 0); // 币种转换增溢
            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $model->float < 0 ? round($model->float/100, 2) : 0); // 币种转换亏损

            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $model->customer_company_number); // G编号
            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $model->customer_number); // 编号
            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $model->payer_email); // 邮箱
            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $model->customer_company_name); // 名称
            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $model->payment_remark); // 备注


            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $model->order_number); // FS 单号


            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $model->claim_name); // 认领人
            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $model->claim_time ? Carbon::parse($model->claim_time)->toJSON() : ""); // 认领时间
            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $model->application ? $model->application->apply_remark : ""); // 认领备注
            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $model->application ? $model->application->check_name : ""); // 审核人

            // todo

            $US = $Germany = $Australia = $Yx = $Singapore = $Russia = 0;

            $details = $model->details;

            foreach ($details as $detail) {
                $shipping = $this->instockShippingRepository->getOrderInfoByProductsInstockId($detail->order_id);
                $companyId = $shipping ? $this->getCompanyId($shipping) : 10;
                switch ($companyId) {
                    case 1: // 德国
                        $Germany += $detail->receipt_use;
                        break;
                    case 3: // 美国
                        $US += $detail->receipt_use;
                        break;
                    case 4:
                        $Australia += $detail->receipt_use;
                        break;
                    case 6:
                        $Singapore += $detail->receipt_use;
                        break;
                    case 7:
                        $Russia += $detail->receipt_use;
                        break;
                    default:
                        $Yx += $detail->receipt_use;
                }
            }


            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, round($US/100, 2)); //

            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, round($Germany/100, 2)); //

            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, round($Australia/100, 2)); //

            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, round($Yx/100, 2)); //

            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, round($Singapore/100, 2)); //

            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, round($Russia/100, 2)); //


            // 驳回相关
            $claims = $model->claims;

            $companyNumber = $claims->pluck('customer_company_number')->all();
            $checkRemark = $claims->pluck('check_remark')->all();
            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, implode("\r", $companyNumber)); //
            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, count($companyNumber)); //
            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, implode("\r", $checkRemark)); //


            $currentLine++;
            $this->count++;
        }
    }
}
