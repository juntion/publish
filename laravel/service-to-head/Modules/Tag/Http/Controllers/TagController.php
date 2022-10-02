<?php

namespace Modules\Tag\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Base\Support\Response\ResponseTrait;
use Modules\Tag\Entities\TagData;
use Modules\Tag\Exceptions\TagDataException;
use Modules\Tag\Exports\TagDataExport;
use Modules\Tag\Exports\TagDataTemplateExport;
use Modules\Tag\Http\Requests\TagChildrenRequest;
use Modules\Tag\Http\Requests\TagStoreRequest;
use Modules\Tag\Http\Resources\TagDataCollection;
use Modules\Tag\Http\Resources\TagOperationLogCollection;
use Modules\Tag\Repositories\TagRepository;

class TagController extends Controller
{
    use ResponseTrait;

    /**
     * @var TagRepository
     */
    private $tag;

    public function __construct(TagRepository $tag)
    {
        $this->tag = $tag;
    }

    /**
     * 标签数据列表
     * @param Request $request
     * @return TagDataCollection
     */
    public function index(Request $request)
    {
        $data = $this->tag->tagList($request);
        return new TagDataCollection($data);
    }

    /**
     * 标签树结构
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function trees(Request $request)
    {
        $tagTrees = $this->tag->trees($request);
        return $this->successWithData(compact('tagTrees'));
    }

    /**
     * 标签下拉选项
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function dropdownList(Request $request)
    {
        $tags = $this->tag->dropdownList($request);
        return $this->successWithData(compact('tags'));
    }

    /**
     * 标签数据子集
     * @param TagData $tag
     * @return TagDataCollection
     */
    public function children(TagData $tag)
    {
        $tags = $this->tag->children($tag);
        return new TagDataCollection($tags);
    }

    /**
     * 下载标签数据更新模板
     * @param TagDataTemplateExport $export
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(TagDataTemplateExport $export)
    {
        return Excel::download($export, '标签批量上传模板.xlsx');
    }

    /**
     * 导出指定标签数据更新模板
     * @param Request $request
     * @param TagDataExport $export
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request, TagDataExport $export)
    {
        $request->validate([
            'uuid' => 'required|array',
            'uuid.*' => 'required|exists:tag_data,uuid',
        ], [], [
            'uuid' => '标签uuid集合',
            'uuid.*' => '标签uuid',
        ]);
        $fileName = '标签批量编辑下载_' . date('YmdHis') . '.xlsx';
        return Excel::download($export, $fileName);
    }

    /**
     * 标签更新日志
     * @param TagData $tag
     * @return TagOperationLogCollection
     */
    public function logs(TagData $tag)
    {
        $logs = $tag->logs();
        return new TagOperationLogCollection($logs);
    }

    /**
     * 全部操作日志
     * @return TagOperationLogCollection
     */
    public function operationLogs()
    {
        $data = $this->tag->operationLogs();
        return new TagOperationLogCollection($data);
    }

    /**
     * 添加一级标签
     * @param TagStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TagStoreRequest $request)
    {
        try {
            $this->tag->store($request->validated());
        } catch (\Exception $e) {
            throw new TagDataException(__('tag::tag.store_error'), $e->getCode(), $e);
        }
        return $this->success();
    }

    /**
     * 添加子级标签
     * @param TagData $tag
     * @param TagChildrenRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addChild(TagData $tag, TagChildrenRequest $request)
    {
        try {
            $this->tag->addChild($tag, $request->validated());
        } catch (\Exception $e) {
            throw new TagDataException(__('tag::tag.store_error'), $e->getCode(), $e);
        }
        return $this->success();
    }

    /**
     * 更新标签信息
     * @param TagData $tag
     * @param TagStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TagData $tag, TagStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->tag->update($tag, $request->validated());
        } catch (\Exception $e) {
            DB::rollBack();
            throw new TagDataException(__('tag::tag.update_error'), $e->getCode(), $e);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 更新标签状态
     * @param TagData $tag
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(TagData $tag, Request $request)
    {
        $request->validate([
            'status' => 'required|in:1,2',
        ], [], [
            'status' => '标签状态',
        ]);
        DB::beginTransaction();
        try {
            $this->tag->updateStatus($tag, $request->input('status'));
        } catch (\Exception $e) {
            DB::rollBack();
            throw new TagDataException(__('tag::tag.update_error'), $e->getCode(), $e);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 删除标签
     * @param TagData $tag
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(TagData $tag)
    {
        $this->tag->delete($tag);
        return $this->success();
    }

    /**
     * 转移标签
     * @param TagData $tag
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws TagDataException
     */
    public function move(TagData $tag, Request $request)
    {
        $request->validate([
            'parent_uuid' => 'required|exists:tag_data,uuid',
        ], [], [
            'parent_uuid' => '新父级标签',
        ]);

        $this->tag->move($tag, $request->input('parent_uuid'));
        return $this->success();
    }

    /**
     * 上传表格批量更新
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $request->validate(['file' => 'required|file']);
        DB::beginTransaction();
        try {
            $this->tag->upload($request);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new TagDataException($e->getMessage(), $e->getCode(), $e);
        }
        DB::commit();
        return $this->success();
    }
}
