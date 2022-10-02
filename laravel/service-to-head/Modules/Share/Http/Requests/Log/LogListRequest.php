<?php

namespace Modules\Share\Http\Requests\Log;

use Modules\Base\Http\Requests\ListRequest;

class LogListRequest extends ListRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function allowSort(): array
    {
        return [];
    }

    public function allowFilter(): array
    {
        return [];
    }
}
