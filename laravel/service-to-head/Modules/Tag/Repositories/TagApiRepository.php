<?php

namespace Modules\Tag\Repositories;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Tag\Entities\TagData;
use Modules\Tag\Entities\TagDataSource;
use Modules\Tag\Traits\ElasticSearchTrait;

class TagApiRepository
{
    use ElasticSearchTrait;

    /**
     * @param Request $request
     * @return mixed
     */
    public function tags(Request $request)
    {
        $options = [];
        // 标签类型
        if ($type = $request->input('type')) {
            $options['body']['query']['bool']['must'][] = [
                'term' => [
                    'type' => $type,
                ],
            ];
        }
        // 标签状态
        if ($status = $request->input('status')) {
            $options['body']['query']['bool']['must'][] = [
                'term' => [
                    'status' => $status,
                ],
            ];
        }
        // 标签ID
        if ($numbers = $request->input('tags')) {
            $numbers = explode(',', $numbers);
            $options['body']['query']['bool']['must'][] = [
                'terms' => [
                    'number' => $numbers,
                ],
            ];
        }
        // 关键字：标签名称和多语言
        if ($keyword = $request->input('keyword')) {
            if ($langCode = $request->input('language_code')) {
                $keywordQuery['bool']['should'] = $this->shouldKeywordQuery($keyword, ["locale.{$langCode}"]);
            } else {
                $keywordQuery['bool']['should'] = $this->shouldKeywordQuery($keyword, ['name']);
            }
            $options['body']['query']['bool']['must'][] = $keywordQuery;
        }

        $queryJson = isset($options['body']['query']) ? json_encode($options['body']['query']) : '';
        $tagDatas = TagData::search($queryJson)->take(1000);

        try {
            if ($random = $request->input('random')) {
                $tagDatas = $tagDatas->get();
                if ($tagDatas->count() < $random) {
                    $result = $tagDatas;
                } else {
                    $result = $tagDatas->random($random);
                }
            } else {
                if ($page = $request->input('page')) {
                    $perPage = (int)($request->input('limit') ?? 15);
                    return $tagDatas->paginate($perPage);
                }
                // 无分页返回所有
                $result = $tagDatas->get();
            }
        } catch (\Exception $e) {
            return $this->catchESException($e);
        }
        return $result;
    }

    /**
     * 分页
     * @param LengthAwarePaginator $res
     * @param $perPage
     * @return array
     */
    public function paginate(LengthAwarePaginator $res, $perPage)
    {
        $paginate = [
            'total' => $res->total(),
            'current_page' => $res->currentPage(),
            'per_page' => (int)$perPage,
            'last_page' => (int)ceil($res->total() / $perPage),
            'from' => $res->firstItem(),
            'to' => $res->lastItem(),
        ];
        return $paginate;
    }

