<?php

namespace App\Http\Requests\ProjectManage\Appeal;

use App\Exceptions\System\InvalidStatusException;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        if (!$this->user()->can('products', $this->route('appeal'))) {
            throw new InvalidStatusException();
        }
        return true;
    }

    public function rules()
    {
        return [
            'product_id' => 'required|integer|exists:pm_products,id',
            'product_modules' => 'array',
            'product_modules.*.module_id' => 'integer|exists:pm_products,id',
            'product_modules.*.label_ids' => 'array',
            'product_modules.*.label_ids.*' => 'integer|exists:pm_products,id',
        ];
    }

    public function attributes()
    {
        return [
            'product_id' => '产品ID',
            'product_modules' => '产品模块',
            'product_modules.*.module_id' => '产品模块ID',
            'product_modules.*.label_ids' => '产品模块标签',
            'product_modules.*.label_ids.*' => '产品模块标签ID',
        ];
    }
}
