<?php


namespace Modules\Base\Http\Resources;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Modules\Base\Http\Resources\Json\Resource;

class OpenAuthResource extends Resource
{
    public static $wrap = 'auth_token';
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'access_key_id'     => $this->access_key_id,
            'access_key_secret' => $this->access_key_secret,
            'exp_time'          => $this->exp_time ? Carbon::instance(Date::createFromTimestamp($this->exp_time))->toJSON() : $this->exp_time,
            'status'            => $this->status,
            'created_at'        => $this->getZoneDatetime($this->created_at),
            'updated_at'        => $this->getZoneDatetime($this->updated_at),
        ];
    }
}