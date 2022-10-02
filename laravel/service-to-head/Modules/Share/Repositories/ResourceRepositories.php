<?php


namespace Modules\Share\Repositories;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Base\Contracts\ListServiceInterface;
use Modules\Base\Entities\Model;
use Modules\Base\Http\Requests\ListRequest;
use Modules\Base\Repositories\OssUploadRepository;
use Modules\Base\Support\Facades\OssService;
use Modules\Share\Entities\Resource;
use Modules\Share\Entities\ResourceCategory;
use Modules\Share\Entities\ResourceChangeCache;
use Modules\Share\Entities\ResourceCustomCategory;
use Modules\Share\Entities\ResourceDownload;
use Modules\Share\Entities\ResourcesLog;
use Modules\Share\Exceptions\ResourceException;
use Modules\Share\Repositories\Traits\SearchTrait;
use Modules\Share\Repositories\Traits\UpdateRedisTrait;
use Modules\Share\Transformers\Categories\ResourceTagsCollection;
use Modules\Share\Transformers\Resource\BatchDownloadResource;

class ResourceRepositories
{
    use SearchTrait, UpdateRedisTrait;

    protected $user;
    protected $admin_uuid;
    protected $admin_name;
    protected $user_data;
    protected $key; // redis 存储的key
    protected $action; // 当前操作
    protected $resourceCache;
    protected $resource_uuid;
    protected $ossUploadRepository;

    public function __construct(OssUploadRepository $ossUploadRepository)
    {
        if(Auth::check()){
            $this->user = Auth::user();
            $this->admin_name = $this->user->name;
            $this->admin_uuid = $this->user->uuid;
            $this->user_data = [
                'admin_uuid' => $this->admin_uuid,
                'admin_name' => $this->admin_name,
            ];
        }
        $this->resourceCache = new ResourceChangeCache();
        $this->ossUploadRepository = $ossUploadRepository;
    }

    protected function setActionAndKey($action, $uuid)
    {
        $this->action = "由 {$this->admin_name} $action";
        $this->key = 'resource_'.$uuid.'_user_'.$this->admin_uuid;
        $this->resource_uuid = $uuid;
        $logs = [
            'title' => $this->action
        ];
        $this->deleteRedisData(); // 删除一下避免有重复信息
        $this->putRedis($logs);
    }

