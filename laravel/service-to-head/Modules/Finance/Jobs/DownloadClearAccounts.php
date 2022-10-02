<?php

namespace Modules\Finance\Jobs;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Modules\Admin\Contracts\AdminService;
use Modules\Finance\Contracts\InvoiceRepository;
use Modules\Admin\Contracts\AdminRepository;
use Modules\Finance\Services\InvoiceService;
use Modules\Finance\Services\ClearDownloadService;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;

class DownloadClearAccounts implements ShouldQueue
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
    public function handle(InvoiceService $invoiceService, InvoiceRepository $invoiceRepository, AdminService $adminService, AdminRepository $adminRepository)
    {
        $downDate = Carbon::now()->toJSON();
        $export = new ClearDownloadService($invoiceService, $invoiceRepository, $adminService, $this->user, $this->request);

        $tmpDir = 'tmp/' . date('Y-m-d');//目录
        if (!is_dir(storage_path('app/'.$tmpDir))) {
            mkdir(storage_path('app/'.$tmpDir), 0777, true);
        }
        $fileName = '清账表+' . Str::uuid()->getHex()->toString() . '.xlsx';//文件名
        $fielPath = $tmpDir . '/' . $fileName;
        Excel::store($export, $fielPath);//生成excel文件

        $content = "您于{$downDate}下载的清账表，已下载完成，请点击附件下载。";
        $root = $adminRepository::getAdminByName('root');
        $ccMail = $root->email;
        $toMail = $this->user->email??$ccMail;
        Mail::raw($content, function ($message) use ($toMail, $downDate, $ccMail, $fielPath) {
            $message->subject('清账表下载结果' .$downDate);
            $message->to($toMail)->cc($ccMail);
            $message->attach(storage_path('app/'.$fielPath));
        });
    }
}
