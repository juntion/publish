<?php


namespace Modules\ERP\Entities;

use Illuminate\Support\Str;

class Admin extends Model
{
    protected $table = 'admin';

    protected $primaryKey = 'admin_id';

    public function export(): array
    {
        return [
            'uuid' => Str::uuid()->getHex()->toString(),
            'name' => $this->admin_name,
            'email' => $this->admin_email,
//            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password

            'id' => $this->admin_id,
        ];
    }
}
