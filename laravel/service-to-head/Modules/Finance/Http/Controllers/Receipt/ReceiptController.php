<?php

namespace Modules\Finance\Http\Controllers\Receipt;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admin\Contracts\AdminRepository;
use Modules\Admin\Contracts\AdminService;
use Modules\Base\Contracts\Company\CompanyBankAccountsRepository;
use Modules\Base\Criteria\ListRequestCriteria;
use Modules\ERP\Contracts\CustomerCompanyRepository;
use Modules\ERP\Contracts\CustomerRepository;
use Modules\ERP\Contracts\PaymentMethodService;
use Modules\ERP\Service\ErpReceiptService;
use Modules\ERP\Support\Facades\Exchange;
use Modules\Finance\Contracts\PaymentClaimFilesRepository;
use Modules\Finance\Contracts\ReceiptRepository;
use Modules\Finance\Contracts\ReceiptService;
use Modules\Finance\Entities\PaymentClaimApplication;
use Modules\Finance\Exceptions\ClaimException;
use Modules\Finance\Exceptions\ReceiptException;
use Modules\Finance\Http\Controllers\Controller;
use Modules\Finance\Http\Controllers\Receipt\Import\ErrorDataExport;
use Modules\Finance\Http\Controllers\Receipt\Import\ReceiptImport;
use Modules\Finance\Http\Requests\Receipt\ApiCreateReceiptRequest;
use Modules\Finance\Http\Requests\Receipt\ApiGetCustomerUnusedRequest;
use Modules\Finance\Http\Requests\Receipt\ApiSearchRequest;
use Modules\Finance\Http\Requests\Receipt\ApiSoftDeleteRequest;
use Modules\Finance\Http\Requests\Receipt\ApiUpdateFeeRequest;
use Modules\Finance\Http\Requests\Receipt\ApiUpdateFloatRequest;
use Modules\Finance\Http\Requests\Receipt\ApiUpdateUsableRequest;
use Modules\Finance\Http\Requests\Receipt\ApiUpdateUseRequest;
use Modules\Finance\Http\Requests\Receipt\CreateApplicationClaimRequest;
use Modules\Finance\Http\Requests\Receipt\CreateApplicationUnClaimRequest;
use Modules\Finance\Http\Requests\Receipt\CreateReceiptRequest;
use Modules\Finance\Http\Requests\Receipt\DownloadReceiptFiles;
use Modules\Finance\Http\Requests\Receipt\ReceiptDownloadListRequest;
use Modules\Finance\Http\Requests\Receipt\ReceiptIndexRequest;
use Modules\Finance\Http\Requests\Receipt\ReceiptSearchRequest;
use Modules\Finance\Http\Requests\Receipt\UpdateReceiptRequest;
use Modules\Finance\Http\Requests\Receipt\UploadRequest;
use Modules\Finance\Http\Requests\Receipt\VerifyClaimRequest;
use Modules\Finance\Http\Resources\Receipt\DetailsResource;
use Modules\Finance\Http\Resources\Receipt\ReceiptApplicationListResource;
use Modules\Finance\Http\Resources\Receipt\ReceiptApplicationWithoutFilesResource;
use Modules\Finance\Http\Resources\Receipt\ReceiptResource;
use Modules\Finance\Http\Resources\Receipt\ReceiptsListCollectionResource;
use Modules\Finance\Http\Resources\Receipt\ReceiptVouchersResource;
use Modules\Finance\Http\Resources\Receipt\ReceiptRefundListResource;
use Modules\Finance\Http\Resources\Receipt\ReceiptWithCustomerResource;
use Modules\Finance\Jobs\DownloadReceiptList;
use Modules\Finance\Repositories\ClaimApplicationRepository;
use Modules\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use Modules\Finance\Entities\PaymentReceipt;

class ReceiptController extends Controller
{

    public function store(CreateReceiptRequest $request, ReceiptService $receiptService)
    {
        $user = Auth::user();
        $paymentReceipt = new PaymentReceipt;

        $paymentReceipt->transaction_serial_number = $request->input('transaction_serial_number');
        $paymentReceipt->payment_method_id = $request->input('payment_method_id');
        $paymentReceipt->currency = $request->input('currency');
        $paymentReceipt->amount = $request->input('amount');
        $paymentReceipt->fee_fs = $request->input('fee_fs') ?? 0;
        $paymentReceipt->payer_email = $request->input('payer_email');
        $paymentReceipt->payer_name = $request->input('payer_name');
        $paymentReceipt->payment_remark = $request->input('payment_remark');
        $paymentReceipt->customer_debit_account = $request->input('customer_debit_account');

        $paymentReceipt->create_from = 0;
        $paymentReceipt->creator_uuid = $user->uuid;
        $paymentReceipt->creator_name = $user->name;

        if ($request->input('payment_time') && $request->input('payment_time') != 'null') {
            $paymentReceipt->payment_time = Carbon::parse($request->input('payment_time'))->toDateTimeString();
        }

        $receipt = $receiptService->create($paymentReceipt);
        $receipt = new ReceiptResource($receipt);
        return $this->createSuccess(compact('receipt'), __('finance::common.createSuccess'));
    }


