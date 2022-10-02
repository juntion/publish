<?php

namespace App\ProjectManage\Repositories;

use App\Enums\ProjectManage\AppealStatus;
use App\Enums\ProjectManage\DemandStatus;
use App\Enums\ProjectManage\ProductStatus;
use App\Enums\ProjectManage\TeamType;
use App\Exceptions\System\InvalidParameterException;
use App\Http\Resources\AppealResource;
use App\Models\User;
use App\ProjectManage\Models\Appeal;
use App\ProjectManage\Models\Label;
use App\ProjectManage\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AppealRepository
{
    protected $teams;

    public function __construct(TeamRepository $teams)
    {
        $this->teams = $teams;
    }

    /**
     * 发布诉求
     * @param Request $request
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function store(Request $request)
    {
        $data = $request->validated();
        if ($request->questions) {
            $data['questions'] = json_encode($request->questions);
        }
        //发布人
        $promulgatorUser = Auth::user();
        $data['promulgator_id'] = $promulgatorUser->id;
        $data['promulgator_name'] = $promulgatorUser->name;
        $data['dept_id'] = $promulgatorUser->basicDepartment->id;
        $data['dept_name'] = $promulgatorUser->basicDepartment->name;
        //产品负责人
        $product = Product::query()->find($request->input('product_id'));
        if ($product->type != ProductStatus::TypeProduct) {
            throw new InvalidParameterException('产品选择有误！');
        }
        $productPrincipalUser = $this->getPrincipalInfoByProductId($product);
        if (empty($productPrincipalUser)) {
            throw new InvalidParameterException('产品负责人不能为空，请先设置产品负责人');
        }
        $data['principal_user_id'] = $productPrincipalUser->user_id;
        $data['principal_user_name'] = $productPrincipalUser->user_name;
        $data['status'] = AppealStatus::STATUS_TO_DISTRIBUTION;
        $appeal = Appeal::query()->create($data);

        $this->attachProducts($appeal, $product, $request->input('product_modules', []));

        // 用户关注
        if ($userIds = $request->attention_user_ids) {
            $users = User::query()->whereIn('id', $userIds)->get();
            foreach ($userIds as $id) {
                $user = $users->where('id', $id)->first();
                $userDept = $user->basicDepartment;
                $appeal->attentionAble()->create([
                    'user_id' => $id,
                    'user_name' => $user->name,
                    'dept_id' => $userDept->id,
                    'dept_name' => $userDept->name,
                ]);
            }
        }
        $this->addUpdatedTagToRelateUsers($appeal);

        // 保存附件
        if ($medias = $request->media) {
            $appeal->addMedias($medias);
        }
    }

    /**
     * 编辑诉求
     * @param Appeal $appeal
     * @param Request $request
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function update(Appeal $appeal, Request $request)
    {
        $data = $request->validated();
        $data['is_urgent'] = $request->input('is_urgent', 0);
        $data['is_important'] = $request->input('is_important', 0);
        $data['questions'] = $request->has('questions') ? json_encode($request->questions) : '';
        if (!$request->has('source_project_id')) {
            $data['source_project_id'] = 0;
            $data['source_project_name'] = '';
        }

        //发布人
        $promulgatorUser = Auth::user();
        $data['promulgator_id'] = $promulgatorUser->id;
        $data['promulgator_name'] = $promulgatorUser->name;
        $data['dept_id'] = $promulgatorUser->basicDepartment->id;
        $data['dept_name'] = $promulgatorUser->basicDepartment->name;
        //产品负责人
        $product = Product::query()->find($request->input('product_id'));

        // 原来的 产品id
        $origin_products_id = $appeal->products()->get()->firstWhere('type', ProductStatus::TypeProduct);
        $update_principal_user = $request->input('product_id') != $origin_products_id->id;
        if ($product->type != ProductStatus::TypeProduct) {
            throw new InvalidParameterException('产品选择有误！');
        }
        $productPrincipalUser = $this->getPrincipalInfoByProductId($product);
        if (empty($productPrincipalUser)) {
            throw new InvalidParameterException('产品负责人不能为空，请先设置产品负责人');
        }
        if ($update_principal_user) {
            $data['principal_user_id'] = $productPrincipalUser->user_id;
            $data['principal_user_name'] = $productPrincipalUser->user_name;
        }

        $this->relatedUpdate($appeal, $product, $request);
        // 更新诉求
        $appeal->updated_at = now();
        $appeal->update($data);
    }

    /**
     * 更新关联的产品、用户关注和附件
     * @param Appeal $appeal
     * @param $product
     * @param $request
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    protected function relatedUpdate(Appeal $appeal, $product, Request $request)
    {
        $changes = [];

        if ($productChanges = $this->appealProductsChange($appeal, $request)) {
            $changes[] = $productChanges;
        }

        $appeal->products()->detach();
        $this->attachProducts($appeal, $product, $request->input('product_modules', []));

        // 用户关注
        if ($userIds = $request->attention_user_ids) {
            $oldAttentionUsers = $appeal->attentionAble();
            $users = User::query()->whereIn('id', $userIds)->get();
            $changes[] = [
                'name' => '需他关注',
                'old' => implode(',', $oldAttentionUsers->pluck('user_name')->toArray()),
                'new' => implode(',', $users->pluck('name')->toArray()),
            ];
            $oldAttentionUsers->delete();
            foreach ($userIds as $id) {
                $user = $users->where('id', $id)->first();
                $userDept = $user->basicDepartment;
                $appeal->attentionAble()->create([
                    'user_id' => $id,
                    'user_name' => $user->name,
                    'dept_id' => $userDept->id,
                    'dept_name' => $userDept->name,
                ]);
            }
        }
        $this->addUpdatedTagToRelateUsers($appeal);

        // 处理附件
        $oldMedias = $appeal->media()->get();
        if ($oldMedia = $request->old_media) {
            // $oldMedia 是要保留的附件
            $deleteMedias = $oldMedias->pluck('id')->reject(function ($item) use ($oldMedia) {
                return in_array($item, $oldMedia);
            })->toArray();
            $appeal->media()->whereIn('id', $deleteMedias)->delete();
        } else {
            $oldMedias->each(function ($media) {
                $media->delete();
            });
        }
        if ($newMedias = $request->new_media) {
            $oldMedias = $oldMedias ?? $appeal->media()->get();
            $medias = collect($newMedias)->map(function ($item) {
                return $item->getClientOriginalName();
            });
            $changes[] = [
                'name' => '更新附件',
                'old' => implode(',', $oldMedias->pluck('name')->toArray()),
                'new' => implode(',', $medias->toArray()),
            ];
            $appeal->addMedias($newMedias);
        }

        // 将修改写入缓存
        $appeal->getUpdatedCacheInstance()->put($appeal->getUpdatedCacheKey(), json_encode($changes), 600);
    }

    /**
     * 诉求关联产品变化
     * @param Appeal $appeal
     * @param Request $request
     * @return array
     */
    protected function appealProductsChange(Appeal $appeal, Request $request)
    {
        // 原始关联产品
        $oldProducts = $appeal->products()->wherePivot('type', '!=', ProductStatus::TypeCategory)->get();
        $oldProductNames = implode(',', $oldProducts->pluck('name')->toArray());

        // 新传过来的产品类别
        $product = Product::query()->find($request->input('product_id'));
        $productLine = $product->parent;
        $modulesIds = collect($request->input('product_modules'))->map(function ($item) {
            return $item['module_id'];
        });
        $productModules = Product::query()->whereIn('id', $modulesIds->toArray())->get();
        $newProducts = collect([$productLine])->merge([$product])->merge($productModules);
        $newProductNames = implode(',', $newProducts->pluck('name')->toArray());

        if ($oldProductNames != $newProductNames) {
            return [
                'name' => '所属产品或模块',
                'old' => $oldProductNames,
                'new' => $newProductNames,
            ];
        }
        return [];
    }

    /**
     * @param Appeal $appeal
     * @throws \Exception
     */
    public function delete(Appeal $appeal)
    {
        $media = $appeal->media();
        // 删除媒体文件
        $media->get()->each(function ($media) {
            Storage::disk($media->disk)->delete($media->getPath());
        });
        $media->delete();
        $appeal->attentionAble()->delete();
        $appeal->demand()->delete();
        $appeal->delete();
    }

    /**
     * 撤销
     * @param Appeal $appeal
     */
    public function revocation(Appeal $appeal)
    {
        $appeal->demand()->delete();
        $appeal->update(['status' => AppealStatus::STATUS_REVOCATION, 'demand_id' => 0]);
    }

    /**
     * 贴标签
     * @param Appeal $appeal
     * @param $labelIds
     */
    public function labels(Appeal $appeal, $labelIds)
    {
        $labels = Label::query()->whereIn('id', $labelIds)->get();
        $labels->each(function ($item) {
            if ($item->is_open == 0) {
                throw new InvalidParameterException('存在已关闭的标签');
            }
        });

        $appeal->labels()->sync($labelIds);
    }

    /**
     * @param Appeal $appeal
     * @param Label $label
     */
    public function deleteLabel(Appeal $appeal, Label $label)
    {
        $appeal->labels()->detach($label);
    }

    /**
     * 认领诉求
     * @param Appeal $appeal
     */
    public function apply(Appeal $appeal)
    {
        $user = Auth::user();
        $appeal->update([
            'follower_id' => $user->id,
            'follower_name' => $user->name,
            'follow_time' => now(),
            'status' => AppealStatus::STATUS_TO_ACCEPT,
        ]);
    }

    /**
     * 取消认领
     * @param Appeal $appeal
     */
    public function applyCancel(Appeal $appeal)
    {
        $appeal->update([
            'follower_id' => 0,
            'follower_name' => '',
            'follow_time' => null,
            'status' => AppealStatus::STATUS_TO_DISTRIBUTION,
        ]);
    }

    /**
     * 指定跟进人
     * @param Appeal $appeal
     * @param Request $request
     */
    public function follow(Appeal $appeal, Request $request)
    {
        $follower = User::find($request->follower_id);
        $appeal->update([
            'follower_id' => $follower->id,
            'follower_name' => $follower->name,
            'follow_time' => now(),
            'follow_type' => 1, // 跟进类型；0；自主跟进；1；负责人指派；
            'expiration_date' => $request->input('expiration_date', null),
            'comment' => $request->input('comment', ''),
            'status' => AppealStatus::STATUS_TO_ACCEPT,
        ]);
    }

    /**
     * @param Appeal $appeal
     * @param $request
     */
    public function products(Appeal $appeal, $request)
    {
        $product = Product::find($request->input('product_id'));
        // 更改产品负责人
        $productPrincipalUser = $this->getPrincipalInfoByProductId($product);
        if (empty($productPrincipalUser)) {
            throw new InvalidParameterException('产品负责人不能为空，请先设置产品负责人');
        }

        if ($productChanges = $this->appealProductsChange($appeal, $request)) {
            $changes[] = $productChanges;
            // 将修改写入缓存
            $appeal->getUpdatedCacheInstance()->put($appeal->getUpdatedCacheKey(), json_encode($changes), 600);
        }

        $data['principal_user_id'] = $productPrincipalUser->user_id;
        $data['principal_user_name'] = $productPrincipalUser->user_name;
        $appeal->updated_at = now();
        $appeal->update($data);

        // 重新关联产品
        $appeal->products()->detach();
        $this->attachProducts($appeal, $product, $request->input('product_modules', []));
    }

    /**
     * @param Appeal $appeal
     * @param $request
     */
    public function verify(Appeal $appeal, Request $request)
    {
        $verify = Auth::user();
        $data = [
            'status' => $request->status,
            'verify_user_id' => $verify->id,
            'verify_user_name' => $verify->name,
            'verify_time' => now(),
        ];
        if ($request->has('crux')) {
            $data['crux'] = $request->input('crux');
        }
        // 跟进人备注
        $data['comment_follower'] = $request->input('comment') ?? '';
        if ($request->status = AppealStatus::STATUS_COMPLETED) {
            $data['finish_time'] = Carbon::now();
        }
        // 清除SQ的demand_id信息，并删除此需求id的信息；（作用等同于取消立项）
        if (in_array($request->status, [AppealStatus::STATUS_COMPLETED, AppealStatus::STATUS_REJECTED])) {
            if ($demand = $appeal->demand()->first()) {
                if ($demand->status == DemandStatus::STATUS_REJECTED) {
                    $demand->delete();
                    $data['demand_id'] = 0;
                }
            }
        }
        $appeal->update($data);
    }

    /**
     * 拆解诉求
     * @param Appeal $appeal
     * @param Request $request
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function disassemble(Appeal $appeal, Request $request)
    {
        //修改源诉求状态,并记录日志
        $appeal->update(['status' => AppealStatus::STATUS_REVOCATION]);
        // 原诉求发布人
        $promulgatorUser = User::query()->find($appeal->promulgator_id);

        $suffix = 65; //新诉求后缀 A
        foreach ($request->appeals as $item) {
            $newAppeal = new Appeal();
            //原始诉求id
            $newAppeal->origin_id = $appeal->id;
            $newAppeal->number = $appeal->number . '-' . chr($suffix);
            $newAppeal->name = $item['name'];
            $newAppeal->brief = $item['brief'] ?? '';
            $newAppeal->content = $item['content'];
            $newAppeal->type = $item['type'];
            $newAppeal->is_urgent = $item['is_urgent'] ?? 0;
            $newAppeal->is_important = $item['is_important'] ?? 0;
            $newAppeal->questions = isset($item['questions']) ? json_encode($item['questions']) : '';
            $newAppeal->source_project_id = $item['source_project_id'] ?? 0;
            $newAppeal->source_project_name = $item['source_project_name'] ?? null;

            //发布人
            $newAppeal->promulgator_id = $promulgatorUser->id;
            $newAppeal->promulgator_name = $promulgatorUser->name;
            $newAppeal->dept_id = $promulgatorUser->basicDepartment->id;
            $newAppeal->dept_name = $promulgatorUser->basicDepartment->name;

            //产品负责人
            $product = Product::query()->find($item['product_id']);
            $productPrincipalUser = $this->getPrincipalInfoByProductId($product);
            if (empty($productPrincipalUser)) {
                throw new InvalidParameterException('产品负责人不能为空，请先设置产品负责人');
            }
            $newAppeal->principal_user_id = $productPrincipalUser->user_id;
            $newAppeal->principal_user_name = $productPrincipalUser->user_name;
            $newAppeal->status = AppealStatus::STATUS_TO_DISTRIBUTION;
            $newAppeal->save();

            //关联产品
            $productModules = $item['product_modules'] ?? [];
            $this->attachProducts($newAppeal, $product, $productModules);

            // 用户关注
            if (isset($item['attention_user_ids'])) {
                foreach ($item['attention_user_ids'] as $id) {
                    $user = User::query()->find($id);
                    $userDept = $user->basicDepartment;
                    $newAppeal->attentionAble()->create([
                        'user_id' => $id,
                        'user_name' => $user->name,
                        'dept_id' => $userDept->id,
                        'dept_name' => $userDept->name,
                    ]);
                }
            }

            $this->addUpdatedTagToRelateUsers($newAppeal);

            // 保存附件
            if (isset($item['media'])) {
                $newAppeal->addMedias($item['media']);
            }

            $suffix++;
        }
    }

    /**
     * 诉求关联产品及产品模块
     * @param Appeal $appeal
     * @param Product $product
     * @param array $productModules
     * @throws InvalidParameterException
     */
    protected function attachProducts(Appeal $appeal, Product $product, $productModules = [])
    {
        // 关联产品
        $this->appealAttachProduct($appeal, $product);
        // 关联产品模块及标签
        foreach ($productModules as $productModule) {
            $appeal->products()->attach($productModule['module_id'], ['type' => ProductStatus::TypeModule]);
            if (isset($productModule['label_ids'])) {
                $appeal->products()->attach($productModule['label_ids'], ['type' => ProductStatus::TypeCategory]);
            }
        }
    }

    /**
     * 诉求递归关联产品
     * @param Appeal $appeal
     * @param Product $product
     * @throws InvalidParameterException
     */
    protected function appealAttachProduct(Appeal $appeal, Product $product)
    {
        if ($product->status == ProductStatus::STATUS_OFF) {
            throw new InvalidParameterException('不能关联已关闭的产品线');
        }
        $appeal->products()->attach($product, ['type' => $product->type]);
        if ($parent = $product->parent) {
            $this->appealAttachProduct($appeal, $parent);
        }
    }

    /**
     * 取消立项
     * @param Appeal $appeal
     * @throws \Exception
     */
    public function cancelDemand(Appeal $appeal)
    {
        $allAppeals = Appeal::query()->where('demand_id', $appeal->demand_id)->get();
        if ($demand = $appeal->demand()->first()) {
            $demand->delete();
        }
        $allAppeals->each(function ($appeal) {
            $appeal->status = AppealStatus::STATUS_FOLLOWING;
            $appeal->demand_id = 0;
            $appeal->save();
        });
    }

    /**
     * @return mixed
     */
    protected function getUserName()
    {
        return Auth::user()->name;
    }

    /**
     * @param Appeal $appeal
     * @return AppealResource
     */
    public function details(Appeal $appeal)
    {
        // 查看详情后删除Update标签
        $appeal->deleteIsUpdated();
        $appeal->append(['policies', 'product_category',]);
        $appeal->is_attention = $appeal->getIsAttention();
        $appeal->load(['labels', 'products', 'attentionAble', 'media', 'demand',
            'activityLogs' => function ($query) {
                $query->orderBy('id', 'desc');
            }]);
        return new AppealResource($appeal);
    }

    /**
     * 给关联用户添加 Update 标签
     * @param Appeal $appeal
     */
    public function addUpdatedTagToRelateUsers(Appeal $appeal)
    {
        $appeal->setIsUpdated($appeal->relateUsers());
    }


    /**
     * 关注或取消关注
     * @param Appeal $appeal
     * @throws InvalidParameterException
     */
    public function attention($appeal, User $user)
    {
        if ($appeal->getIsAttention()) {
            $appeal->attentionAble()->where('user_id', $user->id)->delete();
        } else {
            $userDept = $user->basicDepartment;
            if (is_null($userDept)) {
                throw new InvalidParameterException('用户信息错误，无对应部门信息');
            }
            $appeal->attentionAble()->create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'dept_id' => $userDept->id,
                'dept_name' => $userDept->name,
            ]);
        }
    }

    /**
     * 查找产品负责人
     * @param $productId
     * @param int $type
     */
    protected function getPrincipalInfoByProductId($productId, $type = TeamType::TYPE_PRODUCT)
    {
        $product = $productId instanceof Product ? $productId : Product::query()->find($productId);
        $team = $product->teams()->where('type', $type)->where('is_default', 1)->first();
        if (!is_null($team)) {
            return $team;
        }
        if ($product->parent_id == 0) {
            return null;
        }
        return $this->getPrincipalInfoByProductId($product->parent_id, $type);
    }

    /**
     * @param Appeal $appeal
     * @return array
     */
    public function principal(Appeal $appeal)
    {
        // 通过诉求关联的产品线产品找到该产品所有设置的负责人
        return $this->teams->getTeamPrincipalByProducts($appeal, TeamType::TYPE_PRODUCT);
    }

    /**
     * @param Appeal $appeal
     * @param $data
     */
    public function setPrincipal(Appeal $appeal, $data)
    {
        $user = User::query()->find($data['user_id']);
        $appeal->update([
            'principal_user_id' => $user->id,
            'principal_user_name' => $user->name,
        ]);
    }

    /**
     * 诉求转移
     * @param $data
     * @throws InvalidParameterException
     */
    public function transfer($data)
    {
        $appeals = Appeal::query()->whereIn('id', $data['appeal_ids'])->get();
        if ($appeals->unique('promulgator_id')->count() > 1) {
            throw new InvalidParameterException('请确认需转移的诉求发布人为同一人！');
        }
        if ($appeals->where('status', AppealStatus::STATUS_REVOCATION)->count() > 0) {
            throw new InvalidParameterException('已撤销诉求，不可操作转移！');
        }
        if ($appeals->where('status', AppealStatus::STATUS_COMPLETED)->count() > 0) {
            throw new InvalidParameterException('已完成诉求，不可操作转移！');
        }
        if ($appeals->where('status', AppealStatus::STATUS_REJECTED)->count() > 0) {
            throw new InvalidParameterException('已驳回诉求，不可操作转移！');
        }

        // 修改诉求发布人及部门
        $receiver = User::find($data['receiver_id']);
        $dept = $receiver->basicDepartment;
        $appealData = [
            'promulgator_id' => $receiver->id,
            'promulgator_name' => $receiver->name,
            'dept_id' => $dept->id,
            'dept_name' => $dept->name,
        ];
        $appeals->each(function ($appeal) use ($appealData) {
            $appeal->update($appealData);
        });
    }
}
