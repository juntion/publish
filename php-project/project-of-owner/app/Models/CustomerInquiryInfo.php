<?php

namespace App\Models;

class CustomerInquiryInfo extends BaseModel
{
    protected $table = 'customer_inquiry_info';
    protected $primaryKey = 'id';

    public $fillable = [
        'inquiry_id', 'attachment_path', 'origin_file_name', 'created_person', 'updated_person', 'created_at',
        'updated_at'
    ];

    public $timestamps = false;

    public function getAttachmentPathAttribute($value)
    {
        if (!$value) {
            return '';
        }
        $imagePath = self::trans('HTTPS_PRODUCTS_SERVER').self::trans('DIR_WS_IMAGES');

        return $imagePath . $value;
    }
}
