<?php


namespace Modules\Finance\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Modules\Admin\Entities\Admin;
use Modules\Finance\Entities\PaymentReceipt;
use Modules\Finance\Entities\PaymentClaimApplication;
use Modules\Finance\Entities\PaymentReceiptsToVoucher;
use Modules\Finance\Entities\PaymentReceiptsVouchersDetail;
use Modules\Finance\Entities\PaymentVoucher;

interface ReceiptService
{
    /**
     * 创建到款服务
     * @param PaymentReceipt $paymentReceipt
     * @return PaymentReceipt
     */
    public function create(PaymentReceipt $paymentReceipt);

    /**
     * @param PaymentReceipt $paymentReceipt 对那个到款进行认领申请
     * @param Admin $admin 申请人
     * @param PaymentClaimApplication $application 申请对象(提供申请数据)
     * @param array $file 申请附件
     * @return PaymentClaimApplication
     */
    public function claimApplication(PaymentReceipt $paymentReceipt, Admin $admin, PaymentClaimApplication $application, array $file = [], $claimType = 0);

    /**
     * @param PaymentClaimApplication $application 审核的是哪一个申请对象(提供审核数据)
     * @param Admin $admin 审核人
     * @param bool $verify true：审核通过，false:审核不通过
     * @param array $file 审核附件
     * @return PaymentClaimApplication
     */
    public function verifyApplication(PaymentClaimApplication $application, Admin $admin, PaymentReceipt $paymentReceipt, bool $verify, array $file = []);


    /**
     * @param  PaymentReceipt  $paymentReceipt
     * @param  Admin  $admin
     * @param  PaymentVoucher  $paymentVoucher
     * @return PaymentReceiptsToVoucher
     */
    public function paymentReceiptExpend(PaymentReceipt $paymentReceipt, Admin $admin, PaymentVoucher $paymentVoucher, $insertType);


    /**
     * @param  PaymentReceiptsVouchersDetail  $paymentReceiptsVouchersDetail
     * @param  PaymentReceiptsToVoucher  $paymentReceiptsToVoucher
     * @return mixed
     */
    public function storeReceiptVoucherDetail( PaymentReceiptsVouchersDetail $paymentReceiptsVouchersDetail, PaymentReceiptsToVoucher $paymentReceiptsToVoucher);

    public function storeClaim(array $claim, array $file, array $receipt);

    public function deleteClaim(string $uuid, Authenticatable $user);

    public function verifyClaim(string $uuid, array $claim, array $files, bool $verify);


    /**
     * 发票核销金额返还
     * @param  string $receiptUuid
     * @param  string $voucherNumber
     * @param  string $orderNumber
     * @param  int $receiptUse
     * @param  int $voucherUse
     * @return mixed
     */
    public function clearReceiptVoucherAndDetail(string $receiptUuid, string $voucherNumber, string $orderNumber, int $receiptUse, int $voucherUse);

}
