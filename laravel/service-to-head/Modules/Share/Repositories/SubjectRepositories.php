<?php


namespace Modules\Share\Repositories;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Base\Contracts\ListServiceInterface;
use Modules\Base\Repositories\OssUploadRepository;
use Modules\Base\Support\Facades\OssService;
use Modules\Base\Entities\Base\OssTempUpload;
use Modules\Share\Entities\Resource;
use Modules\Share\Entities\Subject;
use Modules\Share\Exceptions\SubjectException;
use Modules\Share\Http\Requests\Subject\TagsCollectionListRequest;
use Modules\Share\Repositories\Traits\SearchTrait;
use Modules\Share\Transformers\Categories\ResourceTagsCollection;
use Modules\Share\Transformers\Subject\SubjectResource;

class SubjectRepositories
{
    use SearchTrait;

    protected $ossUploadRepository;
    public function __construct(OssUploadRepository $ossUploadRepository)
    {
        $this->ossUploadRepository = $ossUploadRepository;
    }

    /**
     * @param  Request  $request
     * @return SubjectResource
     */
    public function store(Request $request)
    {
        $insertData = $request->all();
        $insertData['sort'] = $insertData['sort'] ?? 255;
        $insertData['uuid'] = Str::uuid()->getHex()->toString();
        $tempUuid = $request->input('background_uuid');
        $temp = $this->ossUploadRepository->getTempInfo($tempUuid);
        $insertData['object'] = $temp->object;
        $data = Subject::query()->create($insertData)->refresh();
        // 删除临时文件表
        $this->ossUploadRepository->deleteTemp($tempUuid);
        // $data->searchable();
        $subject = new SubjectResource($data);
        return $subject;
    }

    /**
     * @param  Request  $request
     * @return bool
     * @throws SubjectException
     */
    public function delete(Request $request)
    {
        $subject = Subject::query()->find($request->uuid);
        if (is_null($subject)) {
            throw new SubjectException(__('share::subject.subjectNotExists'));
        }
        if ($subject->resources->isNotEmpty()) {
            throw new SubjectException(__('share::subject.subjectNotEmpty'));
        }
        try {
            $object = $subject->object;
            OssService::deleteObject(OssService::bucket(), $object);
            $subject->unsearchable();
            $subject->forceDelete();
        } catch (\Exception $exception) {
            throw new SubjectException(__('share::subject.deleteFailed'), $exception->getCode(), $exception);
        }
        return true;
    }


    /**
     * @param  Request  $request
     * @return SubjectResource
     * @throws SubjectException
     */
    public function update(Request $request)
    {
        $updateData = $request->all();
        $updateData['sort'] = $updateData['sort'] ?? 255;
        $data = Subject::query()->find($request->uuid);
        if (is_null($data)) {
            throw new SubjectException(__('share::subject.subjectNotExists'));
        }
        if ($request->has('background_uuid')) {
            $object = $data->object;
            OssService::deleteObject(OssService::bucket(), $object);
            $temp = OssTempUpload::query()->find($request->input('background_uuid'));
            $updateData['object'] = $temp->object;
            // 删除临时文件表
            $temp->delete();
        }
        $data->update($updateData);
        $data->refresh();
        // $data->searchable();
        return new SubjectResource($data);

    }

    /**
     * @param  Request  $request
     * @return bool
     * @throws SubjectException
     */
    public function close(Request $request)
    {
        $subject = Subject::query()->find($request->uuid);
        if (is_null($subject)) {
            throw new SubjectException(__('share::subject.subjectNotExists'));
        }
        $subject->delete();
        return true;
    }

    /**
     * @param  Request  $request
     * @return bool
     * @throws SubjectException
     */
    public function open(Request $request)
    {
        $subject = Subject::query()->onlyTrashed()->find($request->uuid);
        if (is_null($subject)) {
            throw new SubjectException(__('share::subject.subjectNotExists'));
        }
        $subject->restore();
        return true;
    }

    /**
     * @param  TagsCollectionListRequest  $request
     * @param  ListServiceInterface  $service
     * @return array
     */
    public function resourcesTags(TagsCollectionListRequest $request, ListServiceInterface $service)
    {
        $search_data = $this->searchResourceUuidByRequest($request, true);
        $resource_uuid = $search_data['uuid'];
        $paginate = $search_data['paginate'];
        $resourceBuilder = Resource::query()->with('tags')->with('collection');
        $resourceBuilder = $resourceBuilder->whereIn('uuid', $resource_uuid)
            ->orderBy('created_at', 'DESC')
            ->orderBy('name', 'DESC')->get();
        $resources = new ResourceTagsCollection($resourceBuilder);
        return compact('resources', 'paginate');
    }

}
