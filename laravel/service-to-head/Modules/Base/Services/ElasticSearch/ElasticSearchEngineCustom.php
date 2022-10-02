<?php


namespace Modules\Base\Services\ElasticSearch;


use Laravel\Scout\Builder;
use Tamayo\LaravelScoutElastic\Engines\ElasticsearchEngine;
use function React\Promise\all;

class ElasticSearchEngineCustom extends ElasticsearchEngine
{
    public function paginate(Builder $builder, $perPage, $page)
    {
        $perPage = $perPage ?? (intval(request()->input('limit') ?? 15));
        $from = (($page * $perPage) - $perPage);
        $size = $perPage;
        if ($resource_page = request()->input('resource_page')) {
            if ($resource_page == 1) {
                $from = 0;
                $size = request()->input('append_nums');
            } else {
                $from = ($resource_page - 2) * $perPage + request()->input('append_nums');
                $size = $perPage;
            }
        }
        $result = $this->performSearch($builder, [
            'numericFilters' => $this->filters($builder),
            'from' => $from,
            'size' => $size,
        ]);

        $result['nbPages'] = $result['hits']['total']['value'] / $perPage;
        return $result;
    }

    public function getTotalCount($results)
    {
        return $results['hits']['total']['value'];
    }
}
