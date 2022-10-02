<?php

namespace Modules\Base\Http\Controllers;

use Modules\Base\Http\Requests\OpenAuth\ChangeStatusRequest;
use Modules\Base\Http\Requests\OpenAuth\StoreRequest;
use Modules\Base\Http\Requests\OpenAuth\TokenListRequest;
use Modules\Base\Repositories\OpenAuthRepositories;

class OpenAuthController extends Controller
{
    private $authRepositories;
    
    public function __construct(OpenAuthRepositories $authRepositories)
    {
        $this->authRepositories = $authRepositories;
    }
    
    public function store(StoreRequest $request)
    {
        $data = [
            'exp_time' => $request->input('exp_time'),
            'remarks' => $request->input('remarks'),
        ];
        return $this->authRepositories->store($data);
    }
    
    public function index(TokenListRequest $listRequest)
    {
        $listRequestData = [
            'limit' => $listRequest->input('limit'),
            'keyword' => $listRequest->input('keyword'),
        ];
        return $this->authRepositories->tokenList($listRequestData);
    }
    
    public function changeStatus(ChangeStatusRequest $request)
    {
        $accessKeyId = $request->uuid;
        $status = $request->input('status');
        return $this->authRepositories->changeStatus($accessKeyId, $status);
    }
}
