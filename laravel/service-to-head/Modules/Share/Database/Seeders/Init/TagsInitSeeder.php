<?php


namespace Modules\Share\Database\Seeders\Init;


use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Admin\Entities\Admin;
use Modules\Share\Entities\ResourceTag;

class TagsInitSeeder extends Seeder
{
    public function run()
    {
        $user = Admin::query()->where('name', config('app.root'))->first();
        $tags = $this->getData();
        foreach ($tags as $tag) {
            ResourceTag::query()->create([
                'uuid'         => Str::uuid()->getHex()->toString(),
                'name'         => $tag['name'],
                'creator_uuid' => $user->uuid,
            ]);
        }
    }

    public function getDir()
    {
        return __DIR__.'/Data';
    }

    private function getData()
    {
        $lists = json_decode(file_get_contents($this->getDir().'/InitData/tags.json'), true);
        $tags = $lists['tags'];
        return $tags;
    }
}
