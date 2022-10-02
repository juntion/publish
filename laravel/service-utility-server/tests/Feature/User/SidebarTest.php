<?php

namespace Tests\Feature\User;

use App\Models\Page;
use App\Models\Sidebar\SidebarTemplate;
use App\Models\User;
use Tests\TestCase;

class SidebarTest extends TestCase
{
    protected $users;
    protected $templates;
    protected $pages;

    protected function setUp(): void
    {
        parent::setUp();

        $this->users = factory(User::class, 5)->create();
        $this->templates = SidebarTemplate::all();
        $this->pages = Page::all();
    }

    /**
     * @test
     */
    public function bindSidebarTemplate()
    {
        $template = $this->faker()->randomElement($this->templates);
        $users = $this->faker()->randomElements($this->users, 3);
        $data = [
            'sidebar_template_id' => $template->id,
            'user_ids' => collect($users)->pluck('id')->toArray(),
            'guard_name' => 'uums',
        ];
        $response = $this->post('/users/sidebars', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function forbidPage()
    {
        $page = $this->faker()->randomElement($this->pages);
        $users = $this->faker()->randomElements($this->users, 3);
        $data = [
            'page_id' => $page->id,
            'user_ids' => collect($users)->pluck('id')->toArray(),
        ];
        $response = $this->post('/users/sidebars/pages/forbid', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function template()
    {
        $user = $this->faker()->randomElement($this->users);
        $response = $this->get('/users/' . $user->id . '/sidebars', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }
}
