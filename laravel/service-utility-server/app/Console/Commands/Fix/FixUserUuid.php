<?php

namespace App\Console\Commands\Fix;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FixUserUuid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:user-uuid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更改uuid生成规则并重新生成user表的数据';

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
        if (file_exists(storage_path('logs/uuid.log'))) {
            unlink(storage_path('logs/uuid.log'));
        }
        $old = User::all(['uuid']);
        $old->each(function ($item) {
            $uuid = Str::uuid()->getHex();
            $sql = "UPDATE `users` SET `uuid`='{$uuid}' WHERE `uuid`='{$item->uuid}';" . PHP_EOL;
            file_put_contents(storage_path('logs/uuid.log'), $sql, FILE_APPEND);
        });
        $this->info('执行成功');
    }
}
