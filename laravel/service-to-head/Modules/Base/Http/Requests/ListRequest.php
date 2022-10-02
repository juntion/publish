<?php

namespace Modules\Base\Http\Requests;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;

abstract class ListRequest extends FormRequest
{
    /**
     * 列表请求类，用于获取列表数据的请求
     * 支持的请求参数，/ ?page=1&limit=20&filter[name]=admin&sort[name]=desc
     * page  : 当前页码
     * limit ：每页显示多少条
     * filter：列表过滤  name为要过滤的字段名
     * sort  ：列表排序  name为要排序的字段名
     */

    /** 判断是否是分页请求数据
     * @return bool
     */
    public function isPaginate()
    {
        if ($this->query('page')) $this->query->set('page', (int)$this->query('page'));
        if ($this->query('limit')) $this->query->set('limit', (int)$this->query('limit'));

        return $this->query('page') || $this->query('limit');
    }

    public function authorize()
    {
        if (!$this->isPaginate()) {
            return false;
        }

        return true;
    }

    public function rules()
    {
        return [
            'page' => 'sometimes|integer|min:1',
            'limit' => 'sometimes|integer|between:1,100',
            'filter' => 'sometimes|array',
            'sort' => 'sometimes|array',
        ];
    }

    /**
     * 允许过滤的字段
     * @return array
     */
    abstract public function allowFilter(): array;

    /**
     * 允许排序的字段
     * @return array
     */
    abstract public function allowSort(): array;

    /**
     * 反馈走特殊逻辑的filter Builder query
     * @param $query
     * @param $key
     * @return mixed
     */
    public function mappingScopeQuery(Builder $query, $key, $val)
    {
        return $query;
    }

    /**
     * 判断 filter的值是否是走特殊逻辑
     * @param $key
     * @return bool
     */
    public function isScopeQuery($key)
    {
        return false;
    }
}
