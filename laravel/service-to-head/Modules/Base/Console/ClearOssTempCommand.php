<?php

namespace Modules\Base\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Modules\Base\Entities\Base\OssTempUpload;
use Modules\Base\Support\Facades\OssService;
use OSS\Core\OssException;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ClearOssTempCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'oss:temp-clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '清除oss_temp_uploady一天前的临时数据';

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
        $res = OssTempUpload::query()->where('created_at', '<', Carbon::now()->modify('-1 days')->format('Y-m-d H:i:s'))->get(['uuid', 'bucket', 'object']);
        $objects = [];
        if ($res->count() < 1) {
            $this->info(Carbon::now()->format('Y-m-d H:i:s') . ' Good, no junk files for now!');
            return ;
        }
        $bucket = $res->first()->bucket;
        collect($res)->each(function ($item) use (&$objects) {
            $objects[$item->uuid] = $item->object;
        });
        if ($bucket && $objects) {
            try {
                $response = OssService::deleteObjects($bucket, $objects);
                OssTempUpload::destroy(array_keys($objects));
                $log = [];
                if (sizeof($response)) {
                    foreach ($response as $obj) {
                        $log[] = (string)$obj;
                    }
                } else {
                    $log = [$response];
                }
                Log::channel('oss_log')->debug('oss delete', $log);
                $this->info(Carbon::now()->format('Y-m-d H:i:s') . ' Clear success!');
            }catch (OssException $ossException) {
                $this->error($ossException->getMessage());
            }
        } else {
            $this->error(Carbon::now()->format('Y-m-d H:i:s') . ' bucket and object not found!');
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
            // ['example', InputArgument::REQUIRED, 'An example argument.'],
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
            // ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
