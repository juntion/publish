<?php


namespace Modules\ERP\Entities;

class Currency extends Model
{
    protected $table = 'currencies';

    protected $primaryKey = 'currencies_id';

    public function export(): array
    {
        return [
            'code'=>$this->code,
            'symbol'=>$this->symbol_var,
            'value'=>$this->value,
            'currencies_id'=>$this->currencies_id,
        ];
    }
}
