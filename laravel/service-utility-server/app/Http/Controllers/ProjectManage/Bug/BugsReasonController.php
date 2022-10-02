<?php

namespace App\Http\Controllers\ProjectManage\Bug;

use App\Http\Controllers\Controller;
use App\ProjectManage\Models\BugReason;
use Illuminate\Http\Request;

class BugsReasonController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'reasons'                    => 'required|array',
            'reasons.*.reason'           => 'required|string',
            'reasons.*.required_analyse' => 'required|integer|in:0,1'
        ]);

        foreach ($data['reasons'] as $reason) {
            BugReason::query()->create($reason);
        }

        return $this->success();
    }

    /**
     * @param Request $request
     * @param BugReason $reason
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, BugReason $reason)
    {
        $data = $request->validate([
            'reason'           => 'required|string',
            'required_analyse' => 'required|integer|in:0,1'
        ]);
        $reason->update($data);

        return $this->success();
    }

    /**
     * @param Request $request
     * @param BugReason $reason
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(Request $request, BugReason $reason)
    {
        if ($reason->bugs()->exists()) {
            return $this->failedWithMessage('该故障原因已关联bug，无法删除!');
        }
        $reason->delete();
        return $this->success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = BugReason::query()->orderBy('id', 'desc')->get();
        return $this->successWithData($data);
    }
}
