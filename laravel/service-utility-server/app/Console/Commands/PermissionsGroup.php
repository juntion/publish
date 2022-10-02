<?php

namespace App\Console\Commands;

use App\Models\Permission\Permission;
use App\Support\Data\PermissionData;
use Illuminate\Console\Command;

class PermissionsGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:update-group';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新权限 group 字段';

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
        $data = collect(PermissionData::getData())->keyBy(function ($item) {
            return $item['name'] . $item['guard_name'];
        });
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $tmp = $data->get($permission->name . $permission->guard_name);
            $group = $tmp['group'] ?? '';
            if (!$group || $group == $permission->group) continue;
            $permission->update(['group' => $group]);
        }
        $this->info('更新成功');
    }
}
