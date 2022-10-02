<?php

namespace App\ProjectManage\Models\Policies;

use App\Enums\ProjectManage\ProjectStatus;
use App\Models\User;
use App\ProjectManage\Models\Project;

class ProjectPolicy
{
    public function updateProject(User $user, Project $project)
    {
        return in_array($user->id, [
                $project->principal_user_id,
                $project->promulgator_id
            ]) && !in_array($project->status, [ProjectStatus::STATUS_COMPLETED, ProjectStatus::STATUS_REVOCATION]);
    }

    public function updateStatus(User $user, Project $project)
    {
        return in_array($user->id, [
                $project->principal_user_id
            ]) && !in_array($project->status, [ProjectStatus::STATUS_COMPLETED, ProjectStatus::STATUS_REVOCATION]);
    }


    public function projectSummary(User $user, Project $project)
    {
        return in_array($user->id, [
                $project->principal_user_id
            ]) && in_array($project->status, [ProjectStatus::STATUS_COMPLETED]);
    }
}
