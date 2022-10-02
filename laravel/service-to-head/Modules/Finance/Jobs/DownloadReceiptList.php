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
use Modules\ERP\Repositories\InstockShippingRepository;
use Modules\Finance\Http\Requests\Receipt\ReceiptDownloadListRequest;
use Modules\Finance\Services\ReceiptListDownloadService;

class DownloadReceiptList implements ShouldQueue
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
    public function handle(AdminService $adminService, AdminRepository $adminRepository, InstockShippingRepository $instockShippingRepository)
    {
        $downDate = Carbon::now()->toJSON();
        $export = new ReceiptListDownloadService($this->user, $adminService, $this->request, $instockShippingRepository);

        $uuid = Str::uuid()->getHex()->toString();
        $tmpDir = 'tmp/' . date('Y-m-d') .'/receipts';//目录
        if (!is_dir(storage_path('app/'.$tmpDir))) {
            mkdir(storage_path('app/'.$tmpDir), 0777, true);
        }
        $fileName = '到款列表' . $uuid . '.xlsx';//文件名
        $fielPath = $tmpDir . '/' . $fileName;
        Excel::store($export, $fielPath);//生成excel文件

        $content = "您于{$downDate}下载的到款列表，已下载完成，请点击附件下载。";
        $root = $adminRepository::getAdminByName('root');
        $ccMail = $root->email;
        $toMail = $this->user->email ?? $ccMail;
        Mail::raw($content, function ($message) use ($toMail, $downDate, $ccMail, $fielPath) {
            $message->subject('到款列表下载结果' .$downDate);
            $message->to($toMail)->cc($ccMail);
            $message->attach(storage_path('app/'.$fielPath), ['as' => '到款列表.xlsx']);
        });
    }
}
