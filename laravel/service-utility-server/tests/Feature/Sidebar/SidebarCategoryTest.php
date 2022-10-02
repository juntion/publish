<?php

namespace Tests\Feature\Sidebar;

use App\Models\Page;
use App\Models\Sidebar\SidebarCategory;
use App\Models\Sidebar\SidebarTemplate;
use Tests\TestCase;

class SidebarCategoryTest extends TestCase
{
    protected $templates;

    protected function setUp(): void
    {
        parent::setUp();
        $this->templates = SidebarTemplate::all();
    }

    /**
     * @test
     */
    public function store()
    {
        $template = $this->faker()->randomElement($this->templates);
        $data = [
            'parent_id' => 0,
            'sidebar_template_id' => $template->id,
            'name' => $this->faker()->name,
            'comment' => $this->faker()->sentence,
            'locale' => json_encode(['en' => $this->faker()->name, 'zh-CN' => $this->faker()->name]),
            'icon' => 'bars',
        ];
        $response = $this->post('/sidebars/categories', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
        return $response->original['data']['sidebar_category'];
    }

    /**
     * @test
     * @depends store
     * @param $category
     */
    public function update($category)
    {
        $data = [
            'parent_id' => 0,
            'name' => $this->faker()->name,
            'comment' => $this->faker()->sentence,
            'locale' => json_encode(['en' => $this->faker()->name, 'zh-CN' => $this->faker()->name]),
            'icon' => 'bars',
        ];
        $response = $this->patch('/sidebars/categories/' . $category->id, $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $category
     */
    public function addPages($category)
    {
        $pages = Page::query()->limit(10)->pluck('id')->toArray();
        $response = $this->post('/sidebars/categories/' . $category->id . '/pages', ['page_ids' => $pages], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $category
     */
    public function removePages($category)
    {
        $pages = Page::query()->limit(3)->pluck('id')->toArray();
        $response = $this->delete('/sidebars/categories/' . $category->id . '/pages', ['page_ids' => $pages], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $category
     */
    public function sort($category)
    {
        $response = $this->post('/sidebars/categories/' . $category->id . '/sort', ['sort' => 1], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $category
     */
    public function pageSort($category)
    {
        $page = $category->pages()->first();
        $response = $this->post('/sidebars/categories/' . $category->id . '/pages/' . $page->id . '/sort', ['sort' => 10], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function batchSort()
    {
        $data = [];
        $categories = SidebarCategory::query()->limit(5)->get();
        foreach ($categories as $category) {
            $data[] = ['id' => $category->id, 'sort' => random_int(0, 1000)];
        }
        $response = $this->post('/sidebars/categories/batchSort', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function batchPageSort()
    {
        $data = [];
        $categories = SidebarCategory::query()->limit(5)->get();
        foreach ($categories as $category) {
            $page = $this->faker()->randomElement($category->pages()->get());
            $data[] = ['id' => $category->id, 'page_id' => $page->id, 'sort' => random_int(0, 1000)];
        }
        $response = $this->post('/sidebars/categories/pages/batchSort', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $category
     */
    public function deleteCategory($category)
    {
        $response = $this->delete('/sidebars/categories/' . $category->id, [], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }
}
