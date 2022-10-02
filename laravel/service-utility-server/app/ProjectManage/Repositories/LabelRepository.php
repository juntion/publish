<?php

namespace App\ProjectManage\Repositories;

use App\ProjectManage\Models\Label;
use App\ProjectManage\Models\LabelCategory;

class LabelRepository
{
    /**
     * 获取标签
     * @param $category
     * @param $isOpen
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getLabels(LabelCategory $category, $isOpen)
    {
        if ($isOpen) {
            return $category->labels()->isOpen()->orderBy('sort', 'asc')->get();
        }
        return $category->labels()->orderBy('sort', 'asc')->get();
    }

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function create($data)
    {
        $lastLabel = Label::query()->orderBy('sort', 'desc')->first();
        $category = LabelCategory::query()->find($data['label_category_id']);
        $data['style'] = $category->style;
        $data['sort'] = $lastLabel ? ($lastLabel->sort + 1) : 0;
        return Label::query()->create($data);
    }

    /**
     * @param Label $label
     * @param $data
     * @return bool
     */
    public function update(Label $label, $data)
    {
        if ($data['is_open'] == 1) {
            $label->category()->first()->update(['is_open' => 1]);
        }
        return $label->update($data);
    }

    /**
     * @param $data
     */
    public function sort($data)
    {
        foreach ($data as $item) {
            Label::query()->find($item['label_id'])
                ->update(['sort' => $item['sort']]);
        }
    }
}
