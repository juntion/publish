<?php


namespace Modules\Share\Database\Seeders\Init;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Admin\Entities\Admin;
use Modules\Share\Entities\ResourceCategory;

class CategoriesInitSeeder extends Seeder
{
    public function getDir()
    {
        return __DIR__.'/Data';
    }

    private function getData()
    {
        $lists = json_decode(file_get_contents($this->getDir().'/InitData/categories.json'), true);
        $categories = $lists['categories'];
        return $categories;
    }

    public function run()
    {
        $categories = $this->getData();
        DB::beginTransaction();
        try {
            foreach ($categories as $firstCategories) {
                $firstLevelUuid = Str::uuid()->getHex()->toString();
                ResourceCategory::query()->create([
                    'uuid'           => $firstLevelUuid,
                    'sort'           => $firstCategories['sort'],
                    'name'           => $firstCategories['name'],
                    'background'     => 'cover-'.rand(1, 30),
                    'one_level_uuid' => $firstLevelUuid,
                    'type'           => $firstCategories['type']
                ]);
                if (isset($firstCategories['child']) && !empty($firstCategories['child'])) {
                    $this->insertCateData($firstCategories['child'], $firstLevelUuid);
                }
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function insertCateData($data, $oneLevelUuid, $twoLevelUuid = "", $threeLevelUuid = "")
    {
        foreach ($data as $cate) {
            if ($twoLevelUuid == "") {
                $level = 2;
                $twoUuid = $uuid = Str::uuid()->getHex()->toString();
                $parentUuid = $oneLevelUuid;
            } elseif ($threeLevelUuid == "") {
                $threeUuid = $uuid = Str::uuid()->getHex()->toString();
                $twoUuid = $twoLevelUuid;
                $parentUuid = $twoLevelUuid;
                $level = 3;
            } else {
                $level = 4;
                $uuid = Str::uuid()->getHex()->toString();
                $twoUuid = $twoLevelUuid;
                $threeUuid = $threeLevelUuid;
                $parentUuid = $threeLevelUuid;
            }
            $insertData = [
                'uuid'           => $uuid,
                'sort'           => $cate['sort'],
                'background'     => 'cover-'.rand(1, 30),
                'one_level_uuid' => $oneLevelUuid,
                'type'           => $cate['type'],
                'parent_uuid'    => $parentUuid,
                'name'           => $cate['name']
            ];
            if ($level >= 2) {
                $insertData['two_level_uuid'] = $twoUuid;
            }
            if ($level >= 3) {
                $insertData['three_level_uuid'] = $threeUuid;
            }
            ResourceCategory::query()->create($insertData);
            if (isset($cate['child']) && !empty($cate['child'])) {
                if ($level == 2) {
                    $this->insertCateData($cate['child'], $oneLevelUuid, $twoUuid);
                } elseif ($level == 3) {
                    $this->insertCateData($cate['child'], $oneLevelUuid, $twoLevelUuid, $threeUuid);
                }
            }
        }
    }
}
