<?php

namespace Modules\Tag\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Base\Support\Response\ResponseTrait;
use Modules\Tag\Entities\TagDataSource;
use Modules\Tag\Exceptions\TagDataSourceException;
use Modules\Tag\Exports\ProductTemplateExport;
use Modules\Tag\Exports\TagDataSourceExport;
use Modules\Tag\Http\Requests\TagBindingStoreRequest;
use Modules\Tag\Http\Resources\TagDataCollection;
use Modules\Tag\Http\Resources\TagDataSourceCollection;
use Modules\Tag\Repositories\TagBindingRepository;

class TagBindingController extends Controller
{
    use ResponseTrait;

    /**
     * @var TagBindingRepository
     */
    private $tagBinding;

    public function __construct(TagBindingRepository $tagBinding)
    {
        $this->tagBinding = $tagBinding;
    }

    /**
     * 绑定列表
     * @param Request $request
     * @return TagDataSourceCollection
     */
    public function index(Request $request)
    {
        $result = $this->tagBinding->getList($request);
        return new TagDataSourceCollection($result);
    }

    /**
     * 获取模型绑定的标签
     * @param Request $request
     * @return TagDataCollection
     */
    public function bindingTags(Request $request)
    {
        $request->validate([
            'binding_type' => 'required',
            'model_id' => 'required',
        ], [], [
            'binding_type' => '所属绑定',
            'model_id' => '模型ID',
        ]);
        $tags = $this->tagBinding->bindingTags($request);
        return new TagDataCollection($tags);
    }

    /**
     * 添加绑定
     * @param TagBindingStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TagBindingStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->tagBinding->store($request->validated());
        } catch (\Exception $e) {
            DB::rollBack();
            throw new TagDataSourceException($e->getMessage(), $e->getCode(), $e);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 更新绑定
     * @param TagDataSource $tagDataSource
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TagDataSource $tagDataSource, Request $request)
    {
        $data = $request->validate([
            'tag_uuid' => 'required|exists:tag_data,uuid',
            'priority' => 'integer',
        ], [], [
            'tag_uuid' => '标签',
            'priority' => '排序',
        ]);
        $this->tagBinding->update($tagDataSource, $data);
        return $this->success();
    }

    /**
     * 解除绑定
     * @param TagDataSource $tagDataSource
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function unbind(TagDataSource $tagDataSource)
    {
        $this->tagBinding->unbind($tagDataSource);
        return $this->success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchUnbind(Request $request)
    {
        $uuids = $request->validate([
            'binding_uuids' => 'required|array',
            'binding_uuids.*' => 'required|exists:tag_data_source,uuid',
        ], [], [
            'binding_uuids' => '绑定关系集合',
            'binding_uuids.*' => '绑定关系',
        ]);
        DB::beginTransaction();
        try {
            $this->tagBinding->batchUnbind($uuids['binding_uuids']);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new TagDataSourceException(__('tag::tagBinding.unbind_err'), $e->getCode(), $e);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 下载模板
     * @param ProductTemplateExport $export
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(ProductTemplateExport $export)
    {
        return Excel::download($export, $export->title() . '下载.xlsx');
    }

    /**
     * 导出指定的绑定关系
     * @param Request $request
     * @param TagDataSourceExport $export
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request, TagDataSourceExport $export)
    {
        $request->validate([
            'binding_type' => 'required',
            'uuid' => 'required|array',
            'uuid.*' => 'required|exists:tag_data_source,uuid',
        ], [], [
            'binding_type' => '所属绑定',
            'uuid' => '绑定关系',
            'uuid.*' => '绑定关系uuid',
        ]);
        $fileName = "绑定批量编辑下载" . date('YmdHis') . '.xlsx';
        return Excel::download($export, $fileName);
    }

    /**
     * 数据上传
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $request->validate([
            'binding_type' => 'required',
            'file' => 'required|file',
        ], [], [
            'binding_type' => '所属绑定',
            'file' => '文件',
        ]);
        DB::beginTransaction();
        try {
            $this->tagBinding->upload($request);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new TagDataSourceException($e->getMessage(), $e->getCode(), $e);
        }
        DB::commit();
        return $this->success();
    }
}
