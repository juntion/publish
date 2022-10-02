<?php


namespace Modules\Share\Http\Controllers\Resource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Base\Contracts\ListServiceInterface;
use Modules\Base\Http\Controllers\Controller as BaseController;
use Modules\Share\Entities\Resource;
use Modules\Share\Entities\ResourcesLog;
use Modules\Share\Entities\Viewed;
use Modules\Share\Exceptions\ResourceException;
use Modules\Share\Http\Requests\Log\LogListRequest;
use Modules\Share\Http\Requests\Resource\AddCategoryRequest;
use Modules\Share\Http\Requests\Resource\AddTagRequest;
use Modules\Share\Http\Requests\Resource\BatchDeleteRequest;
use Modules\Share\Http\Requests\Resource\BatchDownloadRequest;
use Modules\Share\Http\Requests\Resource\BatchUpdateRequest;
use Modules\Share\Http\Requests\Resource\DownloadRequest;
use Modules\Share\Http\Requests\Resource\ResourceRequest;
use Modules\Share\Http\Requests\Resource\TagsCollectionListRequest;
use Modules\Share\Http\Requests\Resource\TagsCollectionRequest;
use Modules\Share\Http\Requests\Resource\UpdateCategoryRequest;
use Modules\Share\Http\Requests\Resource\UpdateRequest;
use Modules\Share\Repositories\ResourceRepositories;
use Modules\Share\Repositories\Traits\UpdateRedisTrait;
use Modules\Share\Transformers\Categories\ResourceTagsCollection;
use Modules\Share\Transformers\Log\LogListResource;
use Modules\Share\Transformers\Resource\ResourcesCategoriesTagsCollection;

class ResourceController extends BaseController
{

    use UpdateRedisTrait;
    protected $resourceRepositories;

    public function __construct(ResourceRepositories $resourceRepositories)
    {
        $this->resourceRepositories = $resourceRepositories;
    }

    /**
     * @param  Request  $request
     * @return ResourcesCategoriesTagsCollection
     * @throws ResourceException
     */
    public function getResourceInfo(Request $request)
    {
        $resource = Resource::query()->with('collection')->find($request->uuid);
        if (is_null($resource)) {
            throw new ResourceException(__('share::resource.UUIDNotExists'));
        }
        // 足迹+1
        $this->viewedResource($resource);
        return new ResourcesCategoriesTagsCollection($resource);
    }

    /**
     * @param  Resource  $resource
     */
    private function viewedResource(Resource $resource)
    {
        $admin_uuid = Auth::id();
        Viewed::query()->create([
            'uuid'          => Str::uuid()->getHex()->toString(),
            'admin_uuid'    => $admin_uuid,
            'resource_uuid' => $resource->uuid,
            'resource_name' => $resource->name,
            'resource_type' => $resource->type,
        ])->refresh();
        // redis 数据更新
        $this->updateStatsData($admin_uuid, 'viewed', 1);
    }

    /**
     * @param  ResourceRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ResourceException
     */
    public function store(ResourceRequest $request)
    {
        $this->resourceRepositories->store($request);
        return $this->successWithMessage(__('share::resource.storeSuccess'));
    }

    /**
     * @param  UpdateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ResourceException
     */
    public function updateResource(UpdateRequest $request)
    {
        $this->resourceRepositories->update($request);
        return $this->successWithMessage(__('share::resource.updateSuccess'));
    }

    /**
     * @param  BatchUpdateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ResourceException
     */
    public function batchUpdateResource(BatchUpdateRequest $request)
    {
        $this->resourceRepositories->batchUpdate($request);
        return $this->successWithMessage(__('share::resource.batchUpdateSuccess'));
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ResourceException
     */
    public function deleteResource(Request $request)
    {
        $this->resourceRepositories->deleteResource($request);
        return $this->successWithMessage(__('share::resource.deleteSuccess'));
    }

    /**
     * @param  BatchDeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ResourceException
     */
    public function batchDeleteResource(BatchDeleteRequest $request)
    {
        $this->resourceRepositories->batchDeleteResource($request);
        return $this->successWithMessage(__('share::resource.batchDeleteSuccess'));
    }

    /**
     * @param  DownloadRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ResourceException
     */
    public function downloadResource(DownloadRequest $request)
    {
        $url = $this->resourceRepositories->downloadResource($request);
        return $this->successWithData(compact('url'));
    }

    /**
     * @param  BatchDownloadRequest  $request
     * @return \Modules\Share\Transformers\Resource\BatchDownloadResource
     */
    public function batchDownloadResource(BatchDownloadRequest $request)
    {
        $urls = $this->resourceRepositories->batchDownloadResource($request);
        return $urls;
    }


    /**
     * @param  TagsCollectionListRequest  $request
     * @param  ListServiceInterface  $service
     * @return ResourceTagsCollection
     */
    public function resourcesTagsCollectionList(TagsCollectionListRequest $request, ListServiceInterface $service)
    {
        $builder = Resource::query();
        if (!$request->has('sort')) {
            $builder->orderBy('created_at', 'DESC');
        }
        $service->setBuilder($builder);
        $service->setRequest($request);
        return new ResourceTagsCollection($service->getResource());
    }

    /**
     * @param  TagsCollectionRequest  $request
     * @param  ListServiceInterface  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchResourcesTagsCollection(TagsCollectionRequest $request, ListServiceInterface $service)
    {
        $data = $this->resourceRepositories->resourceTagsCollection($request, $service);
        return $this->successWithData($data);
    }

    /**
     * @param  AddCategoryRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ResourceException
     */
    public function addNewCategory(AddCategoryRequest $request)
    {
        $this->resourceRepositories->addNewCategory($request);
        return $this->successWithMessage(__('share::resource.copyCategorySuccess'));
    }

    /**
     * @param  UpdateCategoryRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ResourceException
     */
    public function updateCategory(UpdateCategoryRequest $request)
    {
        $this->resourceRepositories->updateCategory($request);
        return $this->successWithMessage(__('share::resource.moveCategorySuccess'));
    }

    /**
     * @param  AddTagRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ResourceException
     */
    public function addTag(AddTagRequest $request)
    {
        $this->resourceRepositories->addTag($request);
        return $this->successWithMessage(__('share::resource.addTagSuccess'));
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ResourceException
     */
    public function deleteTag(Request $request)
    {
        $this->resourceRepositories->deleteTag($request);
        return $this->successWithMessage(__('share::resource.deleteTagSuccess'));
    }


    /**
     * @param  LogListRequest  $request
     * @param  ListServiceInterface  $service
     * @return LogListResource
     * @throws ResourceException
     */
    public function getLogs(LogListRequest $request, ListServiceInterface $service)
    {
        $this->resourceRepositories->getLogs($request);
        $queryBuilder = ResourcesLog::query()->where('uuid', $request->uuid)->orderBy('created_at', 'DESC');
        $service->setBuilder($queryBuilder);
        $service->setRequest($request);
        return new LogListResource($service->getResource());
    }
}
