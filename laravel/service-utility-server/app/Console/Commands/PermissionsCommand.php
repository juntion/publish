<?php

namespace App\Console\Commands;

use App\Events\Mail\SendPasswordEvent;
use App\Models\Permission\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class PermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:create-super-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建超级管理员';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $superAdmin = new User();
        $superAdmin->name = $this->ask('What is super admin name?');
        $superAdmin->email = $this->ask('What is super admin email?');
        $password = $this->secret('What is super admin password?');
        $passwordConfirm = $this->secret('Confirm super admin password?');

        if ($password != $passwordConfirm) {
            $this->error('password error.');
            return;
        }
        $superAdmin->password = Hash::make($password);

        if ($user = User::where('name', $superAdmin->name)->orWhere('email', $superAdmin->email)->first()) {
            $this->error('super admin is exist.');
            return;
        }

        $superRole = Role::createSuperRole();
        $superAdmin->save();
        $superAdmin->assignRole($superRole->id);

        try {
            $data['name'] = $superAdmin->name;
            $data['email'] = $superAdmin->email;
            $data['password'] = $password;
            event(new SendPasswordEvent($superAdmin, $data));
            $this->info('super admin is created.');
        } catch (\Exception $exception) {
            $this->info('super admin is created,but send email is failed.');
        }
    }
}
