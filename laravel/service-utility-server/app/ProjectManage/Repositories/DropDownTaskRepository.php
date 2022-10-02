<?php

namespace App\ProjectManage\Repositories;

use App\Enums\ProjectManage\TeamMemberType;
use App\Enums\ProjectManage\TeamType;
use App\Models\Position;
use App\Models\Post;
use App\ProjectManage\Models\Team;
use App\ProjectManage\Models\TeamMember;
use Illuminate\Support\Collection;

class DropDownTaskRepository
{
    /**
     * @param int $type
     * @return array
     */
    public function getTeamsByType($type = TeamType::TYPE_PRODUCT)
    {
        $teams = Team::query()->where('type', $type)->get();
        $result = $teams->map(function ($team) {
            return [
                'id' => $team->user_id,
                'name' => $team->user_name,
            ];
        });
        return $result->unique('id')->sortBy('name')->values()->toArray();
    }

    /**
     * @param int|array $type
     * @return array
     */
    public function getTeamMembersByType($type = TeamMemberType::TYPE_PRODUCT)
    {
        if (!is_array($type)) {
            $type = (array)$type;
        }
        $members = TeamMember::query()->whereIn('type', $type)->get();
        $result = $members->map(function ($member) {
            return [
                'id' => $member->user_id,
                'name' => $member->user_name,
            ];
        });
        return $result->unique('id')->sortBy('name')->values()->toArray();
    }

    /**
     * @return array
     */
    public function productFollower()
    {
        $productMembers = $this->getTeamMembersByType();
        $result = collect($productMembers)->merge($this->getTeamsByType());
        return $result->unique('id')->sortBy('name')->values()->toArray();
    }

    /**
     * @param $number string|array
     * @return array
     */
    public function getUsersByPosition($number)
    {
        if (!is_array($number)) {
            $number = [$number];
        }
        $result = collect();
        $positions = Position::query()->whereIn('number', $number)->with('users')->get();
        foreach ($positions as $position) {
            $result = $result->merge($this->filterFields($position->users));
        }
        return $result->unique('id')->sortBy('name')->values()->toArray();
    }

    /**
     * @param $number string
     * @return mixed
     */
    public function getUsersByPost($number)
    {
        $post = Post::query()->where('number', $number)->first();
        return $post->users()->get();
    }

    /**
     * @param Collection $usersCollection
     * @return array
     */
    protected function filterFields(Collection $usersCollection)
    {
        return $usersCollection->map(function ($user) {
            return ['id' => $user->id, 'name' => $user->name];
        })->toArray();
    }

    /**
     * 职位编号为 J0012 、 J0013 、 J0014 、 J0015 的所有用户
     * @return array
     */
    public function testTaskHandler()
    {
        return $this->getUsersByPosition(['J0012', 'J0013', 'J0014', 'J0015']);
    }

    /**
     * 职位编号为 J0014 ，但岗位编号不为 G0006 的用户数据
     * @return array
     */
    public function devTaskHandler()
    {
        $positionUsers = $this->getUsersByPosition('J0014');

        $postUsers = $this->getUsersByPost('G0006');
        $filterIds = $postUsers->pluck('id')->toArray();
        if (!empty($filterIds)) {
            $result = collect($positionUsers)->filter(function ($user) use ($filterIds) {
                return !in_array($user['id'], $filterIds);
            });
            return $result->values()->toArray();
        }
        return $positionUsers;
    }

    /**
     * @return array
     */
    public function designPrincipal()
    {
        $users = $this->getTeamsByType(TeamType::TYPE_DESIGN);
        // 加上角色环节的负责人
        $partUsers = $this->getTeamMembersByType([
            TeamMemberType::TYPE_INTERACTIVE,
            TeamMemberType::TYPE_VISUAL,
            TeamMemberType::TYPE_ART,
            TeamMemberType::TYPE_FRONTEND,
            TeamMemberType::TYPE_MOBILE,
        ]);
        return collect($users)->merge($partUsers)
            ->unique('id')->sortBy('name')->values()->toArray();
    }

    /**
     * @return array
     */
    public function devPrincipal()
    {
        return $this->getTeamsByType(TeamType::TYPE_DEVELOP);
    }

    /**
     * @return array
     */
    public function testPrincipal()
    {
        return $this->getUsersByPosition(['J0012', 'J0013', 'J0014', 'J0015']);
    }

    /**
     * @return array
     */
    public function frontendPrincipal()
    {
        return $this->getTeamsByType(TeamType::TYPE_FRONTEND);
    }

    /**
     * @return array
     */
    public function mobilePrincipal()
    {
        return $this->getTeamsByType(TeamType::TYPE_MOBILE);
    }
}
