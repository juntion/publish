<?php

use App\Models\User;

class AdminAssistantLevelSeeder extends BaseSeeder
{
    const TABLE = 'admin';

    const MODEL = User::class;

    /**
     * 迁移销售职称
     *
     * @return void
     */
    public function run()
    {
        $this->setModel(self::MODEL);

        try {
            $admins = $this->db->table(self::TABLE)->orderBy('admin_id')->get();
            $admins->each(function ($item) {
                $assistantLevel = $this->db->table('assistant_level')->where('assistant_id', $item->assistant_level)->first();
                $this->model->where('origin_id', $item->admin_id)
                    ->update([
                        'assistant_id' => $item->assistant_level,
                        'assistant_name' => $assistantLevel ? $assistantLevel->assistant_name : '',
                    ]);
            });
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}
