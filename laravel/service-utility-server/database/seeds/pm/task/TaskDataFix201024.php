<?php

use App\Enums\ProjectManage\DesignSubTaskStatus;
use App\Enums\ProjectManage\DevSubTaskStatus;
use App\Enums\ProjectManage\TestSubTaskStatus;
use App\Models\User;
use App\ProjectManage\Models\DesignPart;
use App\ProjectManage\Models\DevTask;
use App\ProjectManage\Models\TestTask;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class TaskDataFix201024 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::query()->first();
        Auth::login($admin);

        $designParts = DesignPart::query()->with('subTasks')->get();
        foreach ($designParts as $part) {
            if ($part->subTasks->isEmpty()) {
                $this->createEmptyDesignMainSubTask($part);
            }
        }

        $devTasks = DevTask::query()->with('subTasks')->get();
        foreach ($devTasks as $devTask) {
            if ($devTask->subTasks->isEmpty()) {
                $this->createEmptyDevMainSubtask($devTask);
            }
        }

        $testTasks = TestTask::query()->with('subTasks')->get();
        foreach ($testTasks as $testTask) {
            if ($testTask->subTasks->isEmpty()) {
                $this->createTestEmptyMainSubtask($testTask);
            }
        }
    }

    protected function createEmptyDesignMainSubTask($part)
    {
        $part->subTasks()->create([
            'task_id' => $part->task_id,
            'is_main' => 1,
            'status' => DesignSubTaskStatus::STATUS_CLOSED,
        ]);
    }

    protected function createEmptyDevMainSubtask($task)
    {
        $task->subTasks()->create([
            'is_main' => 1,
            'status' => DevSubTaskStatus::STATUS_CLOSED,
        ]);
    }

    protected function createTestEmptyMainSubtask($task)
    {
        $task->subTasks()->create([
            'is_main' => 1,
            'status' => TestSubTaskStatus::STATUS_CLOSED,
        ]);
    }
}
