<?php


namespace Modules\UUMS\Entities;


use Illuminate\Support\Str;

class Media extends Model
{
    protected $table = 'media';


    public function user()
    {
        return $this->belongsTo(Admin::class, 'user_id', 'id')->withTrashed();
    }

    public function export(): array
    {
        return [
            'id' => $this->id,
            'uuid' => Str::uuid()->getHex()->toString(),
            'model_id' => $this->model_id,
            'model_type'    => $this->model_type,
            'user_id'       => $this->user_id,
            'name'          => $this->name,
            'file_name'     => $this->file_name,
            'size'          => $this->size,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'origin_id'     => $this->user->origin_id
        ];
    }
}