    /**
     * 更新到款信息
     * @param  UpdateReceiptRequest  $request
     * @param  ReceiptRepository  $repository
     * @param  CompanyBankAccountsRepository  $companyBankAccountsRepository
     * @param  PaymentMethodService  $paymentMethodService
     * @return \Illuminate\Http\JsonResponse
     * @throws ReceiptException
     */
    public function update(UpdateReceiptRequest $request, ReceiptRepository $repository, CompanyBankAccountsRepository $companyBankAccountsRepository, PaymentMethodService $paymentMethodService)
    {
        $updateReceipt = $request->all();
        $receipt = $repository->find($request->uuid);
        if ($receipt->claim_status != 0) {
            return $this->failedWithMessage(__('finance::receipt.statusNotAllowUpdate'));
        }
        $useAbleChange = 0;

        if(!is_null($request->input('fee_fs')) && $receipt->fee_fs != $request->input('fee_fs')) { // 不是null 更新
            $updateReceipt['fee'] = DB::raw('fee + ' . ($request->input('fee_fs') - $receipt->fee_fs));
            $useAbleChange += $request->input('fee_fs') - $receipt->fee_fs;
        }  else if (is_null($request->input('fee_fs'))) { // 是null 不更新
            unset($updateReceipt['fee_fs']);
        }

        if($receipt->amount != $request->input('amount')) { // 不是null 更新
            $useAbleChange += $request->input('amount') - $receipt->amount;
        }

        if($useAbleChange != 0) {
            $updateReceipt['usable'] = DB::raw('usable +' . $useAbleChange);
        }
        if ($updateReceipt['payment_method_id'] != $receipt->payment_method_id) {
            $updateReceipt['payment_method_name'] = $paymentMethodService->getPaymentMethodName($request->input('payment_method_id'));
        }

        if ($updateReceipt['payment_method_id'] != $receipt->payment_method_id || $updateReceipt['currency'] != $receipt->currency) {
            // 查询公司信息
            $account = $companyBankAccountsRepository->getAccountAndCompanyInfoByMethodAndCurrency($updateReceipt['payment_method_id'], $updateReceipt['currency']);
            if (is_null($account)) {
                throw new ReceiptException(__('finance::receipt.accountNotFound'));
            }
            $updateReceipt['company_uuid'] = $account->company->uuid;
            $updateReceipt['company_name'] = $account->company->name;
            $updateReceipt['company_account_number'] = $account->account_number;
        }

        if ($request->input('payment_time') && $request->input('payment_time') != 'null') {
            $updateReceipt['payment_time'] = Carbon::parse($request->input('payment_time'))->toDateTimeString();
        } else {
            unset($updateReceipt['payment_time']);
        }
        $repository->update($updateReceipt, $request->uuid);
        $receipt = $receipt->refresh();
        $receipt = new ReceiptResource($receipt);
        return $this->successWithDataAndMessage(compact('receipt'), __('finance::common.updateSuccess'));
    }

    /**
     * 删除到款信息
     * @param  Request  $request
     * @param  ReceiptRepository  $repository
     * @return \Illuminate\Http\JsonResponse
     */
    public function softDelete(Request $request, ReceiptRepository $repository)
    {
        $receipt = $repository->find($request->uuid);
        if ($receipt->claim_status != 0) {
            return $this->failedWithMessage(__('finance::receipt.statusNotAllowDelete'));
        }

        if ($receipt->create_from == 3) {
            return $this->failedWithMessage(__('finance::receipt.advanceNotAllowDeleteFromList'));
        }
        $repository->delete($request->uuid);
        return $this->successWithMessage(__('finance::common.deleteSuccess'));
    }

    /**
     * 恢复到款信息
     * @param  Request  $request
     * @param  ReceiptRepository  $repository
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(Request $request, ReceiptRepository $repository)
    {
        $receipt = $repository->onlyTrashed()->find($request->uuid);
        if (is_null($receipt)) {
            return $this->failedWithMessage(__('finance::receipt.statusNotAllowActive'));
        }
        $receipt->restore();
        return $this->successWithMessage(__('finance::receipt.activeSuccess'));
    }

    /**
     * 新增认领
     * @param  CreateApplicationClaimRequest  $request
     * @param  ReceiptService  $service
     * @param  CustomerCompanyRepository  $repository
     * @param  ClaimApplicationRepository  $claimApplicationRepository
     * @return \Illuminate\Http\JsonResponse
     * @throws ClaimException
     */
    public function storeClaim(CreateApplicationClaimRequest $request, ReceiptService $service, CustomerCompanyRepository $repository, ClaimApplicationRepository $claimApplicationRepository, ReceiptRepository $receiptRepository)
    {
        $unVerify = $claimApplicationRepository->getUnVerifyClaimByReceiptUuid($request->input('receipt_uuid'));
        if (!is_null($unVerify)) {
            throw new ClaimException(__('finance::receipt.statusAllowClaim'));
        }

        $receipt = $receiptRepository->find($request->input('receipt_uuid'));
        $paymentClaimApplication = new PaymentClaimApplication();

        $user = Auth::user();
        $customer_company = $repository::getCompanyByCustomerNumber($request->input('customer_number'));
        if (!$customer_company) {
            throw new ClaimException(__("finance::receipt.customerNumberError"));
        }

        $paymentClaimApplication->apply_remark = $request->input('apply_remark') ?? '';
        $paymentClaimApplication->customer_number = $request->input('customer_number');
        $paymentClaimApplication->customer_company_number = $customer_company->company_number;
        $paymentClaimApplication->apply_type = 1;

        $files = $request->file('apply_file');
        DB::beginTransaction();

        try {
            $service->claimApplication($receipt, $user, $paymentClaimApplication, $files);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            if ($exception instanceof ReceiptException) {
                return $this->failedWithMessage($exception->getMessage());
            } else {
                return $this->failedWithMessage(__('finance::receipt.storeClaimFailed'));
            }
        }

        return $this->successWithMessage(__('finance::receipt.storeClaimSuccess'));
    }


