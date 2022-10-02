<?php

namespace App\Http\Requests\ProjectManage\Appeal;

use App\Exceptions\System\InvalidStatusException;
use Illuminate\Foundation\Http\FormRequest;

class RevocationRequest extends FormRequest
{
    public function authorize()
    {
        if (!$this->user()->can('revocation', $this->route('appeal'))) {
            throw new InvalidStatusException();
        }
        return true;
    }

    public function rules()
    {
        return ['comment' => 'required|string|max:255'];
    }
}
