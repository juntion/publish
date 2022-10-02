<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2020/11/23
 * Time: 14:03
 */

namespace Modules\Base\Support\Search;

use Laravel\Scout\Builder;
use Laravel\Scout\Searchable as ScoutSearchable;
use Modules\Base\Contracts\Search\SearchQueryCallback;

trait Searchable
{
    use ScoutSearchable;
    
    /**
     * 改扩展包目前没有使用ik中文分词，但es服务器已经安装了ik的分词扩展，应该要重写引擎类暂未研究
     * 重写scout searchable的该函数，用于自定义搜索
     *
     * 'body' => [
     *     'query' => [
     *         'bool' => [
     *             'must' => [['query_string' => ['query' => "*{$builder->query}*"]]] //类似like '%key%'
     *         ]
     *     ]
     * ]
     * 这个builder->query对应的就是$query参数
     * 文档使用https://learnku.com/docs/laravel/8.x/scout/9422
     *
     * example：Permission::search('{"match": {"comment": "权限首页"}}')->get();
     *          Permission::search('权限首页')->get();
     *
     * @param string $query  普通字符串还是scout类原生的查询方式，如果是json字符会作为body.query的值，参数写法可查看es文档
     * @param null $callback  自定义回调,可以在请求发送前自定义处理请求参数包括body
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    public static function search($query = '', $callback = null)
    {
        if (static::isJson($query) && empty($callback)) {
            $callback = (new BaseQuery())->callback();
        }
        if ($callback instanceof SearchQueryCallback) {
            $callback = (new $callback)->callback();
        }
        return app(Builder::class, [
            'model' => new static,
            'query' => $query,
            'callback' => $callback,
            'softDelete'=> static::usesSoftDelete() && config('scout.soft_delete', false),
        ]);
    }
    
    public static function isJson($str)
    {
        json_decode($str);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}