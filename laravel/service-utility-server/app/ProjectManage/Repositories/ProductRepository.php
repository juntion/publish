<?php

namespace App\ProjectManage\Repositories;

use App\Enums\ProjectManage\ProductStatus;
use App\Enums\ProjectManage\TeamMemberType;
use App\Enums\ProjectManage\TeamType;
use App\Exceptions\System\InvalidParameterException;
use App\Models\User;
use App\ProjectManage\Models\Product;
use App\ProjectManage\Models\Team;
use Illuminate\Http\Request;

class ProductRepository
{
    /**
     * @var TeamRepository
     */
    private $team;

    public function __construct(TeamRepository $team)
    {
        $this->team = $team;
    }

    /**
     * 更新产品字段
     * @param Product $product
     * @param $data
     * @return bool
     */
    public function update(Product $product, $data)
    {
        return $product->update($data);
    }

    /**
     * 创建产品线
     * @param $data
     */
    public function create($data)
    {
        $productLine = Product::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'type' => ProductStatus::TypeLine,
            'status' => ProductStatus::STATUS_ON,
        ]);
        if (isset($data['products'])) {
            $this->createProduct($data['products'], $productLine->id);
        }
    }

    /**
     * 添加产品
     * @param Product $product
     * @param $data
     */
    public function addProducts(Product $product, $data)
    {
        $this->createProduct($data['products'], $product->id);
    }

    /**
     * @param $data
     * @param int $parentId
     * @param int $type
     */
    public function createProduct($data, $parentId = 0, $type = ProductStatus::TypeProduct): void
    {
        $parentProduct = Product::query()->find($parentId);
        foreach ($data as $product) {
            Product::create([
                'name' => $product['name'],
                'description' => $product['description'],
                'type' => $type,
                'parent_id' => $parentId,
                'status' => $parentProduct ? $parentProduct->status : ProductStatus::STATUS_ON,
            ]);
        }
    }

    /**
     * 产品排序
     * @param $data
     */
    public function sort($data)
    {
        foreach ($data as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $product->update(['sort' => $item['sort']]);
            }
        }
    }

    /**
     * 获取产品团队及成员
     * @param Product $product
     * @return array
     */
    public function getTeams(Product $product)
    {
        $teams = $product->teams()->orderBy('type')->orderBy('is_default', 'desc')->with('members')->get();

        return ['teams' => $teams, 'edit_format' => $this->editFormat($teams)];
    }

    /**
     * @param $teams
     * @return array
     */
    protected function editFormat($teams)
    {
        $result = [];
        $teams->map(function (Team $team) use (&$result) {
            if ($team->type == TeamType::TYPE_PRODUCT) {
                if ($team->is_default == 1) {
                    $productMembers = $team->members()->get();
                    $result['product_user'] = [
                        'main_user' => ['user_id' => $team->user_id, 'user_name' => $team->user_name,],
                        'members' => $productMembers->map(function ($item) {
                            return ['user_id' => $item->user_id, 'user_name' => $item->user_name];
                        }),
                    ];
                } else {
                    $result['product_user']['other_user'][] = ['user_id' => $team->user_id, 'user_name' => $team->user_name];
                }
            }

            if ($team->type == TeamType::TYPE_DESIGN) {
                $result['design_user'][] = [
                    'design_user_id' => $team->user_id,
                    'design_user_name' => $team->user_name,
                    'is_default' => $team->is_default,
                    'members' => $team->members()->get()->map(function ($member) {
                        return [
                            'type' => $member->type,
                            'user_id' => $member->user_id,
                            'user_name' => $member->user_name,
                        ];
                    }),
                ];
            }

            if ($team->type == TeamType::TYPE_DEVELOP) {
                if ($team->is_default == 1) {
                    $result['dev_user']['main_user'] = [
                        'user_id' => $team->user_id,
                        'user_name' => $team->user_name,
                    ];
                } else {
                    $result['dev_user']['other_user'][] = [
                        'user_id' => $team->user_id,
                        'user_name' => $team->user_name,
                    ];
                }
            }

            if ($team->type == TeamType::TYPE_TEST) {
                if ($team->is_default == 1) {
                    $result['test_user']['main_user'] = [
                        'user_id' => $team->user_id,
                        'user_name' => $team->user_name,
                    ];
                } else {
                    $result['test_user']['other_user'][] = [
                        'user_id' => $team->user_id,
                        'user_name' => $team->user_name,
                    ];
                }
            }

            if ($team->type == TeamType::TYPE_FRONTEND) {
                if ($team->is_default == 1) {
                    $result['frontend_user']['main_user'] = [
                        'user_id' => $team->user_id,
                        'user_name' => $team->user_name,
                    ];
                } else {
                    $result['frontend_user']['other_user'][] = [
                        'user_id' => $team->user_id,
                        'user_name' => $team->user_name,
                    ];
                }
            }

            if ($team->type == TeamType::TYPE_MOBILE) {
                if ($team->is_default == 1) {
                    $result['mobile_user']['main_user'] = [
                        'user_id' => $team->user_id,
                        'user_name' => $team->user_name,
                    ];
                } else {
                    $result['mobile_user']['other_user'][] = [
                        'user_id' => $team->user_id,
                        'user_name' => $team->user_name,
                    ];
                }
            }
        });
        return $result;
    }

    /**
     * 团队主负责人绑定
     * @param $product
     * @param $data
     */
    public function teams(Product $product, $data)
    {
        if (isset($data['product_user_id'])) {
            $this->deleteTeam($product, TeamType::TYPE_PRODUCT);
            $this->createTeam($product, $data['product_user_id'], TeamType::TYPE_PRODUCT);
        }

        if (isset($data['design_user_id'])) {
            $this->deleteTeam($product, TeamType::TYPE_DESIGN);
            $this->createTeam($product, $data['design_user_id'], TeamType::TYPE_DESIGN);
        }

        if (isset($data['dev_user_id'])) {
            $this->deleteTeam($product, TeamType::TYPE_DEVELOP);
            $this->createTeam($product, $data['dev_user_id'], TeamType::TYPE_DEVELOP);
        }

        if (isset($data['test_user_id'])) {
            $this->deleteTeam($product, TeamType::TYPE_TEST);
            $this->createTeam($product, $data['test_user_id'], TeamType::TYPE_TEST);
        }

        if (isset($data['frontend_user_id'])) {
            $this->deleteTeam($product, TeamType::TYPE_FRONTEND);
            $this->createTeam($product, $data['frontend_user_id'], TeamType::TYPE_FRONTEND);
        }

        if (isset($data['mobile_user_id'])) {
            $this->deleteTeam($product, TeamType::TYPE_MOBILE);
            $this->createTeam($product, $data['mobile_user_id'], TeamType::TYPE_MOBILE);
        }
    }

    /**
     * 删除产品绑定的团队
     * @param Product $product
     * @param $teamType
     * @param int $isDefault
     */
    protected function deleteTeam(Product $product, $teamType, $isDefault = 1)
    {
        $team = $this->getTeamByType($product, $teamType, $isDefault);
        $team->each(function ($item) {
            $item->delete();
        });
    }

    /**
     * @param Product $product
     * @param $type
     * @param int $isDefault
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTeamByType(Product $product, $type, $isDefault = 1)
    {
        if (!is_array($isDefault)) {
            $isDefault = [$isDefault];
        }
        return $product->teams()->where('type', $type)->whereIn('is_default', $isDefault)->get();
    }

    /**
     * @param Product $product
     * @return array
     */
    public function getDefaultDesignTeamMembers(Product $product)
    {
        $team = $product->teams()->where('type', TeamType::TYPE_DESIGN)->where('is_default', 1)->with('members')->first();
        $result = [];
        if ($team) {
            $team->members->map(function ($member) use (&$result) {
                if ($member->type == TeamMemberType::TYPE_ART) {
                    $result['art'] = [
                        'type' => $member->type,
                        'user_id' => $member->user_id,
                        'user_name' => $member->user_name,
                    ];
                }
                if ($member->type == TeamMemberType::TYPE_FRONTEND) {
                    $result['front'] = [
                        'type' => $member->type,
                        'user_id' => $member->user_id,
                        'user_name' => $member->user_name,
                    ];
                }
                if ($member->type == TeamMemberType::TYPE_MOBILE) {
                    $result['mobile'] = [
                        'type' => $member->type,
                        'user_id' => $member->user_id,
                        'user_name' => $member->user_name,
                    ];
                }
                if ($member->type == TeamMemberType::TYPE_INTERACTIVE) {
                    $result['interactive'] = [
                        'type' => $member->type,
                        'user_id' => $member->user_id,
                        'user_name' => $member->user_name,
                    ];
                }
                if ($member->type == TeamMemberType::TYPE_VISUAL) {
                    $result['visual'] = [
                        'type' => $member->type,
                        'user_id' => $member->user_id,
                        'user_name' => $member->user_name,
                    ];
                }
            });
        }
        return $result;
    }

    /**
     * 创建产品团队
     * @param $product
     * @param $user
     * @param $type
     * @param int $isDefault
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createTeam(Product $product, $user, $type, $isDefault = 1)
    {
        if (!($user instanceof User)) {
            $userId = $user;
            $user = User::find($userId);
            if (!$user) {
                throw new InvalidParameterException("ID为{$userId} 的用户不存在或已被删除.");
            }
        }
        $userDept = $user->department->first()->top();
        if (empty($userDept)) {
            throw new InvalidParameterException("用户: {$user->name} 未绑定部门！");
        }
        return $product->teams()->create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'dept_id' => $userDept->id,
            'dept_name' => $userDept->name,
            'type' => $type,
            'is_default' => $isDefault,
        ]);
    }

    /**
     * 绑定产品团队及成员
     * @param Product $product
     * @param $data
     * @throws InvalidParameterException
     */
    public function members(Product $product, $data)
    {
        // 清除之前绑定的数据
        $product->teams()->delete();

        // 创建开发团队
        if (isset($data['dev_user'])) {
            // 主负责人
            $this->createTeam($product, $data['dev_user']['main_user'], TeamType::TYPE_DEVELOP, 1);
            // 次负责人
            if (isset($data['dev_user']['other_user'])) {
                $devUsers = collect($data['dev_user']['main_user'])->merge($data['dev_user']['other_user']);
                if ($devUsers->count() != $devUsers->unique()->count()) {
                    throw new InvalidParameterException('开发团队不可重复绑定负责人！');
                }
                foreach ($data['dev_user']['other_user'] as $productUser) {
                    $this->createTeam($product, $productUser, TeamType::TYPE_DEVELOP, 0);
                }
            }
        }

        // 创建测试团队
        if (isset($data['test_user'])) {
            // 主负责人
            $this->createTeam($product, $data['test_user']['main_user'], TeamType::TYPE_TEST, 1);
            // 次负责人
            if (isset($data['test_user']['other_user'])) {
                $testUsers = collect($data['test_user']['main_user'])->merge($data['test_user']['other_user']);
                if ($testUsers->count() != $testUsers->unique()->count()) {
                    throw new InvalidParameterException('测试团队不可重复绑定负责人！');
                }
                foreach ($data['test_user']['other_user'] as $testUser) {
                    $this->createTeam($product, $testUser, TeamType::TYPE_TEST, 0);
                }
            }
        }

        // 创建产品团队及成员
        if (isset($data['product_user'])) {
            // 主负责人及团队成员
            $productMainTeam = $this->createTeam($product, $data['product_user']['main_user'], TeamType::TYPE_PRODUCT, 1);
            if (isset($data['product_user']['members'])) {
                $this->team->createTeamMember($productMainTeam, $data['product_user']['members']);
            }
            // 次负责人
            if (isset($data['product_user']['other_user'])) {
                $productUsers = collect($data['product_user']['main_user'])->merge($data['product_user']['other_user']);
                if ($productUsers->count() != $productUsers->unique()->count()) {
                    throw new InvalidParameterException('产品团队不可重复绑定负责人！');
                }
                foreach ($data['product_user']['other_user'] as $productUser) {
                    $this->createTeam($product, $productUser, TeamType::TYPE_PRODUCT, 0);
                }
            }
        }

        // 创建设计团队及成员
        if (isset($data['design_user'])) {
            /*$designUsers = $data['design_user'];
            if (count($designUsers) != collect($designUsers)->unique('design_user_id')->count()) {
                throw new InvalidParameterException('设计团队不能选择相同的主负责人');
            }*/

            foreach ($data['design_user'] as $index => $item) {
                // 第一个是默认
                $isDefault = $index == 0 ? 1 : 0;
                $designTeam = $this->createTeam($product, $item['design_user_id'], TeamType::TYPE_DESIGN, $isDefault);
                if (isset($item['members'])) {
                    $this->team->createTeamMember($designTeam, $item['members']);
                }
            }
        }

        // 创建前端团队
        if (isset($data['frontend_user'])) {
            // 主负责人
            $this->createTeam($product, $data['frontend_user']['main_user'], TeamType::TYPE_FRONTEND, 1);
            // 次负责人
            if (isset($data['frontend_user']['other_user'])) {
                $frontUsers = collect($data['frontend_user']['main_user'])->merge($data['frontend_user']['other_user']);
                if ($frontUsers->count() != $frontUsers->unique()->count()) {
                    throw new InvalidParameterException('前端团队不可重复绑定负责人！');
                }
                foreach ($data['frontend_user']['other_user'] as $productUser) {
                    $this->createTeam($product, $productUser, TeamType::TYPE_FRONTEND, 0);
                }
            }
        }

        // 创建移动端团队
        if (isset($data['mobile_user'])) {
            // 主负责人
            $this->createTeam($product, $data['mobile_user']['main_user'], TeamType::TYPE_MOBILE, 1);
            // 次负责人
            if (isset($data['mobile_user']['other_user'])) {
                $mobileUsers = collect($data['mobile_user']['main_user'])->merge($data['mobile_user']['other_user']);
                if ($mobileUsers->count() != $mobileUsers->unique()->count()) {
                    throw new InvalidParameterException('移动端团队不可重复绑定负责人！');
                }
                foreach ($data['mobile_user']['other_user'] as $productUser) {
                    $this->createTeam($product, $productUser, TeamType::TYPE_MOBILE, 0);
                }
            }
        }
    }

    // 添加产品模块
    public function modules($product, $data)
    {
        $this->createProduct($data, $product->id, ProductStatus::TypeModule);
    }

    // 添加模块标签
    public function labels($product, $data)
    {
        $data['description'] = '';
        $this->createProduct([$data], $product->id, ProductStatus::TypeCategory);
    }

    // 更改产品状态
    public function status(Product $product, $data)
    {
        $product->update($data);
        // 关闭时，下级需联动关闭
        if ($data['status'] == ProductStatus::STATUS_OFF) {
            $this->closeProduct($product);
        }

        // 开启时，父级也需要同步开启
        if ($data['status'] == ProductStatus::STATUS_ON) {
            $this->openParentProduct($product);
        }
    }

    /**
     * 递归关闭子级产品
     * @param Product $product
     */
    protected function closeProduct(Product $product)
    {
        $product->update(['status' => ProductStatus::STATUS_OFF]);
        $childrens = $product->children;
        if ($childrens->toArray()) {
            foreach ($childrens as $item) {
                $this->closeProduct($item);
            }
        }
    }

    /**
     * 递归开启父级产品
     * @param Product $product
     */
    protected function openParentProduct(Product $product)
    {
        $product->update(['status' => ProductStatus::STATUS_ON]);
        if ($parent = $product->parent) {
            $this->openParentProduct($parent);
        }
    }

    /**
     * 产品线列表
     * @param $request
     * @return mixed
     */
    public function list(Request $request)
    {
        $product = Product::query()->orderBy('sort', 'asc');
        if ($request->has('status')) {
            $product = $product->where('status', $request->input('status'));
        }
        // 产品线ID，不传返回type=0的所有产品线，有值返回其下一级
        if ($productId = $request->product_id) {
            return $product->where('parent_id', $productId)->get();
        }
        return $product->isLine()->get();
    }
}
