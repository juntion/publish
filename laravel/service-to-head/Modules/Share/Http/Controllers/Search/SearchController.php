<?php


namespace Modules\Share\Http\Controllers\Search;


use Modules\Base\Http\Controllers\Controller as BaseController;
use Modules\Share\Entities\Key;
use Modules\Share\Http\Requests\Search\KeysTagsRequest;
use Modules\Share\Repositories\Traits\SearchTrait;

class SearchController extends BaseController
{
    use SearchTrait;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function hotKeys()
    {
        $keys = Key::query()
            ->select(['key', 'count'])
            ->orderBy('count', 'DESC')
            ->limit(5)
            ->get();
        return $this->successWithData(compact('keys'));
    }

    /**
     * @param  KeysTagsRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function keysTags(KeysTagsRequest $request)
    {
        $key = $request->input('key');
        // 查询keys
        $key = strtolower($key);
        $keys = $this->searchKey($key);
        $tags = $this->searchTagsNameByKey($key);
        return $this->successWithData(compact('keys', 'tags'));
    }
}
