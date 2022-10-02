<?php


namespace Modules\Base\Repositories;


use Illuminate\Support\Str;
use Modules\Base\Entities\Base\OpenAuth;
use Modules\Base\Http\Resources\OpenAuthCollection;
use Modules\Base\Http\Resources\OpenAuthResource;
use Modules\Base\Support\Signature;

class OpenAuthRepositories
{
    public function store(array $data)
    {
        $expTime = $data['exp_time'] ?? 0;
        $remarks = $data['remarks'] ?? '';
        $expTime = $expTime ? time() + (int)$expTime : 0;
        $saveData = [
            'access_key_id'     => Str::uuid()->getHex()->toString(),
            'access_key_secret' => Signature::get(),
            'exp_time'          => (int)$expTime,
            'remarks'           => $remarks,
            'status'            => 0,
        ];
        $auth = OpenAuth::query()->create($saveData)->refresh();
        $token = new OpenAuthResource($auth);
        return $token;
    }
    
    public function tokenList(array $listRequestData)
    {
        $keyword = $listRequestData['keyword'] ?? '';
        $limit = $listRequestData['limit'] ?: 15;
        if ($keyword) {
            $searchRes = OpenAuth::query()->where('access_key_id', 'like', $keyword . '%')->orWhere('access_key_secret', 'like', $keyword . '%')
            ->paginate($limit);
        } else {
            $searchRes = OpenAuth::query()->paginate($limit);
        }
        return new OpenAuthCollection($searchRes);
    }
    
    public function changeStatus($accessKeyId, $status)
    {
        $authToken = OpenAuth::query()->find($accessKeyId);
        if ($authToken) {
            $authToken->status = $status;
            $authToken->save();
            $authToken->refresh();
            return new OpenAuthResource($authToken);;
        }
        return false;
    }
}