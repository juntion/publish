<?php


namespace Modules\Share\Repositories;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Base\Contracts\ListServiceInterface;
use Modules\Share\Entities\Resource;
use Modules\Share\Entities\ResourceCustomCategory;
use Modules\Share\Exceptions\CategoryException;
use Modules\Share\Http\Requests\Admin\Upload\CategoriesMixCollectionRequest;
use Modules\Share\Repositories\Traits\SearchTrait;
use Modules\Share\Transformers\Admin\Collection\CollectionCatesCollection;
use Modules\Share\Transformers\Admin\SingleCategoryResource;
use Modules\Share\Transformers\Admin\Upload\CategoriesMixResourceCollection;
use Modules\Share\Transformers\Admin\Upload\UploadResourceCollection;

class UploadRepositories
{
    use SearchTrait;

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
            $parent_data = ResourceCustomCategory::query()->find($parent_uuid);
            if (is_null($parent_data)) {
                throw new CategoryException(__('share::admin.upload.categoriesParentUUIDNotExist'));
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
                throw new CategoryException(__('share::admin.upload.categoriesCantCreateFiveLevel'));
            }
        } else {
            $insertData['one_level_uuid'] = $insertData['uuid'];
        }
        $insertData['admin_uuid'] = Auth::id();
        $category = ResourceCustomCategory::query()
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
        $data = ResourceCustomCategory::query()->find($uuid);
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
        $data = ResourceCustomCategory::query()->find($uuid);
        if (is_null($data)) {
            throw new CategoryException(__('share::categories.categoriesNotExists'));
        }
        if ($data->children->isNotEmpty()) {
            throw new CategoryException(__('share::categories.hasChildCategories'));
        }
        if ($data->sum > 0) {
            throw new CategoryException(__('share::categories.isNotEmptyCategories'));
        }
        try {
            $data->unsearchable();
            $data->delete();
        } catch (\Exception $exception) {
            throw new CategoryException(__('share:categories:deleteFailed'), $exception->getCode(), $exception);
        }
        return true;
    }

    /**
     * @param  CategoriesMixCollectionRequest  $request
     * @param  ListServiceInterface  $service
     * @return array|CategoriesMixResourceCollection
     */
    public function getMixData(CategoriesMixCollectionRequest $request, ListServiceInterface $service)
    {
        $uuid = Auth::id();
        $type = $request->input('filter')['type'];
        $resourceModelBuilder = Resource::query()
            ->with('tags')
            ->with('collection')
            ->where('creator_uuid', $uuid)
            ->where('type', $type)
            ->orderBy('created_at', 'DESC')
            ->orderBy('name', 'DESC');
        $categoryModelBuilder = ResourceCustomCategory::query()
            ->where('admin_uuid', $uuid)
            ->where('type', $type)
            ->orderBy('sort', 'asc')
            ->orderBy('created_at', 'DESC');
        $parent_uuid = $request->input('parent_uuid') ?? null;
        $categoryModelBuilder->where('parent_uuid', $parent_uuid);
        $resourceModelBuilder->where('custom_category_uuid', $parent_uuid);
        if ($request->has('key')) {
            $searchCateData = $this->searchUploadCategoryUuidByKey($request, $uuid);
            $cateUuid = $searchCateData['uuid'];
            $paginate = $searchCateData['paginate'];
            $cateTotal = $paginate['total'];
        } else {
            $cateTotal = $categoryModelBuilder->count();
            $resourceTotal = $resourceModelBuilder->count();
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
            $categoryModelBuilder->whereIn('uuid', $cateUuid);
            $resourceModelBuilder->whereIn('uuid', $resource_uuid);
            $cate = CollectionCatesCollection::collection($categoryModelBuilder->get());
            $resources = UploadResourceCollection::collection($resourceModelBuilder->get());
        } else {
            if ($currentPage <= $startResourcePage) {
                $from = ($currentPage - 1) * $pageSize;
                $categoryModelBuilder->offset($from)->limit($pageSize);
                $cate = CollectionCatesCollection::collection($categoryModelBuilder->get());
            }
            if ($selectResource) {
                if ($resourceRealPage == 1) {
                    $from = 0;
                    $limit = $firstPageAppendNums;
                } else {
                    $from = ($resourceRealPage - 2) * $pageSize + $firstPageAppendNums;
                    $limit = $pageSize;
                }
                $resourceModelBuilder->offset($from)->limit($limit);
                $resources = UploadResourceCollection::collection($resourceModelBuilder->get());
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
