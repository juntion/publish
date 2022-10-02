<?php


namespace Modules\UUMS\Entities;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use SoftDeletes;

    protected $table = 'users';

    protected $primaryKey = 'id';

    public function export(): array
    {
        return [
            'uuid' => $this->uuid ?: Str::uuid()->getHex()->toString(),
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,

            'id' => $this->origin_id,    // 此id 对应原erp 后台 的 admin.admin_id
        ];
    }
}
