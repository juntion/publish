<?php

namespace Tests\Feature\ProjectManage\Appeal;

use App\ProjectManage\Models\Label;
use App\ProjectManage\Models\LabelCategory;
use Tests\TestCase;

class LabelTest extends TestCase
{
    /** @test */
    public function store()
    {
        $category = factory(LabelCategory::class)->create();
        $data = [
            'label_category_id' => $category->id,
            'name' => $this->faker()->name,
            'is_open' => random_int(0, 1),
        ];
        $response = $this->post('/pm/labels', $data);
        $response->assertJsonFragment($this->successStructure());
        return $category;
    }

    /**
     * @test
     * @depends store
     * @param $category
     */
    public function index($category)
    {
        $response = $this->get('/pm/labelCategories/' . $category->id . '/labels');
        $response->assertJsonFragment($this->successStructure());
    }

    /** @test */
    public function update()
    {
        $label = Label::first();
        $category = factory(LabelCategory::class)->create();
        $data = [
            'label_category_id' => $category->id,
            'name' => $this->faker()->name,
            'is_open' => random_int(0, 1),
            'comment' => $this->faker()->sentence,
        ];

        $response = $this->patch('/pm/labels/' . $label->id, $data);
        $response->assertJsonFragment($this->successStructure());
    }

    /** @test */
    public function destroy()
    {
        $label = factory(Label::class)->create();
        $response = $this->delete('/pm/labels/' . $label->id);
        $response->assertJsonFragment($this->successStructure());
    }

    /** @test */
    public function sort()
    {
        $data = [];
        $labels = factory(Label::class, 5)->create();
        foreach ($labels as $index => $label) {
            $data[] = [
                'label_id' => $label->id,
                'sort' => random_int(0, 100),
            ];
        }
        $response = $this->post('/pm/labels/sort', ['labels_sort' => $data]);
        $response->assertJsonFragment($this->successStructure());
    }
}