    /**
     * 通过标签查找数据源信息
     * @param Request $request
     * @return array
     */
    public function source(Request $request)
    {
        $tags = TagData::query()->whereIn('number', explode(',', $request->input('tags')))->get();
        // 递归查询子级标签
        $childTags = collect();
        if ($request->input('recursion')) {
            foreach ($tags as $tag) {
                $match = ['match' => ['path' => $tag->uuid]];
                try {
                    $childTag = TagData::search(json_encode($match))->take(1000)->get();
                } catch (\Exception $e) {
                    $childTag = $this->catchESException($e);
                }
                $childTags = $childTags->merge($childTag);
            }
        }
        $allTags = $tags->merge($childTags);
        if ($request->has('level')) {
            $levels = explode(',', $request->input('level'));
            $allTags = $allTags->whereIn('level', $levels);
        }

        $options = [];
        $options['body']['query']['bool']['must'][] = [
            'terms' => [
                'tag_data_uuid' => $allTags->pluck('uuid')->toArray(),
            ],
        ];
        if ($request->has('model_types')) {
            $modelTypes = explode(',', $request->input('model_types'));
            $options['body']['query']['bool']['must'][] = [
                'terms' => [
                    'model_type' => $modelTypes,
                ],
            ];
        }
        $sources = TagDataSource::search(json_encode($options['body']['query']));
        // 分页
        $paginate = null;
        try {
            if ($page = $request->input('page')) {
                $perPage = (int)($request->input('limit') ?? 15);
                $sources = $sources->paginate($perPage);
                $paginate = $this->paginate($sources, $perPage);
            } else {
                $sources = $sources->take(1000)->get();
            }
        } catch (\Exception $e) {
            return $this->catchESException($e);
        }
        $sources->load('tag');
        $source = $sources->map(function ($item) {
            return [
                'number' => $item->tag->number,
                'tagDataSource' => [
                    'model_id' => $item->model_id,
                    'model_type' => $item->model_type,
                ],
            ];
        });

        $tags = $allTags->map(function ($item) {
            return [
                'number' => $item->number,
                'name' => $item->name,
                'level' => $item->level,
                'status' => $item->status,
                'locale' => $item->locale,
                'type' => $item->type,
                'url_name' => $item->url_name,
            ];
        })->values();

        $result = [
            'source' => $source,
            'tags' => $tags,
        ];
        if ($paginate) {
            $result['paginate'] = $paginate;
        }
        return $result;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function sourceTags(Request $request)
    {
        $modelIds = explode(',', $request->input('model_ids'));
        $modeType = $request->input('model_type');

        $options = [];
        $options['body']['query']['bool']['must'][] = [
            'terms' => [
                'model_id' => $modelIds,
            ],
        ];
        $options['body']['query']['bool']['must'][] = [
            'term' => [
                'model_type' => $modeType,
            ],
        ];
        if ($tagType = $request->input('type')) {
            $options['body']['query']['bool']['must'][] = [
                'term' => [
                    'tag_type' => $tagType,
                ],
            ];
        }
        try {
            $source = TagDataSource::search(json_encode($options['body']['query']))->take(1000)->get();
        } catch (\Exception $e) {
            return $this->catchESException($e);
        }
        $source->load('tag');
        $source = $source->map(function ($item) {
            $tag = $item->tag;
            return [
                'model_id' => $item->model_id,
                'model_type' => $item->model_type,
                'tags' => [
                    'number' => $tag->number,
                    'name' => $tag->name,
                    'level' => $tag->level,
                    'status' => $tag->status,
                    'locale' => $tag->locale,
                    'type' => $tag->type,
                    'url_name' => $tag->url_name,
                ],
            ];
        });

        return $source;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function search(Request $request)
    {
        // 关键词，name或locale的内容
        $keyword = $request->input('keyword');

        if ($languageCode = $request->input('language_code')) {
            $options['body']['query']['bool']['should'] = $this->shouldKeywordQuery($keyword, ['name']);
        } else {
            $options['body']['query']['bool']['should'] = $this->shouldKeywordQuery($keyword, ["locale.{$languageCode}"]);
        }
        try {
            $tags = TagData::search(json_encode($options['body']['query']))->take(1000)->get();
        } catch (\Exception $e) {
            $tags = $this->catchESException($e, collect());
        }

        // 搜索数据绑定
        $query['body']['query']['bool']['must'][] = [
            'terms' => [
                'tag_data_uuid' => $tags->pluck('uuid')->toArray(),
            ],
        ];
        if ($modelTypes = $request->input('model_types')) {
            $query['body']['query']['bool']['must'][] = [
                'terms' => [
                    'model_type' => explode(',', $modelTypes),
                ],
            ];
        }
        try {
            $dataSources = TagDataSource::search(json_encode($query['body']['query']))->take(1000)->get();
        } catch (\Exception $e) {
            return $this->catchESException($e);
        }
        $result = [];
        foreach ($tags as $tag) {
            $tagDataSource = $dataSources->where('tag_data_uuid', $tag->uuid);
            $result[] = [
                'number' => $tag->number,
                'tagDataSource' => $tagDataSource->map(function ($item) {
                    return [
                        'model_id' => $item->model_id,
                        'model_type' => $item->model_type,
                    ];
                })->toArray(),
            ];
        }
        return $result;
    }

    /**
     * 创建或更新数据与标签的关联
     * @param array $data
     */
    public function update(array $data)
    {
        $tagNumbers = explode(',', $data['tags']);
        $tags = TagData::query()->whereIn('number', $tagNumbers)->get();
        // 删除
        $tagUuids = $tags->pluck('uuid')->toArray();
        $deleteDataSources = TagDataSource::query()
            ->where('model_id', $data['model_id'])
            ->where('model_type', $data['model_type'])
            ->whereNotIn('tag_data_uuid', $tagUuids)
            ->get();
        $deleteDataSources->each(function (TagDataSource $dataSource) {
            $dataSource->delete();
        });

        foreach ($tags as $tag) {
            $sourceData = $data;
            $sourceData['tag_data_uuid'] = $tag->uuid;
            $sourceData['priority'] = 0;
            unset($sourceData['tags']);
            TagDataSource::query()->updateOrCreate([
                'tag_data_uuid' => $tag->uuid,
                'model_id' => $data['model_id'],
                'model_type' => $data['model_type'],
            ], $sourceData);
        }
    }

    /**
     * @param array $relatedData
     */
    public function batchUpdate(array $relatedData)
    {
        foreach ($relatedData as $item) {
            $this->update($item);
        }
    }
}
