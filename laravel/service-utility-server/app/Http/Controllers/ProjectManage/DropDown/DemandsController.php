<?php

namespace App\Http\Controllers\ProjectManage\DropDown;

use App\Http\Controllers\Controller;
use App\ProjectManage\Models\Demand;
use Illuminate\Http\Request;

class DemandsController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $demands = Demand::query();
        if ($request->has('keyword')) {
            $demands->where('number', 'like', '%' . $request->input('keyword') . '%')
                ->orWhere('name', 'like', '%' . $request->input('keyword') . '%');
        }
        $result = $demands->orderBy('id', 'desc')
            ->select(['id', 'name', 'number', 'status'])
            ->limit(100)->get();

        return $this->successWithData($result);
    }
}
