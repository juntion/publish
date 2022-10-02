<?php
/**
 * Notes:
 * File name:SceneService
 * Create by: Jay.Li
 * Created on: 2020/11/2 0002 16:20
 */


namespace App\Services\Scene;


use App\Models\SceneActionAdvance;
use App\Services\BaseService;

class SceneService extends BaseService
{
    private $advance;

    public function __construct()
    {
        parent::__construct();

        $this->registerModel();
    }

    private function registerModel()
    {
        $this->advance = new SceneActionAdvance();
    }

    public function existsAdvance($type = 3)
    {
        return $this->advance->where('customers_id', $this->customer_id)->where('type', $type)->exists();
    }

    public function createAdvance($data)
    {
        return $this->advance->create($data);
    }

    public function updateAdvance($data)
    {
        try {
            $res = $this->existsAdvance($data['type']);

            if ($res) {
                $this->advance->where('customers_id', $this->customer_id)
                    ->where('type', $data['type'])->increment('c_num', 1);
            } else {
                $this->createAdvance($data);
            }

            $result = true;
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }
}