<?php

namespace App\Console\Commands\User;

use App\Events\User\UserDelete;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class BatchDeleteUsers1208 extends Command
{
    const DATA_SOURCE = __DIR__ . '/data/users_202011.xlsx';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:batch-delete-1208';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '批量注销用户(20201208)';

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
     * 导入
     * @return array|false
     */
    private function loadDataSource()
    {
        $result = [];
        try {
            $xlsxReader = new Xlsx();
            $spreadsheet = $xlsxReader->load(self::DATA_SOURCE);
            $dataSource = $spreadsheet->getActiveSheet()->toArray();
            foreach ($dataSource as $index => $item) {
                if ($index < 2) continue;
                // 多语言销售部的Dale.Jiang已经删除了，品质分析部又新增了一个同名账户，这里要跳过
                if ($item[0] == 'Dale.Jiang') {
                    continue;
                }
                $result[] = [
                    'name' => trim($item[0]),
                    'email' => $item[1] ?? '',
                ];
            }
            return $result;
        } catch (\Exception $e) {
            logger()->error($e);
            $this->error('导入数据源失败 ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = $this->loadDataSource();
        if (empty($data)) return;

        DB::transaction(function () use ($data) {
            $message = "本次计划删除账号" . count($data) . '个,';
            $delCount = 0;
            foreach ($data as $userData) {
                $user = User::query()->where($userData)->first();
                if ($user) {
                    // 触发事件同步删除
                    try {
                        event(new UserDelete($user));
                    } catch (\Exception $e) {
                        logger()->error('删除失败 ' . $e->getMessage(), [$user->toArray()]);
                        // 出现异常跳过删除
                        continue;
                    }
                    if ($user->delete()) {
                        $delCount++;
                    }
                }
            }
            $message .= "实际删除账号{$delCount}个.";
            info($message);
            $this->info('删除成功！');
        });
    }
}
