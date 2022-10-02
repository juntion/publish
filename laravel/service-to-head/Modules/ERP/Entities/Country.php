<?php


namespace Modules\ERP\Entities;


class Country extends Model
{

    protected $table = 'countries';
    protected $primaryKey = 'countries_id';

    public function export(): array
    {
        return [];
    }


}
