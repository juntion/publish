<?php

namespace Modules\Tag\Repositories;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Tag\Entities\TagData;
use Modules\Tag\Entities\TagOperationLog;
use Modules\Tag\Enums\TagDataStatus;
use Modules\Tag\Enums\TagDataType;
use Modules\Tag\Exceptions\TagDataException;
use Modules\Tag\Traits\ElasticSearchTrait;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class TagRepository
{
    use ElasticSearchTrait;

    /**
     * 标签的集合
     */
    private $allTags;

    /**
     * 新增标签
     * @param array $tagData
     */
    public function store($tagData)
    {
        $tagData['locale']['en'] = $tagData['name'];
        $avatar = $tagData['avatar'] ?? null;
        $tagData = collect($tagData)->except('avatar')->toArray();
        $tag = TagData::query()->create($tagData);
        if ($avatar) {
            $tag->avatar = $this->handleUploadAvatar($tag, $avatar);
            $tag->save();
        }
    }

    /**
     * 编辑标签
     * @param TagData $tag
     * @param array $tagData
     */
    public function update(TagData $tag, $tagData)
    {
        $tagData['url_name'] = $tagData['url_name'] ?? '';
        $tagData['locale'] = $tagData['locale'] ?? null;
        $tagData['locale']['en'] = $tagData['name'];
        $avatar = $tagData['avatar'] ?? null;
        if ($avatar) {
            $tagData['avatar'] = $this->handleUploadAvatar($tag, $avatar);
        }
        $tag->update($tagData);
        if ($tag->wasChanged('status')) {
            $this->tagSyncUpdateStatus($tag, $tagData['status']);
        }
    }

    /**
     * 同步标签状态
     * 操作父级标签时，子级标签需要联动开启/关闭
     * @param TagData $tag
     * @param int $status
     */
    protected function tagSyncUpdateStatus(TagData $tag, $status)
    {
        /*if ($status == TagDataStatus::STATUS_ON) {
            $parents = TagData::query()->whereIn('uuid', $tag->parentIds)->get();
            $parents->map(function ($item) {
                $item->update(['status' => TagDataStatus::STATUS_ON]);
            });
        }*/
        $tag->update(['status' => $status]);
        $children = $tag->children;
        if ($children->isNotEmpty()) {
            foreach ($children as $item) {
                $this->tagSyncUpdateStatus($item, $status);
            }
        }
    }

    /**
     * 更改标签状态
     * @param TagData $tag
     * @param $status
     */
    public function updateStatus(TagData $tag, $status)
    {
        $tag->update(['status' => $status]);
        if ($tag->wasChanged('status')) {
            $this->tagSyncUpdateStatus($tag, $status);
        }
    }

    /**
     * 添加子级标签
     * @param TagData $tag
     * @param array $tagData
     */
    public function addChild(TagData $tag, array $tagData)
    {
        $tagData['type'] = $tag->type;
        $tagData['parent_uuid'] = $tag->uuid;
        $tagData['locale']['en'] = $tagData['name'];
        $avatar = $tagData['avatar'] ?? null;
        $tagData = collect($tagData)->except('avatar')->toArray();
        $child = TagData::query()->create($tagData);
        if ($avatar) {
            $child->avatar = $this->handleUploadAvatar($child, $avatar);
            $child->save();
        }
    }

    /**
     * 移动标签
     * @param TagData $tag
     * @param $parentUuid
     */
    public function move(TagData $tag, $parentUuid)
    {
        if ($tag->uuid == $parentUuid) {
            throw new TagDataException(__('tag::tag.move_parent_uuid'));
        }
        $parentTag = TagData::query()->find($parentUuid);
        if ($tag->type != $parentTag->type) {
            throw new TagDataException(__('tag::tag.move_parent_type'));
        }
        try {
            DB::transaction(function () use ($tag, $parentUuid) {
                $tag->update(['parent_uuid' => $parentUuid]);
                if ($tag->wasChanged('parent_uuid')) {
                    $this->syncMoveTag($tag->children);
                }
            });
        } catch (\Exception $e) {
            throw new TagDataException(__('tag::tag.move_error'), $e->getCode(), $e);
        }
    }

    /**
     * 递归修改子级的 path 和 leve 字段
     * @param Collection $collection 子级标签集合
     */
    protected function syncMoveTag(Collection $collection)
    {
        if ($collection->isEmpty()) return;
        $collection->map(function (TagData $tag) {
            [$path, $level] = TagData::newPathAndLevel($tag->parent_uuid);
            $tag->update([
                'path' => $path,
                'level' => $level,
            ]);
            $this->syncMoveTag($tag->children);
        });
    }

    /*
     * 标签列表
     * 有keyword搜索，返回所有匹配结果（包含层级结构，无分页）
     * 无keyword搜索，返回level的一层（无层级结构，前端可异步加载数据）
     * 有limit才有分页
     * @param Request $request
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function tagList(Request $request)
    {
        $filter = $request->input('filter');
        $level = $filter['level'] ?? 1;
        if (isset($filter['status'])) {
            $query['query']['bool']['must'][] = [
                'term' => [
                    'status' => $filter['status'],
                ],
            ];
        }
        if (isset($filter['type'])) {
            $query['query']['bool']['must'][] = [
                'term' => [
                    'type' => $filter['type'],
                ],
            ];
        }
        if ($hasKeyword = isset($filter['keyword'])) {
            $keyword = $filter['keyword'];
            if (Str::startsWith($keyword, "#")) {
                $keyword = ltrim($keyword, "#");
            }
            $keywordQuery['bool']['should'] = $this->shouldKeywordQuery($keyword, ['name', 'number']);
            $query['query']['bool']['must'][] = $keywordQuery;
        } else {
            $query['query']['bool']['must'][] = [
                'term' => [
                    'level' => $level,
                ],
            ];
        }
        $query = isset($query) ? json_encode($query['query']) : '';
        try {
            if ($request->has('limit')) {
                $limit = (int)$request->input('limit');
                return TagData::search($query)->orderBy('created_at', 'desc')->paginate($limit);
            }

            return TagData::search($query)->take(1000)->orderBy('created_at', 'desc')->get();
        } catch (\Exception $e) {
            return $this->catchESException($e);
        }
    }

    /**
     * @param Collection $collection
     * @param string $keySub
     * @return array
     */
    private function getTagTree(Collection $collection, $keySub = 'children')
    {
        $tree = [];
        foreach ($collection as $item) {
            $tmp = [];
            // 递归条件：当标签集合中还有其下级
            if ($this->allTags->where('parent_uuid', $item['uuid'])->isNotEmpty()) {
                $children = $this->allTags->where('parent_uuid', $item['uuid']);
                $tmp = $this->getTagTree($children);
            }
            $tree[] = array_merge($this->filterFields($item), [$keySub => $tmp]);
        }
        return $tree;
    }

    /**
     * @param $tagData
     * @return array
     */
    private function filterFields($tagData): array
    {
        return [
            'uuid' => $tagData->uuid,
            'number' => $tagData->number,
            'name' => $tagData->name,
            'status' => $tagData->status,
            'level' => $tagData->level,
            'locale' => $tagData->locale,
            'type' => $tagData->type,
            'url_name' => $tagData->url_name,
            'avatar' => $tagData->avatar,
            'updated_at' => $tagData->updated_at,
        ];
    }

    /**
     * 获取标签下级
     * @param TagData $tag
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function children(TagData $tag)
    {
        $tags = TagData::query()->where('parent_uuid', $tag->uuid);
        if ($status = request()->input('filter.status')) {
            $tags->where('status', $status);
        }
        return $tags->orderBy('number', 'desc')->get();
    }

    /**
     * 标签树结构
     * @param Request $request
     * @return array
     */
    public function trees(Request $request)
    {
        $tagData = TagData::query()->orderBy('updated_at', 'desc');
        if ($status = $request->input('status', TagDataStatus::STATUS_ON)) {
            $tagData->where('status', $status);
            $query['query']['bool']['must'][] = [
                'term' => [
                    'status' => $status,
                ],
            ];
        }
        if ($type = $request->input('type')) {
            $tagData->where('type', $type);
            $query['query']['bool']['must'][] = [
                'term' => [
                    'type' => $type,
                ],
            ];
        }
        if ($language = $request->input('language')) {
            $tagData->whereRaw("JSON_CONTAINS_PATH(`locale`, 'one', '$.{$language}')");
            $query['query']['bool']['must'][] = [
                'exists' => [
                    'field' => "locale.{$language}",
                ],
            ];
        }
        if ($keyword = $request->input('keyword')) {
            if (Str::startsWith($keyword, "#")) {
                $keyword = ltrim($keyword, "#");
            }
            $keywordQuery['bool']['should'] = $this->shouldKeywordQuery($keyword, ['name', 'number']);
            $query['query']['bool']['must'][] = $keywordQuery;
            try {
                $searchResult = TagData::search(json_encode($query['query']))->take(1000)->get();
            } catch (\Exception $e) {
                return $this->catchESException($e);
            }
            // 获取搜到标签的所有父级标签uuid
            $parentUuids = collect();
            $searchResult->map(function ($tag) use (&$parentUuids) {
                if ($tag->parentIds) {
                    $parentUuids = $parentUuids->merge($tag->parentIds);
                }
            });
            $parentTags = TagData::query()->whereIn("uuid", $parentUuids->unique()->toArray())->get();
            $allTags = $parentTags->merge($searchResult);
            $this->allTags = collect($allTags)->unique('uuid');
        } else {
            $this->allTags = $tagData->get();
        }
        $topLevelTags = $this->allTags->where('level', 1);
        return $this->getTagTree($topLevelTags);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function operationLogs()
    {
        $limit = intval(request()->input('limit', 20));
        $operationLogs = TagOperationLog::query();
        if ($tagUuid = request()->input('filter.tag_uuid')) {
            $operationLogs->where('tag_data_uuid', $tagUuid);
        }
        if ($tagNumber = request()->input('filter.number')) {
            $operationLogs->where('tag_number', $tagNumber);
        }
        if ($created_at = request()->input('filter.created_at')) {
            $operationLogs->whereBetween('created_at', explode(',', $created_at));
        }
        return $operationLogs->orderBy('created_at', 'desc')->paginate($limit);
    }

    /**
     * 标签上传
     * @param Request $request
     * @throws TagDataException
     */
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        if (!in_array(strtolower($ext), ['xls', 'xlsx'])) {
            throw new TagDataException(__('tag::tag.upload.file_extensions'));
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
        if (empty($data) || !in_array($data[0][0], ['标签批量上传模板下载', '标签批量编辑'])) {
            throw new TagDataException(__('tag::tag.upload.file_error'));
        }
        // 表格存在标签ID为更新，否则为创建
        if ($data[1][0] == '标签ID') {
            $this->uploadUpdate($data);
        } else {
            $this->uploadCreate($data);
        }
    }

    /**
     * 上传更新
     * @param array $data
     * @throws TagDataException
     */
    private function uploadUpdate(array $data)
    {
        foreach ($data as $index => $item) {
            if ($index < 2) continue;
            if ($tag = TagData::query()->where('number', $item[0])->first()) {
                if ($parentTagNum = $item[3]) {
                    $parentTag = TagData::query()->where('number', $parentTagNum)->first();
                    if (empty($parentTag)) {
                        throw new TagDataException(__('tag::tag.upload.parent_not_exists', ['name' => $item[4]]));
                    }
                    $parentUuid = $parentTag->uuid;
                } else {
                    $parentUuid = null;
                }
                $tagData = [
                    'name' => $item[1],
                    'locale' => [
                        "en" => $item[1],
                    ],
                    'status' => trim($item[2]) == '开启' ? TagDataStatus::STATUS_ON : TagDataStatus::STATUS_OFF,
                    'parent_uuid' => $parentUuid,
                    'type' => TagDataType::getTypeValue($item[5]),
                ];
                if (isset($item[6])) {
                    $tagData['url_name'] = $item[6];
                }
                if (isset($item[7])) {
                    $tagData['locale']['es'] = $item[7];
                }
                if (isset($item[8])) {
                    $tagData['locale']['fr'] = $item[8];
                }
                if (isset($item[9])) {
                    $tagData['locale']['ru'] = $item[9];
                }
                if (isset($item[10])) {
                    $tagData['locale']['de'] = $item[10];
                }
                if (isset($item[11])) {
                    $tagData['locale']['jp'] = $item[11];
                }
                if (isset($item[12])) {
                    $tagData['locale']['it'] = $item[12];
                }
                if (isset($item[13])) {
                    $tagData['locale']['cn'] = $item[13];
                }
                $tag->update($tagData);
                // 状态改变
                if ($tag->wasChanged('status')) {
                    $this->tagSyncUpdateStatus($tag, $tag->status);
                }
            } else {
                throw new TagDataException(__('tag::tag.upload.tag_not_exists', ['number' => $item[0]]));
            }
        }
    }

    /**
     * 批量上传标签数据
     * @param array $data
     */
    private function uploadCreate(array $data)
    {
        $tagCollection = collect();
        foreach ($data as $index => $item) {
            if ($index < 2 || empty($item[0])) continue;
            $tagData = [
                'name' => $item[0],
                'locale' => [
                    "en" => $item[0],
                ],
                'status' => trim($item[1]) == '开启' ? TagDataStatus::STATUS_ON : TagDataStatus::STATUS_OFF,
                'parent_number' => $item[2] ?? null,
                'type' => TagDataType::getTypeValue($item[4]),
            ];
            if (isset($item[5])) {
                $tagData['url_name'] = $item[5];
            }
            if (isset($item[6])) {
                $tagData['locale']['es'] = $item[6];
            }
            if (isset($item[7])) {
                $tagData['locale']['fr'] = $item[7];
            }
            if (isset($item[8])) {
                $tagData['locale']['ru'] = $item[8];
            }
            if (isset($item[9])) {
                $tagData['locale']['de'] = $item[9];
            }
            if (isset($item[10])) {
                $tagData['locale']['jp'] = $item[10];
            }
            if (isset($item[11])) {
                $tagData['locale']['it'] = $item[11];
            }
            if (isset($item[12])) {
                $tagData['locale']['cn'] = $item[12];
            }
            $tagCollection = $tagCollection->merge([$tagData]);
        }
        $tagCollection->map(function ($item) {
            if (!empty($item['parent_number'])) {
                $parentTag = TagData::query()->where('number', $item['parent_number'])->first();
                if (empty($parentTag)) {
                    throw new TagDataException(__('tag::tag.upload.parent_not_exists', ['name' => $item['name']]));
                }
                $item['parent_uuid'] = $parentTag->uuid;
            }
            TagData::query()->create($item);
        });
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function dropdownList(Request $request)
    {
        $result = [];
        if ($keyword = $request->input('keyword')) {
            if (Str::startsWith($keyword, "#")) {
                $keyword = ltrim($keyword, "#");
            }
            $options['query']['bool']['should'] = $this->shouldKeywordQuery($keyword, ['name', 'number']);
            try {
                $result = TagData::search(json_encode($options['query']))
                    ->take(1000)
                    ->get();
            } catch (\Exception $e) {
                return $this->catchESException($e);
            }
            $result = $result->map(function ($item) {
                return [
                    'uuid' => $item->uuid,
                    'number' => $item->number,
                    'name' => $item->name,
                ];
            });
        }
        return $result;
    }

    /**
     * @param TagData $tag
     * @return bool|null
     * @throws TagDataException
     */
    public function delete(TagData $tag)
    {
        $existsChildren = TagData::query()->where('parent_uuid', $tag->uuid)->exists();
        if ($existsChildren) {
            throw new TagDataException(__('tag::tag.delete.exists_children'));
        }
        $existsBindings = $tag->tagDataSource()->exists();
        if ($existsBindings) {
            throw new TagDataException(__('tag::tag.delete.exists_bindings'));
        }
        if ($tag->avator && Storage::disk('public')->exists($tag->avator)) {
            Storage::disk('public')->delete($tag->avator);
        }
        return $tag->delete();
    }

    /**
     * 标签头像上传
     * @param TagData $tag
     * @param UploadedFile $file
     * @return false|string
     */
    private function handleUploadAvatar(TagData $tag, UploadedFile $file)
    {
        $avatarPath = 'tag/avatar/' . substr($tag->uuid, 0, 2);
        $avatarName = $tag->uuid . '.' . now()->timestamp . '.' . $file->extension();
        $path = $file->storeAs($avatarPath, $avatarName, 'public');
        if ($tag->avatar && Storage::disk('public')->exists($tag->avator)) {
            Storage::disk('public')->delete($tag->avator);
        }
        return $path;
    }
}
