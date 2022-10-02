<?php

namespace Modules\Tag\Tests\Feature;

use Modules\Base\Tests\AdminTestCase;

class ProductDataSourceTest extends AdminTestCase
{
    private static $productUrl = '/tag/dataSource/products';
    private static $productCategoriesUrl = '/tag/dataSource/productCategories';

    public function testProducts()
    {
        $this->getJson(self::$productUrl)->assertSuccessful();
    }

    public function testProductCategories()
    {
        $this->getJson(self::$productCategoriesUrl)->assertSuccessful();
    }
}
