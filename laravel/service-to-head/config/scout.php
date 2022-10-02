<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Search Engine
    |--------------------------------------------------------------------------
    |
    | This option controls the default search connection that gets used while
    | using Laravel Scout. This connection is used when syncing all models
    | to the search service. You should adjust this based on your needs.
    |
    | Supported: "algolia", "null"
    |
    */

    'driver' => env('SCOUT_DRIVER', 'algolia'),

    /*
    |--------------------------------------------------------------------------
    | Index Prefix
    |--------------------------------------------------------------------------
    |
    | Here you may specify a prefix that will be applied to all search index
    | names used by Scout. This prefix may be useful if you have multiple
    | "tenants" or applications sharing the same search infrastructure.
    |
    */

    'prefix' => env('SCOUT_PREFIX', ''),

    /*
    |--------------------------------------------------------------------------
    | Queue Data Syncing
    |--------------------------------------------------------------------------
    |
    | This option allows you to control if the operations that sync your data
    | with your search engines are queued. When this is set to "true" then
    | all automatic data syncing will get queued for better performance.
    |
    */

     // 'queue' => env('SCOUT_QUEUE', false),
      'queue' => [
          'queue' => env('SCOUT_QUEUE_NAME'),
          'connection' => env('SCOUT_QUEUE_CONNECTION'),
      ],

    /*
    |--------------------------------------------------------------------------
    | Chunk Sizes
    |--------------------------------------------------------------------------
    |
    | These options allow you to control the maximum chunk size when you are
    | mass importing data into the search engine. This allows you to fine
    | tune each of these chunk sizes based on the power of the servers.
    |
    */

    'chunk' => [
        'searchable' => 100,
        'unsearchable' => 100,
    ],

    /*
    |--------------------------------------------------------------------------
    | Soft Deletes
    |--------------------------------------------------------------------------
    |
    | This option allows to control whether to keep soft deleted records in
    | the search indexes. Maintaining soft deleted records can be useful
    | if your application still needs to search for the records later.
    |
    */

    'soft_delete' => true,

    /*
    |--------------------------------------------------------------------------
    | Identify User
    |--------------------------------------------------------------------------
    |
    | This option allows you to control whether to notify the search engine
    | of the user performing the search. This is sometimes useful if the
    | engine supports any analytics based on this application's users.
    |
    | Supported engines: "algolia"
    |
    */

    'identify' => env('SCOUT_IDENTIFY', false),

    /*
    |--------------------------------------------------------------------------
    | Algolia Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Algolia settings. Algolia is a cloud hosted
    | search engine which works great with Scout out of the box. Just plug
    | in your application ID and admin API key to get started searching.
    |
    */

    'algolia' => [
        'id' => env('ALGOLIA_APP_ID', ''),
        'secret' => env('ALGOLIA_SECRET', ''),
    ],
    'elastic-search' => [
        'hosts' => [
            [
                'host'   => env('ELASTICSEARCH_HOST', 'localhost'),
                'port'   => env('ELASTICSEARCH_PORT', '9200'),
                'scheme' => env('ELASTICSEARCH_SCHEME', 'https'),
                'path'   => env('ELASTICSEARCH_PATH', '/elastic'),
                'user'   => env('ELASTICSEARCH_USER', null),
                'pass'   => env('ELASTICSEARCH_PASS', null),
            ],
        ],
    ],
    /**
     * 建议将该参数移到枚举类或其他静态数据文件中，修改SeedEsCommand调用即可
     *
     * 添加需要同步es的model类  执行scout:import or scout:flush 批量操作
     */
    'models' => [
        'Admin' => [
            \Modules\Admin\Entities\Admin::class
        ],
        'Share' => [
            \Modules\Share\Entities\Resource::class,
            \Modules\Share\Entities\ResourceTag::class,
            \Modules\Share\Entities\Key::class,
            \Modules\Share\Entities\Subject::class,
            \Modules\Share\Entities\ResourceCategory::class,
            \Modules\Share\Entities\ResourceCustomCategory::class,
            \Modules\Share\Entities\CollectionCategory::class,
            \Modules\Share\Entities\ResourceDownload::class,
            \Modules\Share\Entities\Viewed::class,
        ],
        'Tag' => [
            \Modules\Tag\Entities\TagData::class,
            \Modules\Tag\Entities\TagDataSource::class,
        ],
        'Finance' => [
            \Modules\Finance\Entities\PaymentReceipt::class,
            \Modules\Finance\Entities\PaymentVoucher::class,
            \Modules\Finance\Entities\Invoice::class,
        ]
    ],
];
