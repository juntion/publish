<?php


namespace Modules\Finance\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Finance\Contracts\ReceiptsVouchersRepository as ContractsReceiptsVouchersRepository;
use Modules\Finance\Entities\PaymentReceiptsToVoucher;
use Modules\Finance\Entities\PaymentReceiptsVouchersDetail;

class ReceiptsVouchersRepository implements ContractsReceiptsVouchersRepository
{
    public function getReceiptsVouchersByOrderNumber($orderNumber)
    {
        return PaymentReceiptsVouchersDetail::query()
            ->where('order_number', $orderNumber)
            ->with(['receipt', 'voucher'])
            ->get();
    }

    public function revokeReceiptsToVouchers(
        PaymentReceiptsToVoucher $paymentReceiptsToVoucher,
        int $receiptUsed,
        int $voucherUsed
    ) {
        PaymentReceiptsToVoucher::query()->where('receipt_uuid', $paymentReceiptsToVoucher->receipt_uuid)
            ->where('voucher_uuid', $paymentReceiptsToVoucher->voucher_uuid)
            ->update([
                'receipt_use' => DB::raw('`receipt_use` - '. $receiptUsed),
                'voucher_use' => DB::raw('`voucher_use` - '. $voucherUsed)
            ]);
    }

    public function getReceiptsToVouchersByReceiptAndVoucherUuid(string $receiptUuid, string $voucherUuid)
    {
        return PaymentReceiptsToVoucher::query()
            ->where('receipt_uuid', $receiptUuid)
            ->where('voucher_uuid', $voucherUuid)
            ->first();
    }

    public function updateUseByReceiptUuidAnyVoucherNumber(string $receiptUuid, string $voucherNumber, int $receiptUsed, int $voucherUsed)
    {
        PaymentReceiptsToVoucher::query()
            ->where('receipt_uuid', $receiptUuid)
            ->where('voucher_number', $voucherNumber)
            ->update([
                'receipt_use' => DB::raw('`receipt_use` + '. $receiptUsed),
                'voucher_use' => DB::raw('`voucher_use` + '. $voucherUsed)
            ]);
    }

}
