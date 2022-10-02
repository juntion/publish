<?php

namespace Modules\Tag\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Base\Support\Response\ResponseTrait;
use Modules\Tag\Exceptions\TagDataSourceException;
use Modules\Tag\Http\Resources\TagDataCollection;
use Modules\Tag\Repositories\TagApiRepository;

class TagApiController extends Controller
{
    use ResponseTrait;

    /**
     * @var TagApiRepository
     */
    private $tagApi;

    public function __construct(TagApiRepository $tagApi)
    {
        $this->tagApi = $tagApi;
    }

    /**
     * 获取标签列表
     * @param Request $request
     * @return TagDataCollection
     */
    public function tags(Request $request)
    {
        $res = $this->tagApi->tags($request);
        return new TagDataCollection($res);
    }

    /**
     * 通过标签查找数据源信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function source(Request $request)
    {
        $request->validate([
            'tags' => 'required',
        ], [
            'tags.required' => '标签ID集合不能为空.',
        ]);
        $result = $this->tagApi->source($request);
        return $this->successWithData($result);
    }

    /**
     * 获取数据关联的标签
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sourceTags(Request $request)
    {
        $request->validate([
            'model_ids' => 'required',
            'model_type' => 'required|integer',
        ], [
            'model_ids.required' => '数据源ID不能为空',
            'model_type.required' => '数据类型不能为空',
            'model_type.integer' => '数据类型必须为整型',
        ]);
        $source = $this->tagApi->sourceTags($request);
        return $this->successWithData(compact('source'));
    }

    /**
     * 通过标签名搜索数据源信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string',
        ], [
            'keyword.required' => '关键字不能为空',
            'keyword.string' => '关键字必须为字符串',
        ]);
        $tags = $this->tagApi->search($request);
        return $this->successWithData(compact('tags'));
    }

    /**
     * 创建或更新数据与标签的关联
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'model_id' => 'required',
            'model_type' => 'required',
            'model_desc' => 'required',
            'tags' => 'required',
        ], [
            'model_id.required' => '数据主键ID不能为空',
            'model_type.required' => '数据类型不能为空',
            'model_desc.required' => '数据描述不能为空',
            'tags.required' => '标签ID不能为空',
        ]);

        \DB::beginTransaction();
        try {
            $this->tagApi->update($data);
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new TagDataSourceException(__('tag::tagBinding.fail'), $e->getCode(), $e);
        }
        \DB::commit();
        return $this->success();
    }

    /**
     * 批量创建或更新绑定关系
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function batchUpdate(Request $request)
    {
        $data = $request->validate([
            'related' => 'required|array',
            'related.*.model_id' => 'required',
            'related.*.model_type' => 'required',
            'related.*.model_desc' => 'required',
            'related.*.tags' => 'required',
        ], [
            'related.required' => '关联关系不能为空',
            'related.array' => '关联关系必须为数组',
            'related.*.model_id.required' => '数据主键ID不能为空',
            'related.*.model_type.required' => '数据类型不能为空',
            'related.*.model_desc.required' => '数据描述不能为空',
            'related.*.tags.required' => '标签ID不能为空',
        ]);

        \DB::beginTransaction();
        try {
            $this->tagApi->batchUpdate($data['related']);
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new TagDataSourceException(__('tag::tagBinding.fail'), $e->getCode(), $e);
        }
        \DB::commit();
        return $this->success();
    }
}
