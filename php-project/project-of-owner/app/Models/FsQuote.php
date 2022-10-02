<?php


namespace App\Models;

use App\Models\BaseModel;

class FsQuote extends BaseModel
{
    protected $table = "fs_quotes";
    public $timestamps = false;

    public function quotesProducts()
    {
        return  $this->hasMany('\App\Models\FsQuotesProducts', "quotes_id", 'id');
    }

    public function quotesAddress()
    {
        return  $this->hasMany('\App\Models\FsQuotesAddress', "quotes_id", 'id');
    }

    public function quotesTotal()
    {
        return $this->hasMany('\App\Models\FsQuotesTotal', "quotes_id", 'id');
    }

    public function quoteCustomers()
    {
        return  $this->hasMany('\App\Models\FsQuotesProducts', "quotes_id", 'id');
    }

    public function quotesAttributes()
    {
        return  $this->hasMany('\App\Models\FsQuotesProductsAttributes', "quotes_id", 'id');
    }

    public function quotesLength()
    {
        return  $this->hasMany('\App\Models\FsQuotesProductsLength', "quotes_id", 'id');
    }

    public function quotesOrders()
    {
        return  $this->hasOne('\App\Models\FsQuotesOrders', "quotes_id", 'id');
    }
}