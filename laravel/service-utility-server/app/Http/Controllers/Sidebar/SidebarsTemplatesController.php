<?php

namespace App\Http\Controllers\Sidebar;

use App\Repositories\Sidebar\SidebarsTemplateRepository;
use App\Traits\RefreshFlagTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SidebarsTemplatesController extends Controller
{
    use RefreshFlagTrait;

    protected $sidebarTemplate;

    public function __construct(SidebarsTemplateRepository $sidebarTemplate)
    {
        parent::__construct();
        $this->sidebarTemplate = $sidebarTemplate;
    }

    /**
     * 创建侧边栏模板
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->only(['name', 'comment', 'locale', 'guard_name']);
        Validator::make($data, [
            'name' => 'required|string',
            'comment' => 'required|string',
            'locale' => 'required|json',
            'guard_name' => 'required|string',
        ])->validate();

        $createInfo = $this->sidebarTemplate->create($data);
        if ($createInfo[0]) {
            return $this->successWithData(['sidebar_template' => $createInfo[1]]);
        }
        return $this->failedWithMessage(__('error.created_failed'));
    }

    /**
     * 更新侧边栏模板
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function update(Request $request, $id)
    {
        $template = $this->getInstance($this->sidebarTemplate, $id);
        $data = $request->only(['name', 'comment', 'locale']);
        Validator::make($data, [
            'name' => 'required|string',
            'comment' => 'required|string',
            'locale' => 'required|json',
        ])->validate();

        $template->update($data);
        return $this->success();
    }

    /**
     * 删除侧边栏模板
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function delete(Request $request, $id)
    {
        $template = $this->getInstance($this->sidebarTemplate, $id);
        $template->delete();
        $userIds = $template->users()->get()->pluck('id')->toArray();
        $this->addRefreshFlag($userIds, $this->FLAG_SIDEBAR);
        return $this->success();
    }

    /**
     * 所有侧边栏模板
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        Validator::make($request->all(), [
            'guard_name' => 'required|string',
        ])->validate();

        $templates = $this->sidebarTemplate->all($request->input('guard_name'));
        return $this->successWithData(['sidebar_templates' => $templates]);
    }

    /**
     * 侧边栏模板列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $limit = $request->input('limit');
        $data = $this->sidebarTemplate->getModelsList($limit);
        return $this->successWithData($data);
    }

    /**
     * 模板所有侧边栏分类
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function categories(Request $request, $id)
    {
        $template = $this->getInstance($this->sidebarTemplate, $id);
        $categories = $template->categories()->get();
        return $this->successWithData(['sidebar_categories' => $categories]);
    }

    /**
     * 侧边栏模板树结构
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function trees(Request $request, $id)
    {
        $template = $this->getInstance($this->sidebarTemplate, $id);
        $categories = $template->categories()->where('parent_id', 0)->with('pages')->get();
        $trees = $this->sidebarTemplate->getTree($categories)['tree'];
        return $this->successWithData(compact('trees'));
    }

    /**
     * 获取侧边栏模板下的页面
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function pages(Request $request, $id)
    {
        $template = $this->getInstance($this->sidebarTemplate, $id);
        $categories = $template->categories()->get();
        $pages = $categories->map(function ($category) {
            return $category->pages()->get();
        })->flatten(1)->unique('id')->values();
        return $this->successWithData($pages);
    }
}
