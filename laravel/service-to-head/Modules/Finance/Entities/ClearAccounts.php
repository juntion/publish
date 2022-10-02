<?php

namespace Modules\Finance\Entities;

use Modules\Base\Entities\Model;
use Modules\Finance\Entities\Invoice;

class ClearAccounts extends Model
{

    /**
     * @var string
     */
    protected $table = 'f_clear_accounts';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $guarded = [];

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'number', 'expend_number');
    }
}
