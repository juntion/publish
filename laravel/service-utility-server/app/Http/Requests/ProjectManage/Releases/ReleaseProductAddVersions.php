<?php

namespace App\Http\Requests\ProjectManage\Releases;

use App\Http\Requests\BaseRequest;

class ReleaseProductAddVersions extends BaseRequest
{

    public function rules(): array
    {
        return [
            'version_plan' => 'required|array',
            'version_plan.*.main_version' => 'required|integer',
            'version_plan.*.second_version' => 'required|integer',
            'version_plan.*.third_version' => 'required|integer',
            'version_plan.*.expected_release_test_time' => 'required|date_format:Y-m-d H:i:s',
            'version_plan.*.expected_release_online_time' => 'required|date_format:Y-m-d H:i:s',
        ];
    }

    public function attributes()
    {
        return [
            'version_plan' => '版本计划',
            'version_plan.*.main_version' => '主版本号',
            'version_plan.*.second_version' => '次版本号',
            'version_plan.*.third_version' => '末版本号',
            'version_plan.*.expected_release_test_time' => '预计发布测试时间',
            'version_plan.*.expected_release_online_time' => '预计发布上线时间',
        ];
    }
}
