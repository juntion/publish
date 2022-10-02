<?php

namespace Modules\Finance\Services;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Modules\Admin\Contracts\AdminService;
use Modules\Finance\Contracts\InvoiceRepository;
use Modules\Finance\Entities\Invoice;

class ClearDownloadService implements WithTitle, WithEvents
{
    use Exportable;

    const INVOICE_TYPE = [
        1 => '货物发票',
        2 => '服务发票',
        3 => '其他补款发票',
    ];
    const INVOICE_STATUS = [
        0 => '正常',
        1 => '作废',
        2 => '重开',
    ];
    const CLEAR_STATUS = [
        1 => '银行回款',
        2 => '现金折扣',
        3 => '发票作废',
        4 => '坏账申请',
        5 => '取消补款',
        6 => '商业折让',
        7 => '退货退款',
        8 => '退货不退款',
        9 => '退款不退货',
    ];
    protected $headers = [
        '订单编号', '作业日期', '中国CST作业时间', '发票号', '发票类型', '发票状态', '票面币种', '票面金额', '发票备注', '清账类型', '清账类型编号',
        '清账备注', '清账币种-原币', '清账金额-原币', '清账币种-票面币', '清账金额-票面币', '未清余额币种-票面币', '未清余额-票面币',
        '账期时间', '逾期风险'
    ];

    protected $deadline;//截止日期
    protected $request;
    protected $lastColumn;//最后一列
    protected $invoiceService;
    protected $invoiceRepository;
    protected $user;
    protected $adminService;
    protected $count = 0;

    public function __construct(InvoiceService $invoiceService, InvoiceRepository $invoiceRepository, AdminService $adminService, $user, $request)
    {
        $this->invoiceService = $invoiceService;
        $this->invoiceRepository = $invoiceRepository;
        $this->adminService = $adminService;
        $this->user = $user;
        $this->request = $request;
        $this->deadline = $request['deadline'];
        $this->lastColumn = $this->getLetterColumn(count($this->headers)-1);
    }

    public function title(): string
    {
        return '清账表.xlsx';
    }

    protected function headLine(): int
    {
        return 1;
    }

