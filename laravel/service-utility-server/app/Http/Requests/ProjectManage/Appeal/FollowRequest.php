<?php

namespace App\Http\Requests\ProjectManage\Appeal;

use App\Exceptions\System\InvalidStatusException;
use Illuminate\Foundation\Http\FormRequest;

class FollowRequest extends FormRequest
{
    public function authorize()
    {
        if (!$this->user()->can('follow', $this->route('appeal'))) {
            throw new InvalidStatusException();
        }
        return true;
    }

    public function rules()
    {
        return [
            'follower_id' => 'required|integer|exists:users,id',
            'expiration_date' => 'date',
            'comment' => 'string',
        ];
    }

    public function attributes()
    {
        return [
            'follower_id' => '跟进人ID',
            'expiration_date' => '过期时间',
            'comment' => '诉求备注',
        ];
    }
}
