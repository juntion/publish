<?php

namespace Modules\Tag\Database\Seeders\Migrate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Entities\Tag;
use Modules\Tag\Entities\TagData;
use Modules\Tag\Enums\TagDataSourceModelType;

// 从fs_blog迁移标签绑定数据
class TagDataSourceBlogSeeder extends Seeder
{
    // 板块和模型对应关系
    const classificationModelTypeMappings = [
        // classification_id => model_type
        1 => TagDataSourceModelType::BLOG,   //blog
        3 => TagDataSourceModelType::NEWS,   //News
        4 => TagDataSourceModelType::INSIGHT,//insight
        5 => TagDataSourceModelType::IDEAS,  //ideas
    ];

    /**
     * @var \Symfony\Component\Console\Helper\ProgressBar
     */
    private $progressBar;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $tagBlogs = Tag::query()->with(['posts' => function ($query) {
            // Support已废弃
            $query->where('classification_id', '!=', 2);
        }])->get();

        $count = 0;
        $tagBlogs->each(function ($tag) use (&$count) {
            $count += $tag->posts->unique('id')->count();
        });
        $this->command->info('开始迁移Blog标签绑定关系...');
        $this->progressBar = $this->command->getOutput()->createProgressBar($count);
        $this->progressBar->start();

        DB::transaction(function () use ($tagBlogs) {

            $tagBlogs->map(function (Tag $tag) {
                $tagData = TagData::query()->where('number', $tag->id)->firstOrFail();
                $posts = $tag->posts->unique('id')->values();

                foreach ($posts as $post) {
                    $data = [
                        'model_id' => $post->id,
                        'model_type' => self::classificationModelTypeMappings[$post->classification_id],
                        'model_desc' => $post->post_name,
                        'priority' => 0,
                    ];
                    $tagData->tagDataSource()->create($data);
                    $this->progressBar->advance();
                }
            });
        });

        $this->progressBar->finish();
    }
}
