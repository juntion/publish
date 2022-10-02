<?php


namespace Modules\Share\Entities;


use Illuminate\Database\Eloquent\Relations\Pivot;

class SubjectToResource extends Pivot
{
    protected $table = 'share_subject_to_resources';
}
