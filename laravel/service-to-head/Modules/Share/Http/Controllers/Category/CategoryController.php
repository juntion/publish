<?php


namespace Modules\Share\Http\Controllers\Category;


use Illuminate\Http\Request;
use Modules\Base\Contracts\ListServiceInterface;
use Modules\Base\Http\Controllers\Controller as BaseController;
use Modules\Share\Entities\ResourceCategory;
use Modules\Share\Http\Requests\Categories\CategoriesRequest;
use Modules\Share\Http\Requests\Categories\MixListRequest;
use Modules\Share\Http\Requests\Categories\ResourceTagsRequest;
use Modules\Share\Http\Requests\Categories\SortRequest;
use Modules\Share\Http\Requests\Categories\TopCategoriesRequest;
use Modules\Share\Http\Requests\Categories\UpdateCategoriesRequest;
use Modules\Share\Repositories\CategoriesRepositories;
use Modules\Share\Transformers\Categories\CategoryResource;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class CategoryController extends BaseController
{
    private $categoriesRepositories;

    public function __construct(CategoriesRepositories $categoriesRepositories)
    {
        $this->categoriesRepositories = $categoriesRepositories;
    }

    /**
     * @param  TopCategoriesRequest  $request
     * @param  ListServiceInterface  $listService
     * @return \Illuminate\Http\JsonResponse
     */
    public function topCategories(TopCategoriesRequest $request, ListServiceInterface $listService)
    {
        $listService->setBuilder(
            ResourceCategory::query()
                ->select([
                    'uuid', 'type', 'parent_uuid', 'name', 'background', 'sort', 'sum', 'created_at', 'updated_at'
                ])
                ->whereNull('parent_uuid')
                ->orderBy('sort', "ASC")
        );
        $listService->setRequest($request);

        $categories = $listService->getResource();
        return $this->successWithData(compact('categories'));
    }

    /**
     * 查询指定分类的子分类
     * @param $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories($uuid)
    {
        $categories = ResourceCategory::query()
            ->select(['uuid', 'type', 'parent_uuid', 'name', 'background', 'sort', 'sum', 'created_at', 'updated_at'])
            ->where('parent_uuid', '=', $uuid)
            ->orderBy('sort', "ASC")
            ->get();
        $categories = CategoryResource::collection($categories);
        return $this->successWithData(compact('categories'));
    }

    /**
     * @param  CategoriesRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\CategoryException
     */
    public function store(CategoriesRequest $request)
    {
        $category = $this->categoriesRepositories->store($request);
        return $this->successWithData(compact('category'), FoundationResponse::HTTP_CREATED);
    }

    /**
     * @param  UpdateCategoriesRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\CategoryException
     */
    public function update(UpdateCategoriesRequest $request)
    {
        $category = $this->categoriesRepositories->update($request);
        return $this->successWithData(compact('category'));
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\CategoryException
     */
    public function delete(Request $request)
    {
        $this->categoriesRepositories->delete($request);
        return $this->successWithMessage(__('share::categories.deleteSuccess'));
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function treeType(Request $request)
    {
        $tree = $this->categoriesRepositories->treeType($request);
        return $this->successWithData(compact('tree'));
    }

    /**
     * @param  ResourceTagsRequest  $request
     * @param  ListServiceInterface  $service
     * @return array|\Illuminate\Http\JsonResponse|\Modules\Share\Transformers\Categories\ResourceTagsCollection
     * @throws \Modules\Share\Exceptions\CategoryException
     */
    public function resourcesTags(ResourceTagsRequest $request, ListServiceInterface $service)
    {
        $data = $this->categoriesRepositories->resourcesTags($request, $service);
        if ($request->input('key') || $request->input('tag_uuid')) {
            return $this->successWithData($data);
        }
        return $data;
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\CategoryException
     */
    public function close(Request $request)
    {
        $this->categoriesRepositories->close($request);
        return $this->successWithMessage(__('share::categories.closeSuccess'));
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\CategoryException
     */
    public function open(Request $request)
    {
        $this->categoriesRepositories->open($request);
        return $this->successWithMessage(__('share::categories.openSuccess'));
    }

    /**
     * @param  SortRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\CategoryException
     */
    public function sort(SortRequest $request)
    {
        $this->categoriesRepositories->sort($request);
        return $this->successWithMessage(__('share::categories.sortSuccess'));
    }

    public function getCategoriesMixCollectionList(MixListRequest $request, ListServiceInterface $service)
    {
        $mixs = $this->categoriesRepositories->getMixList($request, $service);
        return $this->successWithData($mixs);
    }
}
