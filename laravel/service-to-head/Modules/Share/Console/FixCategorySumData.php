<?php


namespace Modules\Share\Console;


use Illuminate\Console\Command;
use Modules\Share\Entities\CollectionCategory;
use Modules\Share\Entities\ResourceCategory;
use Modules\Share\Entities\ResourceCustomCategory;

class FixCategorySumData extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'share:fix-category-sum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '修正分类下资源sum数据错误';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 前台显示分类
        ResourceCategory::query()
            ->withTrashed()
            ->whereNotNull('three_level_uuid')
            ->where('uuid', '!=', 'three_level_uuid')
            ->with('resources')
            ->get()
            ->map(function ($item){
               $item->update([
                   'sum' => $item->resources->count()
               ]);
            });
        $cols = ['three_level_uuid', 'two_level_uuid', 'one_level_uuid'];
        foreach ($cols as $col) {
            ResourceCategory::query()
                ->where('uuid', '=', $col)
                ->with('resources')
                ->with(['children' => function($query){
                    $query->withTrashed();
                }])
                ->withTrashed()
                ->get()
                ->map(function ($item){
                    $sum1 = $item->children->sum(function ($child){
                        return $child->sum;
                    });
                    $item->update([
                        'sum' => $item->resources->count() + $sum1
                    ]);
                });
        }

        // 用户分类
        ResourceCustomCategory::query()
            ->whereNotNull('three_level_uuid')
            ->where('uuid', '!=', 'three_level_uuid')
            ->with('resources')
            ->get()
            ->map(function ($item){
                $item->update([
                    'sum' => $item->resources->count()
                ]);
            });
        foreach ($cols as $col) {
            ResourceCustomCategory::query()
                ->with('children')
                ->with('resources')
                ->where('uuid', '=', $col)
                ->get()
                ->map(function ($item){
                    $sum1 = $item->children->sum(function ($child){
                        return $child->sum;
                    });
                    $item->update([
                        'sum' => $item->resources->count() + $sum1
                    ]);
                });
        }

        // 收藏分类
        CollectionCategory::query()
            ->whereNotNull('three_level_uuid')
            ->where('uuid', '!=', 'three_level_uuid')
            ->with('collections')
            ->get()
            ->map(function ($item){
                $item->update([
                    'sum' => $item->collections->count()
                ]);
            });
        foreach ($cols as $col) {
            CollectionCategory::query()
                ->where('uuid', '=', $col)
                ->with('collections')
                ->with('children')
                ->get()
                ->map(function ($item){
                    $sum1 = $item->children->sum(function ($child){
                        return $child->sum;
                    });
                    $item->update([
                        'sum' => $item->collections->count() + $sum1
                    ]);
                });
        }
    }
}
