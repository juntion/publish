<?php

namespace App\Repositories\Position;

use App\Models\Post;
use App\Repositories\BaseRepository;

class PostRepository extends BaseRepository
{
    protected $model;

    public function __construct(Post $post)
    {
        $this->model = $post;
    }
}
