<?php


namespace Modules\Share\Repositories;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Base\Contracts\ListServiceInterface;
use Modules\Base\Http\Requests\ListRequest;
use Modules\Share\Entities\Collection;
use Modules\Share\Entities\CollectionCategory;
use Modules\Share\Entities\Resource;
use Modules\Share\Exceptions\CategoryException;
use Modules\Share\Exceptions\CollectionException;
use Modules\Share\Repositories\Traits\SearchTrait;
use Modules\Share\Repositories\Traits\UpdateRedisTrait;
use Modules\Share\Transformers\Admin\Collection\CollectionCatesCollection;
use Modules\Share\Transformers\Admin\Collection\CollectionsDataCollection;
use Modules\Share\Transformers\Admin\Collection\SingleCollectionResource;
use Modules\Share\Transformers\Admin\SingleCategoryResource;

class CollectionRepositories
{
    use SearchTrait, UpdateRedisTrait;

    /**
     * @param  Request  $request
     * @return SingleCategoryResource
     * @throws CategoryException
     */
    public function store(Request $request)
    {
        $insertData = $request->all();
        $insertData['uuid'] = Str::uuid()->getHex()->toString();
        $insertData['sort'] = $insertData['sort'] ?? 255;
        if ($parent_uuid = $request->input('parent_uuid')) {
            $parent_data = CollectionCategory::query()->find($parent_uuid);
            if (is_null($parent_data)) {
                throw new CategoryException(__('share::admin.collection.categoriesParentUUIDNotExist'));
            }
            if (!$parent_data->parent_uuid) { // 父级为一级分类
                $insertData['one_level_uuid'] = $parent_uuid;
                $insertData['two_level_uuid'] = $insertData['uuid'];
            } elseif ($parent_data->two_level_uuid == $parent_uuid) { // 父级为二级分类
                $insertData['one_level_uuid'] = $parent_data->one_level_uuid;
                $insertData['two_level_uuid'] = $parent_uuid;
                $insertData['three_level_uuid'] = $insertData['uuid'];
            } elseif ($parent_data->three_level_uuid == $parent_uuid) { // 父级为3级分类
                $insertData['one_level_uuid'] = $parent_data->one_level_uuid;
                $insertData['two_level_uuid'] = $parent_data->two_level_uuid;
                $insertData['three_level_uuid'] = $parent_uuid;
            } else {
                // 无法为4级分类创建分类
                throw new CategoryException(__('share::admin.collection.categoriesCantCreateFiveLevel'));
            }
        } else {
            $insertData['one_level_uuid'] = $insertData['uuid'];
        }
        $insertData['admin_uuid'] = Auth::id();
        $category = CollectionCategory::query()
            ->create($insertData)
            ->refresh();
        // $category->searchable();
        return new SingleCategoryResource($category);
    }


    /**
     * @param  Request  $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|SingleCategoryResource|null
     * @throws CategoryException
     */
    public function update(Request $request)
    {
        $uuid = $request->uuid;
        $updateData = $request->all();
        $data = CollectionCategory::query()->find($uuid);
        if (is_null($data)) {
            throw new CategoryException((__('share::categories.parentUUIDNotExist')));
        }
        $updateData['sort'] = $updateData['sort'] ?? 255;
        $data->update($updateData);
        $data->refresh();
        // $data->searchable();
        return new SingleCategoryResource($data);
    }

    /**
     * @param  Request  $request
     * @return bool
     * @throws CategoryException
     */
    public function delete(Request $request)
    {
        $uuid = $request->uuid;
        $data = CollectionCategory::query()->with('collections')->with('resources')->find($uuid);
        if (is_null($data)) {
            throw new CategoryException(__('share::categories.categoriesNotExists'));
        }
        if ($data->children->isNotEmpty()) {
            throw new CategoryException(__('share::categories.hasChildCategories'));
        }
        try {
            $data->unsearchable();
            $num = $data->collections->count();
            $resource = $data->resources;
            if($data->delete()){
                if ($resource->isNotEmpty()) {
                    $resource->map(function ($item) {
                        $item->increment('collection_num', -1);
                    });
                }
                $this->updateRedisCollection(Auth::id(), 0 - $num);
            }
        } catch (\Exception $exception) {
            throw new CategoryException(__('share::categories.deleteFailed'), $exception->getCode(), $exception);
        }
        return true;
    }

