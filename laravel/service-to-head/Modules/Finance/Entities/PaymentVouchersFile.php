<?php


namespace Modules\Finance\Entities;


use Illuminate\Support\Facades\Storage;
use Modules\Base\Entities\Model;

class PaymentVouchersFile extends Model
{
    protected $table = 'f_payment_vouchers_files';

    public $timestamps = false;

    protected $fillable = ['uuid', 'vouch_uuid', 'name', 'storage_name', 'path', 'created_at'];

    protected static function boot()
    {
        parent::boot();
        self::deleted(function ($media){
            $path = $media->path . '/' . $media->storage_name;
            Storage::disk('finance')->delete($path);
        });
    }
}