    /**
     * @param  CreateApplicationUnClaimRequest  $request
     * @param  ReceiptService  $service
     * @param  CustomerCompanyRepository  $repository
     * @param  ClaimApplicationRepository  $claimApplicationRepository
     * @return \Illuminate\Http\JsonResponse
     * @throws ClaimException
     */
    public function storeUnClaim(CreateApplicationUnClaimRequest $request, ReceiptService $service,  ClaimApplicationRepository $claimApplicationRepository, ReceiptRepository $receiptRepository)
    {
        $receipt = $receiptRepository->find($request['receipt_uuid']);

        if ($receipt->used != 0) {
            throw new ClaimException(__('finance::receipt.statusAllowClaim'));
        }

        if ($receipt->create_from == 3) { // 垫付的禁止在列表申请取消认领
            throw new ClaimException(__('finance::receipt.advanceNotAllowDeleteFromList'));
        }

        $unVerify = $claimApplicationRepository->getUnVerifyClaimByReceiptUuid($request->input('receipt_uuid'));
        if (!is_null($unVerify)) {
            throw new ClaimException(__('finance::receipt.statusAllowClaim'));
        }
        $user = Auth::user();
        $paymentClaimApplication = new PaymentClaimApplication();
        $paymentClaimApplication->apply_remark = $request->input('apply_remark') ?? '';
        $paymentClaimApplication->customer_number = $request->input('customer_number');
        $paymentClaimApplication->apply_type = 2;


        $files = $request->file('apply_file') ?? [];

        DB::beginTransaction();

        try {
            $service->claimApplication($receipt, $user, $paymentClaimApplication, $files);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            if ($exception instanceof ReceiptException) {
                return $this->failedWithMessage($exception->getMessage());
            } else {
                return $this->failedWithMessage(__('finance::receipt.storeClaimFailed'));
            }
        }

        return $this->successWithMessage(__('finance::receipt.storeClaimSuccess'));
    }