    /**
     * @param  Request  $request
     * @return SingleCollectionResource
     * @throws CollectionException
     */
    public function collection(Request $request)
    {
        $uid = Auth::id();
        $collection = Collection::query()
            ->where('resource_uuid', $request->input('resource_uuid'))
            ->where('admin_uuid', $uid)
            ->get();
        if ($collection->isNotEmpty()) {
            throw new CollectionException(__('share::admin.collection.hasCollection'));
        }
        $resource = Resource::query()->find($request->input('resource_uuid'));
        $collectionData = $request->all();
        $collectionData['admin_uuid'] = $uid;
        $collectionData['resource_type'] = $resource->type;
        $collectionData['resource_name'] = $resource->name;
        $collectionData['uuid'] = Str::uuid()->getHex()->toString();
        $collection = Collection::query()->create($collectionData)
            ->refresh();
        // $collection->searchable();
        // 收藏数+1
        $resource->increment('collection_num');
        if ($categoryUuid = $request->input('category_uuid')) {
            $category = CollectionCategory::query()->find($categoryUuid);
            $this->updateCategoryCollectionSum($category, 1);
        }
        $this->updateRedisCollection($uid, 1);
        return new SingleCollectionResource($collection);
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     * @throws CollectionException
     */
    public function batchCollection(Request $request)
    {
        $collections = [];
        DB::beginTransaction();
        try {
            $uid = Auth::id();
            $num = 0;
            foreach ($request->input('resource_uuid') as $item) {
                $collection = Collection::query()
                    ->where('resource_uuid', $item)
                    ->where('admin_uuid', $uid)
                    ->get();
                if ($collection->isNotEmpty()) {
                    continue;
                }
                $resource = Resource::query()->find($item);
                $collectionData = [];
                $collectionData['category_uuid'] = $request->input('category_uuid');
                $collectionData['resource_uuid'] = $item;
                $collectionData['admin_uuid'] = $uid;
                $collectionData['resource_type'] = $resource->type;
                $collectionData['resource_name'] = $resource->name;
                $collectionData['uuid'] = Str::uuid()->getHex()->toString();
                $collection = Collection::query()->create($collectionData)->refresh();
                // $collection->searchable();
                // 收藏数+1
                $resource->increment('collection_num');
                $num++;
                $collections[] = new SingleCollectionResource($collection);
            }
            DB::commit();
            if ($categoryUuid = $request->input('category_uuid')) {
                $category = CollectionCategory::query()->find($categoryUuid);
                $this->updateCategoryCollectionSum($category, $num);
            }
            $this->updateRedisCollection($uid, $num);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new CollectionException(__('share::admin.collection.batchCollectionFailed'), $exception->getCode(), $exception);
        }
        return $collections;
    }

    /**
     * @param  Request  $request
     * @return bool
     * @throws CollectionException
     */
    public function deleteCollection(Request $request)
    {
        $admin_uuid = Auth::id();
        $collection = Collection::query()->where('admin_uuid', $admin_uuid)->find($request->uuid);
        if (is_null($collection)) {
            throw new CollectionException(__('share::admin.collection.collectionUUIDNotExists'));
        }
        DB::beginTransaction();
        $num = 0;
        try {
            $resource = $collection->resource;
            $categoryUuid = $collection->category_uuid;
            $category = $collection->category;
            if ($collection->delete()) {
                if (!is_null($resource)){ // 资源可能被删除
                    $resource->increment('collection_num', -1);
                }
                // 更新分类的收藏数 -1
                if ($categoryUuid) {
                    $this->updateCategoryCollectionSum($category, -1);
                }
                $num = -1;
            }
            $collection->unsearchable();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new CollectionException(__('share::admin.collection.deleteCollectionFailed'), $exception->getCode(), $exception);
        }
        $this->updateRedisCollection($admin_uuid, $num);
        return true;
    }


    /**
     * @param  ListRequest  $request
     * @param  ListServiceInterface  $service
     * @return array
     */
    public function getMixData(ListRequest $request, ListServiceInterface $service)
    {
        $uuid = Auth::id();
        $type = $request->input('filter')['type'];
        $cateModelBuilder = CollectionCategory::query()
            ->where('admin_uuid', $uuid)
            ->where('type', $type)
            ->orderBy('sort', 'asc')
            ->orderBy('created_at', 'DESC');
        $collectionModelBuilder = Collection::query()
            ->where('admin_uuid', $uuid)
            ->where('resource_type', $type)
            ->with([
                'resources' => function ($q1) {
                    return $q1->with('tags')->with('collection');
                }
            ])
            ->orderBy('created_at', 'DESC')
            ->orderBy('resource_name', 'DESC');
        $parent_uuid = $request->input('parent_uuid') ?? null;
        $cateModelBuilder->where('parent_uuid', $parent_uuid);
        $collectionModelBuilder->where('category_uuid', $parent_uuid);
        if ($request->has('key')) {
            $searchCateData = $this->searchCollectionCategoryUuidByKey($request, $uuid);
            $cateUuid = $searchCateData['uuid'];
            $paginate = $searchCateData['paginate'];
            $cateTotal = $paginate['total'];
        } else {
            $cateTotal = $cateModelBuilder->count();
            $resourceTotal = $collectionModelBuilder->count();
        }
        $pageSize = $request->input('limit') ?? 15;
        // 当前页
        $currentPage = $request->input('page') ?? 1;
        // cate 可以填充多少页 向下取整
        $catePage = intval(floor($cateTotal / $pageSize));
        // 填充了该页后余下多少个
        $remain = $cateTotal % $pageSize;
        // 第几页开始有资源
        $startResourcePage = $catePage + 1;
        // 默认不查资源
        $selectResource = false;
        // 没有分类数据或者分类数据 或 不足一页的时候 需要去查询resource 进行填充 即 当前页 >= 开始有资源的页面
        if ($currentPage >= $startResourcePage) {
            $selectResource = true;
            $resourceRealPage = $currentPage - $startResourcePage + 1; // 资源的真正页数
            $firstPageAppendNums = $pageSize - $remain; // 第一次出现资源时的一页 填充的数据量
        }
        $cate = $resources = collect([]); // 默认都是空
        if ($request->has('key')) {
            $request->offsetSet('one_page_size', $pageSize);
            if ($selectResource) { // 如果要查
                request()->offsetSet('resource_page', $resourceRealPage);
                request()->offsetSet('append_nums', $firstPageAppendNums);
            } else { // 如果不查 默认都是1 只需要知道用多少个资源
                request()->offsetSet('resource_page', 1);
                request()->offsetSet('append_nums', 1);
            }
            // 获取收藏相关信息
            $searchCollectionData = $this->searchCollectionData($request, $uuid);
            $resource_uuid = $searchCollectionData['uuid'];
            $resourceTotal = $searchCollectionData['paginate']['total'];
            $cateModelBuilder->whereIn('uuid', $cateUuid);
            $collectionModelBuilder->whereIn('uuid', $resource_uuid);
            $cate = CollectionCatesCollection::collection($cateModelBuilder->get());
            $resources = CollectionsDataCollection::collection($collectionModelBuilder->get());
        } else {
            if ($currentPage <= $startResourcePage) {
                $from = ($currentPage - 1) * $pageSize;
                $cate = $cateModelBuilder->offset($from)->limit($pageSize);
                $cate = CollectionCatesCollection::collection($cateModelBuilder->get());
            }
            if ($selectResource) {
                if ($resourceRealPage == 1) {
                    $from = 0;
                    $limit = $firstPageAppendNums;
                } else {
                    $from = ($resourceRealPage - 2) * $pageSize + $firstPageAppendNums;
                    $limit = $pageSize;
                }
                $collectionModelBuilder->offset($from)->limit($limit);
                $resources = CollectionsDataCollection::collection($collectionModelBuilder->get());
            }
        }

        $allTotal = $cateTotal + $resourceTotal;
        $lastPage = intval(ceil($allTotal / $pageSize));
        $paginate['total'] = $allTotal;
        $paginate['last_page'] = $lastPage;
        $paginate['current_page'] = $currentPage;
        $paginate['per_page'] = $pageSize;

        $mixs = $cate->merge($resources);
        return compact('mixs', 'paginate');
    }

    /**
     * 更新redis缓存的数据
     * @param $uuid
     * @param $num
     */
    private function updateRedisCollection($uuid, $num)
    {
        $this->updateStatsData($uuid, 'collection', $num);
    }

    /**
     * 更新分类的收藏数
     * @param  CollectionCategory  $category
     * @param $sum
     */
    private function updateCategoryCollectionSum(CollectionCategory $category, $sum = 1)
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
     * @return bool
     * @throws CollectionException
     */
    public function batchDeleteCollection(Request $request)
    {
        $uuid = $request->input('uuid');
        $num = 0;
        DB::beginTransaction();
        try {
            Collection::query()->whereIn('uuid', $uuid)
                ->with('resources')
                ->with('category')
                ->get()
                ->map(function ($collection)use(&$num) {
                    $collection->unsearchable();
                    $categoryUuid = $collection->category_uuid;
                    $category = $collection->category;
                    $resource = $collection->resource;
                    if ($collection->delete()) {
                        if(!is_null($resource)) {
                            $resource->increment('collection_num', -1);
                        }
                        // 更新分类的收藏数 -1
                        if ($categoryUuid) {
                            $this->updateCategoryCollectionSum($category, -1);
                        }
                        $num = $num+1;
                    }
                });
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new CollectionException(__('share::admin.collection.batchCollectionFailed'), $exception->getCode(), $exception);
        }
        $this->updateRedisCollection(Auth::id(), 0 - $num);
        return true;
    }
}
