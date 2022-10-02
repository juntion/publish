<?php

namespace App\Observers;

use App\Enums\ProjectManage\DemandLinksGroup;
use App\Enums\ProjectManage\DemandLinksType;
use App\ProjectManage\Models\DemandLink;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class DemandLinksObserver
{
    public function updated(DemandLink $demandLink)
    {
        /** 更新时需分情况
         * 1. 设计：
         * 1-1 更新了负责人和备注
         * 1-2 仅更新了负责人
         * 1-3 仅跟新了备注
         * 2. 开发
         * 同设计
         * 3. 测试：
         * 3-1 更新了测试类型 :更新测试类型时 必定更新了负责人
         * 3-2 未更新测试类型
         */
        $key = 'demand_id_' . $demandLink->demand_id . '_user_id_' . Auth::id();
        $change = $demandLink->demand->getUpdatedChanges($key);
        $demandLinkChanges = [];
        if ($change !== false){
            switch ($demandLink->type) {
                case DemandLinksType::TYPE_DESIGN:
                    $demandLinkChanges['name'] = '更新设计环节';
                    $old = "";
                    $new = "";
                    if ($demandLink->isDirty('principal_user_name')) {
                        $old .= "负责人：" . $demandLink->getOriginal('principal_user_name');
                        $new .= "负责人：" . $demandLink->principal_user_name;
                    }
                    if ($demandLink->isDirty('comment')) {
                        $old .= "备注：" . $demandLink->getOriginal('comment');
                        $new .= "备注：" . $demandLink->comment;
                    }
                    $demandLinkChanges['old'] = $old;
                    $demandLinkChanges['new'] = $new;
                    break;
                case DemandLinksType::TYPE_DEVELOP:
                    $demandLinkChanges['name'] = '更新开发环节';
                    $old = "";
                    $new = "";
                    if ($demandLink->isDirty('principal_user_name')) {
                        $old .= "负责人：" . $demandLink->getOriginal('principal_user_name');
                        $new .= "负责人：" . $demandLink->principal_user_name;
                    }
                    if ($demandLink->isDirty('comment')) {
                        $old .= "备注：" . $demandLink->getOriginal('comment');
                        $new .= "备注：" . $demandLink->comment;
                    }
                    $demandLinkChanges['old'] = $old;
                    $demandLinkChanges['new'] = $new;
                    break;
                case DemandLinksType::TYPE_TEST:
                    $demandLinkChanges['name'] = '更新测试环节';
                    $old = '';
                    $new = '';
                    if ($demandLink->isDirty('group')){
                        $old .= '测试类型：' . DemandLinksGroup::getTestType($demandLink->getOriginal('group')) . "负责人：" . $demandLink->getOriginal('principal_user_name') ;
                        $new .= '测试类型：' . DemandLinksGroup::getTestType($demandLink->group) . "负责人：" . $demandLink->principal_user_name;
                    } else {
                        $old .= "负责人：" . $demandLink->getOriginal('principal_user_name') ;
                        $new .= "负责人：" . $demandLink->principal_user_name;
                    }
                    if ($demandLink->isDirty('comment')) {
                        $old .= "备注：" . $demandLink->getOriginal('comment');
                        $new .= "备注：" . $demandLink->comment;
                    }
                    $demandLinkChanges['old'] = $old;
                    $demandLinkChanges['new'] = $new;
                    break;
                case DemandLinksType::TYPE_FRONTEND:
                    $demandLinkChanges['name'] = '更新前端开发环节';
                    $old = "";
                    $new = "";
                    if ($demandLink->isDirty('principal_user_name')) {
                        $old .= "负责人：" . $demandLink->getOriginal('principal_user_name');
                        $new .= "负责人：" . $demandLink->principal_user_name;
                    }
                    if ($demandLink->isDirty('comment')) {
                        $old .= "备注：" . $demandLink->getOriginal('comment');
                        $new .= "备注：" . $demandLink->comment;
                    }
                    $demandLinkChanges['old'] = $old;
                    $demandLinkChanges['new'] = $new;
                    break;
                case DemandLinksType::TYPE_MOBILE:
                    $demandLinkChanges['name'] = '更新移动端开发环节';
                    $old = "";
                    $new = "";
                    if ($demandLink->isDirty('principal_user_name')) {
                        $old .= "负责人：" . $demandLink->getOriginal('principal_user_name');
                        $new .= "负责人：" . $demandLink->principal_user_name;
                    }
                    if ($demandLink->isDirty('comment')) {
                        $old .= "备注：" . $demandLink->getOriginal('comment');
                        $new .= "备注：" . $demandLink->comment;
                    }
                    $demandLinkChanges['old'] = $old;
                    $demandLinkChanges['new'] = $new;
                    break;
            }
            $demandLink->demand->updateCacheOfUpdated($key, $demandLinkChanges);
        }

    }


    public function created(DemandLink $demandLink)
    {
        $key = 'demand_id_' . $demandLink->demand_id . '_user_id_' . Auth::id();
        $change = $demandLink->demand->getUpdatedChanges($key);
        $demandLinkChanges = [];
        if ($change !== false){
            switch ($demandLink->type){
                case DemandLinksType::TYPE_DESIGN:
                    $demandLinkChanges['name'] = '新增设计环节';
                    $demandLinkChanges['old'] = "";
                    $demandLinkChanges['new'] = "负责人：" . $demandLink->principal_user_name . '备注:' . $demandLink->comment;
                    break;
                case DemandLinksType::TYPE_DEVELOP:
                    $demandLinkChanges['name'] = '新增开发环节';
                    $demandLinkChanges['old'] = "";
                    $demandLinkChanges['new'] = "负责人：" . $demandLink->principal_user_name . '备注:' . $demandLink->comment;
                    break;
                case DemandLinksType::TYPE_TEST:
                    $demandLinkChanges['name'] = '新增测试环节';
                    $demandLinkChanges['old'] = "";
                    $demandLinkChanges['new'] = "负责人：" . $demandLink->principal_user_name . '备注:' . $demandLink->comment . '测试类型：' . DemandLinksGroup::getTestType($demandLink->group);
                    break;
                case DemandLinksType::TYPE_FRONTEND:
                    $demandLinkChanges['name'] = '新增前端开发环节';
                    $demandLinkChanges['old'] = "";
                    $demandLinkChanges['new'] = "负责人：" . $demandLink->principal_user_name . '备注:' . $demandLink->comment;
                    break;
                case DemandLinksType::TYPE_MOBILE:
                    $demandLinkChanges['name'] = '新增移动端开发环节';
                    $demandLinkChanges['old'] = "";
                    $demandLinkChanges['new'] = "负责人：" . $demandLink->principal_user_name . '备注:' . $demandLink->comment;
                    break;
            }
            $demandLink->demand->updateCacheOfUpdated($key, $demandLinkChanges);
        }
    }


    public function deleted(DemandLink $demandLink)
    {
        $key = 'demand_id_' . $demandLink->demand_id . '_user_id_' . Auth::id();
        $change = $demandLink->demand->getUpdatedChanges($key);
        $demandLinkChanges = [];
        if ($change !== false){
            switch ($demandLink->type){
                case DemandLinksType::TYPE_DESIGN:
                    $demandLinkChanges['name'] = '删除设计环节负责人';
                    $demandLinkChanges['new'] = "";
                    $demandLinkChanges['old'] = "负责人：" . $demandLink->principal_user_name . '备注:' . $demandLink->comment;
                    break;
                case DemandLinksType::TYPE_DEVELOP:
                    $demandLinkChanges['name'] = '删除开发环节负责人';
                    $demandLinkChanges['new'] = "";
                    $demandLinkChanges['old'] = "负责人：" . $demandLink->principal_user_name . '备注:' . $demandLink->comment;
                    break;
                case DemandLinksType::TYPE_TEST:
                    $demandLinkChanges['name'] = '删除测试环节负责人';
                    $demandLinkChanges['new'] = "";
                    $demandLinkChanges['old'] = "负责人：" . $demandLink->principal_user_name . '备注:' . $demandLink->comment . '测试类型：' . DemandLinksGroup::getTestType($demandLink->group);
                    break;
                case DemandLinksType::TYPE_FRONTEND:
                    $demandLinkChanges['name'] = '删除前端开发环节负责人';
                    $demandLinkChanges['new'] = "";
                    $demandLinkChanges['old'] = "负责人：" . $demandLink->principal_user_name . '备注:' . $demandLink->comment;
                    break;
                case DemandLinksType::TYPE_MOBILE:
                    $demandLinkChanges['name'] = '删除移动端开发环节负责人';
                    $demandLinkChanges['new'] = "";
                    $demandLinkChanges['old'] = "负责人：" . $demandLink->principal_user_name . '备注:' . $demandLink->comment;
                    break;
            }
            $demandLink->demand->updateCacheOfUpdated($key, $demandLinkChanges);
        }
    }
}
