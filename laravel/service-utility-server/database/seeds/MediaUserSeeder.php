<?php

use App\Models\System\Media;
use App\ProjectManage\Models\Appeal;
use App\ProjectManage\Models\Bug;
use App\ProjectManage\Models\BugAccept;
use App\ProjectManage\Models\Demand;
use App\ProjectManage\Models\DesignSubTask;
use App\ProjectManage\Models\DesignTask;
use App\ProjectManage\Models\DevSubTask;
use App\ProjectManage\Models\DevTask;
use App\ProjectManage\Models\Project;
use App\ProjectManage\Models\TestSubTask;
use App\ProjectManage\Models\TestTask;
use Illuminate\Database\Seeder;

/**
 * 修复附件上传人数据
 */
class MediaUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medias = Media::query()->where('collection_name', '!=', 'avatar')->where('user_id', 0)->with('model')->get();
        $medias->each(function (Media $media) {
            if ($userArr = $this->uploadUser($media)) {
                $media->update($userArr);
            }
        });
    }

    /**
     * 根据模型推出上传人
     * @param $media
     * @return array
     */
    protected function uploadUser($media): array
    {
        $model = $media->model;
        $user = [];

        // 诉求 => 诉求发布人
        if ($model instanceof Appeal) {
            return [
                'user_id' => $model->promulgator_id,
                'user_name' => $model->promulgator_name,
            ];
        }

        // 需求 => 需求发布人
        if ($model instanceof Demand) {
            return [
                'user_id' => $model->promulgator_id,
                'user_name' => $model->promulgator_name,
            ];
        }

        // 项目
        if ($model instanceof Project) {
            // 项目报告=>项目负责人
            if ($media->collection_name == 'project_summary') {
                return [
                    'user_id' => $model->principal_user_id,
                    'user_name' => $model->principal_user_name,
                ];
            }
            // 项目附件 => 项目发布人
            return [
                'user_id' => $model->promulgator_id,
                'user_name' => $model->promulgator_name,
            ];
        }

        // 设计总任务
        if ($model instanceof DesignTask) {
            //设计走查附件 => 走查人
            if ($media->collection_name == DesignTask::reviewMediaCollection) {
                return [
                    'user_id' => $model->reviewer_id,
                    'user_name' => $model->reviewer_name,
                ];
            }
            // 设计总任务附件 => 发布人
            return [
                'user_id' => $model->promulgator_id,
                'user_name' => $model->promulgator_name,
            ];
        }
        // 设计子任务 => 处理人
        if ($model instanceof DesignSubTask) {
            return [
                'user_id' => $model->handler_id,
                'user_name' => $model->handler_name,
            ];
        }

        // 开发总任务
        if ($model instanceof DevTask) {
            return [
                'user_id' => $model->promulgator_id,
                'user_name' => $model->promulgator_name,
            ];
        }
        // 开发子任务
        if ($model instanceof DevSubTask) {
            return [
                'user_id' => $model->handler_id,
                'user_name' => $model->handler_name,
            ];
        }

        // 测试总任务
        if ($model instanceof TestTask) {
            return [
                'user_id' => $model->promulgator_id,
                'user_name' => $model->promulgator_name,
            ];
        }
        // 测试子任务
        if ($model instanceof TestSubTask) {
            return [
                'user_id' => $model->handler_id,
                'user_name' => $model->handler_name,
            ];
        }

        // Bug => 提Bug人
        if ($model instanceof Bug) {
            return [
                'user_id' => $model->promulgator_id,
                'user_name' => $model->promulgator_name,
            ];
        }

        // Bug验收附件 => 验收人
        if ($model instanceof BugAccept) {
            return [
                'user_id' => $model->user_id,
                'user_name' => $model->user_name,
            ];
        }

        return $user;
    }
}