    /**
     * @param  Request  $request
     * @param  ReceiptService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteClaim(Request $request, ReceiptService $service)
    {
        $user = Auth::user();
        $service->deleteClaim($request->uuid, $user);
        return $this->successWithMessage(__('finance::receipt.deleteClaimSuccess'));
    }


    /**
     * @param  VerifyClaimRequest  $request
     * @param  ReceiptService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyClaim(VerifyClaimRequest $request, ReceiptService $service, ReceiptRepository $receiptRepository, ClaimApplicationRepository $claimApplicationRepository)
    {
        $verify = true;
        $user = Auth::user();
        $files = $request->file('check_file') ?? [];
        if ($request->input('check_status') != 1) {
            $verify = false;
        }
        $application = $claimApplicationRepository->find($request->uuid);
        $application->check_remark = $request->input('check_remark') ?? null;
        $receipt = $receiptRepository->find($application->receipt_uuid);

        DB::beginTransaction();

        try {
            $service->verifyApplication($application, $user, $receipt, $verify, $files);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            if ($exception instanceof ReceiptException) {
                return $this->failedWithMessage($exception->getMessage());
            } else {
                return $this->failedWithMessage(__('finance::receipt.storeClaimFailed'));
            }
        }

        return $this->successWithMessage(__('finance::receipt.verifySuccess'));
    }

    /**
     * @param  DownloadReceiptFiles  $request
     * @param  PaymentClaimFilesRepository  $repository
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse|\Symfony\Component\HttpFoundation\StreamedResponse
     * @throws ClaimException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function downloadFile(DownloadReceiptFiles $request, PaymentClaimFilesRepository $repository, AdminService $service)
    {
        $user = Auth::user();
        if ($user->hasPermissionTo('finance.receipt.receipts.all')){
            $action = 'notCheck';
        } else if ($user->hasPermissionTo('finance.receipt.receipts.group')){
            $action = 'checkIsGroup';
        } else {
            $action = 'checkIsSelf';
        }
        $fileUuids = $request->input('file_uuid');
        if (count($fileUuids) == 1) {
            $file = $this->checkFile($action, $repository, $fileUuids[0], $user, $service);
            if($file){
                return Storage::disk('finance')->download($file->path . '/' . $file->storage_name, $file->name);
            } else {
                return $this->failedWithMessage(__('finance::receipt.noPermissionDownload'));
            }
        } else {
            // 创建打包文件
            $files = $this->checkFiles($action, $repository, $fileUuids, $user, $service);
            if ($files){
                return $this->makeZip($files);
            } else {
                return $this->failedWithMessage(__('finance::receipt.noPermissionDownload'));
            }
        }
    }


    /**
     * @param  string  $action
     * @param  PaymentClaimFilesRepository  $repository
     * @param  string  $uuid
     * @param  Authenticatable  $user
     * @return bool|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function checkFile(string $action, PaymentClaimFilesRepository $repository,string $uuid, Authenticatable $user, AdminService $service)
    {
        switch ($action){
            case "notCheck":
                return $repository->find($uuid);
                break;
            case "checkIsGroup":
                $file = $repository->with('receipt')->find($uuid);
                if ($file->receipt->claim_status == 0){
                    return $file;
                }  else if($file->receipt->claim_uuid == $user->uuid){
                    return $file;
                } else {
                    $claimGroup = $service->getAdminGroupId($file->receipt->claimsUser);
                    $selfGroup = $service->getAdminGroupId($user);
                    if ($claimGroup == $selfGroup){
                        return $file;
                    }
                    return false;
                }
                break;
            case "checkIsSelf":
                $file = $repository->with('receipt')->find($uuid);
                if ($file->receipt->claim_status == 0 || $file->receipt->claim_uuid == $user->uuid) {
                    return $file;
                }
                return false;
                break;
            default :
                return false;
                break;
        }
    }

    /**
     * @param  string  $action
     * @param  PaymentClaimFilesRepository  $repository
     * @param  array  $uuids
     * @param  Authenticatable  $user
     * @return bool|mixed
     * @throws ClaimException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function checkFiles(string $action, PaymentClaimFilesRepository $repository,array $uuids, Authenticatable $user, AdminService $service)
    {
        $files = $this->checkFileIsOneReceipt($repository, $uuids);
        switch ($action){
            case "notCheck":
                return $files;
                break;
            case "checkIsGroup":
                $receipt = $files[0]->receipt;
                if ($receipt->claim_status == 0){
                    return $files;
                } else if($receipt->claim_uuid == $user->uuid){
                    return $files;
                } else {
                    $claimGroup = $service->getAdminGroupId($receipt->claimUser);
                    $userGroup = $service->getAdminGroupId($user);
                    if ($claimGroup == $userGroup){
                        return $files;
                    }
                    return false;
                }
                break;
            case "checkIsSelf":
                $receipt = $files[0]->receipt;
                if ($receipt->claim_status == 0 || $receipt->claim_uuid == $user->uuid) {
                    return $files;
                }
                return false;
                break;
            default :
                return false;
                break;
        }
    }

    /**
     * @param  PaymentClaimFilesRepository  $repository
     * @param  array  $uuids
     * @return mixed
     * @throws ClaimException
     */
    protected function checkFileIsOneReceipt(PaymentClaimFilesRepository $repository,array $uuids)
    {
        $files = $repository->with('receipt')->findWhereIn('uuid', $uuids);
        $applyUuid = $files->groupBy(function ($item){
            return $item->receipt->uuid;
        })->all();
        if(count($applyUuid) == 1) {
            return $files;
        }
        throw new ClaimException(__('finance::receipt.fileNotOneReceipt'));
    }


    /**
     * @param $files
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    protected function makeZip($files)
    {
        // 多文件压缩成zip包
        $tmpDir = storage_path('app/tmp/') . date('Y-m-d') ;
        if (!is_dir($tmpDir)) {
            mkdir($tmpDir, 0777, true);
        }
        $nowFiles = [];

        $zipFileName = $tmpDir . '/' . (Str::uuid()->getHex()->toString()).'.zip';
        $zip = new \ZipArchive();
        $zip->open($zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        foreach ($files as $file){
            if (!array_key_exists($sha1 = sha1(strtolower($file->name)), $nowFiles)) {
                $nowFiles[$sha1] = 0;
                $fileName = $file->name;
            } else {
                $nowFiles[$sha1]++;
                $pos = strrpos($file->name, '.');
                $fileName = substr($file->name, 0, $pos) .
                    "({$nowFiles[$sha1]})" .
                    substr($file->name, $pos);
            }
            $zip->addFile(Storage::disk('finance')->path($file->path . '/' . $file->storage_name), $fileName);
        }
        $zip->close();
        return response()->download($zipFileName, date('YmdHis').'.zip');
    }


    /**
     * @param  UploadRequest  $request
     * @param  ReceiptImport  $import
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws ReceiptException
     */
    public function upload(UploadRequest $request, ReceiptImport $import)
    {
        $extension = $request->file('file')->extension();

        if (!in_array($extension, ['xlsx', 'xls'])) {
            throw new ReceiptException(__('finance::receipt.fileTypeNotAllow'));
        }

        $tmpDir = 'tmp/' . date('Y-m-d') . '/' ;

        $path = $request->file('file')->store($tmpDir);
        Excel::import($import, $path);
        if (empty($import->errorData)) {
            $data['url'] = null;
            return $this->successWithDataAndMessage($data, __('finance::receipt.uploadSuccess'));
        } else {
            $uuid = Str::uuid()->getHex()->toString();
            $dir = 'tmp/' . date('Y-m-d') . '/' . $uuid . '/上传失败数据.xls';
            Excel::store(new ErrorDataExport($import->errorData), $dir);
            $data['url'] = config('app.url') . '/finance/receipt/receipts/' . $uuid . '/download';
            return $this->successWithDataAndMessage($data, __('finance::receipt.uploadFailed'));
        }
    }

