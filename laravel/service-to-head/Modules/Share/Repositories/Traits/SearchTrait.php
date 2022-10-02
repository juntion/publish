<?php

namespace Modules\Share\Repositories\Traits;

use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Http\Request;
use Modules\Share\Entities\Collection;
use Modules\Share\Entities\CollectionCategory;
use Modules\Share\Entities\Key;
use Modules\Share\Entities\Resource;
use Modules\Share\Entities\ResourceCategory;
use Modules\Share\Entities\ResourceCustomCategory;
use Modules\Share\Entities\ResourceDownload;
use Modules\Share\Entities\ResourceTag;
use Modules\Share\Entities\Viewed;
use Modules\Share\Exceptions\ElasticSearchException;

trait SearchTrait
{
    protected $paginate = [
        'total'        => 0,
        'current_page' => 1,
        'per_page'     => 0,
        'last_page'    => 1,
    ];
    private $client;


    /**
     * @param  Request  $request
     * @return array
     * @throws \Exception
     */
    public function searchCategoryUuidByKey(Request $request)
    {
        $options = [];
        $key = strtolower($request->input('key'));
        if ($request->has('key') && $key) {
            $options['body']['query']['bool']['must'][] = [
                'bool' => [
                    'should' => [
                        [
                            'match_phrase' => [
                                'name' => $key
                            ]
                        ],
                        [
                            'prefix' => [
                                'name' => $key
                            ]
                        ]
                    ]
                ]
            ];
        }

        if ($parent_uuid = $request->input('parent_uuid')) {
            $options['body']['query']['bool']['must'][] = [
                'term' => [
                    'parent_uuid' => $parent_uuid
                ]
            ];
        } else {
            $options['body']['query']['bool']['must_not'][] = [
                "exists" => [
                    "field" => "two_level_uuid"
                ]
            ];
        }
        try {
            $query = (json_encode($options['body']['query']));
            $res = ResourceCategory::search($query)->paginate();
            $data = $this->paginate($res, $request);
        } catch (\Exception $exception) {
            $data = $this->catchException($exception);
        }
        return $data;
    }

    /**
     * @param $request
     * @param $adminUuid
     * @return array
     * @throws \Exception
     */
    public function searchCollectionCategoryUuidByKey($request, $adminUuid)
    {
        $options = [];
        $key = strtolower($request->input('key'));
        if ($request->has('key') && $key) {
            $options['body']['query']['bool']['must'][] = [
                'bool' => [
                    'should' => [
                        [
                            'match_phrase' => [
                                'name' => $key
                            ]
                        ],
                        [
                            'prefix' => [
                                'name' => $key
                            ]
                        ]
                    ]
                ]
            ];
        }

        if ($parent_uuid = $request->input('parent_uuid')) {
            $options['body']['query']['bool']['must'][] = [
                'term' => [
                    'parent_uuid' => $parent_uuid
                ]
            ];
        } else {
            $options['body']['query']['bool']['must_not'][] = [
                "exists" => [
                    "field" => "two_level_uuid"
                ]
            ];
        }

        // 必须是自己的
        $options['body']['query']['bool']['must'][] = [
            'term' => [
                'admin_uuid' => $adminUuid
            ]
        ];
        // type要一致
        $options['body']['query']['bool']['must'][] = [
            'term' => [
                'type.keyword' => $request->input('filter')['type']
            ]
        ];

        $options['body']['sort'] = [
            ["_score" => ['order' => "DESC"]], // 先按照匹配规则 匹配度高的再前
            ["sort" => ['order' => "ASC"]] // 再按照搜索次数，次数多的在前
        ];
        try {
            $query = (json_encode($options['body']['query']));
            $res = CollectionCategory::search($query)->paginate();
            $data = $this->paginate($res, $request);
        } catch (\Exception $exception) {
            $data = $this->catchException($exception);
        }
        return $data;
    }

