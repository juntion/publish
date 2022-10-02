<?php


namespace App\Models;

use App\Models\BaseModel;

class AvaTaxQueues extends BaseModel
{
    protected $table = 'avaTax_queue';
    public $timestamps = true;
    protected $connection = "write";
    protected $fillable = [
        'orders_id',
        'attempt',
        'is_success',
        'data',
        'exception',
        'response',
        'created_at',
        'updated_at'
    ];
    /**
     * 获取当前时间
     *
     * @return int
     */
    public function freshTimestamp()
    {
        return time();
    }

    /**
     * 避免转换时间戳为时间字符串
     *
     * @param DateTime|int $value
     * @return DateTime|int
     */
    public function fromDateTime($value)
    {
        return $value;
    }


    /**
     * 从数据库获取的为获取时间戳格式
     *
     * @return string
     */
    public function getDateFormat()
    {
        return 'U';
    }
}
