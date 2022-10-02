<?php


namespace App\Http\Requests\Project;


use Illuminate\Foundation\Http\FormRequest;

class ProjectSummaryRequest  extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "project_summary" => ['required', 'file']
        ];
    }

    public function messages()
    {
        return [
            'project_summary.required'  => '项目总结文件不能为空',
            'project_summary.file'      => '项目总结文件必须是一个文件',
        ];
    }
}

{

}