    /**
     * @param $request
     * @param $adminUuid
     * @return array
     * @throws \Exception
     */
    public function searchCollectionData($request, $adminUuid)
    {
        $options = [];
        // 必须是自己的
        $options['body']['query']['bool']['must'][] = [
            'term' => [
                'admin_uuid' => $adminUuid
            ]
        ];
        // type要一致
        $options['body']['query']['bool']['must'][] = [
            'term' => [
                'resource_type.keyword' => $request->input('filter')['type']
            ]
        ];
        $key = strtolower($request->input('key'));
        if ($request->has('key') && $key) {
            $options['body']['query']['bool']['must'][] = [
                'bool' => [
                    'should' => [
                        [
                            'match_phrase' => [
                                'resource_name' => $key
                            ]
                        ],
                        [
                            'match_phrase' => [
                                'tag_name' => $key
                            ]
                        ],
                        [
                            'prefix' => [
                                'name' => $key
                            ]
                        ],
                        [
                            'prefix' => [
                                'tag_name' => $key
                            ]
                        ],
                    ]
                ]
            ];
        }
        if ($cate = $request->input('parent_uuid')) {
            $options['body']['query']['bool']['must'][] = [
                'term' => [
                    'category_uuid' => $cate
                ]
            ];
        } else {
            $options['body']['query']['bool']['must_not'][] = [
                'exists' => [
                    'field' => 'category_uuid'
                ]
            ];
        }
        $options['body']['sort'] = [
            ["_score" => ['order' => "DESC"]], // 先按照匹配规则 匹配度高的再前
            ["created_at" => ['order' => "DESC"]] // 再按照搜索次数，次数多的在前
        ];
        try {

            $query = (json_encode($options['body']['query']));
            $res = Collection::search($query)->paginate();
            $data = $this->paginate($res, $request);
        } catch (\Exception $exception) {
            $data = $this->catchException($exception);
        }
        return $data;
    }

    /**
     * @param $request
     * @param $adminUuid
     * @return array
     * @throws \Exception
     */
    public function searchViewedData($request, $adminUuid)
    {
        $options = [];
        // 必须是自己的
        $options['body']['query']['bool']['must'][] = [
            'term' => [
                'admin_uuid' => $adminUuid
            ]
        ];
        // type要一致
        $options['body']['query']['bool']['must'][] = [
            'term' => [
                'resource_type.keyword' => $request->input('filter')['type']
            ]
        ];
        $key = strtolower($request->input('key'));
        if ($request->has('key') && $key) {
            $options['body']['query']['bool']['must'][] = [
                'bool' => [
                    'should' => [
                        [
                            'match_phrase' => [
                                'resource_name' => $key
                            ]
                        ],
                        [
                            'match_phrase' => [
                                'tag_name' => $key
                            ]
                        ],
                        [
                            'prefix' => [
                                'resource_name' => $key
                            ]
                        ],
                        [
                            'prefix' => [
                                'tag_name' => $key
                            ]
                        ]
                    ]
                ]
            ];
        }
        $options['body']['sort'] = [
            ["_score" => ['order' => "DESC"]], // 先按照匹配规则 匹配度高的再前
            ["created_at" => ['order' => "DESC"]] // 再按照搜索次数，次数多的在前
        ];
        try {

            $query = (json_encode($options['body']['query']));
            $res = Viewed::search($query)->paginate();
            $data = $this->paginate($res, $request);
        } catch (\Exception $exception) {
            $data = $this->catchException($exception);
        }
        return $data;
    }


    /**
     * @param $request
     * @param $adminUuid
     * @return array
     * @throws \Exception
     */
    public function searchDownloadData($request, $adminUuid)
    {
        $options = [];
        // 必须是自己的
        $options['body']['query']['bool']['must'][] = [
            'term' => [
                'admin_uuid' => $adminUuid
            ]
        ];
        // type要一致
        $options['body']['query']['bool']['must'][] = [
            'term' => [
                'resource_type.keyword' => $request->input('filter')['type']
            ]
        ];
        $key = strtolower($request->input('key'));
        if ($request->has('key') && $key) {
            $options['body']['query']['bool']['must'][] = [
                'bool' => [
                    'should' => [
                        [
                            'match_phrase' => [
                                'resource_name' => $key
                            ]
                        ],
                        [
                            'match_phrase' => [
                                'tag_name' => $key
                            ]
                        ],
                        [
                            'prefix' => [
                                'resource_name' => $key
                            ]
                        ],
                        [
                            'prefix' => [
                                'tag_name' => $key
                            ]
                        ]
                    ]
                ]
            ];
        }
        $options['body']['sort'] = [
            ["_score" => ['order' => "DESC"]], // 先按照匹配规则 匹配度高的再前
            ["created_at" => ['order' => "DESC"]] // 再按照搜索次数，次数多的在前
        ];
        try {
            $query = (json_encode($options['body']['query']));
            $res = ResourceDownload::search($query)->paginate();
            $data = $this->paginate($res, $request);
        } catch (\Exception $exception) {
            $data = $this->catchException($exception);
        }
        return $data;
    }

