<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2020/11/23
 * Time: 14:26
 */

namespace Modules\Base\Support\Search;


use Elasticsearch\Client;
use Modules\Base\Contracts\Search\SearchQueryCallback;

class BaseQuery implements SearchQueryCallback
{
    
    public function handle(Client $client, string $query, array $options)
    {
        unset($options['body']['query']['bool']);
        $options['body']['query'] = json_decode($query, true);
        return $client->search($options);
    }
    
    public function callback(): \Closure
    {
        return function (Client $client, $query, array $options) {
            return call_user_func_array([(new static()), 'handle'], [$client, $query, $options]);
        };
    }
}