<?php


namespace Modules\Finance\Http\Requests\Invoice;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Base\Http\Requests\ListRequest;

class InvoiceIndexRequest extends ListRequest
{
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                'filter.claim_status' => 'nullable|type|in:0,1,2,3',
                'filter.cleared_status' => 'nullable|sometimes|in:0,1,2',
                'filter.to_void' => 'nullable|sometimes|in:0,1,2',
                'sort.created_at' => 'nullable|sometimes|in:asc,desc',
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
            'type',
            'company_uuid',
            'assistant_uuid',
            'cleared_status',
            'to_void',
            'created_at_begin',
            'created_at_end',
            'risk'
        ];
    }

    public function isScopeQuery($key): bool
    {
        return  in_array($key, ['type', 'company_uuid', 'assistant_uuid', 'cleared_status', 'to_void', 'created_at_begin', 'created_at_end', 'risk']);
    }

    public function mappingScopeQuery(Builder $query, $key, $val)
    {
        switch ($key) {
            case "type":
                return $query->where('type', '=',  $val);
                break;
            case "company_uuid":
                return $query->where('company_uuid', '=', $val);
                break;
            case "assistant_uuid":
                return $query->where('assistant_uuid', '=', $val);
                break;
            case "cleared_status":
                return $query->where('cleared_status', '=', $val);
                break;
            case "to_void":
                return $query->where('to_void', '=', $val);
                break;
            case "created_at_begin":
                return $query->where('created_at', '>=', Carbon::parse($val)->toDateTimeString());
                break;
            case "created_at_end":
                return $query->where('created_at', '<=', Carbon::parse($val)->toDateTimeString());
                break;
            case "risk":
                if ($val == 'no') {
                    return $query->where(function ($q){
                        $q->whereRaw('(TIMESTAMPDIFF(DAY,created_at,DATE_FORMAT(NOW(), \'%Y-%m-%d %H:%i:%S\'))) <= account_days')
                            ->orWhere('account_days', '0');
                    });
                } else if ($val == 'low') {
                    return $query->whereRaw('(TIMESTAMPDIFF(DAY,created_at,DATE_FORMAT(NOW(), \'%Y-%m-%d %H:%i:%S\'))) <= account_days+30')
                        ->whereRaw('(TIMESTAMPDIFF(DAY,created_at,DATE_FORMAT(NOW(), \'%Y-%m-%d %H:%i:%S\'))) > account_days')
                        ->where('account_days', '<>', '0');
                } else if ($val == 'medium') {
                    return $query->whereRaw('(TIMESTAMPDIFF(DAY,created_at,DATE_FORMAT(NOW(), \'%Y-%m-%d %H:%i:%S\'))) > account_days+30')
                        ->whereRaw('(TIMESTAMPDIFF(DAY,created_at,DATE_FORMAT(NOW(), \'%Y-%m-%d %H:%i:%S\'))) <= account_days+90')
                        ->where('account_days', '<>', '0');
                } else if ($val == 'high') {
                    return $query->whereRaw('(TIMESTAMPDIFF(DAY,created_at,DATE_FORMAT(NOW(), \'%Y-%m-%d %H:%i:%S\'))) > account_days+90')
                        ->where('account_days', '<>', '0');
                } else {
                    return $query;
                }
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
