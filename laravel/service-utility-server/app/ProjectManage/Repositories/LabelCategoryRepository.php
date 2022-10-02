<?php

namespace App\ProjectManage\Repositories;

use App\ProjectManage\Models\LabelCategory;

class LabelCategoryRepository
{
    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function create($data)
    {
        $lastCategory = LabelCategory::query()->orderBy('sort', 'desc')->first();
        $data['sort'] = $lastCategory ? ($lastCategory->sort + 1) : 0;
        return LabelCategory::query()->create($data);
    }

    /**
     * @param LabelCategory $category
     * @param $data
     * @return bool
     */
    public function update(LabelCategory $category, $data)
    {
        $labels = $category->labels()->get();
        $labels->each(function ($label) use ($data) {
            $label->update(['style' => $data['style']]);
        });
        // 标签分类关闭时，分类下面的标签也关闭
        if ($data['is_open'] == 0) {
            $labels->each(function ($label) {
                $label->update(['is_open' => 0]);
            });
        }
        return $category->update($data);
    }

    /**
     * @param $data
     */
    public function sort($data)
    {
        foreach ($data as $item) {
            LabelCategory::query()->find($item['label_category_id'])
                ->update(['sort' => $item['sort']]);
        }
    }

    /**
     * @param $isOpen
     * @param bool $withLabels
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCategories($isOpen, $withLabels = false)
    {
        $categories = LabelCategory::query();
        if ($isOpen) {
            $categories->isOpen();
        }
        if ($withLabels) {
            $categories->with(['labels' => function ($query) use ($isOpen) {
                if ($isOpen) {
                    $query->isOpen();
                }
                $query->orderBy('sort', 'asc');
            }]);
        }
        return $categories->orderBy('sort', 'asc')->get();
    }
}
