<?php

namespace App\ProjectManage\Repositories;

use App\Enums\ProjectManage\ProductStatus;
use App\Enums\ProjectManage\TeamMemberType;
use App\Enums\ProjectManage\TeamType;
use App\Exceptions\System\InvalidParameterException;
use App\Models\User;
use App\ProjectManage\Models\Product;
use App\ProjectManage\Models\Team;

class TeamRepository
{
    // 创建团队成员
    public function createTeamMember(Team $team, $members)
    {
        foreach ($members as $item) {
            if (is_array($item)) {
                $userId = $item['user_id'];
                $type = $item['type'];
            } else {
                $userId = $item;
                $type = TeamMemberType::TYPE_PRODUCT;
            }
            $user = User::find($userId);
            if (!$user) {
                throw new InvalidParameterException("ID为{$userId} 的用户不存在或已被删除.");
            }
            $userDept = $user->department->first()->top();
            $team->members()->create([
                'user_id' => $userId,
                'user_name' => $user->name,
                'dept_id' => $userDept->id,
                'dept_name' => $userDept->name,
                'type' => $type,
            ]);
        }
    }

    /**
     * 通过关联的产品查找负责人
     * @param $hasProducts
     * @param $teamType
     * @return array
     */
    public function getTeamPrincipalByProducts($hasProducts, $teamType)
    {
        $result = [];
        $products = $hasProducts->products()->with('teams')->get();
        foreach ($products as $product) {
            $teams = $product->teams->where('type', $teamType);
            foreach ($teams as $team) {
                $result[] = [
                    'id' => $team->user_id,
                    'name' => $team->user_name
                ];
            }
        }
        return collect($result)->unique('id')->sortBy('name')->values()->toArray();
    }

    /**
     * @param $hasProducts
     * @return array
     */
    public function getDesignTeamsByProducts($hasProducts)
    {
        if ($hasProducts instanceof Product) {
            $product = $hasProducts;
        } else {
            $products = $hasProducts->products()->with(['teams', 'teams.members'])->get();
            $product = $products->where('type', ProductStatus::TypeProduct)->first();
        }
        $teams = $product->teams->where('type', TeamType::TYPE_DESIGN);
        return $this->formatDesignTeams($teams);
    }

    /**
     * @param $teams
     * @return array
     */
    public function formatDesignTeams($teams)
    {
        $result = [];
        foreach ($teams as $team) {
            $members = $team->members;
            $result[] = [
                'team_id' => $team->id,
                'user_id' => $team->user_id,
                'user_name' => $team->user_name,
                'members' => [
                    'interaction' => ($m = $members->where('type', TeamMemberType::TYPE_INTERACTIVE)->first()) ? $m->user_name : '',
                    'vision' => ($m = $members->where('type', TeamMemberType::TYPE_VISUAL)->first()) ? $m->user_name : '',
                    'frontend' => ($m = $members->where('type', TeamMemberType::TYPE_FRONTEND)->first()) ? $m->user_name : '',
                    'mobile' => ($m = $members->where('type', TeamMemberType::TYPE_MOBILE)->first()) ? $m->user_name : '',
                    'artist' => ($m = $members->where('type', TeamMemberType::TYPE_ART)->first()) ? $m->user_name : '',
                ],
            ];
        }
        return collect($result)->sortBy('team_id')->values()->toArray();
    }
}
