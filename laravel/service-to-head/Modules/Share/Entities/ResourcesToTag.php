<?php


namespace Modules\Share\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ResourcesToTag extends Pivot
{
    protected $table = 'share_resources_to_tags';

    public $timestamps = false;

}
