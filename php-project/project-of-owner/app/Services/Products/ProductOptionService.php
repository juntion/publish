<?php

namespace App\Services\Products;

use App\Models\ProductOption;
use App\Services\BaseService;

class ProductOptionService extends BaseService
{
    private $optionObj;

    public function __construct()
    {
        parent::__construct();

        $this->optionObj = new ProductOption();
    }

    /**
     * 获取所有多选类型的属性项
     * @return mixed
     */
    public function getCheckboxOptionId()
    {
        $optionId = $this->optionObj->where('products_options_type', 3)
            ->where('language_id', 1)
            ->lists('products_options_id');
        return $optionId;
    }
}