    /**
     * @param $request
     * @param $adminUuid
     * @return array
     * @throws \Exception
     */
    public function searchUploadCategoryUuidByKey($request, $adminUuid)
    {
        $options = [];
        $key = strtolower($request->input('key'));
        if ($request->has('key') && $key) {
            $options['body']['query']['bool']['must'][] = [
                'bool' => [
                    'should' => [
                        [
                            'match_phrase' => [
                                'name' => $key
                            ]
                        ],
                        [
                            'prefix' => [
                                'name' => $key
                            ]
                        ]
                    ]
                ]
            ];
        }
        if ($parent_uuid = $request->input('parent_uuid')) {
            $options['body']['query']['bool']['must'][] = [
                'term' => [
                    'parent_uuid' => $parent_uuid
                ]
            ];
        } else {
            $options['body']['query']['bool']['must_not'][] = [
                "exists" => [
                    "field" => "two_level_uuid"
                ]
            ];
        }

        // 必须是自己的
        $options['body']['query']['bool']['must'][] = [
            'term' => [
                'admin_uuid' => $adminUuid
            ]
        ];
        // type要一致
        $options['body']['query']['bool']['must'][] = [
            'term' => [
                'type.keyword' => $request->input('filter')['type']
            ]
        ];

        $options['body']['sort'] = [
            ["_score" => ['order' => "DESC"]], // 先按照匹配规则 匹配度高的再前
            ["sort" => ['order' => "ASC"]] // 再按照搜索次数，次数多的在前
        ];
        try {
            $query = (json_encode($options['body']['query']));
            $res = ResourceCustomCategory::search($query)->paginate();
            $data = $this->paginate($res, $request);
        } catch (\Exception $exception) {
            $data = $this->catchException($exception);
        }
        return $data;
    }

    /**
     * @param $name
     * @return array
     * @throws \Exception
     */
    public function searchTagsNameByKey($name)
    {
        try {
            $options['body']['query']['bool']['must'][] = [
                'bool' => [
                    'should' => [
                        [
                            'match_phrase' => [
                                'name' => $name
                            ]
                        ],
                        [
                            'prefix' => [
                                'name' => $name
                            ]
                        ]
                    ]
                ]
            ];
            $query = json_encode($options['body']['query']);
            return ResourceTag::search($query)->withTrashed()
                ->paginate(10)
                ->map(function ($item) {
                    return $item->only(['uuid', 'name']);
                })->all();
        } catch (\Exception $exception) {
            return $this->catchException($exception, 2);
        }
    }

    /**
     * @param $name
     * @return array
     * @throws \Exception
     */
    public function searchKey($name)
    {
        try {
            return Key::search('', function (Client $search, $query, $options) use ($name) {
                $options['body']['query']['bool']['must'][] = [
                    'bool' => [
                        'should' => [
                            [
                                "match_phrase" => [
                                    'key' => $name
                                ]
                            ],
                            [
                                "prefix" => [
                                    'key' => $name
                                ]
                            ]
                        ]
                    ]
                ];
                $options['body']['sort'] = [
                    ["_score" => ['order' => "DESC"]], // 先按照匹配规则 匹配度高的再前
                    ["count" => ['order' => "DESC"]] // 再按照搜索次数，次数多的在前
                ];
                return $search->search($options);
            })->paginate(10)->map(function ($item) { // 取前15位返回
                    return $item->only(['key', 'count']);
                })->all();
        } catch (\Exception $exception) {
            return $this->catchException($exception, 2);
        }
    }

    /**
     * 搜索+1
     * @param $key
     */
    public function insertHotKey($key)
    {
        $key = Key::query()->firstOrCreate(['key' => $key]);
        $key->increment('count', 1);
        $key->searchable();
    }

