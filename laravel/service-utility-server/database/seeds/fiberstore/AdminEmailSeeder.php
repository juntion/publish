<?php

use App\Models\User;

class AdminEmailSeeder extends BaseSeeder
{
    const TABLE = 'admin';

    const MODEL = User::class;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setModel(self::MODEL);

        try {
            $admins = $this->db->table(self::TABLE)->orderBy('admin_id')->get();
            $admins->each(function ($item) {
                $email = !empty($item->code_email) ? $item->code_email : $item->admin_email;
                $this->model->where('origin_id', $item->admin_id)
                    ->update([
                        'email' => $email,
                    ]);
            });
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}
