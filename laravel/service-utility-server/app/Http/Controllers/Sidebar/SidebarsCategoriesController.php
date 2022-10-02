<?php

namespace App\Http\Controllers\Sidebar;

use App\Models\Sidebar\SidebarCategory;
use App\Repositories\Page\PageRepository;
use App\Repositories\Sidebar\SidebarCategoryRepository;
use App\Traits\RefreshFlagTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SidebarsCategoriesController extends Controller
{
    use RefreshFlagTrait;

    protected $sidebarCategory;
    protected $page;

    public function __construct(SidebarCategoryRepository $categoryRepository, PageRepository $page)
    {
        parent::__construct();
        $this->sidebarCategory = $categoryRepository;
        $this->page = $page;
    }

    /**
     * 创建侧边栏分类
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'parent_id' => 'required|numeric',
            'sidebar_template_id' => 'required|numeric',
            'name' => 'required|string',
            'comment' => 'required|string',
            'locale' => 'required|json',
            'icon' => 'required|string',
        ])->validate();

        $createInfo = $this->sidebarCategory->create($request->all());
        if ($createInfo[0]) {
            return $this->successWithData(['sidebar_category' => $createInfo[1]]);
        }
        return $this->failedWithMessage(__('error.created_failed'));
    }

    /**
     * 更新侧边栏分类
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function update(Request $request, $id)
    {
        $sidebarCategory = $this->getInstance($this->sidebarCategory, $id);
        Validator::make($request->all(), [
            'parent_id' => 'required|numeric',
            'name' => 'required|string',
            'comment' => 'required|string',
            'locale' => 'required|json',
            'icon' => 'required|string',
        ])->validate();

        $sidebarCategory->update($request->only(['parent_id', 'name', 'comment', 'locale', 'icon']));
        if ($sidebarCategory->wasChanged(['parent_id', 'name', 'locale'])) {
            $this->sidebarCategoryChanges($sidebarCategory);
        }
        return $this->success();
    }

    /**
     * 删除侧边栏分类
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function delete(Request $request, $id)
    {
        $sidebarCategory = $this->getInstance($this->sidebarCategory, $id);
        $sidebarCategory->delete();
        $this->sidebarCategoryChanges($sidebarCategory);
        return $this->success();
    }

    /**
     * 添加关联页面
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function addPages(Request $request, $id)
    {
        $sidebarCategory = $this->getInstance($this->sidebarCategory, $id);
        Validator::make($request->all(), [
            'page_ids' => 'required|array',
            'page_ids.*' => 'required|exists:pages,id',
        ])->validate();

        try {
            $pageIds = $request->input('page_ids');
            foreach ($pageIds as $pageId) {
                if (!$sidebarCategory->pages()->wherePivot('page_id', $pageId)->first()) {
                    $sidebarCategory->pages()->attach($pageId);
                }
            }
        } catch (\Exception $exception) {
            \Log::error('添加关联页面错误', [$exception->getMessage()]);
            return $this->failed();
        }
        $this->sidebarCategoryChanges($sidebarCategory);
        return $this->success();
    }

    /**
     * 删除关联页面
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function removePages(Request $request, $id)
    {
        $sidebarCategory = $this->getInstance($this->sidebarCategory, $id);
        Validator::make($request->all(), [
            'page_ids' => 'required|array',
        ])->validate();
        $pages = $this->page->findWhereIn('id', $request->input('page_ids'));
        try {
            $sidebarCategory->pages()->detach($pages);
        } catch (\Exception $exception) {
            \Log::error('添加关联页面错误', [$exception->getMessage()]);
            return $this->failed();
        }
        $this->sidebarCategoryChanges($sidebarCategory);
        return $this->success();
    }

    /**
     * 模板分类更新触发页面刷新
     * @param SidebarCategory $sidebarCategory
     */
    protected function sidebarCategoryChanges(SidebarCategory $sidebarCategory)
    {
        $sidebarTemplate = $sidebarCategory->templates()->first();
        $userIds = $sidebarTemplate->users()->get()->pluck('id')->toArray();
        $this->addRefreshFlag($userIds, $this->FLAG_SIDEBAR);
    }

    /**
     * 侧边栏栏目排序
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function sort(Request $request, $id)
    {
        $sidebarCategory = $this->getInstance($this->sidebarCategory, $id);
        Validator::make($request->all(), [
            'sort' => 'required|numeric',
        ])->validate();
        $sidebarCategory->update($request->only('sort'));
        return $this->success();
    }

    /**
     * 批量侧边栏栏目排序
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function batchSort(Request $request)
    {
        Validator::make($request->all(), [
            '*.id' => 'required|integer|exists:sidebar_categories,id',
            '*.sort' => 'required|integer',
        ])->validate();

        $categories = $this->sidebarCategory->findWhereIn('id', collect($request->all())->pluck('id')->toArray());
        foreach ($request->all() as $item) {
            $sidebarCategory = $categories->where('id', $item['id'])->first();
            $sidebarCategory->update(['sort' => $item['sort']]);
        }
        return $this->success();
    }

    /**
     * 侧边栏栏目页面排序
     * @param Request $request
     * @param $id
     * @param $pid
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function pageSort(Request $request, $id, $pid)
    {
        $sidebarCategory = $this->getInstance($this->sidebarCategory, $id);
        Validator::make($request->all(), [
            'sort' => 'required|numeric',
        ])->validate();

        // 更新中间表sort字段
        $sidebarCategory->pages()->updateExistingPivot($pid, ['sort' => $request->input('sort')]);
        return $this->success();
    }

    /**
     * 批量侧边栏栏目页面排序
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function batchPageSort(Request $request)
    {
        Validator::make($request->all(), [
            '*.id' => 'required|integer|exists:sidebar_categories,id',
            '*.page_id' => 'required|integer|exists:pages,id',
            '*.sort' => 'required|integer',
        ])->validate();

        $categories = $this->sidebarCategory->findWhereIn('id', collect($request->all())->pluck('id')->toArray());
        foreach ($request->all() as $item) {
            $sidebarCategory = $categories->where('id', $item['id'])->first();
            // 更新中间表sort字段
            $sidebarCategory->pages()->updateExistingPivot($item['page_id'], ['sort' => $item['sort']]);
        }
        return $this->success();
    }
}
