<?php


namespace Modules\Finance\Repositories\Traits;


use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Container\Container;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Modules\Share\Exceptions\ElasticSearchException;

trait EsTrait
{
    protected $paginate = [
        'total'        => 0,
        'current_page' => 1,
        'per_page'     => 0,
        'last_page'    => 1,
    ];

    /**
     * @param  \Exception  $exception
     * @param  int  $type
     * @return array
     * @throws \Exception
     */
    public function catchException(\Exception $exception)
    {
        if($exception instanceof Missing404Exception){ // index 索引未建立的错误
            throw new ElasticSearchException(__('finance::common.esIndexNotFound'));
        } else { // query错误或es服务器等错误
            throw new ElasticSearchException(__('finance::common.searchFailed'), $exception->getCode(), $exception);
        }
    }

    public function resetNewPaginator(AbstractPaginator $list, $key)
    {
        $paginator = Container::getInstance()->makeWith(LengthAwarePaginator::class, [
            'items' => $list->getCollection(),
            'total' => $list->total(),
            'perPage' => $list->perPage(),
            'currentPage' => $list->currentPage(),
            'options' => [
                'path' =>$list->path(),
                'pageName' => $list->getPageName(),
            ],
        ]);
        $paginator->appends([
            'filter' => [
                'search' => $key
            ]
        ]);

        return $paginator;
    }
}
