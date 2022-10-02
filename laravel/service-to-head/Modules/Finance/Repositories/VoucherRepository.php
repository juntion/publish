<?php

namespace Modules\Finance\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Base\Support\Facades\Number;
use Modules\Finance\Contracts\VoucherRepository as ContractsVoucherRepository;
use Modules\Finance\Entities\PaymentVoucher;
use Modules\Finance\Repositories\Traits\EsTrait;
use Modules\Finance\Repositories\Traits\UploadTrait;
use Prettus\Repository\Eloquent\BaseRepository;

class VoucherRepository extends BaseRepository implements ContractsVoucherRepository
{

    use UploadTrait, EsTrait;

    public function model()
    {
        return PaymentVoucher::class;
    }

    /**
     * @param  array  $data
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function storeVoucher(array $data)
    {
       $voucher = $this->create($data);
       return $voucher->refresh();
    }

    /**
     * @param  PaymentVoucher  $paymentVoucher
     * @param  array  $data
     * @return mixed
     */
    public function relateReceipt(PaymentVoucher $paymentVoucher, array $data)
    {
        $data['receipt_init'] = $data['receipt_use'];
        $data['voucher_init'] = $data['voucher_use'];
        $paymentVoucher->receiptsToVoucher()->create($data);
        return $paymentVoucher->receiptsToVoucher;
    }

    public function getTypeIndex(int $type, $limit ,$adminIds = [], $sort = "DESC")
    {
        switch ($type) {
            case 1:
                return $this->with('receiptsToVoucher')
                    ->with(['receiptsToVoucher' => function($query){
                        $query->with('receipt');
                    }])
                    ->with('details')
                    ->orderBy('created_at', $sort)
                    ->orderBy('number', "DESC")
                    ->paginate($limit);
                break;
            case 2:
                return $this->whereIn('creator_uuid', $adminIds)
                    ->with(['receiptsToVoucher' => function($query){
                        $query->with('receipt');
                    }])
                    ->with('details')
                    ->orderBy('created_at', $sort)
                    ->orderBy('number', "DESC")
                    ->paginate($limit);
                break;
            case 3:
                return $this->where('creator_uuid', $adminIds)
                    ->with(['receiptsToVoucher' => function($query){
                        $query->with('receipt');
                    }])
                    ->with('details')
                    ->orderBy('created_at', $sort)
                    ->orderBy('number', "DESC")
                    ->paginate($limit);
                break;
        }
    }

    /**
     * @param  int  $type
     * @param $limit
     * @param $key
     * @param  array  $admins
     * @param  string  $sort
     * @return array
     * @throws \Exception
     */
    public function getTypeIndexByES(int $type, $limit, $key, $admins = [], $sort = "DESC"){
        $key = strtolower($key);
        $must =  [
            [
                'match_phrase' => [
                    'number' => $key // 到款编号
                ]
            ],
            [
                'prefix' => [
                    'number' => $key // 到款编号
                ]
            ],
            [
                'match_phrase' => [
                    'order_number' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'remark' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'customer_number' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'company_number' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'customer_email' => $key
                ]
            ],
            [
                'match_phrase' => [
                    'DK_number' => $key
                ]
            ]
        ];
        if (is_numeric($key) && $key < 21474836 ) {
            $must[] =
                [
                    'term' => [
                        'usable' =>  $key * 100// 到款金额 防止大于 2^32-1
                    ]
                ];
        }
        $query['bool']['must'][]= [
            'bool' => [
                'should' => $must
            ]
        ];
        if ($type == 2) { // 同组
            $query['bool']['must'][] = [
                'terms' => [
                    'creator_uuid' => $admins
                ]
            ];
        } elseif ($type == 3) {
            $query['bool']['must'][] = [
                'term' => [
                    'creator_uuid' => $admins
                ]
            ];
        }

        $query = json_encode($query);
        try {
            $lists = PaymentVoucher::search($query)->orderBy('created_at', $sort)->paginate($limit);
            $lists->setCollection($lists->getCollection()->load(['receiptsToVoucher' => function($q){
                $q->with('receipt');
            }, 'details']));
            $lists = $this->resetNewPaginator($lists, $key);
        } catch (\Exception $exception) {
            $this->catchException($exception);
        }
        return  $lists;
    }

    /**
     * @param  string  $orderNumber
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|mixed|object|null
     */
    public function getInfoByOrderNumber(string $orderNumber)
    {
        return PaymentVoucher::query()->where('order_number', $orderNumber)->first();
    }

    /**
     * @param  string  $orderNumber
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|mixed|object|null
     */
    public function getInfoByVoucherNumber(string $number)
    {
        return PaymentVoucher::query()->where('number', $number)->first();
    }


    /**
     * @param  PaymentVoucher  $voucher
     * @param  array  $data
     * @return mixed|void
     */
    public function storeVoucherDetail(PaymentVoucher $voucher, array $data)
    {
       // $voucher->increment('used', $data['voucher_use']);
        $voucher->details()->create($data);
    }

    /**
     * @param  string  $uuid
     * @param  int  $use
     * @return mixed|void
     */
    public function revokeUse(string $uuid, int $use)
    {
        $this->find($uuid)->decrement('used', $use);
    }


    /**
     * @param  string  $number
     * @param  int  $used
     * @return mixed|void
     */
    public function updateUsedByNumber(string $number, int $used)
    {
        $voucher = $this->getInfoByVoucherNumber($number);
        $voucher->update([
            'used' => DB::raw('`used` +' . $used),
        ]);
    }

    /**
     * @param  PaymentVoucher  $paymentVoucher
     * @return PaymentVoucher
     */
    public function createByModel(PaymentVoucher $paymentVoucher)
    {
        $paymentVoucher->uuid = Str::uuid()->getHex()->toString();
        $paymentVoucher->number = Number::create("CW")->get();
        $paymentVoucher->save();
        return $paymentVoucher->refresh();
    }

}
