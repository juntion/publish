<?php

namespace Modules\Tag\Database\Seeders\Migrate;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Base\Contracts\Number\Factory;
use Modules\Blog\Entities\Tag;
use Modules\Blog\Entities\TagDetail;
use Modules\Tag\Entities\TagData;
use Modules\Tag\Exceptions\TagDataException;

// 从fs_blog迁移标签数据
class TagDataBlogSeeder extends Seeder
{
    /**
     * blog 标签
     */
    private $blogTags;

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

        $this->blogTags = Tag::query()->with('details.language')->get();
        $topTag = $this->blogTags->where('parent_id', 0);

        $this->command->info('开始迁移Blog标签数据...');
        $this->progressBar = $this->command->getOutput()->createProgressBar($this->blogTags->count());
        $this->progressBar->start();

        DB::transaction(function () use ($topTag) {
            $this->createTagData($topTag);
        });

        $this->progressBar->finish();

        // 维护TagData redis中number值
        $lastNumber = TagData::query()->max('number');
        $tagNumber = app()->make(Factory::class)->create('TAG');
        $tagNumber->set($lastNumber);
    }

    /**
     * 递归创建标签
     * @param Collection $tags
     * @param null|TagData $parentTag
     */
    protected function createTagData(Collection $tags, $parentTag = null)
    {
        $tags->map(function (Tag $tag) use ($parentTag) {
            $detailEn = $tag->details->where('language_id', 1)->first();
            if (!$detailEn) {
                throw new TagDataException("标签(id:{$tag->id})无英语语种.");
            }
            $data = [
                'name' => $detailEn->tag_name,
                'type' => $tag->tag_type,
                'url_name' => $tag->tag_url,
                'number' => $tag->id,
            ];
            if ($parentTag) {
                $data['parent_uuid'] = $parentTag->uuid;
            }
            $tag->details->map(function (TagDetail $tagDetail) use (&$data) {
                $data['locale'][$tagDetail->language->code] = $tagDetail->tag_name;
            });

            $tagData = TagData::query()->create($data);
            $this->progressBar->advance();
            $childrenTags = $this->blogTags->where('parent_id', $tag->id);
            if ($childrenTags->isNotEmpty()) {
                $this->createTagData($childrenTags, $tagData);
            }
        });
    }
}