    /**
     * @param  Request  $request
     * @throws ResourceException
     */
    public function store(Request $request)
    {
        $resources = $request->input('resources');
        $insertData = $request->only(['type', 'custom_category_uuid']);
        $insertData['creator_uuid'] = $this->admin_uuid;
        $insertData['creator_name'] = $this->admin_name;
        $num = count($resources);
        DB::beginTransaction();
        try {
            $toEsArr = [];
            foreach ($resources as $v) {
                $this->setActionAndKey('创建', $v['uuid']);
                // 获取到临时资源表数据
                $temResource = $this->ossUploadRepository->getTempInfo($v['uuid']);
                $resourcesData = $insertData;
                $resourcesData['name'] = $v['name'];
                $resourcesData['object'] = $temResource->object;
                $resourcesData['size'] = ($temResource->origin_body)['size'] ?? 0;
                $resourcesData['mime_type'] = ($temResource->origin_body)['mime_type'] ?? "";
                $resourcesData['format'] = ($temResource->origin_body)['format'] ?? "";

                $resourcesData['uuid'] = $v['uuid'];
                $resourcesData['duration'] = $v['duration'];
                // 更新至resource
                $resource = Resource::query()->create($resourcesData);
                $toEsArr[] = $resource;
                // logs 存入redis
                // 删除temp文件
                $this->ossUploadRepository->deleteTemp($v['uuid']);
                // 远程一对多 tag & subject 更新
                if ($tags = $request->input('tag_uuid')) {
                    $this->syncUpdateTags($resource, $tags);
                }
                if ($subjects = $request->input('subject_uuid')) {
                    $this->syncUpdateSubjects($resource, $subjects);
                }
                $this->syncUpdateCategories($resource, $request->input('category_uuid'));
                // 插入logs表
                $this->logsInsert();
            }
            // 对应的category 更新数量
            $ResourceCategory = ResourceCategory::query()->find($request->input('category_uuid'));
            $this->updateCategorySum($ResourceCategory, $num);
            if ($customCategoryUuid = $request->input('custom_category_uuid')) {
                $CustomerCategory = ResourceCustomCategory::query()->find($customCategoryUuid);
                $this->updateCategorySum($CustomerCategory, $num);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ResourceException(__("share::resource.uploadFailed"), $exception->getCode(), $exception);
        }
        // 上传数 +N
        $this->updateUploadData($num);
        foreach ($toEsArr as $resource) {
            // 同步到es 手动同步 aliyun 兑换缩略图 避免
            $resource->searchable();
        }
        return true;
    }

    private function updateCategorySum(Model $category, $sum = 1)
    {
        $parent = $category;
        $level = $parent->level;
        for ($i = $level; $i >= 1; $i--) {
            $parent = $i == $level ? $parent : $parent->parent;
            $parent->increment('sum', $sum);
        }
    }

    /**
     * @param  Request  $request
     * @throws ResourceException
     */
    public function update(Request $request)
    {
        $resource = $this->checkUuidIsExists($request->uuid, true);
        $old_cate = $resource->categories;
        $updateData = $request->only(['name']);
        DB::beginTransaction();
        try {
            $this->setActionAndKey('更新', $request->uuid);
            $resource->update($updateData);
            $tag_uuid = $request->input('tag_uuid') ?? [];
            $this->syncUpdateTags($resource, $tag_uuid);
            $this->syncUpdateCategories($resource, $request->input('category_uuid'));
            $old_cate->map(function ($cate) {
                $this->updateCategorySum($cate, -1);
            });
            $resourceCategory = ResourceCategory::query()->find($request->input('category_uuid'));
            $this->updateCategorySum($resourceCategory, 1);
            $this->logsInsert();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ResourceException(__('share::resource.updateFailed'), $exception->getCode(), $exception);
        }
        $resource->searchable();
        return true;
    }

    /**
     * @param  Request  $request
     * @throws ResourceException
     */
    public function batchUpdate(Request $request)
    {
        $updateData = [];
        $tag_uuid = $request->input('tag_uuid') ?? [];
        DB::beginTransaction();
        try {
            Resource::query()->whereIn('uuid', $request->input('uuid'))
                ->get()
                ->map(function ($resource) use ($updateData, $tag_uuid, $request) {
                    $this->setActionAndKey('更新', $resource->uuid);
                    $resource->update($updateData);
                    $this->syncUpdateTags($resource, $tag_uuid);
                    // 原分类-1
                    $resource->categories->map(function ($cate) {
                        $this->updateCategorySum($cate, -1);
                    });
                    $this->syncUpdateCategories($resource, $request->input('category_uuid'));
                    $resource->searchable();
                    $this->logsInsert();
                });

            // 新分类+N
            $num = count($request->input('uuid'));
            $resourceCategory = ResourceCategory::query()->find($request->input('category_uuid'));
            $this->updateCategorySum($resourceCategory, $num);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ResourceException(__("share::resource.batchUpdateFailed"), $exception->getCode(), $exception);
        }
    }

    /**
     * @param  Request  $request
     * @throws ResourceException
     */
    public function deleteResource(Request $request)
    {
        $resource = $this->checkUuidIsExists($request->uuid, true);
        // 对应的category 更新数量
        DB::beginTransaction();
        $num = 0;
        try {
            // 移除OSS数据
            OssService::deleteObjects(OssService::bucket(), [
                $resource->object,
                $resource->object_height_216_width_216,
                $resource->object_height_500_width_930
            ]);
            $resource->unsearchable();
            $customCategory = $resource->customCategory;
            $categories = $resource->categories;
            if ($resource->delete()){
                if ($customCategory) {
                    $this->updateCategorySum($customCategory, -1);
                }
                $categories->map(function ($cate) {
                    $this->updateCategorySum($cate, -1);
                });
                $num = -1;
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ResourceException(__("share::resource.deleteFailed"), $exception->getCode(), $exception);
        }
        // upload -1
        $this->updateUploadData($num);
    }

    /**
     * @param  Request  $request
     * @throws ResourceException
     */
    public function batchDeleteResource(Request $request)
    {
        $num = 0;
        DB::beginTransaction();
        try {
            $objects = [];
            Resource::query()->whereIn('uuid', $request->input('uuid'))
                ->with('customCategory')
                ->with('categories')
                ->get()
                ->map(function ($resource) use (&$objects, &$num) {
                    $objects[] = $resource->object;
                    $objects[] = $resource->object_height_500_width_930;
                    $objects[] = $resource->object_height_216_width_216;
                    $resource->unsearchable();
                    $customCategory = $resource->customCategory;
                    $categories = $resource->categories;
                    if ($resource->delete()) {
                        $num = $num +1;
                        if ($customCategory) {
                            $this->updateCategorySum($customCategory, -1);
                        }
                        $categories->map(function ($cate) {
                            $this->updateCategorySum($cate, -1);
                        });
                    }
                });
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ResourceException(__("share::resource.batchDeleteFailed"), $exception->getCode(), $exception);
        }
        $this->updateUploadData(0 - $num);
        OssService::deleteObjects(OssService::bucket(), $objects);
        return true;
    }

    /**
     * @param  Request  $request
     * @return mixed
     * @throws ResourceException
     */
    public function downloadResource(Request $request)
    {
        $resource = $this->checkUuidIsExists($request->uuid);
        $resource->increment('download_num');
        $this->markDownload($resource);
        if ($is_watermark = $request->input('is_watermark') && $resource->type == 'picture') {
            return OssService::imageWatermark($resource->object, config('oss.watermark_base64'), 'fill_1');
        }
        return OssService::getSignUrl($resource->object);
    }

    public function batchDownloadResource(Request $request)
    {
        $resources = Resource::query()->whereIn('uuid', $request->input('resource_uuid'))->get();
        $resources->map(function ($resource) {
            $resource->increment('download_num');
            $this->markDownload($resource);
        });
        return new BatchDownloadResource($resources);
    }

    public function resourceTagsCollection(ListRequest $request, ListServiceInterface $service)
    {
        $search_data = $this->searchResourceUuidByRequest($request);
        $resource_uuid = $search_data['uuid'];
        $paginate = $search_data['paginate'];
        $resourceBuilder = Resource::query()->whereIn('uuid', $resource_uuid)
            ->orderBy('created_at', 'desc')
            ->orderBy('name', 'DESC')
            ->get();
        if($request->has('key')) { // 查询关键字
            $key = $request->input('key');
            $this->insertHotKey($key);
        }
        $resources = new ResourceTagsCollection($resourceBuilder);
        return compact('resources', 'paginate');
    }

    /**
     * @param  Request  $request
     * @return bool
     * @throws ResourceException
     */
    public function addNewCategory(Request $request)
    {
        $categoryUuid = $request->input('category_uuid');
        $resource = $this->checkUuidIsExists($request->uuid);
        $cate = $resource->categories()->where('uuid', $categoryUuid)->withTrashed()->get();
        if ($cate->isNotEmpty()) {
            throw new ResourceException(__('share::resource.cantCopyAgain'));
        }
        DB::beginTransaction();
        try {
            $this->setActionAndKey('复制到', $request->uuid);
            $this->syncUpdateCategories($resource, $categoryUuid, 3);
            // 分类资源 + 1
            $resourceCategory = ResourceCategory::query()->withTrashed()->find($categoryUuid);
            $this->updateCategorySum($resourceCategory, 1);
            $resource->searchable();
            $this->logsInsert();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ResourceException(__('share::resource.copyCategoryFailed'), $exception->getCode(), $exception);
        }
        return true;
    }

    /**
     * @param  Request  $request
     * @throws ResourceException
     */
    public function updateCategory(Request $request)
    {
        $removeCategoryUuid = $request->input('origin_category_uuid');
        $moveCategoryUuid = $request->input('category_uuid');
        $resource = $this->checkUuidIsExists($request->uuid);
        if (is_null($resource)) {
            throw new ResourceException(__("share::resource.UUIDNotExists"));
        }
        $cate = $resource->categories()->where('uuid', $moveCategoryUuid)->withTrashed()->get();
        if ($cate->isNotEmpty()) {
            throw new ResourceException(__('share::resource.targetCategoryHasThisResource'));
        }
        $originCate = $resource->categories()->where('uuid', $removeCategoryUuid)->withTrashed()->get();
        if ($originCate->isEmpty()) {
            throw new ResourceException(__('share::resource.originCategoryNotExists'));
        }
        DB::beginTransaction();
        try {
            $this->setActionAndKey('移动了分类', $resource->uuid);
            $toggleUuid = [$removeCategoryUuid, $moveCategoryUuid];
            $this->syncUpdateCategories($resource, $toggleUuid, 3);
            // 分类资源 + 1
            $moveResourceCategory = ResourceCategory::query()->withTrashed()->find($moveCategoryUuid);
            $this->updateCategorySum($moveResourceCategory, 1);
            // 分类资源 - 1
            $removeResourceCategory = ResourceCategory::query()->withTrashed()->find($removeCategoryUuid);
            $this->updateCategorySum($removeResourceCategory, -1);
            $resource->searchable();
            $this->logsInsert();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ResourceException(__('share::resource.copyCategoryFailed'), $exception->getCode(), $exception);
        }
    }

    /**
     * @param  Request  $request
     * @return bool
     * @throws ResourceException
     */
    public function addTag(Request $request)
    {
        $resource = $this->checkUuidIsExists($request->uuid);
        $tagUuid = $request->input('tag_uuid');
        $tag = $resource->tags()->whereIn('uuid', $tagUuid)->withTrashed()->get()->pluck('uuid')->all(); // 已存在的
        $sync = array_diff($tagUuid, $tag);
        if (!empty($sync)) {
            $this->setActionAndKey('添加了标签', $resource->uuid);
            $this->syncUpdateTags($resource, $sync, 2);
            $this->logsInsert();
            $resource->searchable();
        }
        return true;
    }

    /**
     * @param  Request  $request
     * @return bool
     * @throws ResourceException
     */
    public function deleteTag(Request $request)
    {
        $resource = $this->checkUuidIsExists($request->resource_uuid);
        $tagUuid = $request->tag_uuid;
        $tag = $resource->tags()->wherePivot('admin_uuid', $this->admin_uuid)->where('uuid', $tagUuid)->get();
        if ($tag->isEmpty()) {
            throw new ResourceException(__('share::resource.tagNotExistsOrNotYour'));
        }
        $this->setActionAndKey('删除了标签', $resource->uuid);
        $this->syncUpdateTags($resource, [$tagUuid], 3);
        $this->logsInsert();
        $resource->searchable();
        return true;
    }

    /**
     * @param  Request  $request
     * @throws ResourceException
     */
    public function getLogs(ListRequest $request)
    {
        $resource = $this->checkUuidIsExists($request->uuid);
        return $resource;
    }

    protected function syncUpdateSubjects(Resource $resource, $data, $type = 1)
    {
        if ($type == 1) { // 新增，删除原来的
            $resource->subjects()->sync($data);
        } elseif ($type == 2) { // 新增，保留来的的
            $resource->subjects()->syncWithoutDetaching($data);
        }
    }

    protected function syncUpdateTags(Resource $resource, $data, $type = 1)
    {
        $sync = [];
        $oldTagsUuid = $resource->tags->pluck('uuid')->all();
        foreach ($data as $tag) {
            if (in_array($tag, $oldTagsUuid) && $type == 1) {
                $sync[] = $tag;
            } else {
                $sync[$tag] = $this->user_data;
            }
        }
        if ($type == 1) { // 删除原来的
            $resource->tags()->sync($sync);
        } elseif ($type == 2) { // 新增
            $resource->tags()->syncWithoutDetaching($sync);
        } elseif ($type == 3) { // 有则删无则加
            $resource->tags()->toggle($data);
        }
    }

    protected function syncUpdateCategories(Resource $resource, $data, $type = 1)
    {
        if (is_array($data)) {
            foreach ($data as $cate) {
                $sync[$cate] = $this->user_data;
            }
        } else {
            $sync = [$data => $this->user_data];
        }
        if ($type == 1) { // 删除原来的
            $origin = $resource->categories()->get()->pluck('uuid')->all();
            $now = [$data];
            if (!empty(array_diff($origin, $now)) || empty($origin)) {
                $resource->categories()->sync($sync);
            }
        } elseif ($type == 2) { // 新增
            $resource->categories()->syncWithoutDetaching($sync);
        } elseif ($type == 3) { // 有则删无则加
            $resource->categories()->toggle($sync);
        }
    }


    protected function updateUploadData($num)
    {
        $this->updateStatsData($this->admin_uuid, 'upload', $num);
    }

    /**
     * @param $uuid
     * @param  bool  $isSelf
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     * @throws ResourceException
     */
    protected function checkUuidIsExists($uuid, $isSelf = false)
    {
        $resource = Resource::query();
        if ($isSelf) {
            $resource->where('creator_uuid', $this->admin_uuid);
        }
        $resource = $resource->find($uuid);
        if (is_null($resource)) {
            throw new ResourceException(__("share::resource.UUIDNotExists"));
        }
        $resource->with('tags');
        return $resource;
    }

    protected function putRedis(array $data)
    {
        $this->resourceCache->save($this->key, $data);
    }

    protected function getRedisData()
    {
        return $this->resourceCache->find($this->key);
    }

    /**
     * 删除对应缓存
     */
    protected function deleteRedisData()
    {
        $this->resourceCache->forget($this->key);
    }

    /**
     * 插入记录
     */
    protected function logsInsert()
    {
        $log['uuid'] = $this->resource_uuid;
        $logData = $this->getRedisData();
        if (count($logData) > 1) {
            $log['log'] = $logData;
            ResourcesLog::query()->create($log);
        }
        $this->deleteRedisData();
    }

    /**
     * 记录下载
     * @param  Resource  $resource
     */
    protected function markDownload(Resource $resource)
    {
        // mysql 插入
        ResourceDownload::query()->create([
            'uuid'          => Str::uuid()->getHex()->toString(),
            'admin_uuid'    => $this->admin_uuid,
            'resource_name' => $resource->name,
            'resource_uuid' => $resource->uuid,
            'resource_type' => $resource->type,
        ])->refresh();
        // $download->searchable();
        // redis 更新
        $this->updateStatsData($this->admin_uuid, 'download', 1);
    }
}
