<?php

namespace Modules\Tag\Traits;

use Elasticsearch\Common\Exceptions\Missing404Exception;
use Modules\Tag\Exceptions\ElasticSearchException;

trait ElasticSearchTrait
{
    /**
     * @param \Exception $exception
     * @param array $returnData
     * @return array|mixed
     * @throws ElasticSearchException
     */
    public function catchESException(\Exception $exception, $returnData = [])
    {
        // 索引未创建错误
        if ($exception instanceof Missing404Exception) {
            return $returnData;
        }

        throw new ElasticSearchException(__('tag::es.search.searchFailed'), $exception->getCode(), $exception);
    }

    public function shouldKeywordQuery($keyword, array $columns)
    {
        $query = [];
        foreach ($columns as $column) {
            $query = array_merge([
                [
                    'wildcard' => [ // 类似SQL中的LIKE，但 keyword 出现空格时会查不到结果，例如 MAC Address 无结果
                        $column => "*{$keyword}*",
                    ],
                ],
                [
                    'match_phrase' => [// 短语匹配，需要是正确的短语，例如 MAC Address 有结果，但 MAC Addres 没有结果
                        $column => [
                            'query' => $keyword,
                            'slop' => 1,// 短语匹配间隔，例如 MAC Address 可以 匹配到 MAC X Address
                        ],
                    ],
                ],
                [
                    'match_phrase_prefix' => [// 短语前缀匹配，解决短语匹配中 MAC Addres 没有结果的问题
                        $column => [
                            'query' => $keyword,
                            'slop' => 1,
                            'max_expansions' => 100,// 取匹配到的前100个结果
                        ],
                    ],
                ]
            ], $query);
        }

        return $query;
    }
}
