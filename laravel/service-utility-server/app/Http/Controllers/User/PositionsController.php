<?php

namespace App\Http\Controllers\User;

use App\Events\User\UserUpdate;
use App\Models\User;
use App\Repositories\Position\PositionRepository;
use App\Repositories\Position\PostRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PositionsController extends Controller
{
    protected $user;
    protected $position;
    protected $post;

    public function __construct(UserRepository $user, PositionRepository $position, PostRepository $post)
    {
        parent::__construct();
        $this->user = $user;
        $this->position = $position;
        $this->post = $post;
    }

    /**
     * 设置用户职称
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function setPosition(Request $request, $id)
    {
        $user = $this->getInstance($this->user, $id);
        Validator::make($request->all(), [
            'position_ids' => 'required|array',
            'position_ids.*' => 'required|exists:positions,id',
            'post_ids' => 'array',
            'post_ids.*' => 'exists:posts,id',
            'which_language' => 'integer',
            'is_customer_service' => 'integer',
        ])->validate();

        $user->positions()->sync($request->input('position_ids'));
        if ($postIds = $request->input('post_ids')) {
            $user->posts()->sync($postIds);
        }
        $this->updateUserLanguageAndCustomService($user, $request);

        return $this->success();
    }

    /**
     * 批量添加用户职称
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function batchSetPosition(Request $request)
    {
        Validator::make($request->all(), [
            'position_id' => 'required|exists:positions,id',
            'post_id' => 'exists:posts,id',
            'which_language' => 'integer',
            'is_customer_service' => 'integer',
            'user_ids' => 'required|array',
            'user_ids.*' => 'required|exists:users,id',
        ])->validate();

        $position = $this->getInstance($this->position, $request->input('position_id'));
        $postId = $request->input('post_id');
        if ($postId) {
            $post = $this->getInstance($this->post, $postId);
        }
        $users = $this->user->findWhereIn('id', $request->input('user_ids'));
        foreach ($request->input('user_ids') as $userId) {
            if (!$position->users()->wherePivot('user_id', $userId)->first()) {
                $position->users()->attach($userId);
            }
            if ($postId && !$post->users()->wherePivot('user_id', $userId)->first()) {
                $post->users()->attach($userId);
            }
            $user = $users->where('id', $userId)->first();
            $this->updateUserLanguageAndCustomService($user, $request);
        }
        return $this->success();
    }

    /**
     * 更新客服区域和语种归属
     * @param $user
     * @param $request
     */
    protected function updateUserLanguageAndCustomService(User $user, Request $request)
    {
        $data = $request->only(['which_language', 'is_customer_service']);
        if (!empty($data)) {
            $user->update($data);
            event(new UserUpdate($user, $data));
        }
    }
}
