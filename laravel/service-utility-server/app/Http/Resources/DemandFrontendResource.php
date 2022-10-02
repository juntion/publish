<?php

namespace App\Http\Resources;

use App\Enums\ProjectManage\TaskType;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DemandFrontendResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [];
        $data[] = [
            'type' => TaskType::TASK_TYPE_FRONTEND,
            'number' => $this->number,
            'principal_user_name' => $this->main_principal_user_name,
            'follower_name' => "",
            'expiration_date' => $this->expiration_date,
            'start_date' => "",
            'finish_date' => "",
            'expected_time' => "",
            'actual_time' => "",
            'overdue_time' => "",
            'status' => $this->status,
            'status_desc' => $this->status_desc,
            'task_type' => TaskType::TYPE_MAIN,
            'role_type' => '',
        ];

        $this->subTasks()->get()->map(function ($item) use (&$data) {
            $overdue_time = "";
            if (!is_null($item->expiration_date)) {
                if ($item->finish_time && (date('Y-m-d', strtotime($item->finish_time)) > $item->expiration_date)) {
                    $overdue_time = Carbon::parse($item->finish_time)->diffInDays($item->expiration_date);
                } else if (date('Y-m-d', time()) > $item->expiration_date) {
                    $overdue_time = Carbon::parse(date('Y-m-d', time()))->diffInDays($item->expiration_date);
                }
            }
            $data[] = [
                'type' => TaskType::TASK_TYPE_FRONTEND,
                'number' => $item->number,
                'principal_user_name' => $this->principal_user_name,
                'follower_name' => $item->handler_name,
                'expiration_date' => $item->expiration_date,
                'start_date' => $item->start_time,
                'finish_date' => $item->finish_time,
                'expected_time' => $item->expiration_date ? Carbon::parse($item->created_at)->diffInDays($item->expiration_date) + 1 : '',
                'actual_time' => $item->start_time && $item->finish_time ? Carbon::parse($item->start_time)->diffInDays($item->finish_time) + 1 : "",
                'overdue_time' => $overdue_time,
                'status' => empty($item->handler_id) ? $this->status : $item->status,
                'status_desc' => empty($item->handler_id) ? $this->status_desc : $item->status_desc,
                'is_main' => $item->is_main,
                'role_type' => '',
                'task_type' => TaskType::TYPE_SUB_TASK,
            ];
        });

        return $data;
    }
}
