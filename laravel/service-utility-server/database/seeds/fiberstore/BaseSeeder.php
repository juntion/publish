<?php

use Illuminate\Database\Seeder;

class BaseSeeder extends Seeder
{
    protected $db;
    protected $model;

    public function __construct()
    {
        $this->db = (new DB())::connection('mysql_old');
    }


    public function setModel($model)
    {
        $this->model = new $model();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->handel();
    }

    // 执行迁移
    public function handel()
    {

    }
}
