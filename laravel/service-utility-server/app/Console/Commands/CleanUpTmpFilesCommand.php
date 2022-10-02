<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class CleanUpTmpFilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmp:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '清理临时文件';

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
        // 获取tmp下目录
        $directories = Storage::disk('tmp')->directories();
        $directories = array_filter($directories, function ($dir) {
            return $dir <= Carbon::yesterday()->toDateString();
        });
        foreach ($directories as $directory) {
            $result = Storage::disk('tmp')->deleteDirectory($directory);
            if ($result) {
                $this->info('Temporary files cleared successfully');
            } else {
                $this->info('Execute successfully. No directory exists');
            }
        }
    }
}
