<?php


namespace Modules\Base\Http\Requests\Company;


use Modules\Base\Http\Requests\ListRequest;

class CompanyListRequest extends ListRequest
{
    public function allowFilter(): array
    {
        return  [];
    }

    public function allowSort(): array
    {
        return [];
    }
}
