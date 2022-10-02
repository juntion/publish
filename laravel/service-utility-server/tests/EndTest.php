<?php

namespace Tests;

use App\Models\System\Media;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class EndTest extends BaseTestCase
{
    use CreatesApplication;

    public function testMigrateFresh()
    {
        if (Schema::hasTable('media')) {
            // 删除多媒体文件
            collect(Media::all())->each(function ($media) {
                $media->delete();
            });
        }
        // 清空数据库
        Artisan::call('migrate:fresh');
        $this->assertTrue(true);
    }
}
