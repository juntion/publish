<?php
/**
 * Notes:
 * File name:scene_action_advance
 * Create by: Jay.Li
 * Created on: 2020/11/2 0002 16:15
 */


namespace App\Models;


class SceneActionAdvance extends BaseModel
{
    protected $table = 'scene_action_advance';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    public $fillable = [
        'customers_id',
        'type',
        'c_num'
    ];
}