    /**
     * 获取发票对象
     * @return \Illuminate\Database\Eloquent\Builder|Invoice
     */
    public function getClearInvoice()
    {
        $user = $this->user;
        if ($user->hasPermissionTo('finance.invoice.invoices.all')){
            $admins = [];
            $type = 1;
        } else if ($user->hasPermissionTo('finance.invoice.invoices.group')){
            $admins = $this->adminService->getGroupAdmins($user)->pluck('uuid')->all();
            $type = 2;
        } else {
            $admins = $user->uuid;
            $type = 3;
        }
        $invoices = $this->invoiceService->getClearInvoice($this->request, $type, $admins);
        $dateEnd = $this->deadline;
        $sort = ($this->request)['sort']['created_at']??'desc';
        $invoices = $invoices
            ->with([
                'clearAccounts' => function ($query) use($dateEnd) {
                    $query->whereDate('created_at', '<=', $dateEnd)->orderBy('created_at', 'asc')->orderBy('flag', 'desc');
                }
            ])
            ->orderBy('created_at', $sort)->orderBy('number', 'asc');

        return $invoices;
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

                $styleArray['font']['color'] = ['argb'=>"fffd0707"];
                $invoices = $this->getClearInvoice();
                $invoices->chunk(100, function ($data) use(&$workSheet, &$currentLine, $styleArray) {
                    foreach ($data as $demand) {
                        $column = 0;
                        $productsInstockRes = $this->invoiceRepository->getErpProductsInstockShippingData($demand->relate_id, $demand->relate_type)->toArray();
                        $invoiceOrderNumber = [];
                        foreach ($productsInstockRes as $val) {
                            $invoiceOrderNumber[] = $val['order_number'] ?? $val['order_invoice'];
                        }
                        $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, join(',', $invoiceOrderNumber));
                        $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, Carbon::parse($demand->created_at)->toJSON());
                        $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, Carbon::createFromFormat('Y-m-d H:i:s',$demand->created_at, config('app.timezone'))->tz('CST')->toDateTimeString());
                        $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $demand->number);
                        $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, self::INVOICE_TYPE[$demand->type]);
                        $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, self::INVOICE_STATUS[$demand->to_void]);
                        $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $demand->currency);
                        $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, round($demand->amount/100, 2));
                        $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $demand->remark);
                        $workSheet->setCellValue('Q' . $currentLine, $demand->currency);
                        $workSheet->setCellValue('R' . $currentLine, round($demand->amount/100, 2));
                        $this->count++;
                        $currentLine++;

                        foreach ($demand->clearAccounts as $account) {
                            $column = 0;
                            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $account->order_number);
                            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, Carbon::parse($account->created_at)->toJSON());
                            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, Carbon::createFromFormat('Y-m-d H:i:s',$account->created_at, config('app.timezone'))->tz('CST')->toDateTimeString());
                            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $demand->number);
                            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, self::INVOICE_TYPE[$demand->type]);
                            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, self::INVOICE_STATUS[$demand->to_void]);
                            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $demand->currency);
                            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, round($demand->amount/100, 2));
                            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $demand->remark);
                            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, self::CLEAR_STATUS[$account->type]);
                            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $account->income_number);
                            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $account->remark);
                            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $account->income_currency);
                            $incomeClearCol = $this->getLetterColumn($column++);
                            $workSheet->setCellValue($incomeClearCol . $currentLine, round($account->income_clear/100, 2));
                            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $account->expend_currency);
                            $expendClearCol = $this->getLetterColumn($column++);
                            $workSheet->setCellValue($expendClearCol . $currentLine, round($account->expend_clear/100, 2));
                            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $account->expend_currency);
                            $expendUnclearCol = $this->getLetterColumn($column++);
                            $workSheet->setCellValue($expendUnclearCol . $currentLine, round($account->expend_unclear/100, 2));
                            $AccountsDays = $account->expend_unclear > 0 ? abs(round((strtotime($this->deadline) - strtotime($demand->created_at)) / 86400)) : '';
                            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $AccountsDays);
                            $risk = $this->invoiceService->getInvoiceRisk($demand->created_at, $this->deadline, $demand->account_days);
                            $risk = $this->invoiceService::RISK_CN[$risk];
                            $workSheet->setCellValue($this->getLetterColumn($column++) . $currentLine, $risk);

                            if ($account->flag == 0) {
                                $workSheet->getStyle("{$incomeClearCol}{$currentLine}")->applyFromArray($styleArray);
                                $workSheet->getStyle("{$expendClearCol}{$currentLine}")->applyFromArray($styleArray);
                            }
                            if ($account->expend_unclear < 0) {
                                $workSheet->getStyle("{$expendUnclearCol}{$currentLine}")->applyFromArray($styleArray);
                            }
                            $this->count++;
                            $currentLine++;
                        }
                        $this->count++;
                        $currentLine++;
                    }
                });;
            },

            // 样式调整
            AfterSheet::class => function (AfterSheet $event) {
                $workSheet = $event->sheet->getDelegate();
                $length = $this->headLine() + $this->count;
                for ($i = $this->headLine(); $i <= $length; $i++) {
                    $workSheet->getRowDimension($i)->setRowHeight(30);
                }
                $workSheet->getStyle('A1:' . $this->lastColumn . $length)->getAlignment()->setHorizontal('center')->setVertical('center');
                $workSheet->getStyle('A1:' . $this->lastColumn . $length)->getFont()->setName('微软雅黑')->setSize(9);
                // 边框
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000'],
                        ],
                    ],
                ];
                $workSheet->getStyle('A' . $this->headLine() . ':' . $this->lastColumn . $length)->applyFromArray($styleArray);

                // 列宽
                $column = 0;
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(20);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(20);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(20);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(20);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(10);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(10);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(10);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(10);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(15);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(15);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(15);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(15);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(15);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(15);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(15);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(15);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(15);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(15);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(15);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(15);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(15);
                $workSheet->getColumnDimension($this->getLetterColumn($column++))->setWidth(15);
            }
        ];
    }




    /**
     * 设置表头
     * @param $workSheet
     * @param $column
     */
    protected function setHeaders($workSheet, $column)
    {
        for ($i = 0; $i < count($this->headers); $i++) {
            $workSheet->getCell(chr(65 + $i) . $this->headLine())->setValue($this->headers[$i]);
        }
        $workSheet->getStyle('A' . $this->headLine() . ':' . $column . $this->headLine())->getAlignment()->setVertical('center');
        $workSheet->getStyle('A' . $this->headLine() . ':' . $column . $this->headLine())->getFont()->setBold(true)->setName('微软雅黑')->setSize(10);
    }


    /**
     * 根据数值判断对应的Excel列      起始数是0   即0=A  25=Z  26=AA
     */
    public static function getLetterColumn($num, &$left = '')
    {
        $num = $num + 1;
        $perfix = 0;
        if ($num > 26) {
            $perfix = floor($num / 26);
            $hand = $num % 26 == 0 ? 26 : $num % 26;
            $perfix = $num % 26 == 0 ? ($perfix - 1) : $perfix;
        } else {
            $hand = $num;
        }
        switch ($hand) {
            case 1:
                $handLette = 'A';
                break;
            case 2:
                $handLette = 'B';
                break;
            case 3:
                $handLette = 'C';
                break;
            case 4:
                $handLette = 'D';
                break;
            case 5:
                $handLette = 'E';
                break;
            case 6:
                $handLette = 'F';
                break;
            case 7:
                $handLette = 'G';
                break;
            case 8:
                $handLette = 'H';
                break;
            case 9:
                $handLette = 'I';
                break;
            case 10:
                $handLette = 'J';
                break;
            case 11:
                $handLette = 'K';
                break;
            case 12:
                $handLette = 'L';
                break;
            case 13:
                $handLette = 'M';
                break;
            case 14:
                $handLette = 'N';
                break;
            case 15:
                $handLette = 'O';
                break;
            case 16:
                $handLette = 'P';
                break;
            case 17:
                $handLette = 'Q';
                break;
            case 18:
                $handLette = 'R';
                break;
            case 19:
                $handLette = 'S';
                break;
            case 20:
                $handLette = 'T';
                break;
            case 21:
                $handLette = 'U';
                break;
            case 22:
                $handLette = 'V';
                break;
            case 23:
                $handLette = 'W';
                break;
            case 24:
                $handLette = 'X';
                break;
            case 25:
                $handLette = 'Y';
                break;
            case 26:
                $handLette = 'Z';
                break;
            default:
                $handLette = '';
                break;
        }
        if ($perfix) {
            $left = self::getLetterColumn($perfix - 1, $left);
        }
        return $left . $handLette;
    }

}
