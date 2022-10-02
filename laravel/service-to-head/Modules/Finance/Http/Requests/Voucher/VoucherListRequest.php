<?php


namespace Modules\Finance\Http\Requests\Voucher;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Base\Http\Requests\ListRequest;

class VoucherListRequest extends ListRequest
{
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                'sort.created_at' => 'sometimes|in:asc,desc',
            ]
        );
    }

    public function allowSort(): array
    {
        return ['created_at'];
    }

    public function allowFilter(): array
    {
        return [
            'created_at_begin',
            'created_at_end',
            'type',
            'creator_uuid'
        ];
    }

    public function isScopeQuery($key): bool
    {
        return  in_array($key, ['created_at_end', 'created_at_begin']);
    }

    public function mappingScopeQuery(Builder $query, $key, $val)
    {
        switch ($key){
            case "created_at_begin":
                return $query->where('created_at', '>=',  Carbon::parse($val)->toDateTimeString());
                break;
            case "created_at_end":
                return $query->where('created_at', '<=', Carbon::parse($val)->toDateTimeString());
                break;
            default:
                return $query;
        }
    }

    public function prepareForValidation()
    {
        $sort = $this->query->get('sort');
        if (!$sort || !isset($sort['created_at'])) {
            $sort['created_at'] = 'desc';
            $this->query->set('sort', $sort); // 默认倒序
        }
    }
}
