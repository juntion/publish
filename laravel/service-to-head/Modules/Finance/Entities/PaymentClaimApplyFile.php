<?php


namespace Modules\Finance\Entities;


use Illuminate\Support\Facades\Storage;
use Modules\Base\Entities\Model;

class PaymentClaimApplyFile extends Model
{
    protected $table = 'f_payment_claim_apply_files';

    protected $fillable = ['uuid', 'apply_uuid', 'name', 'storage_name', 'path', 'type', 'created_at'];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        self::deleted(function ($media){
            $path = $media->path . '/' . $media->storage_name;
            Storage::disk('finance')->delete($path);
        });
    }

    public function receipt()
    {
        return $this->hasOneThrough(
            PaymentReceipt::class,
            PaymentClaimApplication::class,
            'uuid',
            'uuid',
            'apply_uuid',
            'receipt_uuid'
            );
    }

    public function claim()
    {
        return $this->belongsTo(PaymentClaimApplication::class ,'apply_uuid', 'uuid' );
    }

}
