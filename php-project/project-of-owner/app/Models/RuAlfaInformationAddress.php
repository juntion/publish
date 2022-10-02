<?php
/**
 * Notes:
 * File name:ru_alfa_Information_address
 * Create by: Jay.Li
 * Created on: 2020/5/27 0027 17:01
 */


namespace App\Models;

class RuAlfaInformationAddress extends BaseModel
{
    protected $table = 'ru_alfa_Information_address';

    public $fillable = [
        'customers_id', 'alfa_phone', 'alfa_email', 'alfa_organization', 'alfa_legal_address', 'alfa_inn', 'alfa_kpp',
        'alfa_bic', 'alfa_bank_name', 'card_path', 'type', 'card_path_name'
    ];

    public function getCardPathNameAttribute($value)
    {
        if (empty($value)) {
            return pathinfo($this->card_path, PATHINFO_FILENAME);
        }
        $temp1 = $temp2 = $value;

        if (mb_strlen($value) > 20) {
            $firstStr = mb_substr($temp1, 0, 6);
            $lastStr = mb_substr($temp2, -10, 10);
            return $firstStr . '...' . $lastStr;
        }

        return $value;
    }
}
