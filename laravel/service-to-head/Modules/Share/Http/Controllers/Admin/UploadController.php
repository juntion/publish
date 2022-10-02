<?php


namespace Modules\Share\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Base\Contracts\ListServiceInterface;
use Modules\Base\Http\Controllers\Controller;
use Modules\Share\Entities\ResourceCustomCategory;
use Modules\Share\Http\Requests\Admin\Upload\CategoriesMixCollectionRequest;
use Modules\Share\Http\Requests\Admin\Upload\CreateCategoriesRequest;
use Modules\Share\Http\Requests\Admin\Upload\TopCategoriesRequest;
use Modules\Share\Http\Requests\Admin\Upload\UpdateCategoriesRequest;
use Modules\Share\Repositories\UploadRepositories;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class UploadController extends Controller
{

    protected $uploadRepositories;

    public function __construct(UploadRepositories $uploadRepositories)
    {
        $this->uploadRepositories = $uploadRepositories;
    }

    /**
     * @param  TopCategoriesRequest  $request
     * @param  ListServiceInterface  $listService
     * @return \Illuminate\Http\JsonResponse
     */
    public function topCategories(TopCategoriesRequest $request, ListServiceInterface $listService)
    {
        $listService->setBuilder(
            ResourceCustomCategory::query()
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
        $categories = ResourceCustomCategory::query()
            ->select(['uuid', 'type', 'parent_uuid', 'name', 'sort', 'sum', 'created_at', 'updated_at'])
            ->where('admin_uuid', Auth::id())
            ->where('parent_uuid', $uuid)
            ->orderBy('sort', "ASC")
            ->get();
        return $this->successWithData(compact('categories'));
    }

    /**
     * @param  CreateCategoriesRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\CategoryException
     */
    public function store(CreateCategoriesRequest $request)
    {
        $category = $this->uploadRepositories->store($request);
        return $this->successWithData(compact('category'), FoundationResponse::HTTP_CREATED);
    }


    public function delete(Request $request)
    {
        $this->uploadRepositories->delete($request);
        return $this->successWithMessage(__('share::admin.upload.deleteCategorySuccess'));
    }

    /**
     * @param  UpdateCategoriesRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\CategoryException
     */
    public function update(UpdateCategoriesRequest $request)
    {
        $category = $this->uploadRepositories->update($request);
        return $this->successWithData(compact('category'));
    }

    /**
     * @param  CategoriesMixCollectionRequest  $request
     * @param  ListServiceInterface  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategoriesMixCollectionList(CategoriesMixCollectionRequest $request, ListServiceInterface $service)
    {
        $data = $this->uploadRepositories->getMixData($request, $service);
        return $this->successWithData($data);
    }
}
