<?php

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\ProductsInstockShippingFieldsRepository as ProductsInstockShippingFieldsMain;
use Modules\ERP\Entities\ProductsInstockShippingFields;

class ProductsInstockShippingFieldsRepository implements ProductsInstockShippingFieldsMain
{

    public function getProductsInstockShippingFieldsByProductsInstockId(int $productsInstockId)
    {
        return ProductsInstockShippingFields::where('products_instock_id', $productsInstockId)->first();
    }

    public function createByModel(ProductsInstockShippingFields $fields){
        $shippingFields = $this->getProductsInstockShippingFieldsByProductsInstockId($fields->products_instock_id);
        if (!is_null($shippingFields)) {
            return ProductsInstockShippingFields::where(['products_instock_id'=>$fields->products_instock_id])->update(['company_number'=>$fields->company_number]);
        } else {
            if ($fields->exists) return $fields;
            $fields->save();
            $fields->refresh();
            return $fields;
        }
    }
}