    /**
     * @param  ApiCreateReceiptRequest  $request
     * @param  ReceiptRepository  $repository
     * @param  AdminService  $adminService
     * @return \Illuminate\Http\JsonResponse
     * @throws UnauthorizedException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function apiStore(ApiCreateReceiptRequest $request, ReceiptService $receiptService, AdminService $adminService, AdminRepository $adminRepository)
    {
        $user = $adminService->getAdminInfoById($request->input('admin_id'));
        $this->checkPermission($user, "finance.receipt.receipts.action");
        $paymentReceipt = new PaymentReceipt;

        $paymentReceipt->transaction_serial_number = $request->input('transaction_serial_number');
        $paymentReceipt->payment_method_id = $request->input('payment_method_id');
        $paymentReceipt->currency = $request->input('currency');
        $paymentReceipt->amount = $request->input('amount');
        $paymentReceipt->fee_fs = $request->input('fee_fs') ?? 0;
        $paymentReceipt->payer_email = $request->input('payer_email');
        $paymentReceipt->payer_name = $request->input('payer_name');
        $paymentReceipt->payment_remark = $request->input('payment_remark');
        $paymentReceipt->customer_debit_account = $request->input('customer_debit_account');

        $paymentReceipt->create_from = 3;
        $paymentReceipt->creator_uuid = $user->uuid;
        $paymentReceipt->creator_name = $user->name;

        DB::beginTransaction();
        try {

            $applyUser = $adminService->getAdminInfoById($request->input('apply_id'));

            if (is_null($applyUser)) {
                throw new ReceiptException(__('finance::receipt.notFoundApplyIdUser'));
            }

            $receipt = $receiptService->create($paymentReceipt);

            $application = new PaymentClaimApplication;
            $application->customer_number = $request->input('customer_number');
            $application->apply_remark = '款项申请应付申请 自动申请到款认领';
            $application = $receiptService->claimApplication($paymentReceipt, $applyUser, $application);

            // 自动审核

            $systemAdmin = $adminRepository->getAdminByName(config('app.root'));
            $application->check_remark = '款项申请应付申请 自动审核到款认领';
            $receiptService->verifyApplication($application, $systemAdmin, $paymentReceipt, true);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            if ($exception instanceof ReceiptException || $exception instanceof ClaimException) {
                return  $this->failedWithMessage($exception->getMessage());
            } else {
                return  $this->failedWithMessage(__('finance::receipt.apiStoreFailed'));
            }
        }


        $receipt = new ReceiptResource($receipt->refresh());
        return $this->successWithDataAndMessage(compact('receipt'), __('finance::common.createSuccess'), FoundationResponse::HTTP_CREATED);
    }

    /**
     * @param  ApiUpdateUseRequest  $request
     * @param  ReceiptRepository  $repository
     * @param  AdminService  $adminService
     * @return \Illuminate\Http\JsonResponse
     * @throws UnauthorizedException
     */
    public function apiUpdateUse(ApiUpdateUseRequest $request, ReceiptRepository $repository, AdminService $adminService)
    {
        $user = $adminService->getAdminInfoById($request->input('admin_id'));
        if (!$user) {
            throw new UnauthorizedException(__('finance::receipt.userNotFound'));
        }

        if ($user->hasPermissionTo('finance.receipt.receipts.all')){
            $type = 1;
            $admins = [];
        } else if ($user->hasPermissionTo('finance.receipt.receipts.group')){
            $admins = $adminService->getGroupAdmins($user)->pluck('uuid')->all();
            $type =2;
        } else {
            $type = 3;
            $admins = $user->uuid;
        }

        $receipt = $repository->getReceiptByNumberAndType($request->input('number'), $type, $admins);
        if (!$receipt) {
            return $this->failedWithMessage(__('finance::receipt.notFound'));
        }
        $used = $request->input('use');


        $canUsd = $receipt->usable - $receipt->used;


        if ($receipt->currency != $request->input('currency')){
            $used =  Exchange::exchange($receipt->created_at, $request->input('currency'), $used, $receipt->currency);
        }

        if ($used > 0 && $used > $canUsd) {
            return $this->failedWithMessage(__('finance::receipt.receiptCanUseNotEnough'));
        }


        if ($used < 0 && abs($used) > $receipt->used) {
            return $this->failedWithMessage(__('finance::receipt.receiptCanUseNotEnough'));
        }

        $receipt->increment('used', $used);
        return $this->successWithMessage(__('finance::common.actionSuccess'));
    }

