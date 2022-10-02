<?php

namespace Modules\Route\Tests\Feature;

use Modules\Base\Tests\AdminTestCase;

class MenuRouteTreeTest extends AdminTestCase
{
    private static $treeUri = 'route/menuRouteTrees';

    public function testTrees()
    {
        $this->getJson(self::$treeUri . '/admin')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['tree']]);
    }

//    public function testUpdateTrees()
//    {
//        $this->patchJson(self::$treeUri . '/admin', [
//            "form_parent_uuid" => null,
//            "to_parent_uuid" => null,
//            "node_uuid" => "",
//            "node_type" => "",
//            "sort" => [
//                "parent_uuid" => null,
//                "node_type" => "",
//                "uuid" => "",
//                "sort" => ""
//            ]
//        ])
//            ->assertSuccessful();
//    }

//    public function testDestroyTreeNode()
//    {
//        $response = $this->deleteJson(self::$treeUri . '/admin/nodes/uuid')
//            ->assertSuccessful(['status' => 'success']);
//    }
}
