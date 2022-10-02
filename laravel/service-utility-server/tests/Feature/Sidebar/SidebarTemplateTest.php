<?php

namespace Tests\Feature\Sidebar;

use Tests\TestCase;

class SidebarTemplateTest extends TestCase
{
    /**
     * @test
     */
    public function store()
    {
        $data = [
            'name' => $this->faker()->name,
            'comment' => $this->faker()->sentence,
            'locale' => json_encode(['en' => $this->faker()->name, 'zh-CN' => $this->faker()->name]),
            'guard_name' => 'uums',
        ];
        $response = $this->post('/sidebars/templates', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
        return $response->original['data']['sidebar_template'];
    }

    /**
     * @test
     * @depends store
     * @param $template
     */
    public function update($template)
    {
        $data = [
            'name' => $this->faker()->name,
            'comment' => $this->faker()->sentence,
            'locale' => json_encode(['en' => $this->faker()->name, 'zh-CN' => $this->faker()->name]),
        ];
        $response = $this->patch('/sidebars/templates/' . $template->id, $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function all()
    {
        $response = $this->post('/sidebars/templates/all', ['guard_name' => 'uums'], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function list()
    {
        $response = $this->get('/sidebars/templates', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $template
     */
    public function categories($template)
    {
        $response = $this->get('/sidebars/templates/' . $template->id . '/categories', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $template
     */
    public function trees($template)
    {
        $response = $this->get('/sidebars/templates/' . $template->id . '/trees', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $template
     */
    public function pages($template)
    {
        $response = $this->get('/sidebars/templates/' . $template->id . '/pages', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }


    /**
     * @test
     * @depends store
     * @param $template
     */
    public function deleteTemplate($template)
    {
        $response = $this->delete('/sidebars/templates/' . $template->id, [], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }
}
