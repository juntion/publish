<?php


namespace Modules\Base\Http\Resources\Company;


use Modules\Base\Http\Resources\Json\Resource;

class ContactsResource extends Resource
{
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'tel'  => $this->tel,
            'type' => $this->type,
        ];
    }
}