    /**
     * @param  ApiUpdateUsableRequest  $request
     * @param  ReceiptRepository  $repository
     * @param  AdminService  $adminService
     * @return \Illuminate\Http\JsonResponse
     * @throws UnauthorizedException
     */
    function apiUpdateUsable(ApiUpdateUsableRequest $request, ReceiptRepository $repository, AdminService $adminService)
    {
        $user = $adminService->getAdminInfoById($request->input('admin_id'));
        $this->checkPermission($user, "finance.receipt.receipts.action");
        $receipt = $repository->findByField('number', $request->input('number'));
        if ($receipt->isEmpty()) {
            return $this->failedWithMessage(__('finance::receipt.notFound'));
        }
        $receipt = $receipt->first();
        $used = $request->input('usable');
        if ($receipt->currency != $request->input('currency')){
            Exchange::exchange($receipt->created_at, $request->input('currency'), $used, $receipt->currency);
        }
        $receipt->decrement('used', $used);
        return $this->successWithMessage(__('finance::common.actionSuccess'));
    }

    /**
     * @param  Request  $request
     * @param  ReceiptRepository  $repository
     * @param  AdminService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Request $request, ReceiptRepository $repository, AdminService $service)
    {
        $receipt = $this->getReceiptByPermission($repository, $request->uuid, $service);
        if (is_null($receipt)) {
            return $this->failedWithMessage(__('finance::common.NoPermission'));
        }
        $receipt = New ReceiptResource($receipt);
        return $this->successWithData(compact('receipt'));
    }

    /**
     * @param  ReceiptRepository  $repository
     * @param $uuid
     * @param  AdminService  $service
     * @return mixed
     */
    protected function getReceiptByPermission(ReceiptRepository $repository, $uuid, AdminService $service)
    {
        $user = Auth::user();
        if ($user->hasPermissionTo('finance.receipt.receipts.all')){
            $receipt = $repository->withTrashed()->find($uuid);
        } else if ($user->hasPermissionTo('finance.receipt.receipts.group')){
            $admins = $service->getGroupAdmins($user)->pluck('uuid')->all();
            $receipt = $repository->findGroup($uuid, $admins);
        } else {
            $receipt = $repository->findSelf($uuid, $user->uuid);
        }
        return $receipt;
    }

    /**
     * 获取退款记录
     * @param  Request  $request
     * @param  ReceiptRepository  $repository
     * @param  AdminService  $service
     * @param  ErpReceiptService  $erpReceiptService
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRefunds(Request $request, ReceiptRepository $repository, AdminService $service, ErpReceiptService $erpReceiptService)
    {
        $receipt = $this->getReceiptByPermission($repository, $request->uuid, $service);
        if (is_null($receipt)) {
            return $this->failedWithMessage(__('finance::common.NoPermission'));
        }
        $refunds = $erpReceiptService->getRefunds($receipt->number);
        $refunds = new ReceiptRefundListResource($refunds);
        return $this->successWithDataAndMessage(compact('refunds'), __('base::base.successGet'));
    }

    /**
     * 获取手续费用申请记录
     * @param  Request  $request
     * @param  ReceiptRepository  $repository
     * @param  AdminService  $service
     * @param  ErpReceiptService  $erpReceiptService
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFees(Request $request, ReceiptRepository $repository, AdminService $service, ErpReceiptService $erpReceiptService)
    {
        $receipt = $this->getReceiptByPermission($repository, $request->uuid, $service);
        if (is_null($receipt)) {
            return $this->failedWithMessage(__('finance::common.NoPermission'));
        }
        $fees = $erpReceiptService->getFees($receipt->number);
        $fees = new ReceiptApplicationListResource($fees);
        return $this->successWithData(compact('fees'));
    }

    /**
     * @param  Request  $request
     * @param  ReceiptRepository  $repository
     * @param  AdminService  $service
     * @param  ErpReceiptService  $erpReceiptService
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFloats(Request $request, ReceiptRepository $repository, AdminService $service, ErpReceiptService $erpReceiptService)
    {
        $receipt = $this->getReceiptByPermission($repository, $request->uuid, $service);
        if (is_null($receipt)) {
            return $this->failedWithMessage(__('finance::common.NoPermission'));
        }
        $floats = $erpReceiptService->getFloats($receipt->number);
        $floats = new ReceiptApplicationListResource($floats);
        return $this->successWithData(compact('floats'));
    }

    /**
     * @param  Request  $request
     * @param  ReceiptRepository  $repository
     * @param  AdminService  $service
     * @param  ErpReceiptService  $erpReceiptService
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPrepays(Request $request, ReceiptRepository $repository, AdminService $service, ErpReceiptService $erpReceiptService)
    {
        $receipt = $this->getReceiptByPermission($repository, $request->uuid, $service);
        if (is_null($receipt)) {
            return $this->failedWithMessage(__('finance::common.NoPermission'));
        }
        $prepays = $erpReceiptService->getPrepays($receipt->number);
        $prepays = new ReceiptApplicationListResource($prepays);
        return $this->successWithData(compact('prepays'));
    }

    /**
     * @param  Request  $request
     * @param  ReceiptRepository  $repository
     * @param  AdminService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function vouchers(Request $request, ReceiptRepository $repository, AdminService $service)
    {
        $receipt = $this->getReceiptByPermission($repository, $request->uuid, $service);
        if (is_null($receipt)) {
            return $this->failedWithMessage(__('finance::common.NoPermission'));
        }

        $vouchers = $repository->getReceiptVouchers($request->uuid);

        $vouchers = ReceiptVouchersResource::collection($vouchers);

        return $this->successWithData(compact('vouchers'));
    }

    /**
     * @param  Request  $request
     * @param  ReceiptRepository  $repository
     * @param  AdminService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function vouchersDetails(Request $request, ReceiptRepository $repository, AdminService $service)
    {
        $receipt = $this->getReceiptByPermission($repository, $request->uuid, $service);
        if (is_null($receipt)) {
            return $this->failedWithMessage(__('finance::common.NoPermission'));
        }

        $details = $repository->getVouchersDetails($request->uuid, $request->vouchers_uuid);

        $details = DetailsResource::collection($details);

        return $this->successWithData(compact('details'));
    }


    /**
     * @param  ReceiptSearchRequest  $request
     * @param  ReceiptRepository  $repository
     * @param  AdminService  $service
     * @param  CustomerRepository  $customerRepository
     * @param  CustomerCompanyRepository  $companyRepository
     * @return \Illuminate\Http\JsonResponse
     * @throws ReceiptException
     */
    public function search(
        ReceiptSearchRequest $request,
        ReceiptRepository $repository,
        AdminService $service,
        CustomerRepository $customerRepository,
        CustomerCompanyRepository $companyRepository)
    {
        $user = Auth::user();
        if ($user->hasPermissionTo('finance.receipt.receipts.all')){
            $receipt = $repository->findByNumber($request->input('number'), 1);
        } else if ($user->hasPermissionTo('finance.receipt.receipts.group')){
            $admins = $service->getGroupAdmins($user)->pluck('uuid')->all();
            $receipt = $repository->findByNumber($request->input('number'), 2, $admins);
        } else {
            $receipt = $repository->findByNumber($request->input('number'), 3, $user->uuid);
        }
        if($receipt->isNotEmpty()) {
            $receipt = new ReceiptWithCustomerResource($receipt->first(), $customerRepository, $companyRepository);
        } else {
            throw new ReceiptException(__('finance::receipt.notFound'));
        }
        return $this->successWithData(compact('receipt'));
    }

