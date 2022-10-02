<?php


namespace Modules\Finance\Http\Requests\Receipt;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Base\Http\Requests\ListRequest;

class ReceiptIndexRequest extends ListRequest
{
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                'filter.claim_status' => 'nullable|in:0,1,2',
                'filter.check_status' => 'nullable|in:0,1,2',
                'sort.created_at' => 'nullable|in:asc,desc',
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
            'payment_method_id',
            'claim_status',
            'check_status',
            'payment_time_begin',
            'payment_time_end',
            'created_at_begin',
            'created_at_end',
            'claim_time_begin',
            'claim_time_end',
            'company_uuid',
            'create_from',
            'deleted_at'
        ];
    }

    public function isScopeQuery($key): bool
    {
        return  in_array($key, ['payment_time_begin', 'payment_time_end', 'claim_time_begin', 'claim_time_end', 'deleted_at', 'check_status', 'created_at_begin', 'created_at_end']);
    }

    public function mappingScopeQuery(Builder $query, $key, $val)
    {
        switch ($key){
            case "payment_time_begin":
                return $query->where('payment_time', '>=',  Carbon::parse($val)->toDateTimeString());
                break;
            case "payment_time_end":
                return $query->where('payment_time', '<=', Carbon::parse($val)->toDateTimeString());
                break;
            case "claim_time_begin":
                return $query->where('claim_time', '>=', Carbon::parse($val)->toDateTimeString());
                break;
            case "claim_time_end":
                return $query->where('claim_time', '<=', Carbon::parse($val)->toDateTimeString());
                break;
            case "created_at_begin":
                return $query->where('created_at', '>=', Carbon::parse($val)->toDateTimeString());
                break;
            case "created_at_end":
                return $query->where('created_at', '<=', Carbon::parse($val)->toDateTimeString());
                break;
            case "deleted_at":
                if ($val == 'null') {
                    return $query->withoutTrashed();
                } elseif ($val == 'not_null') {
                    return $query->onlyTrashed();
                } else {
                    return $query->withTrashed();
                }
                break;
            case "check_status":
                return $query->whereHas('lastApplication', function ($q)use ($val){
                    $q->whereExists(function ($q1)use ($val){
                        $q1->select(DB::raw(1))
                            ->from('f_payment_claim_applications as b')
                            ->whereRaw(DB::raw('f_payment_claim_applications.receipt_uuid = b.receipt_uuid'))
                            ->where('check_status', $val)
                            ->havingRaw('max(b.created_at) = f_payment_claim_applications.created_at');
                    });
                });
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
        $filter = $this->query->get('filter');
        if (!$filter || !isset($filter['deleted_at']))
        {
            $filter['deleted_at'] = 'null';
            $this->query->set('filter', $filter); // 默认倒序
        }
    }
}
