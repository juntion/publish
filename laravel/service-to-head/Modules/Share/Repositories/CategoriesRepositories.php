<?php


namespace Modules\Share\Repositories;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Base\Contracts\ListServiceInterface;
use Modules\Base\Http\Requests\ListRequest;
use Modules\Share\Entities\CategoryTreeCache;
use Modules\Share\Entities\Resource;
use Modules\Share\Entities\ResourceCategory;
use Modules\Share\Exceptions\CategoryException;
use Modules\Share\Repositories\Traits\SearchTrait;
use Modules\Share\Transformers\Admin\Upload\UploadResourceCollection;
use Modules\Share\Transformers\Categories\CategoryResource;
use Modules\Share\Transformers\Categories\MixCategoryDataCollection;
use Modules\Share\Transformers\Categories\ResourceTagsCollection;

class CategoriesRepositories
{
    use SearchTrait;

    protected $cache;

    public function __construct()
    {
        $this->cache = new CategoryTreeCache();
    }

    /**
     * @param  Request  $request
     * @return CategoryResource
     * @throws CategoryException
     */
    public function store(Request $request)
    {
        $insertData = $request->all();
        $insertData['uuid'] = Str::uuid()->getHex()->toString();
        $insertData['sort'] = $insertData['sort'] ?? 255;
        if ($parent_uuid = $request->input('parent_uuid')) {
            $parent_data = ResourceCategory::query()->find($parent_uuid);
            if (is_null($parent_data)) {
                throw new CategoryException(__('share::categories.parentUUIDNotExist'));
            }
            if (!$parent_data->parent_uuid) { // 父级为一级分类
                $insertData['one_level_uuid'] = $parent_uuid;
                $insertData['two_level_uuid'] = $insertData['uuid'];
            } else if ($parent_data->two_level_uuid == $parent_uuid) { // 父级为二级分类
                $insertData['one_level_uuid'] = $parent_data->one_level_uuid;
                $insertData['two_level_uuid'] = $parent_uuid;
                $insertData['three_level_uuid'] = $insertData['uuid'];
            } else if ($parent_data->three_level_uuid == $parent_uuid) { // 父级为3级分类
                $insertData['one_level_uuid'] = $parent_data->one_level_uuid;
                $insertData['two_level_uuid'] = $parent_data->two_level_uuid;
                $insertData['three_level_uuid'] = $parent_uuid;
            } else {
                // 无法为4级分类创建分类
                throw new CategoryException(__('share::categories.cantCreateFiveLevel'));
            }
        } else {
            $insertData['one_level_uuid'] = $insertData['uuid'];
        }
        $data = ResourceCategory::query()
            ->create($insertData)
            ->refresh();
        // $data->searchable();
        return new CategoryResource($data);
    }

    /**
     * @param  Request  $request
     * @return CategoryResource
     * @throws CategoryException
     */
    public function update(Request $request)
    {
        $uuid = $request->uuid;
        $updateData = $request->all();
        $data = ResourceCategory::query()->find($uuid);
        if (is_null($data)) {
            throw new CategoryException((__('share::categories.parentUUIDNotExist')));
        }
        $updateData['sort'] = $updateData['sort'] ?? 255;
        $data->update($updateData);
        $data->refresh();
        // $data->searchable();
        return new CategoryResource($data);
    }


