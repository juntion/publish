<?php


namespace Modules\Base\Http\Controllers\PaymentMethod;

use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\Controller;
use Modules\ERP\Contracts\PaymentMethodService;

class PaymentMethodController extends Controller
{
    public function all(Request $request, PaymentMethodService $paymentMethodService)
    {
        if ($request->has('filter')) {
            $filter = $request->input('filter');
            $type = $filter['is_real'] ?? 2;

        } else {
            $type = 2; // 所有的不区分
        }
        $paymentMethods = $paymentMethodService->getAllPaymentMethods($type);
        return $this->successWithData(compact('paymentMethods'));
    }
}
