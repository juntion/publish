<?php

namespace Modules\Base\Console;

use Illuminate\Support\Str;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Commands\SeedCommand as Command;

class SeedMigrateCommand extends Command
{
    protected $name = 'module:seed-migrate';

    protected $description = '迁移原项目的数据,单个模块或者所有的';

    /**
     * Get master database seeder name for the specified module.
     *
     * @param string $name
     *
     * @return string
     */
    public function getSeederName($name)
    {
        $name = Str::studly($name);

        $namespace = $this->laravel['modules']->config('namespace');
        $config = GenerateConfigReader::read('seeder');
        $seederPath = str_replace('/', '\\', $config->getPath());

        return $namespace . '\\' . $name . '\\' . $seederPath . '\\' . $name . 'MigrateSeeder';
    }

}