    /**
     * 区别于关闭，此为强制删除
     * @param  Request  $request
     * @return bool
     * @throws CategoryException
     */
    public function delete(Request $request)
    {
        $uuid = $request->uuid;
        $data = ResourceCategory::query()->withTrashed()->find($uuid);
        if (is_null($data)) {
            throw new CategoryException(__('share::categories.categoriesNotExists'));
        }
        if ($data->children()->withTrashed()->get()->isNotEmpty()) {
            throw new CategoryException(__('share::categories.hasChildCategories'));
        }
        if ($data->sum > 0) {
            throw new CategoryException(__('share::categories.isNotEmptyCategories'));
        }
        try {
            $data->unsearchable();
            $data->forceDelete();
        } catch (\Exception $exception) {
            throw new CategoryException(__('share::categories:deleteFailed'), $exception->getCode(), $exception);
        }
        return true;
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|mixed
     */
    public function treeType(Request $request)
    {
        $cache = $this->cache;
        $type = $request->type;
        $key = $type;
        $tree = $cache->findOrSaveCache($key, function ()use ($type) {
            $query = ResourceCategory::query()
                ->whereNull('parent_uuid')
                ->withTrashed()
                ->where('type',$type);
            $data = $query->orderBy('sort', 'ASC')->orderBy('created_at', 'ASC')->get();
            return $data;
        });
        return $tree;
    }


    /**
     * @param  ListRequest  $request
     * @param  ListServiceInterface  $service
     * @return array|ResourceTagsCollection
     * @throws CategoryException
     */
    public function resourcesTags(ListRequest $request, ListServiceInterface $service)
    {
        $uuid = $request->uuid;
        $category = ResourceCategory::query()
            ->with([
                'resources' => function ($q1) {
                    return $q1->with('tags')->with('collection');
                }
            ])->find($uuid);

        if (is_null($category)) {
            throw new CategoryException(__('share::categories.categoriesNotExists'));
        }
        if ($request->has('key') || $tagUuid = $request->input('tag_uuid')){
            $search_data = $this->searchResourceUuidByRequest($request, false, false, false, false, false, true);
            $resource_uuid = $search_data['uuid'];
            $paginate = $search_data['paginate'];
            $resourceBuilder = Resource::query()
                ->whereIn('uuid', $resource_uuid)->orderBy('created_at', "DESC")
                ->orderBy('created_at', 'DESC')
                ->orderBy('name', 'DESC')
                ->get();
            // 查询关键字
            $key = $request->input('key');
            if ($key != ""){
                $this->insertHotKey($key);
            }
            $resources = new ResourceTagsCollection($resourceBuilder);
            return compact('resources', 'paginate');
        } else {
            $parentUuid = $request->uuid;
            $resourceBuilder = Resource::query()
                ->whereHas('categories', function ($q) use ($parentUuid) {
                    return $q->where('uuid', $parentUuid);
                })
                ->orderBy('created_at', 'DESC')
                ->orderBy('name', 'DESC');
            $service->setRequest($request);
            $service->setBuilder($resourceBuilder);
            return new ResourceTagsCollection($service->getResource());
        }
    }

    /**
     * @param  Request  $request
     * @throws CategoryException
     */
    public function close(Request $request)
    {
        $category = ResourceCategory::query()->find($request->uuid);
        if (is_null($category)) {
            throw new CategoryException(__('share::categories.categoriesNotExists'));
        }
        $level = $category->level;
        $col = $this->getColName($level);
        ResourceCategory::query()->where($col, $request->uuid)->get()->map(function ($item){
            $item->delete();
        });
    }

    /**
     * @param  Request  $request
     * @throws CategoryException
     */
    public function open(Request $request)
    {
        $category = ResourceCategory::query()->onlyTrashed()->find($request->uuid);
        if (is_null($category)) {
            throw new CategoryException(__('share::categories.categoriesNotExists'));
        }
        $level = $category->level;
        $col = $this->getColName($level);
        ResourceCategory::query()->onlyTrashed()->where($col, $request->uuid)->get()->map(function ($item){
            $item->restore();
        });;
    }

    /**
     * @param $level
     * @return string
     */
    protected function getColName($level)
    {
        switch ($level) {
            case 1:
                $col = 'one_level_uuid';
                break;
            case 2:
                $col = 'two_level_uuid';
                break;
            case 3:
                $col = 'three_level_uuid';
                break;
            case 4:
                $col = 'uuid';
                break;
        }
        return $col;
    }

    /**
     * @param  Request  $request
     * @return bool
     * @throws CategoryException
     */
    public function sort(Request $request)
    {
        $sorts = $request->input('sort');
        DB::beginTransaction();
        try {
            foreach ($sorts as $sort) {
                ResourceCategory::query()->withTrashed()->find($sort['uuid'])->update([
                    'sort' => $sort['sort']
                ]);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new CategoryException(__('share::categories.sortFailed'), $exception->getCode(), $exception);
        }
        return true;
    }


    public function getMixList(ListRequest $request, ListServiceInterface $service)
    {
        $resourceBuilder = Resource::query()
            ->orderBy('created_at', 'DESC')
            ->orderBy('name', 'DESC');
        $categoryBuilder = ResourceCategory::query()
            ->orderBy('sort', 'ASC')
            ->orderBy('created_at', 'DESC');
        $parentUuid = $request->input('parent_uuid') ?? null;
        $categoryBuilder->where('parent_uuid', $parentUuid);
        $resourceBuilder->whereHas('categories', function ($q) use ($parentUuid) {
            return $q->where('uuid', $parentUuid);
        })
            ->with('tags')
            ->with('collection');
        if ($request->has('key') || $tagsUuid = $request->input('tag_uuid')) {
            $searchCateData = $this->searchCategoryUuidByKey($request);
            $cateUuid = $searchCateData['uuid'];
            $paginate = $searchCateData['paginate'];
            $cateTotal = $paginate['total'];
        } else {
            $cateTotal = $categoryBuilder->count();
            $resourceTotal = $resourceBuilder->count();
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
        if ($request->has('key') || $tagsUuid = $request->input('tag_uuid')) {
            $request->offsetSet('one_page_size', $pageSize);
            if ($selectResource) { // 如果要查
                request()->offsetSet('resource_page', $resourceRealPage);
                request()->offsetSet('append_nums', $firstPageAppendNums);
            } else { // 如果不查 默认都是1 只需要知道用多少个资源
                request()->offsetSet('resource_page', 1);
                request()->offsetSet('append_nums', 1);
            }
            // 获取资源相关信息
            $searchResourceData = $this->searchResourceUuidByRequest($request, false, false, true);
            $resource_uuid = $searchResourceData['uuid'];
            $resourceBuilder->whereIn('uuid', $resource_uuid);
            $categoryBuilder->whereIn('uuid', $cateUuid);
            $resource_paginate = $searchResourceData['paginate'];
            $resourceTotal = $resource_paginate['total'];
            $cate = MixCategoryDataCollection::collection($categoryBuilder->get());
            $resources = UploadResourceCollection::collection($resourceBuilder->get());
            $key = $request->input('key');
            if ($key != ""){
                $this->insertHotKey($key);
            }
        } else {
            if ($currentPage <= $startResourcePage) {
                $from = ($currentPage - 1) * $pageSize;
                $categoryBuilder->offset($from)->limit($pageSize);
                $cate = MixCategoryDataCollection::collection($categoryBuilder->get());
            }
            if ($selectResource) {
                if ($resourceRealPage == 1) {
                    $from = 0;
                    $limit = $firstPageAppendNums;
                } else {
                    $from = ($resourceRealPage - 2) * $pageSize + $firstPageAppendNums;
                    $limit = $pageSize;
                }
                $resourceBuilder->offset($from)->limit($limit);
                $resources = UploadResourceCollection::collection($resourceBuilder->get());
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
}
