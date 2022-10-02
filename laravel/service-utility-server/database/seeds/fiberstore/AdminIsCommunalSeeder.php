<?php

use App\Models\User;

/**
 * 迁移是否是公共账号字段（is_communal）
 */
class AdminIsCommunalSeeder extends BaseSeeder
{
    const TABLE = 'admin';

    const MODEL = User::class;

    public function run()
    {
        $this->setModel(self::MODEL);

        try {
            $admins = $this->db->table(self::TABLE)->orderBy('admin_id')->get();
            $admins->each(function ($item) {
                $this->model->where('origin_id', $item->admin_id)
                    ->update([
                        'is_communal' => $item->is_communal,
                    ]);
            });
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}
