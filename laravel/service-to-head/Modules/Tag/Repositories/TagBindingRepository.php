<?php

namespace Modules\Tag\Repositories;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Modules\Tag\Entities\TagData;
use Modules\Tag\Entities\TagDataSource;
use Modules\Tag\Exceptions\TagDataSourceException;
use Modules\Tag\Traits\ElasticSearchTrait;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class TagBindingRepository
{
    use ElasticSearchTrait;

    /**
     * 添加绑定
     * @param $data
     * @throws TagDataSourceException
     */
    public function store($data)
    {
        $tag = TagData::query()->find($data['tag_uuid']);
        $exists = $tag->tagDataSource()
            ->where(['model_id' => $data['model_id'], 'model_type' => $data['binding_type']])
            ->exists();
        if ($exists) {
            throw new TagDataSourceException(__('tag::tagBinding.store_repeat'));
        }
        $tagDataSource = $tag->tagDataSource()->create([
            'model_id' => $data['model_id'],
            'model_type' => $data['binding_type'],
            'model_desc' => $data['model_desc'],
            'priority' => $data['priority'] ?? 0,
            'status' => 1,
        ]);
        // 记录日志
        $this->addTagBindingLog($tag, 'bind', [$tagDataSource->toArray()]);
    }

    /**
     * 添加标签绑定日志
     * @param TagData $tag
     * @param string $action
     * @param array $data
     */
    public function addTagBindingLog(TagData $tag, $action, array $data)
    {
        $tag->createOperationLog(['action' => $action, 'data' => $data]);
    }

    /**
     * 更新绑定
     * @param TagDataSource $tagDataSource
     * @param array $data
     */
    public function update(TagDataSource $tagDataSource, array $data)
    {
        $oldTagUuid = $tagDataSource->tag_data_uuid;
        $tagDataSource->update([
            'tag_data_uuid' => $data['tag_uuid'],
            'priority' => $data['priority'] ?? 0,
        ]);
        if ($oldTagUuid != $data['tag_uuid']) {
            $oldTag = TagData::query()->find($oldTagUuid);
            $this->addTagBindingLog($oldTag, 'unbind', [$tagDataSource->toArray()]);

            $newTag = TagData::query()->find($data['tag_uuid']);
            $this->addTagBindingLog($newTag, 'bind', [$tagDataSource->toArray()]);
        }
    }

    /**
     * 解除绑定
     * @param TagDataSource $tagDataSource
     * @throws TagDataSourceException
     */
    public function unbind(TagDataSource $tagDataSource)
    {
        $tag = $tagDataSource->tag()->first();
        $this->addTagBindingLog($tag, 'unbind', [$tagDataSource->toArray()]);
        $tagDataSource->delete();
    }

    /**
     * 批量解除绑定
     * @param array $uuids
     */
    public function batchUnbind(array $uuids)
    {
        // 记录标签解绑日志
        $tags = TagData::query()
            ->whereHas('tagDataSource', function ($query) use ($uuids) {
                $query->whereIn('uuid', $uuids);
            })
            ->with(['tagDataSource' => function ($query) use ($uuids) {
                $query->whereIn('uuid', $uuids);
            }])->get();
        foreach ($tags as $tag) {
            $this->addTagBindingLog($tag, 'unbind', $tag->tagDataSource->toArray());
        }
        // 删除绑定关系
        TagDataSource::query()->whereIn('uuid', $uuids)->delete();
    }

    /**
     * 绑定关系列表
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws \Modules\Tag\Exceptions\ElasticSearchException
     */
    public function getList(Request $request)
    {
        if ($request->has('filter.keyword')) {
            return $this->getListFromES($request);
        }
        return $this->getListFromDB($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function getListFromDB(Request $request)
    {
        $tagDataSource = TagDataSource::query();
        if ($tagUuid = $request->input('filter.tag_uuid')) {
            $tagDataSource->where('tag_data_uuid', $tagUuid);
        }
        if ($modelType = $request->input('filter.binding_type')) {
            $tagDataSource->where('model_type', $modelType);
        }
        $limit = (int)$request->input('limit', 15);
        return $tagDataSource->orderBy('priority', 'asc')->paginate($limit);
    }

    /**
     * @param Request $request
     * @return array|mixed
     * @throws \Modules\Tag\Exceptions\ElasticSearchException
     */
    protected function getListFromES(Request $request)
    {
        if ($tagUuid = $request->input('filter.tag_uuid')) {
            $query['query']['bool']['must'][] = [
                'term' => ['tag_data_uuid' => $tagUuid],
            ];
        }
        if ($modelType = $request->input('filter.binding_type')) {
            $query['query']['bool']['must'][] = [
                'term' => ['model_type' => $modelType],
            ];
        }
        if ($keyword = $request->input('filter.keyword')) {
            $query['query']['bool']['must'][] = [
                'multi_match' => [
                    'query' => $keyword,
                    'fields' => ['model_id', 'model_desc'],
                ],
            ];
        }
        $limit = (int)$request->input('limit', 15);
        $queryJson = isset($query) ? json_encode($query['query']) : '';
        try {
            $result = TagDataSource::search($queryJson)->orderBy('priority', 'asc')->paginate($limit);
        } catch (\Exception $e) {
            $result = $this->catchESException($e);
        }
        return $result;
    }

    /**
     * 获取绑定的Tag
     * @param Request $request
     * @return array|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function bindingTags(Request $request)
    {
        $modelType = $request->input('binding_type');
        $modelId = $request->input('model_id');
        $tagDataSource = TagDataSource::query()->where('model_type', $modelType)->where('model_id', $modelId)->get();
        if ($tagDataSource->isNotEmpty()) {
            $tagUuids = $tagDataSource->pluck('tag_data_uuid')->toArray();
            return TagData::query()->whereIn('uuid', $tagUuids)->get();
        }
        return [];
    }

    /**
     * 数据上传
     * @param Request $request
     * @throws TagDataSourceException
     */
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        if (!in_array(strtolower($ext), ['xls', 'xlsx'])) {
            throw new TagDataSourceException(__('tag::tag.upload.file_extensions'));
        }
        $this->handleUploadFile($file);
    }

    /**
     * 处理上传文件
     * @param UploadedFile $file
     */
    private function handleUploadFile(UploadedFile $file)
    {
        $spreadsheet = (new Xlsx())->load($file->path());
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();
        if (empty($data)) {
            throw new TagDataSourceException(__('tag::tag.upload.file_error'));
        }
        // uuid存在为更新，否则为上传
        if ($data[0][0] == 'uuid') {
            $this->uploadUpdate($data);
        } else {
            $this->uploadCreate($data);
        }
    }

    /**
     * 上传更新
     * @param array $data
     */
    private function uploadUpdate(array $data)
    {
        foreach ($data as $index => $item) {
            if ($index == 0) continue;
            $tagSource = TagDataSource::query()->find($item[0]);
            if (empty($tagSource)) {
                throw new TagDataSourceException(__('tag::tagBinding.binding_not_exists', ['uuid' => $item[0]]));
            }
            if ($tag = TagData::query()->where('number', $item[1])->first()) {
                $this->update($tagSource, [
                    'tag_uuid' => $tag->uuid,
                    'priority' => $item[5] ?? 0,
                ]);
            } else {
                // 未找到标签
                throw new TagDataSourceException(__('tag::tag.upload.tag_not_exists', ['number' => $item[1]]));
            }
        }
    }

    /**
     * 上传新增绑定
     * @param array $data
     */
    private function uploadCreate(array $data)
    {
        $modelType = request()->input('binding_type');
        $dataCol = collect();
        foreach ($data as $index => $item) {
            if ($index == 0 || empty($item[0])) continue;
            $dataSource = [
                'tag_number' => $item[0],
                'tag_name' => $item[1],
                'model_id' => $item[2],
                'model_type' => $modelType,
                'model_desc' => $item[3] ?? '',
                'priority' => $item[4] ?? 0,
                'status' => 1,
            ];
            $dataCol = $dataCol->merge([$dataSource]);
        }
        $dataCol->map(function ($item) {
            $tag = TagData::query()->where('number', $item['tag_number'])->get();
            if ($tag->count() == 0) {
                throw new TagDataSourceException(__('tag::tag.upload.tag_name_not_exists', ['name' => $item['tag_name']]));
            }
            /*if ($tag->count() > 1) {
                throw new TagDataSourceException('标签名称为：' . $item['tag_name'] . ' 的标签存在多个，请检查表格数据！');
            }*/
            $tag = $tag->first();
            $exists = $tag->tagDataSource()
                ->where(['model_id' => $item['model_id'], 'model_type' => $item['model_type']])
                ->exists();
            if ($exists) {
                throw new TagDataSourceException(__('tag::tagBinding.binding_repeat',
                    ['name' => $item['tag_name'], 'modelID' => $item['model_id']]));
            }
            $tagDataSource = $tag->tagDataSource()->create($item);
            // 记录日志
            $this->addTagBindingLog($tag, 'bind', [$tagDataSource->toArray()]);
        });
    }
}
