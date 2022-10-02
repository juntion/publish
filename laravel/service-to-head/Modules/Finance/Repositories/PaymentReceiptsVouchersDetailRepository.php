<?php


namespace Modules\Finance\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Finance\Contracts\PaymentReceiptsVouchersDetailRepository as ContractsPaymentReceiptsVouchersDetailRepository;
use Modules\Finance\Entities\PaymentReceiptsVouchersDetail;

class PaymentReceiptsVouchersDetailRepository implements ContractsPaymentReceiptsVouchersDetailRepository
{

    public function store(array $data)
    {
        PaymentReceiptsVouchersDetail::query()->create($data);
    }

    /**
     * @param string $fields
     * @param string $val
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getDetailCollectionByWhere($fields = '', $val = '')
    {
        return PaymentReceiptsVouchersDetail::query()->where($fields, $val)->get();
    }


    public function findDetailByNumberAndOrderId(string $voucherNumber, int $orderId)
    {
        return PaymentReceiptsVouchersDetail::query()->where('voucher_number', $voucherNumber)->where('order_id', $orderId)->get();
    }


    public function updateUseByUuidNumberAndOrderNumber(string $receiptUuid, string $voucherNumber, string $orderNumber, int $receiptUse,int $voucherUse)
    {
        $detail = PaymentReceiptsVouchersDetail::query()
            ->where('receipt_uuid', $receiptUuid)
            ->where('voucher_number', $voucherNumber)
            ->where('order_number', $orderNumber)
            ->first();

        $detail->update([
            'receipt_use' => DB::raw('`receipt_use` +' . $receiptUse),
            'voucher_use' => DB::raw('`voucher_use` +' . $voucherUse),
        ]);
    }


    public function creatByModel(PaymentReceiptsVouchersDetail $paymentReceiptsVouchersDetail)
    {
        $paymentReceiptsVouchersDetail->uuid = Str::uuid()->getHex()->toString();
        $paymentReceiptsVouchersDetail->created_at = Carbon::now();
        $paymentReceiptsVouchersDetail->save();
    }
}
