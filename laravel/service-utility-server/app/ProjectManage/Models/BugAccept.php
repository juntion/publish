<?php

namespace App\ProjectManage\Models;

use App\Traits\DateFormatTrait;
use App\Traits\ModelsTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

// bug 验收
class BugAccept extends Model implements HasMedia
{
    use HasMediaTrait, ModelsTrait, DateFormatTrait;

    protected $table = 'pm_bugs_accept';

    protected $fillable = ['user_id', 'user_name', 'type', 'result', 'comment'];

    protected $appends = ['role'];

    const media = 'bugsAccept'; // 验收附件

    const TYPE_PROMULGATOR = 1;
    const TYPE_TEST = 2;
    const TYPE_PRODUCT = 3;
    const TYPE_PROGRAM_PRINCIPAL = 4;

    public function getRoleAttribute()
    {
        switch ($this->type) {
            case self::TYPE_PROMULGATOR:
                return '发布人';
            case self::TYPE_TEST:
                return '测试负责人';
            case self::TYPE_PRODUCT:
                return '产品负责人';
            case self::TYPE_PROGRAM_PRINCIPAL:
                return '程序负责人';
            default:
                return '';
        }
    }

    public function getMediaCollectionName()
    {
        return self::media;
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection(self::media)->useDisk('pm');
    }
}
