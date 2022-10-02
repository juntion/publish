<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2020/11/23
 * Time: 14:23
 */

namespace Modules\Base\Contracts\Search;


use Elasticsearch\Client;

interface SearchQueryCallback
{
    /**
     * @param Client $client
     * @param string $query
     * @param array $options
     * @return mixed
     */
    public function handle(Client $client, string $query, array $options);
    
    /**
     * @return \Closure
     */
    public function callback(): \Closure;
}