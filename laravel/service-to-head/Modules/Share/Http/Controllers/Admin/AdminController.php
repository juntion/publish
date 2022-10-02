<?php


namespace Modules\Share\Http\Controllers\Admin;


use Illuminate\Support\Facades\Auth;
use Modules\Base\Contracts\ListServiceInterface;
use Modules\Base\Http\Controllers\Controller as BaseController;
use Modules\Share\Entities\ResourceDownload;
use Modules\Share\Entities\UserStats;
use Modules\Share\Entities\Viewed;
use Modules\Share\Http\Requests\Admin\DownloadedListRequest;
use Modules\Share\Http\Requests\Admin\ViewedListRequest;
use Modules\Share\Repositories\Traits\SearchTrait;
use Modules\Share\Repositories\Traits\UpdateRedisTrait;
use Modules\Share\Transformers\Admin\Collection\DownloadedCollection;
use Modules\Share\Transformers\Admin\ViewedCollection;

class AdminController extends BaseController
{
    use SearchTrait, UpdateRedisTrait;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStats()
    {
        $key = Auth::id();
        $cache = new UserStats();
        $stats = $cache->findOrSaveCache($key, function ($key){
            return $this->getStatsBySql($key);
        });
        return $this->successWithData(compact('stats'));
    }

    /**
     * @param  ViewedListRequest  $request
     * @param  ListServiceInterface  $service
     * @return \Illuminate\Http\JsonResponse|ViewedCollection
     */
    public function getViewedList(ViewedListRequest $request, ListServiceInterface $service)
    {
        $uuid = Auth::id();
        $builder = Viewed::query()->where('admin_uuid', $uuid)
            ->with([
                'resource' => function ($q) {
                    return $q->with('tags')->with('collection');
                }
            ])
            ->orderBy('created_at', 'DESC');
        if ($request->has('key')) {
            $search_data = $this->searchViewedData($request, $uuid);
            $uuid = $search_data['uuid'];
            $paginate = $search_data['paginate'];
            $vieweds = $builder->whereIn('uuid', $uuid)->get();
            $vieweds = new ViewedCollection($vieweds);
            return $this->successWithData(compact('vieweds', 'paginate'));
        } else {
            $service->setRequest($request);
            $service->setBuilder($builder);
            return new ViewedCollection($service->getResource());
        }
    }


    /**
     * @param  DownloadedListRequest  $request
     * @param  ListServiceInterface  $service
     * @return \Illuminate\Http\JsonResponse|DownloadedCollection
     */
    public function getDownloadList(DownloadedListRequest $request, ListServiceInterface $service)
    {
        $uuid = Auth::id();
        $builder = ResourceDownload::query()
            ->with([
                'resource' => function ($q) {
                    return $q->with('tags')->with('collection');
                }
            ])
            ->where('admin_uuid', $uuid)
            ->orderBy('created_at', 'DESC');
        if ($request->has('key')) {
            $search_data = $this->searchDownloadData($request, $uuid);
            $uuid = $search_data['uuid'];
            $paginate = $search_data['paginate'];
            $builder = $builder->whereIn('uuid', $uuid)->get();
            $downloads = new DownloadedCollection($builder);
            return $this->successWithData(compact('downloads', 'paginate'));
        } else {
            $service->setRequest($request);
            $service->setBuilder($builder);
            return new DownloadedCollection($service->getResource());
        }
    }
}
