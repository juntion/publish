<?php

namespace Tests\Feature\ProjectManage\Appeal;

use App\Enums\ProjectManage\AppealStatus;
use App\Models\Department;
use App\Models\User;
use App\ProjectManage\Models\Appeal;
use App\ProjectManage\Models\Label;
use App\ProjectManage\Models\Product;
use App\ProjectManage\Models\Project;
use App\ProjectManage\Models\Team;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AppealTest extends TestCase
{
    /** @test */
    public function store()
    {
        $response = $this->post('/pm/appeals', $this->generateAppealData());
        $response->assertJsonFragment($this->successStructure());
        return Appeal::query()->orderBy('id', 'desc')->first();
    }

    /** @test */
    public function list()
    {
        $response = $this->get('/pm/appeals');
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $appeal
     * @throws \Exception
     */
    public function update($appeal)
    {
        $response = $this->post('/pm/appeals/' . $appeal->id, $this->generateAppealData());
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function generateAppealData()
    {
        $questions = [
            'urgent' => [
                ['question' => $this->faker()->sentence, 'answer' => $this->faker()->sentence],
            ],
            'important' => [
                ['question' => $this->faker()->sentence, 'answer' => $this->faker()->sentence],
            ]
        ];
        $project = factory(Project::class)->create();
        $product = factory(Product::class)->create();
        $team = factory(Team::class)->create(['product_id' => $product->id]);
        $attentionUsers = factory(User::class, 5)->create();
        $department = factory(Department::class)->create();

        $defaultDepart = Auth::user()->department()->first();
        if (empty($defaultDepart)) {
            Auth::user()->department()->attach($department, ['is_default' => 1]);
        }
        // 关联部门
        foreach ($attentionUsers as $user) {
            $user->department()->attach($department, ['is_default' => 1]);
        }

        return [
            'name' => $this->faker()->sentence,
            'brief' => $this->faker()->sentence,
            'content' => $this->faker()->paragraph,
            'type' => random_int(0, 5),
            'is_urgent' => random_int(0, 1),
            'is_important' => random_int(0, 1),
            'questions' => $questions,
            'source_project_id' => $project->id,
            'source_project_name' => $project->name,
            'product_id' => $product->id,
            'attention_user_ids' => $attentionUsers->pluck('id')->toArray(),
        ];
    }

    /** @test */
    public function deleteAppeal()
    {
        $appeal = factory(Appeal::class)->create();
        $appeal->update([
            'promulgator_id' => Auth::id(),
            'status' => AppealStatus::STATUS_TO_ACCEPT,
        ]);
        $response = $this->delete('/pm/appeals/' . $appeal->id);
        $response->assertJsonFragment($this->successStructure());
    }

    /** @test
     * @depends store
     * @param $appeal
     */
    public function logs($appeal)
    {
        $response = $this->get('/pm/appeals/' . $appeal->id . '/logs');
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends store
     * @param $appeal
     */
    public function revocation($appeal)
    {
        $data = ['comment' => $this->faker()->sentence];
        $response = $this->post('/pm/appeals/' . $appeal->id . '/revocation', $data);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function labels()
    {
        $appeal = factory(Appeal::class)->create();
        $labels = factory(Label::class, 3)->create(['is_open' => 1]);
        $data = ['label_ids' => $labels->pluck('id')->toArray()];
        Auth::login(User::find($appeal->principal_user_id));
        $response = $this->post('/pm/appeals/' . $appeal->id . '/labels', $data);
        $response->assertJsonFragment($this->successStructure());
        return compact('appeal', 'labels');
    }

    /**
     * @test
     * @depends labels
     * @param $data
     */
    public function deleteLabel($data)
    {
        $appeal = $data['appeal'];
        $label = $this->faker()->randomElement($data['labels']);
        Auth::login(User::find($appeal->principal_user_id));
        $response = $this->delete('/pm/appeals/' . $appeal->id . '/labels/' . $label->id);
        $response->assertJsonFragment($this->successStructure());
    }

    /** @test */
    public function apply()
    {
        $appeal = factory(Appeal::class)->create();
        $response = $this->get('/pm/appeals/' . $appeal->id . '/apply');
        $response->assertJsonFragment($this->successStructure());
        return $appeal;
    }

    /**
     * @test
     * @depends apply
     * @param $appeal
     */
    public function applyCancel($appeal)
    {
        $response = $this->get('/pm/appeals/' . $appeal->id . '/apply/cancel');
        $response->assertJsonFragment($this->successStructure());
    }

    /** @test */
    public function follow()
    {
        $appeal = factory(Appeal::class)->create();
        $follower = factory(User::class)->create();
        $data = [
            'follower_id' => $follower->id,
            'expiration_date' => $this->faker()->date(),
            'comment' => $this->faker()->sentence,
        ];
        $response = $this->post('/pm/appeals/' . $appeal->id . '/follow', $data);
        $response->assertJsonFragment($this->successStructure);
    }

    /** @test */
    public function products()
    {
        $appeal = factory(Appeal::class)->create();
        $product = factory(Product::class)->create();
        factory(Team::class)->create(['product_id' => $product->id]);
        $data = [
            'product_id' => $product->id,
        ];
        $response = $this->post('/pm/appeals/' . $appeal->id . '/products', $data);
        $response->assertJsonFragment($this->successStructure);
    }

    /** @test */
    public function verify()
    {
        $appeal = factory(Appeal::class)->create();
        $data = [
            'status' => random_int(0, 7),
            'crux' => $this->faker()->sentence,
            'comment' => $this->faker()->sentence,
        ];
        $response = $this->post('/pm/appeals/' . $appeal->id . '/verify', $data);
        $response->assertJsonFragment($this->successStructure);
    }

    /** @test */
    public function disassemble()
    {
        $appeal = factory(Appeal::class)->create();
        $appeals = [];
        for ($i = 0; $i < 3; $i++) {
            $appeals[] = $this->generateAppealData();
        }
        $data = [
            'appeals' => $appeals,
            'comment' => $this->faker()->sentence,
        ];
        $response = $this->post('/pm/appeals/' . $appeal->id . '/disassemble', $data);
        $response->assertJsonFragment($this->successStructure);
    }

    /** @test */
    public function details()
    {
        $appeal = factory(Appeal::class)->create();
        $response = $this->get('/pm/appeals/' . $appeal->id . '/details');
        $response->assertJsonFragment($this->successStructure());
    }

    //todo /** @test */
    public function createDemand()
    {
        $appeal = factory(Appeal::class)->create();
        $product = factory(Product::class)->create();
        $project = factory(Project::class)->create();
        $attentionUsers = factory(User::class, 3)->create();
        $data = [
            'product_id' => $product->id,
            'priority' => random_int(1, 5),
            'expiration_date' => $this->faker()->date(),
            'source_project_id' => $project->id,
            'source_project_name' => $project->name,
            'name' => $this->faker()->sentence,
            'content' => $this->faker()->sentence,
            'demand_links' => [
                'design' => ['comment' => $this->faker()->sentence],
                'dev' => ['comment' => $this->faker()->sentence],
            ],
            'attention_user_ids' => $attentionUsers->pluck('id')->toArray(),
            'appeal_ids' => $appeal->pluck('id')->toArray(),
        ];
        $response = $this->post('/pm/appeals/createDemand', $data);
        $response->assertJsonFragment($this->successStructure());
    }

    /** @test */
    public function cancelDemand()
    {
        $appeal = factory(Appeal::class)->create();
        $response = $this->get('/pm/appeals/' . $appeal->id . '/createDemand/cancel');
        $response->assertJsonFragment($this->successStructure());
    }

}
