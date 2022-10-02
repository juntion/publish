<?php


namespace Modules\UUMS\Entities;


use Illuminate\Support\Str;

class CompanyStatusLog extends Model
{
    protected $table = "company_status_logs";

    public function user()
    {
        return $this->belongsTo(Admin::class, 'user_id', 'id')->withTrashed();
    }

    public function export(): array
    {
        return [
            'id'             => $this->id,
            'uuid'           => Str::uuid()->getHex()->toString(),
            'model_id'       => $this->model_id,
            'model_type'     => $this->model_type,
            'user_id'        => $this->user_id,
            'action_name'    => $this->action_name,
            'old_status'     => $this->old_status,
            'new_status'     => $this->new_status,
            'comment'        => $this->comment,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
            'origin_id'      => $this->user->origin_id,
        ];
    }
}
