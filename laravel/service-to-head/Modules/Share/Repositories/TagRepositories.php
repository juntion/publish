<?php


namespace Modules\Share\Repositories;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Share\Entities\ResourceTag;
use Modules\Share\Exceptions\SubjectException;
use Modules\Share\Exceptions\TagException;
use Modules\Share\Jobs\UpdateTagsClaim;
use Modules\Share\Repositories\Traits\SearchTrait;
use Modules\Share\Transformers\Tag\TagResource;

class TagRepositories
{
    use SearchTrait;

    /**
     * @param  Request  $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|TagResource
     */
    public function store(Request $request)
    {
        $insertData = $request->all();
        $insertData['uuid'] = Str::uuid()->getHex()->toString();
        $insertData['creator_uuid'] = Auth::id();
        $tag = ResourceTag::query()->create($insertData)->refresh();
        // $tag->searchable();
        $tag = new TagResource($tag);
        return $tag;
    }

    /**
     * @param  Request  $request
     * @return bool
     * @throws TagException
     */
    public function delete(Request $request)
    {
        $tag = ResourceTag::query()->find($request->uuid);
        if (is_null($tag)) {
            throw new TagException(__('share::tags.tagNotExists'));
        }
        if ($tag->resources->isNotEmpty()) {
            throw new TagException(__('share::tags.tagResourceNotEmpty'));
        }

        try {
            $tag->unsearchable();
            $tag->forceDelete();
        } catch (\Exception $exception) {
            throw new TagException(__('share::tags.deleteTagFailed'), $exception->getCode(), $exception);
        }
        return true;
    }

    /**
     * @param  Request  $request
     * @return array
     * @throws \Exception
     */
    public function searchTags(Request $request)
    {
        // es 查询返回15条
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
        $delete = 'null';
        if ($filter = request()->input('filter')) {
            $delete = $filter['deleted_at'];
        }

        if ($delete == 'null') {
            $query['bool']['must_not'][] = [
                "exists" => [
                    "field" => "deleted_at"
                ]
            ];
        } else if ($delete == 'not_null') {
            $query['bool']['must'][] = [
                "exists" => [
                    "field" => "deleted_at"
                ]
            ];
        }
        $query = json_encode($query);
        try {
            $tags = ResourceTag::search($query)->paginate(10);
        } catch (\Exception $exception){
            $tags = $this->catchException($exception, 2);
        }
        $tags = TagResource::collection($tags);
        return compact('tags');
    }

    /**
     * @param  Request  $request
     * @return bool
     * @throws SubjectException
     */
    public function close(Request $request)
    {
        $tag = ResourceTag::query()->find($request->uuid);
        if (is_null($tag)) {
            throw new SubjectException(__('share::tags.tagNotExists'));
        }
        $tag->delete();
        return true;
    }

    /**
     * @param  Request  $request
     * @return bool
     * @throws SubjectException
     */
    public function open(Request $request)
    {
        $tag = ResourceTag::query()->onlyTrashed()->find($request->uuid);
        if (is_null($tag)) {
            throw new SubjectException(__('share::tags.tagNotExists'));
        }
        $tag->restore();
        return true;
    }

    /**
     * @param  Request  $request
     * @return array
     * @throws SubjectException
     */
    public function update(Request $request)
    {
        $tag = ResourceTag::query()->find($request->uuid);
        if (is_null($tag)) {
            throw new SubjectException(__('share::tags.tagNotExists'));
        }
        $tag->update($request->only('name'));
        $tag->refresh();
        // $tag->searchable();
        dispatch(new UpdateTagsClaim($tag));
        $tag = new TagResource($tag);
        return compact('tag');
    }
}