    /**
     * @param  ReceiptIndexRequest  $request
     * @param  ReceiptRepository  $repository
     * @param  AdminService  $service
     * @return ReceiptsListCollectionResource
     */
    public function index(ReceiptIndexRequest $request, ReceiptRepository $repository, AdminService $service)
    {
        $filter = $request->input('filter');
        $user = Auth::user();
        if ($user->hasPermissionTo('finance.receipt.receipts.all')){
            $admins = [];
            $type = 1;
        } else if ($user->hasPermissionTo('finance.receipt.receipts.group')){
            $admins = $service->getGroupAdmins($user)->pluck('uuid')->all();
            $type = 2;
        } else {
            $type = 3;
            $admins = $user->uuid;
        }
        $sort = $request->input('sort') ?? [];
        $sort = $sort['created_at'] ?? "DESC";
        if($filter && isset($filter['key']) && $filter['key']){ // 走es查询逻辑
            $key = $filter['key'];
            $lists = $repository->getTypeIndexByES($type, $request->input('limit'), $key, $admins, $sort);
        } else {
            $repository->pushCriteria(new ListRequestCriteria($request));
            $lists = $repository->getTypeIndex($type, $request->input('limit'), $admins, $sort);
        }
        return new ReceiptsListCollectionResource($lists);
    }


    /**
     * @param  ApiSoftDeleteRequest  $request
     * @param  AdminService  $adminService
     * @param  ReceiptRepository  $receiptRepository
     * @return \Illuminate\Http\JsonResponse
     * @throws UnauthorizedException
     */
    public function apiSoftDelete(ApiSoftDeleteRequest $request, AdminService $adminService, ReceiptRepository $receiptRepository)
    {
        $user = $adminService->getAdminInfoById($request->input('admin_id'));
        $this->checkPermission($user, "finance.receipt.receipts.action");
        $receipt = $receiptRepository->getReceiptByNumber($request->input('number'));
        if (is_null($receipt)) {
            return  $this->failedWithMessage(__('finance::receipt.receiptNotFound'));
        }
        if ($receipt->claim_status != 0 && $receipt->create_from != 3) {
            return $this->failedWithMessage(__('finance::receipt.statusNotAllowDelete'));
        } else if ($receipt->create_from == 3 && $receipt->used > 0) {
            return $this->failedWithMessage(__('finance::receipt.advanceHasUsed'));
        }
        if ($receipt->create_from == 3) {
            $receipt->claims()->delete();
        }
        $receipt->delete();
        return $this->successWithMessage(__('finance::common.deleteSuccess'));
    }

    /**
     * @param  ApiSearchRequest  $request
     * @param  AdminService  $adminService
     * @param  ReceiptRepository  $receiptRepository
     * @return \Illuminate\Http\JsonResponse
     * @throws UnauthorizedException
     */
    public function apiSearch(ApiSearchRequest $request, AdminService $adminService, ReceiptRepository $receiptRepository)
    {
        $user = $adminService->getAdminInfoById($request->input('admin_id'));
        $this->checkPermission($user, 'finance.receipt.receipts.detail');

        if ($user->hasPermissionTo('finance.receipt.receipts.all')){
            $type = 1;
            $admins = [];
        } else if ($user->hasPermissionTo('finance.receipt.receipts.group')){
            $admins = $adminService->getGroupAdmins($user)->pluck('uuid')->all();
            $type = 2;
        } else {
            $admins = $user->uuid;
            $type = 3;
        }
        $number = $request->input('number') ?? "";
        $orderNumber = $request->input('order_number') ?? "";

        if($orderNumber) { // 获取订单单号的receipt
            $receipts = $receiptRepository->findByOrderNumberAndNumber($orderNumber, $number, $type, $admins);
        } else { // 直接从receipt 查询指定的单号
            $receipts = $receiptRepository->findByNumber($number, $type, $admins);
        }

        $receipts = ReceiptResource::collection($receipts);
        return $this->successWithData(compact('receipts'));
    }


