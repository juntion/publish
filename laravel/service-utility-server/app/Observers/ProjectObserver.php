<?php


namespace App\Observers;


use App\ProjectManage\Models\Project;

class ProjectObserver
{
    public function updated(Project $project)
    {
        if ($project->isDirty('status')) {
            $project->createStatusLog($project->getOriginal('status'), $project->status);
        }
    }
}
