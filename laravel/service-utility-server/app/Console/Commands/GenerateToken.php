<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class GenerateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:generate-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '快速为用户生成token(仅限测试用)';

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
        $userId = $this->ask('请输入用户id:');
        $user = User::find($userId);
        if (!$user) {
            return $this->error('用户不存在');
        }

        // 一天以后过期
        $ttl = 1 * 24 * 60;
        $this->info(Auth::guard()->setTTL($ttl)->fromUser($user));
    }
}
