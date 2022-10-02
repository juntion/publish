<?php


namespace App\Models;

use App\Models\BaseModel;

class CustomerOldEmail extends BaseModel
{
    protected $table = 'customer_old_emails';
    protected $fillable = ['customers_id', 'email', 'created_person', 'updated_person', 'created_at', 'updated_at'];
    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @param int $value
     * @return int|string
     */
    public function fromDateTime($value = 0)
    {
        return $value;
    }
}
