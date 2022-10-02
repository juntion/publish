<?php

namespace Tests\Feature\Page;

use App\Models\Page;
use Tests\TestCase;

class PageTest extends TestCase
{
    /**
     * @test
     */
    public function list()
    {
        $response = $this->get('/pages', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function homepages()
    {
        $response = $this->post('/pages/homepages', ['guard_name' => 'uums'], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function all()
    {
        $response = $this->get('/pages/all?guard_name=uums&type=1', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function update()
    {
        $page = Page::first();
        $data = [
            'name' => $this->faker()->name,
            'comment' => $this->faker()->sentence,
            'locale' => json_encode(['en' => $this->faker()->name, 'zh-CN' => $this->faker()->name]),
        ];
        $response = $this->patch('/pages/' . $page->id, $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }
}
