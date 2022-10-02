<?php

namespace App\Http\Controllers\User;

use App\Exceptions\System\InvalidParameterException;
use App\Repositories\Page\PageRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HomepagesController extends Controller
{
    protected $user;
    protected $page;

    public function __construct(UserRepository $user, PageRepository $page)
    {
        parent::__construct();

        $this->user = $user;
        $this->page = $page;
    }

    /**
     * 设置用户系统首页
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function setHomepage(Request $request, $id)
    {
        $user = $this->getInstance($this->user, $id);
        Validator::make($request->all(), [
            'page_id' => 'required|numeric|exists:pages,id',
            'guard_name' => 'required|string',
        ])->validate();

        try {
            $pageId = $request->input('page_id');
            $guardName = $request->input('guard_name');
            $this->setUserHomePage($user, $pageId, $guardName);
        } catch (\Exception $exception) {
            \Log::error('设置用户系统首页错误', [$exception->getMessage()]);
            throw new InvalidParameterException();
        }
        return $this->success();
    }

    /**
     * 批量设置用户系统首页
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidParameterException
     */
    public function batchSetHomepage(Request $request)
    {
        Validator::make($request->all(), [
            'user_ids' => 'required|array',
            'user_ids.*' => 'required|exists:users,id',
            'page_id' => 'required|numeric|exists:pages,id',
            'guard_name' => 'required|string',
        ])->validate();

        try {
            $userIds = $request->input('user_ids');
            $guardName = $request->input('guard_name');
            $users = $this->user->findWhereIn('id', $userIds);
            foreach ($users as $user) {
                $this->setUserHomePage($user, $request->input('page_id'), $guardName);
            }
        } catch (\Exception $e) {
            \Log::error('设置用户系统首页错误', [$e->getMessage()]);
            throw new InvalidParameterException();
        }
        return $this->success();
    }

    /**
     * 设置用户首页
     * @param $user
     * @param $pageId
     * @param $guardName
     */
    protected function setUserHomePage($user, $pageId, $guardName)
    {
        if ($homepage = $user->pages()->wherePivot('guard_name', $guardName)->first()) {
            $user->pages()->detach($homepage->id);
        }
        $user->pages()->attach($pageId, ['guard_name' => $guardName]);
    }

    /**
     * 查询用户各子系统首页
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidParameterException
     */
    public function getHomepage(Request $request, $id)
    {
        $user = $this->getInstance($this->user, $id);
        $homepages = $user->pages()->get();
        return $this->successWithData(compact('homepages'));
    }
}
