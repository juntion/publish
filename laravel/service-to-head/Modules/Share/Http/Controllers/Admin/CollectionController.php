<?php


namespace Modules\Share\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Base\Contracts\ListServiceInterface;
use Modules\Base\Http\Controllers\Controller as BaseController;
use Modules\Share\Entities\CollectionCategory;
use Modules\Share\Http\Requests\Admin\Collection\BatchCollectionRequest;
use Modules\Share\Http\Requests\Admin\Collection\BatchDeleteRequest;
use Modules\Share\Http\Requests\Admin\Collection\CategoriesMixCollectionRequest;
use Modules\Share\Http\Requests\Admin\Collection\CollectionRequest;
use Modules\Share\Http\Requests\Admin\Collection\CreateCategoriesRequest;
use Modules\Share\Http\Requests\Admin\Collection\TopCategoriesRequest;
use Modules\Share\Http\Requests\Admin\Collection\UpdateCategoriesRequest;
use Modules\Share\Repositories\CollectionRepositories;
use Modules\Share\Transformers\Admin\Collection\CategoriesMixResourceCollection;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class CollectionController extends BaseController
{

    protected $collectionRepositories;

    public function __construct(CollectionRepositories $collectionRepositories)
    {
        $this->collectionRepositories = $collectionRepositories;
    }

    /**
     * @param  TopCategoriesRequest  $request
     * @param  ListServiceInterface  $listService
     * @return \Illuminate\Http\JsonResponse
     */
    public function TopCategories(TopCategoriesRequest $request, ListServiceInterface $listService)
    {
        $listService->setBuilder(
            CollectionCategory::query()
                ->select(['uuid', 'type', 'parent_uuid', 'name', 'sort', 'sum', 'created_at', 'updated_at'])
                ->where('admin_uuid', Auth::id())
                ->whereNull('parent_uuid')
                ->orderBy('sort', "ASC")
        );
        $listService->setRequest($request);

        $categories = $listService->getResource();
        return $this->successWithData(compact('categories'));
    }

    /**
     * @param $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories($uuid)
    {
        $categories = CollectionCategory::query()
            ->select(['uuid', 'type', 'parent_uuid', 'name', 'sort', 'sum', 'created_at', 'updated_at'])
            ->where('admin_uuid', Auth::id())
            ->where('parent_uuid', $uuid)
            ->orderBy('sort', "ASC")
            ->get();
        return $this->successWithData(compact('categories'));
    }

    public function store(CreateCategoriesRequest $request)
    {
        $category = $this->collectionRepositories->store($request);
        return $this->successWithData(compact('category'), FoundationResponse::HTTP_CREATED);
    }

    /**
     * @param  UpdateCategoriesRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\CategoryException
     */
    public function update(UpdateCategoriesRequest $request)
    {
        $category = $this->collectionRepositories->update($request);
        return $this->successWithData(compact('category'));
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\CategoryException
     */
    public function delete(Request $request)
    {
        $this->collectionRepositories->delete($request);
        return $this->successWithMessage(__('share::admin.collection.deleteCategorySuccess'));
    }

    /**
     * @param  CollectionRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\CollectionException
     */
    public function collections(CollectionRequest $request)
    {
        $collection = $this->collectionRepositories->collection($request);
        return $this->successWithDataAndMessage(compact('collection'), __('share::admin.collection.collectionSuccess'));
    }

    /**
     * @param  BatchCollectionRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\CollectionException
     */
    public function batchCollection(BatchCollectionRequest $request)
    {
        $collections = $this->collectionRepositories->batchCollection($request);
        return $this->successWithData(compact('collections'));
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\CollectionException
     */
    public function deleteCollection(Request $request)
    {
        $this->collectionRepositories->deleteCollection($request);
        return $this->successWithMessage(__('share::admin.collection.deleteCollectionSuccess'));
    }

    /**
     * @param  CategoriesMixCollectionRequest  $request
     * @param  ListServiceInterface  $service
     * @return array|\Illuminate\Http\JsonResponse|CategoriesMixResourceCollection
     */
    public function getCategoriesMixCollectionList(CategoriesMixCollectionRequest $request, ListServiceInterface $service)
    {
        $data = $this->collectionRepositories->getMixData($request, $service);
        return $this->successWithData($data);

    }

    /**
     * @param  BatchDeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\CollectionException
     */
    public function batchDeleteCollection(BatchDeleteRequest $request)
    {
        $this->collectionRepositories->batchDeleteCollection($request);
        return $this->successWithMessage(__('share::admin.collection.batchDeleteCollectionSuccess'));
    }
}
