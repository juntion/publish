<?php

namespace Modules\Finance\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admin\Contracts\AdminRepository;
use Modules\Admin\Contracts\AdminService;
use Modules\Base\Contracts\Company\CompanyRepository;
use Modules\ERP\Contracts\CustomerCompanyRepository;
use Modules\ERP\Contracts\CustomerRepository;
use Modules\ERP\Contracts\InstockShippingRepository;
use Modules\ERP\Contracts\OrderCustomerCompanyService;
use Modules\Finance\Http\Requests\Voucher\VoucherListDownloadRequest;
use Modules\Finance\Services\VoucherListDownloadService;

class DownloadVoucherList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;

        $this->user = Auth::user();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(
        AdminService $adminService,
        AdminRepository $adminRepository,
        OrderCustomerCompanyService $companyService,
        CustomerRepository $customerRepository,
        CustomerCompanyRepository $companyRepository,
        InstockShippingRepository $instockShippingRepository,
        CompanyRepository $orderCompanyRepository
    )
    {
        $downDate = Carbon::now()->toJSON();
        $export = new VoucherListDownloadService($this->user, $adminService, $this->request, $companyService, $customerRepository, $companyRepository, $instockShippingRepository, $orderCompanyRepository);

        $uuid = Str::uuid()->getHex()->toString();
        $tmpDir = 'tmp/' . date('Y-m-d') .'/vouchers';//目录
        if (!is_dir(storage_path('app/'.$tmpDir))) {
            mkdir(storage_path('app/'.$tmpDir), 0777, true);
        }
        $fileName = '凭证列表' . $uuid . '.xlsx';//文件名
        $fielPath = $tmpDir . '/' . $fileName;
        Excel::store($export, $fielPath);//生成excel文件

        $content = "您于{$downDate}下载的凭证列表，已下载完成，请点击附件下载。";
        $root = $adminRepository::getAdminByName('root');
        $ccMail = $root->email;
        $toMail = $this->user->email ?? $ccMail;
        Mail::raw($content, function ($message) use ($toMail, $downDate, $ccMail, $fielPath) {
            $message->subject('凭证列表下载结果' .$downDate);
            $message->to($toMail)->cc($ccMail);
            $message->attach(storage_path('app/'.$fielPath), ['as' => '凭证列表.xlsx']);
        });
    }
}
