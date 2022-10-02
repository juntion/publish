<?php

namespace Modules\Base\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SeedEsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'scout:seed-es';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'seed model data to elasticsearch';

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
        $action = $this->argument('action') ?: 'import';
        $module = $this->argument('module') ?: '';
        $models = $module == '' ? config('scout.models') : config('scout.models.'.$module);
        if (sizeof($models)) {
            collect($models)->each(function ($class) use ($action) {
                if(!is_array($class)) {
                    if (class_exists($class) && method_exists((new $class), 'shouldBeSearchable')) {
                        if ((new $class)->shouldBeSearchable()) {
                            $this->info('Start model ' . $class);
                            $this->call('scout:' . $action, ['model' => $class]);
                        }
                    }
                } else {
                    collect($class)->each(function ($c) use ($action) {
                        if (class_exists($c) && method_exists((new $c), 'shouldBeSearchable')) {
                            if ((new $c)->shouldBeSearchable()) {
                                $this->info('Start model ' . $c);
                                $this->call('scout:' . $action, ['model' => $c]);
                            }
                        }
                    });
                }
            });
        } else {
            $this->error('scout config file model not set');
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
            ['module', InputArgument::OPTIONAL, 'module name.']
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
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
