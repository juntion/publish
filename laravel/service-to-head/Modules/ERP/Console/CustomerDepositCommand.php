<?php


namespace Modules\ERP\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Contracts\AdminRepository;
use Modules\ERP\Contracts\OrderRepository;
use Modules\ERP\Contracts\OrderService;
use Modules\ERP\Contracts\OrdersInputNotesRepository;
use Modules\ERP\Entities\OrdersInputNotes;
use Modules\ERP\Enums\Order\OrdersDeposit;
use Modules\ERP\Service\ProductsInstockShippingService;
use Modules\Finance\Contracts\ReceiptService;
use Modules\Finance\Entities\PaymentReceipt;
use Modules\Finance\Entities\PaymentClaimApplication;
use Modules\Finance\Entities\PaymentReceiptsVouchersDetail;
use Modules\Finance\Entities\PaymentVoucher;

class CustomerDepositCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'erp:customer-deposit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '推送客户存款单';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param OrderService $ordersService
     * @param ReceiptService $receiptService
     * @param AdminRepository $adminRepository
     * @param OrderRepository $orderRepository
     * @param ProductsInstockShippingService $productsInstockShippingService
     * @return mixed
     */
    public function handle(
        OrderService $ordersService,
        ReceiptService $receiptService,
        AdminRepository $adminRepository,
        OrderRepository $orderRepository,
        ProductsInstockShippingService $productsInstockShippingService
    )
    {
        $data = $ordersService->getOrdersDepositData();
        if ($data->isNotEmpty()) {
            $data->each(function ($item) use ($receiptService, $orderRepository, $adminRepository, $productsInstockShippingService) {
                DB::beginTransaction();
                try {
                    //验证到款
                    if ($receiptService->verifyRepeatTransaction($item['transaction_serial_number'])) {
                        $orderRepository->storeDepositStatus($item['orders_id'], OrdersDeposit::EXISTS);
                        $this->logSave(OrdersDeposit::EXISTS, $item['orders_id'], json_encode($item), '该到款已存在');
                    } else {
                        $systemAdmin = $adminRepository->getAdminByName(config('app.root'));
                        $applyAdmin = $adminRepository->getAdminByErpID($item['admin_id'])->first();

                        $paymentReceipt = new PaymentReceipt;
                        $paymentReceipt->transaction_serial_number = $item['transaction_serial_number'];
                        $paymentReceipt->payment_method_id = $item['payment_method_id'];
                        $paymentReceipt->currency = $item['currency'];
                        $paymentReceipt->amount = $item['amount'];
                        $paymentReceipt->order_number = $item['orders_number'];
                        $paymentReceipt->create_from = 2;
                        $paymentReceipt->payer_email = $item['payer_email'];
                        $paymentReceipt->payer_name = $item['payer_name'];
                        $paymentReceipt->payment_remark = $item['payment_remark'];
                        $paymentReceipt->company_uuid = $item['company_uuid'];
                        $paymentReceipt->company_name = $item['company_name'];
                        $paymentReceipt->company_account_number = $item['company_account_number'];
                        $paymentReceipt->creator_uuid = $systemAdmin->uuid;
                        $paymentReceipt->creator_name = $systemAdmin->name;

                        // 创建到款
                        $paymentReceipt = $receiptService->create($paymentReceipt);

                        // 如果用户存在，则到款自动认领申请，自动审核，自动支出
                        if ($item['admin_id'] && $applyAdmin->exists && $paymentReceipt->exists) {
                            // 自动认领申请
                            $application = new PaymentClaimApplication;
                            $application->customer_number = $item['customer_number'];
                            $application->apply_remark = '自动申请到款认领';
                            $application = $receiptService->claimApplication($paymentReceipt, $applyAdmin, $application, [], 1);

                            // 自动审核
                            $application->check_remark = '自动审核到款认领';
                            $receiptService->verifyApplication($application, $systemAdmin, $paymentReceipt, true);

                            // 自动创建凭证  创建用款凭证，到款关联用款
                            $paymentVoucher = new PaymentVoucher;
                            $paymentVoucher->order_number = $item['orders_number'];
                            $paymentVoucher->currency = $item['currency'];
                            $paymentVoucher->usable = $item['amount'];
                            $paymentVoucher->used = $item['amount'];
                            $paymentVoucher->customer_number = $item['customer_number'];
                            $paymentVoucher->type = 1;
                            $paymentVoucher->remark = '线上订单自动录入';
                            $paymentVoucher->customer_company_number = $item['customer_company_number'];
                            $paymentVoucher->created_at = Carbon::now();

                            // 创建凭证
                            $receiptsToVoucher = $receiptService->paymentReceiptExpend($paymentReceipt, $applyAdmin, $paymentVoucher);

                            // 自动录单

                            $paymentVoucherData['renling'] = 3;
                            $paymentVoucherData['isCustomerZone'] = false;
                            $paymentVoucherData['orders_id'] = $item['orders_id'];
                            $instockInfo = $productsInstockShippingService->createByVoucher($paymentVoucher, $paymentVoucherData);//插入订单流程数据

                            // 使用凭证
                            $paymentReceiptsVouchersDetail = new PaymentReceiptsVouchersDetail;
                            $paymentReceiptsVouchersDetail->order_id = $instockInfo->products_instock_id;
                            $paymentReceiptsVouchersDetail->order_number = $item['orders_number'];
                            $paymentReceiptsVouchersDetail->parent_id = null;
                            $paymentReceiptsVouchersDetail->origin_id = null;
                            $receiptService->storeReceiptVoucherDetail($paymentReceiptsVouchersDetail, $receiptsToVoucher->first());
                        }
                        $orderRepository->storeDepositStatus($item['orders_id'], OrdersDeposit::SUCCESS);
                        $this->logSave(OrdersDeposit::SUCCESS, $item['orders_id'], json_encode($item), '');
                    }
                    DB::commit();
                } catch (\Exception $exception) {
                    DB::rollBack();
                    $orderRepository->storeDepositStatus($item['orders_id'], OrdersDeposit::ERROR);
                    $this->logSave(OrdersDeposit::ERROR, $item['orders_id'], json_encode($item), $exception->getMessage());
                }
            });
        }

    }

    /**
     * @param $status
     * @param $orders_id
     * @param $data
     * @param string $message
     * @return
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function logSave($status, $orders_id, $data, $message = '')
    {
        $ordersInputNotesRepository = app()->make(OrdersInputNotesRepository::class);
        $ordersInputNotes = new OrdersInputNotes;
        $ordersInputNotes->related_id = $orders_id;
        $ordersInputNotes->status = $status;
        $ordersInputNotes->data = json_encode(['url' => config('app.url'), 'request' => $data, 'response' => $message], true);
        $ordersInputNotes->remark = $message;
        $ordersInputNotes->create_at = Carbon::now();
        return $ordersInputNotesRepository->store($ordersInputNotes);
    }
}