    /**
     * @param  Request  $request
     * @param  bool  $is_subject  筛选专题
     * @param  bool  $filter_type 筛选类型
     * @param  bool  $is_mix      是否是混合分页
     * @param  bool  $adminUuid   是否查询当前用户的
     * @param  bool  $customCate  是否是查询用户分类下的
     * @param  bool  $fromCate    是否是搜索分类下的资源
     * @return array
     * @throws \Exception
     */
    public function searchResourceUuidByRequest(
        Request $request,
        $is_subject = false,
        $filter_type = true,
        $is_mix = false,
        $adminUuid = false,
        $customCate = false,
        $fromCate = false
    ) {
        $options = [];
        if ($request->has('key')) {
            $key = strtolower($request->input('key'));
            $options['body']['query']['bool']['must'][] = [
                'bool' => [
                    'should' => [
                        [
                            'match_phrase' => [
                                'name' => $key
                            ]
                        ],
                        [
                            'match_phrase' => [
                                'tag_name' => $key
                            ]
                        ],
                        [
                            'prefix' => [
                                'name' => $key
                            ]
                        ],
                        [
                            'prefix' => [
                                'tag_name' => $key
                            ]
                        ],
                    ]
                ]
            ];
        }
        if ($cate = $request->input('category_uuid')) {
            $options['body']['query']['bool']['must'][] = [
                'terms' => [
                    'cate_uuid' => [$cate]
                ]
            ];
        }
        // 混合分类时 cate 为 parent_uuid
        if ($is_mix) {
            if ($cate = $request->input('parent_uuid')) {
                $options['body']['query']['bool']['must'][] = [
                    'terms' => [
                        'cate_uuid' => [$cate]
                    ]
                ];
            } else {
                $options['body']['query']['bool']['must'][] = [
                    'terms' => [
                        'cate_uuid' => ['noCate']
                    ]
                ];
            }

        }
        // 筛选tag
        if ($tag_uuid = $request->input('tag_uuid')) {
            foreach ($tag_uuid as $id) {
                $options['body']['query']['bool']['must'][] = [
                    'term' => [
                        'tag_uuid' => $id
                    ]
                ];
            }

        }
        if ($filter_type) {
            // 筛选type
            $options['body']['query']['bool']['must'][] = [
                'term' => [
                    'type' => $request->input('filter')['type']
                ]
            ];
        }

        // 筛选 subject
        if ($is_subject) {
            $options['body']['query']['bool']['must'][] = [
                'terms' => [
                    'subject' => [$request->uuid]
                ]
            ];
        }

        if ($adminUuid) { // 筛选
            $options['body']['query']['bool']['must'][] = [
                'term' => [
                    'creator_uuid' => $adminUuid,
                ]
            ];
        }

        if ($customCate) {
            if ($cate = ($request->input('parent_uuid'))) {
                $options['body']['query']['bool']['must'][] = [
                    'term' => [
                        'custom_category_uuid' => $cate
                    ]
                ];
            } else {
                $options['body']['query']['bool']['must_not'][] = [
                    "exists" => [
                        "field" => "custom_category_uuid"
                    ]
                ];
            }
        }
        // 搜索分类下的资源
        if ($fromCate) {
            $options['body']['query']['bool']['must'][] = [
                'terms' => [
                    'cate_uuid' => [$request->uuid]
                ]
            ];
        }
        // 排序
        $options['body']['sort'] = [
            ["_score" => ['order' => "DESC"]], // 先按照匹配规则 匹配度高的再前
            ["created_at" => ['order' => "DESC"]] // 再按照搜索次数，次数多的在前
        ];


        // 官方未解决分页bug  解决方案 https://github.com/ErickTamayo/laravel-scout-elastic/issues/123
        // callback 分页失效

        $query = (json_encode($options['body']['query']));
        try {
            $res = Resource::search($query)->orderBy('created_at', 'DESC')->paginate();
            $res = $this->paginate($res, $request);
        } catch (\Exception $exception) {
            $res = $this->catchException($exception);
        }
        return $res;
    }

    public function paginate($res, $request)
    {
        $uuid = $res->map(function ($r) {
            return $r->uuid;
        })->all();
        $perPage = $request->input('limit') ?? 15;
        $paginate = [
            'total'        => $res->total(),
            'current_page' => $res->currentPage(),
            'per_page'     => intval($perPage),
            'last_page'    => intval(ceil($res->total() / $perPage)),
        ];
        return compact('uuid', 'paginate');
    }

    /**
     * @param  \Exception  $exception
     * @param  int  $type
     * @return array
     * @throws \Exception
     */
    public function catchException(\Exception $exception, $type = 1)
    {
        if($exception instanceof Missing404Exception){ // index 索引未建立的错误
            $res = $type == 1 ? [
                'uuid'     => [],
                'paginate' => $this->paginate
            ] : [];
            return $res;
        } else { // query错误或es服务器等错误
            throw new ElasticSearchException(__('share::admin.search.searchFailed'), $exception->getCode(), $exception);
        }
    }

}
