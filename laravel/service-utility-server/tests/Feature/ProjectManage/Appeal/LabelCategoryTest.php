<?php

namespace Tests\Feature\ProjectManage\Appeal;


use App\ProjectManage\Models\LabelCategory;
use Tests\TestCase;

class LabelCategoryTest extends TestCase
{
    /** @test */
    public function store()
    {
        $data = [
            'name' => $this->faker()->name,
            'is_open' => random_int(0, 1),
            'style' => $this->faker()->randomElement(['red', 'blue', 'yellow']),
        ];

        $response = $this->post('/pm/labelCategories', $data);
        $response->assertJsonFragment($this->successStructure());
    }

    /** @test */
    public function update()
    {
        $category = LabelCategory::first();
        $data = [
            'name' => $this->faker()->name,
            'is_open' => random_int(0, 1),
            'style' => $this->faker()->randomElement(['red', 'blue', 'yellow']),
        ];
        $response = $this->patch('/pm/labelCategories/' . $category->id, $data);
        $response->assertJsonFragment($this->successStructure());
    }

    /** @test */
    public function index()
    {
        $isOpen = random_int(0, 1);
        $response = $this->get('/pm/labelCategories?is_open=' . $isOpen);
        $response->assertJsonFragment($this->successStructure());
    }

    /** @test */
    public function tree()
    {
        $isOpen = random_int(0, 1);
        $response = $this->get('/pm/labelCategories/tree?is_open=' . $isOpen);
        $response->assertJsonFragment($this->successStructure());
    }

    /** @test */
    public function destroy()
    {
        $category = factory(LabelCategory::class)->create();
        $response = $this->delete('/pm/labelCategories/' . $category->id);
        $response->assertJsonFragment($this->successStructure());
    }

    /** @test */
    public function sort()
    {
        $categories = factory(LabelCategory::class, 5)->create();
        $data = [];
        foreach ($categories as $index => $category) {
            $data[$index]['label_category_id'] = $category->id;
            $data[$index]['sort'] = random_int(0, 100);
        }

        $response = $this->post('/pm/labelCategories/sort', ['label_categories_sort' => $data]);
        $response->assertJsonFragment($this->successStructure());
    }

}
