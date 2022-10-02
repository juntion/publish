<?php

namespace Modules\Base\Entities;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model as LaravelModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

abstract class Model extends LaravelModel
{
    use HasFactory;

    protected $primaryKey = 'uuid';

    protected $keyType = 'char';

    public $incrementing = false;

    /**
     * 创建或者更新一个模型，不同于查询构造器的updateOrCreate方法 ,在更新模型时不应该更新其主键
     *
     * @param array $attributes
     * @param array $values
     * @return mixed
     */
    public static function modelUpdateOrCreate(array $attributes, array $values = [])
    {
        return tap(static::firstOrNew($attributes, $values), function ($instance) use ($values) {
            $instance->fill(Arr::except($values, $instance->getKeyName()))->save();
        });
    }
}
