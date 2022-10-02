<?php

namespace Modules\ERP\Contracts;

use Modules\ERP\Entities\ProductsInstockShippingFields;

interface ProductsInstockShippingFieldsRepository
{

    /**
     * @param int $productsInstockId
     * @return mixed
     */
    public function getProductsInstockShippingFieldsByProductsInstockId(int $productsInstockId);

    /**
     * @param ProductsInstockShippingFields $fields
     * @return mixed
     */
    public function createByModel(ProductsInstockShippingFields $fields);
}
