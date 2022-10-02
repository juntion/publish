<?php


namespace Modules\Share\Http\Controllers\Tag;


use Illuminate\Http\Request;
use Modules\Base\Contracts\ListServiceInterface;
use Modules\Base\Http\Controllers\Controller as BaseController;
use Modules\Share\Entities\ResourceTag;
use Modules\Share\Http\Requests\Tag\CreateTagRequest;
use Modules\Share\Http\Requests\Tag\SearchTagRequest;
use Modules\Share\Http\Requests\Tag\TagsListRequest;
use Modules\Share\Http\Requests\Tag\UpdateRequest;
use Modules\Share\Repositories\TagRepositories;
use Modules\Share\Transformers\Tag\TagsListCollection;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class TagController extends BaseController
{
    protected $tagRepositories;

    public function __construct(TagRepositories $tagRepositories)
    {
        $this->tagRepositories = $tagRepositories;
    }

    /**
     * @param  CreateTagRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateTagRequest $request)
    {
        $tag = $this->tagRepositories->store($request);
        return $this->successWithData(compact('tag'), FoundationResponse::HTTP_CREATED);
    }


    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\TagException
     */
    public function delete(Request $request)
    {
        $this->tagRepositories->delete($request);
        return $this->successWithMessage(__('share:deleteTagSuccess'));
    }

    /**
     * @param  SearchTagRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchTags(SearchTagRequest $request)
    {
        $tag = $this->tagRepositories->searchTags($request);
        return $this->successWithData($tag);
    }

    /**
     * @param  TagsListRequest  $request
     * @param  ListServiceInterface  $service
     * @return TagsListCollection
     */
    public function tags(TagsListRequest $request, ListServiceInterface $service)
    {
        $tagBuilder = ResourceTag::query();
        $type = $request->has('filter') ? $request->input('filter')['deleted_at'] : null;
        if ($type == 'not_null') {
            $tagBuilder->onlyTrashed();
        } elseif ($type == 'all') {
            $tagBuilder->withTrashed();
        }
        $service->setBuilder($tagBuilder->orderBy('created_at', 'DESC'));
        $service->setRequest($request);
        return new TagsListCollection($service->getResource());
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\SubjectException
     */
    public function close(Request $request)
    {
        $this->tagRepositories->close($request);
        return $this->successWithMessage(__('share::tag.closeSuccess'));
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Share\Exceptions\SubjectException
     */
    public function open(Request $request)
    {
        $this->tagRepositories->open($request);
        return $this->successWithMessage(__('share::tag.openSuccess'));
    }

    public function update(UpdateRequest $request)
    {
        $tag = $this->tagRepositories->update($request);
        return $this->successWithData($tag);
    }
}
