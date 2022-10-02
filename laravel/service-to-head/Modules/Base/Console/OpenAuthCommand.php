<?php

namespace Modules\Base\Console;

use Illuminate\Console\Command;
use Modules\Base\Entities\Base\OpenAuth;
use Modules\Base\Repositories\OpenAuthRepositories;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class OpenAuthCommand extends Command
{
    /**
     * The console command name.
     *
     * base:open-auth get 获取token，此token无过期时间，可选参数--exp=指定有效期(秒), 可选参数--remarks=备注
     * base:open-auth {close|open} accessKeyId，关闭或开启指定access key id
     * base:open-auth list 列出所有token信息
     *
     * @var string
     */
    protected $name = 'base:open-auth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage open api token.';

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
     * @return mixed
     */
    public function handle()
    {
        $action = $this->argument('action') ?: 'get';
        $accessKey = $this->argument('access_key_id') ?: 0;
        $expTime = $this->option('exp') ?: 0;
        $remarks = $this->option('remarks') ?: 'token by command';
        if (!in_array($action, ['get', 'close', 'open', 'list'])) {
            $this->error('Error Arguments');
            return;
        }
        switch ($action) {
            case 'get':
                $res = app(OpenAuthRepositories::class)->store([
                    'exp_time' => $expTime,
                    'remarks' => $remarks,
                ]);
                $this->info("Access key id: {$res->access_key_id}");
                $this->info("Access key secret: {$res->access_key_secret}");
                $this->info("Expire time: {$res->exp_time}");
                break;
            case 'close':
            case 'open':
                if ($accessKey) {
                    $res = app(OpenAuthRepositories::class)->changeStatus($accessKey, ($action == 'close' ? 1 : 0));
                    $res ? $this->info("$action success") : $this->error("$action failed");
                } else {
                    $this->error('Error Arguments');
                }
                break;
            case 'list':
                $allToken = OpenAuth::all(['access_key_id', 'access_key_secret', 'exp_time', 'status'])->toArray();
                $this->table(['key id', 'key secret', 'exp time', 'status'], $allToken);
                break;
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['action', InputArgument::REQUIRED, 'action name.'],
            ['access_key_id', InputArgument::OPTIONAL, 'access key id.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['exp', null, InputOption::VALUE_OPTIONAL, 'An exp time option.', null],
            ['remarks', null, InputOption::VALUE_OPTIONAL, 'An remarks option.', null],
        ];
    }
}
