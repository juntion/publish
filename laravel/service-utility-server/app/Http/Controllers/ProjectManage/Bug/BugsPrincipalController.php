<?php

namespace App\Http\Controllers\ProjectManage\Bug;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectManage\Bug\BugsPrincipalBindingRequest;
use App\Http\Requests\ProjectManage\Bug\BugsPrincipalUpdateRequest;
use App\ProjectManage\Models\BugPrincipal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class BugsPrincipalController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param BugsPrincipalBindingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchBinding(BugsPrincipalBindingRequest $request)
    {
        $data = $request->validated();
        $data['backend_program_user_name'] = getUserNameById($data['backend_program_user_id']);
        $data['backend_product_user_name'] = getUserNameById($data['backend_product_user_id']);
        $data['frontend_program_user_name'] = getUserNameById($data['frontend_program_user_id']);
        $data['frontend_product_user_name'] = getUserNameById($data['frontend_product_user_id']);
        $data['test_user_name'] = getUserNameById($data['test_user_id']);

        foreach ($data['dept_ids'] as $deptId) {
            BugPrincipal::query()->updateOrCreate(['dept_id' => $deptId], array_merge($data, ['dept_id' => $deptId]));
        }

        return $this->success();
    }

    /**
     * @param BugsPrincipalUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BugsPrincipalUpdateRequest $request)
    {
        $principal = BugPrincipal::query()->where('dept_id', $request->route('dept_id'))->first();
        if (empty($principal)) {
            return $this->failed(Response::HTTP_NOT_FOUND);
        }
        $data = $request->validated();
        $data['backend_program_user_name'] = getUserNameById($data['backend_program_user_id']);
        $data['backend_product_user_name'] = getUserNameById($data['backend_product_user_id']);
        $data['frontend_program_user_name'] = getUserNameById($data['frontend_program_user_id']);
        $data['frontend_product_user_name'] = getUserNameById($data['frontend_product_user_id']);
        $data['test_user_name'] = getUserNameById($data['test_user_id']);
        $principal->update($data);

        return $this->success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $limit = intval($request->input('limit', 20));
        $principals = BugPrincipal::query();
        if ($deptId = $request->input('dept_id')) {
            $principals->where('dept_id', $deptId);
        }
        if ($name = $request->input('keyword')) {
            if (!Str::contains($name, '%')) {
                $name = '%' . $name . '%';
            }
            $principals->orWhereHas('department', function ($query) use ($name) {
                $query->where('name', 'like', $name);
            })->orWhere('backend_program_user_name', 'like', $name)
                ->orWhere('frontend_program_user_name', 'like', $name)
                ->orWhere('backend_product_user_name', 'like', $name)
                ->orWhere('frontend_product_user_name', 'like', $name)
                ->orWhere('test_user_name', 'like', $name);
        } else {
            $principals->whereHas('department', function ($query) {
                $query->whereNull('deleted_at');
            });
        }

        $principals = $principals->with('department')->orderBy('dept_id', 'asc')->paginate($limit);

        return $this->successWithData($principals);
    }
}
