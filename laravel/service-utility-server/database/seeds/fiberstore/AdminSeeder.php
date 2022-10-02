<?php

use App\Models\Department;
use App\Repositories\User\UserRepository;
use App\Support\Upload;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends BaseSeeder
{
    const TABLE = 'admin';

    const MODEL = \App\Models\User::class;

    protected $users;

    public function __construct(UserRepository $users)
    {
        parent::__construct();
        $this->users = $users;
    }

    public function handel()
    {
        $this->setModel(self::MODEL);

        $admins = $this->db->table(self::TABLE)->orderBy('admin_id')->get();
        try {
            $admins->each(function ($item) {
                if (!filter_var($item->admin_email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception('邮箱格式错误 ' . $item->admin_email);
                }
                $model = $this->model->create([
                    'name' => $item->admin_name,
                    'email' => $item->admin_email,
                    'password' => Hash::make(Str::random(12)),
                    'origin_id' => $item->admin_id,
                    'which_language' => $item->which_language,
                    'is_customer_service' => $item->is_customer_service,
                    'admin_level' => $item->admin_level,
                    'duties' => $item->duties,
                ]);

                // 设置权限
                $this->users->setErpPermissionsOnSetDuties($model, $item->duties);

                // 部门
                if ($item->department) {
                    $department = Department::where('origin_id', $item->department)->first();
                    $model->departments()->attach($department, ['is_default' => 1]);
                }


                if (Storage::disk('migrations')->exists($item->admin_image)) {
                    $avatar = new \Illuminate\Http\UploadedFile(
                        Storage::disk('migrations')->path($item->admin_image),
                        substr($item->admin_image, 6)
                    );
                    $path = Upload::addFile($avatar)->save();
                    $model->moveTmpMedia($this->model->getUserAvatarMedia(), $path, true);
                }
            });
        } catch (Exception $e) {
            \Log::error('用户数据迁移失败', [$e->getMessage()]);
        }
    }
}
