<?php
/**
 * Notes:
 * File name:OrdersAlfaAccount
 * Create by: Jay.Li
 * Created on: 2020/5/27 0027 16:55
 */


namespace App\Models;

class OrdersAlfaAccount extends BaseModel
{
    protected $table = 'orders_alfa_account';

    public $timestamps = false;

    public $fillable = [
        'orders_id', 'alfa_contact_person', 'alfa_phone', 'alfa_email', 'alfa_organization', 'alfa_inn', 'alfa_kpp',
        'alfa_okpo', 'alfa_bic', 'alfa_legal_address', 'alfa_postal_address', 'alfa_correspondent_accout',
        'alfa_bank_name', 'alfa_settlement_account', 'alfa_holder_name', 'card_path'
    ];
}
