<?php

namespace Modules\Base\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TempFileClearCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'tempFile:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '删除临时上传/下载的文件';

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
        $dirs = Storage::directories('tmp');
        $todayDir = 'tmp/'. date('Y-m-d');
        foreach ($dirs as $dir) {
            if ($dir != $todayDir) {
                Storage::deleteDirectory($dir); // 删除文件夹
            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