    /**
     * @param  ApiUpdateFeeRequest  $request
     * @param  ReceiptRepository  $receiptRepository
     * @param  AdminService  $adminService
     * @return \Illuminate\Http\JsonResponse
     * @throws ReceiptException
     * @throws UnauthorizedException
     */
    public function apiUpdateFee(ApiUpdateFeeRequest $request, ReceiptRepository $receiptRepository, AdminService $adminService)
    {
        $user = $adminService->getAdminInfoById($request->input('admin_id'));
        $this->checkPermission($user, 'finance.receipt.receipts.action');
        $number = $request->input('number');
        $receipt = $receiptRepository->getReceiptByNumber($number);
        if(is_null($receipt)) {
            throw new ReceiptException(__("finance::receipt.receiptNotFound"));
        }
        $currency = $request->input('currency');

        $fee = $request->input('fee');

        $canUsd = $receipt->usable - $receipt->used;

        if ($currency != $receipt->currency) {
             $fee = Exchange::exchange($receipt->created_at, $currency, $fee, $receipt->currency);
        }

        if($fee < 0 && abs($fee) > $canUsd) {
            throw new ReceiptException(__("finance::receipt.receiptCanUseNotEnough"));
        }

        $receiptRepository->updateFee($receipt, $fee);

        return $this->successWithMessage(__("finance::common.updateSuccess"));
    }


    /**
     * @param  ApiUpdateFloatRequest  $request
     * @param  ReceiptRepository  $receiptRepository
     * @param  AdminService  $adminService
     * @return \Illuminate\Http\JsonResponse
     * @throws ReceiptException
     * @throws UnauthorizedException
     */
    public function apiUpdateFloat(ApiUpdateFloatRequest $request, ReceiptRepository $receiptRepository, AdminService $adminService)
    {
        $user = $adminService->getAdminInfoById($request->input('admin_id'));
        $this->checkPermission($user, 'finance.receipt.receipts.action');
        $number = $request->input('number');
        $receipt = $receiptRepository->getReceiptByNumber($number);
        if(is_null($receipt)) {
            throw new ReceiptException(__("finance::receipt.receiptNotFound"));
        }
        $currency = $request->input('currency');

        $float = $request->input('float');

        if ($currency != $receipt->currency) {
            $float = Exchange::exchange($receipt->created_at, $currency, $float, $receipt->currency);
        }

        $canUsd = $receipt->usable - $receipt->used;

        if($float < 0 && abs($float) > $canUsd) {
            throw new ReceiptException(__("finance::receipt.receiptCanUseNotEnough"));
        }

        $receiptRepository->updateFloat($receipt, $float);

        return $this->successWithMessage(__("finance::common.updateSuccess"));
    }

    /**
     * 下载指定的上传失败文件
     * @param  Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadUploadFailedData(Request $request)
    {
        $dir = 'app/tmp/' . date('Y-m-d') . '/' . $request->uuid . '/上传失败数据.xls';
        return response()->download(storage_path($dir));
    }

    /**
     * 队列下载数据
     * @param  ReceiptDownloadListRequest  $request
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function downloadList(ReceiptDownloadListRequest $request)
    {
        $email = Auth::user()->email;

        if(!$email) {
            return $this->failedWithMessage(__('finance::common.hasNotSetEmail'));
        }

        dispatch(new DownloadReceiptList($request->all()));
        return $this->successWithMessage(__('finance::receipt.downloadInQueue'));
    }


    /**
     * @param  ApiGetCustomerUnusedRequest  $request
     * @param  ReceiptRepository  $repository
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiGetCustomerUnused(ApiGetCustomerUnusedRequest $request, ReceiptRepository $repository)
    {
        $receipts = $repository->getUnusedReceiptByGNumber($request->input('customer_company_number'));
        $receipts = ReceiptResource::collection($receipts);

        return $this->successWithData(compact('receipts'));
    }


    /**
     * @param  Request  $request
     * @param  ReceiptRepository  $repository
     * @param  AdminService  $service
     * @param  ErpReceiptService  $erpReceiptService
     * @return \Illuminate\Http\JsonResponse
     */
    public function getApplication(Request $request, ReceiptRepository $repository, AdminService $service, ErpReceiptService $erpReceiptService)
    {
        $receipt = $this->getReceiptByPermission($repository, $request->uuid, $service);
        if (is_null($receipt)) {
            return $this->failedWithMessage(__('finance::common.NoPermission'));
        }

        $applications = $receipt->claims;
        $applications = ReceiptApplicationWithoutFilesResource::collection($applications);
        return $this->successWithData(compact('applications'));
    }
}

