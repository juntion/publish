<?php


namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\PaymentMethodRepository as ContractPaymentMethodRepository;
use Modules\ERP\Entities\PaymentMethod;
use Prettus\Repository\Eloquent\BaseRepository;

class PaymentMethodRepository extends BaseRepository  implements ContractPaymentMethodRepository
{
    public function model()
    {
        return PaymentMethod::class;
    }

    public function getPaymentMethodById($id)
    {
        return PaymentMethod::find($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public static function getAllPaymentMethods($type)
    {
        return PaymentMethod::query()
            ->whereIn('status', [1])
            ->where('pid', '!=', 0)
            ->when($type == 1, function ($query) {
                return $query->where('payment_image', 'greenfs_icon.png');
            })
            ->when($type == 0,function ($query) {
                return $query->where('payment_image', 'yellowfs_icon.png');
            })
            ->with('parent')
            ->orderBy("sort", "ASC")
            ->orderBy("id", "DESC")
            ->get()
            ->map(function ($item){
               return [
                   'id' => $item->id,
                   'name' => ($item->parent ? $item->parent->payment_method_cn : "") . ($item->payment_method_cn ? (" " . $item->payment_method_cn ): ""),
               ];
            });
    }

    /**
     * @param $id
     * @return mixed|string
     */
    public function getPaymentMethodName($id)
    {
        $payment = PaymentMethod::query()->find($id);
        return $payment ? $payment->payment_method : "";
    }

    public static function getPaymentMethodsIDByType($type = 1)
    {
        return PaymentMethod::query()
            ->whereIn('status', [1, 2])
            ->where('pid', '!=', 0)
            ->with('parent')
            ->when($type == 1, function ($query) {
                return $query->where('payment_image', 'greenfs_icon.png');
            }, function ($query) {
                return $query->where('payment_image', 'yellowfs_icon.png');
            })
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id
                ];
            });
    }
}
