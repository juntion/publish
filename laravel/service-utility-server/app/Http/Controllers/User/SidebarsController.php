<?php

namespace App\Http\Controllers\User;

use App\Repositories\Page\PageRepository;
use App\Repositories\Sidebar\SidebarsTemplateRepository;
use App\Repositories\User\UserRepository;
use App\Traits\RefreshFlagTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SidebarsController extends Controller
{
    use RefreshFlagTrait;

    protected $user;
    protected $sidebarTemplate;
    protected $page;

    public function __construct(UserRepository $user, SidebarsTemplateRepository $sidebarTemplate, PageRepository $page)
    {
        parent::__construct();
        $this->user = $user;
        $this->sidebarTemplate = $sidebarTemplate;
        $this->page = $page;
    }

    /**
     * 批量绑定用户侧边栏模板
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bindSidebarTemplate(Request $request)
    {
        Validator::make($request->all(), [
            'sidebar_template_id' => 'required|numeric|exists:sidebar_templates,id',
            'user_ids' => 'required|array',
            'user_ids.*' => 'required|exists:users,id',
            'guard_name' => 'required|string',
        ])->validate();

        $guardName = $request->input('guard_name');
        $templateId = $request->input('sidebar_template_id');
        $users = $this->user->findWhereIn('id', $request->input('user_ids'));
        foreach ($users as $user) {
            if ($template = $user->sidebarTemplates()->wherePivot('guard_name', $guardName)->first()) {
                $user->sidebarTemplates()->detach($template->id);
            }
            $user->sidebarTemplates()->attach($templateId, ['guard_name' => $guardName]);
        }
        $this->addRefreshFlag($request->input('user_ids'), $this->FLAG_SIDEBAR);
        return $this->success();
    }

    /**
     * 批量设置用户禁止展示的页面入口
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function forbidPage(Request $request)
    {
        Validator::make($request->all(), [
            'page_id' => 'required|numeric|exists:pages,id',
            'user_ids' => 'required|array',
            'user_ids.*' => 'required|exists:users,id',
        ])->validate();

        $page = $this->getInstance($this->page, $request->input('page_id'));
        foreach ($request->input('user_ids') as $userId) {
            if (!$page->forbidUsers()->wherePivot('user_id', $userId)->first()) {
                $page->forbidUsers()->attach($userId);
            }
        }
        return $this->success();
    }

    /**
     * 查询用户各子系统侧边栏模板
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function template(Request $request, $id)
    {
        $user = $this->getInstance($this->user, $id);
        $templates = $user->sidebarTemplates()->get();
        return $this->successWithData(['sidebar_templates' => $templates]);
    }
}
