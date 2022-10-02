<?php

namespace App\Services\Sample;

use App\Models\SampleApply;
use App\Services\BaseService;

class SampleApplyService extends BaseService
{
    protected $sample;
    public function __construct()
    {
        parent::__construct();
        $this->sample = new SampleApply();
    }
    public function createSample($data)
    {
        if ($data) {
            try {
                $this->sample->insert($data);
                return true;
            } catch (\Exception $e) {
                var_dump($e->getMessage());
                return false;
            }
        }
    }
}
