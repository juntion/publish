<?php

namespace Tests\Feature\User;

use App\Models\Page;
use App\Models\User;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    protected $users;
    protected $pages;

    protected function setUp(): void
    {
        parent::setUp();
        $this->users = factory(User::class, 5)->create();
        $this->pages = Page::all();
    }

    /**
     * @test
     */
    public function setHomepage()
    {
        $user = $this->faker()->randomElement($this->users);
        $page = $this->faker->randomElement($this->pages);
        $data = [
            'page_id' => $page->id,
            'guard_name' => 'uums'
        ];
        $response = $this->post('/users/' . $user->id . '/homepages', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function batchSetHomepage()
    {
        $users = $this->faker()->randomElements($this->users, 3);
        $page = $this->faker->randomElement($this->pages);
        $data = [
            'page_id' => $page->id,
            'user_ids' => collect($users)->pluck('id')->toArray(),
            'guard_name' => 'uums'
        ];
        $response = $this->post('/users/homepages', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function getHomepage()
    {
        $user = $this->faker()->randomElement($this->users);
        $response = $this->get('/users/' . $user->id . '/homepages', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }
}
