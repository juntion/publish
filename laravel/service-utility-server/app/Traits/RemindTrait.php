<?php


namespace App\Traits;

trait RemindTrait
{
    public function getRemind()
    {
        $countSql = ' COUNT(IF(status = ?, 1, null)) ';
        $reviewSql = ' COUNT(IF(review = ?, 1, null ))';
        $statusArr = $this->showRemindData;
        $showDataKeys = [];
        // request 删除status
        $search = request()->input('search', []);
        if (array_key_exists('status', $search)){
            unset($search['status']);
        }
        if (array_key_exists('review', $search)){
            unset($search['review']);
        }
        request()->offsetSet('search', $search);
        $selectRaw = collect($statusArr)->map(function ($item) use ($countSql, &$showDataKeys){
            $showDataKeys[] = 'status' . $item;
            return $countSql . 'AS status' . $item;
        });
        $review = [];
        if (isset($this->showReviewData)){
            $review = $this->showReviewData;
            collect($this->showReviewData)->map(function ($item)use($reviewSql, &$selectRaw, &$showDataKeys){
                $showDataKeys[] = 'review' . $item;
                $selectRaw[] =  $reviewSql . "AS review" . $item;
            });
        }
        $selectRaw = $selectRaw->implode(',');
        $countRes =  $this->queryBuilder()
            ->selectRaw($selectRaw, array_merge($statusArr, $review))
            ->where(function ($q)use($review,$statusArr){
                if($review){
                    $q->whereIn('status', $statusArr)->orWhereIn('review', $review);
                } else {
                    $q->whereIn('status', $statusArr);
                }
            })
            ->first()->only($showDataKeys);
        return $countRes;
    }
}
