<?php


namespace Modules\Share\Http\Controllers\Subject;


use Illuminate\Http\Request;
use Modules\Base\Contracts\ListServiceInterface;
use Modules\Base\Http\Controllers\Controller as BaseController;
use Modules\Share\Entities\Subject;
use Modules\Share\Http\Requests\Subject\SubjectCreateRequest;
use Modules\Share\Http\Requests\Subject\SubjectListRequest;
use Modules\Share\Http\Requests\Subject\SubjectUpdateRequest;
use Modules\Share\Http\Requests\Subject\TagsCollectionListRequest;
use Modules\Share\Http\Requests\Tag\SearchRequest;
use Modules\Share\Repositories\SubjectRepositories;
use Modules\Share\Repositories\Traits\SearchTrait;
use Modules\Share\Transformers\Subject\SubjectCollection;
use Modules\Share\Transformers\Subject\SubjectResource;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class SubjectController extends BaseController
{
    use SearchTrait;
    protected $subjectRepositories;

    public function __construct(SubjectRepositories $subjectRepositories)
    {
        $this->subjectRepositories = $subjectRepositories;
    }

    /**
     * @param  SubjectListRequest  $request
     * @param  ListServiceInterface  $listService
     * @return SubjectCollection
     */
    public function index(SubjectListRequest $request, ListServiceInterface $listService)
    {
        $queryBuilder = Subject::query()->orderBy('sort', 'ASC')->orderBy('created_at','DESC');
        $type = $request->has('filter') ? $request->input('filter')['deleted_at'] : null;
        if ($type == 'not_null') {
            $queryBuilder->onlyTrashed();
        } elseif ($type == 'all') {
            $queryBuilder->withTrashed();
        }
        $listService->setBuilder($queryBuilder);
        $listService->setRequest($request);
        return new SubjectCollection($listService->getResource());
    }

    /**
     * @param  SubjectCreateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SubjectCreateRequest $request)
    {
        $subject = $this->subjectRepositories->store($request);
        return $this->successWithData(compact('subject'), FoundationResponse::HTTP_CREATED);
    }

    /**
     * @param  SubjectUpdateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\SubjectException
     */
    public function update(SubjectUpdateRequest $request)
    {
        $subject = $this->subjectRepositories->update($request);
        return $this->successWithData(compact('subject'));
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\SubjectException
     */
    public function delete(Request $request)
    {
        $this->subjectRepositories->delete($request);
        return $this->successWithMessage(__('share::subject.deleteSuccess'));
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\SubjectException
     */
    public function close(Request $request)
    {
        $this->subjectRepositories->close($request);
        return $this->successWithMessage(__('share::subject.closeSuccess'));
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\SubjectException
     */
    public function open(Request $request)
    {
        $this->subjectRepositories->open($request);
        return $this->successWithMessage(__('share::subject.openSuccess'));
    }

    /**
     * @param  TagsCollectionListRequest  $request
     * @param  ListServiceInterface  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function resourcesTags(TagsCollectionListRequest $request, ListServiceInterface $service)
    {
        $data = $this->subjectRepositories->resourcesTags($request, $service);
        return $this->successWithData($data);
    }

    /**
     * @param  SearchRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function search(SearchRequest $request)
    {
        $key = strtolower($request->input('key'));
        $query['bool']= [
            'should' => [
                [
                    'match_phrase' => [
                        'name' => $key
                    ]
                ],
                [
                    'prefix' => [
                        'name' => $key
                    ]
                ],
            ]
        ];
        $query = json_encode($query);
        try {
            $subjects = Subject::search($query)->withTrashed()->take(10)->get();
        } catch (\Exception $exception){
            $subjects = $this->catchException($exception, 2);
        }
        $subjects = SubjectResource::collection($subjects);
        return $this->successWithData(compact('subjects'));
    }
}
