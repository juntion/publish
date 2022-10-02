<?php

namespace Modules\Share\Tests\Feature;

use Modules\Base\Tests\AdminTestCase;

class AdminTest extends AdminTestCase
{
    private static $stats = '/share/admin/stats';
    private static $viewed = '/share/admin/vieweds?filter[type]=picture&limit=15&page=1';
    private static $download = '/share/admin/downloads?filter[type]=picture&limit=15&page=1';

    public function testStats()
    {
        $this->getJson(self::$stats)
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['stats']]);
    }

    public function testVieweds()
    {
        $this->postJson(self::$viewed)
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['vieweds']]);
    }

    public function testDownloads()
    {
        $this->postJson(self::$download)
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['downloads']]);
    }
}
