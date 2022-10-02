<?php

namespace App\Http\Controllers\Page;

use App\Repositories\Page\PageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    protected $pages;

    public function __construct(PageRepository $pages)
    {
        parent::__construct();
        $this->pages = $pages;
    }

    /**
     * 页面列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $limit = $request->input('limit');
        $pages = $this->pages->getModelsList($limit);
        return $this->successWithData($pages);
    }

    /**
     * 获取某个子系统下所有页面
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        Validator::make($request->all(), [
            'guard_name' => 'required|string',
        ])->validate();

        $guardName = $request->input('guard_name');
        $type = $request->input('type', '');
        $where = ['guard_name' => $guardName];
        if ($type) {
            $where['type'] = intval($type);
        }
        $pages = $this->pages->findWhere($where);
        return $this->successWithData($pages);
    }

    /**
     * 首页页面
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function homepages(Request $request)
    {
        Validator::make($request->all(), [
            'guard_name' => 'required|string',
        ])->validate();

        $guardName = $request->input('guard_name');
        $homepages = $this->pages->homepages($guardName);
        return $this->successWithData(compact('homepages'));
    }

    /**
     * 更新页面
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function update(Request $request, $id)
    {
        $page = $this->getInstance($this->pages, $id);
        $data = $request->only(['comment', 'locale']);
        Validator::make($data, [
            // 'name' => 'required|string',
            'comment' => 'required|string',
            'locale' => 'required|json',
        ])->validate();

        $page->update($data);
        return $this->success();
    }

}
