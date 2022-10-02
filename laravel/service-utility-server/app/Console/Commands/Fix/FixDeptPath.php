<?php

namespace App\Console\Commands\Fix;

use App\Models\Department;
use Illuminate\Console\Command;

class FixDeptPath extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:dept-path';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '修复部门 path 字段数据';

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
        $this->fixDeptPathField();
    }

    /**
     * @param int $parentId
     * @author: King
     * @version: 2020/7/9 18:06
     */
    public function fixDeptPathField($parentId = 0)
    {
        Department::query()->where('parent_id', $parentId)
            ->get()
            ->each(function (Department $department) {
                $department->update(['path' => $department->getNewPath()]);
                $this->fixDeptPathField($department->id);
            });
    }
}
