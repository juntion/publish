<?php


namespace Modules\Share\Entities;


use Illuminate\Database\Eloquent\Model;
use Modules\Base\Support\Search\Searchable;

class Key extends Model
{
    use Searchable;
    protected $table = 'share_keys';
    protected $fillable = ['key', 'count'];
    public $timestamps = false;
    protected $primaryKey = 'key';
    protected $keyType = 'string';
    public $incrementing = false;

    public function toSearchableArray()
    {
        $array = $this->toArray();
        return $array;
    }

    public function getScoutKey()
    {
        return $this->key;
    }

    public function getScoutKeyName()
    {
        return 'key';
    }
}
