<?php

namespace App\Http\Requests\ProjectManage\Releases;

use App\Http\Requests\BaseRequest;

class ReleaseVersionUpdate extends BaseRequest
{

    public function rules(): array
    {
        return [
            'main_version' => 'required|integer',
            'second_version' => 'required|integer',
            'third_version' => 'required|integer',
            'expected_release_test_time' => 'required|date_format:Y-m-d H:i:s',
            'expected_release_online_time' => 'required|date_format:Y-m-d H:i:s',
        ];
    }

    public function attributes()
    {
        return [
            'main_version' => '主版本号',
            'second_version' => '次版本号',
            'third_version' => '末版本号',
            'expected_release_test_time' => '预计发布测试时间',
            'expected_release_online_time' => '预计发布上线时间',
        ];
    }
}
