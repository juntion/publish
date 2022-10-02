<?php


namespace App\Http\Resources;


use App\Enums\ProjectManage\TaskType;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DemandDesignResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [];
        $data[] = $this->getTaskData();
        if ($this->parts->isEmpty()) {
            return $data;
        } else {
            $this->parts()->get()->map(function ($part) use (&$data) {

                $data[] = $this->getPartData($part);

                $part->subTasks()->get()->map(function ($val) use (&$data, $part) {
                    $data[] = $this->getSubTasKData($val, $part);
                });
            });
        };
        return $data;
    }

    public function getTaskData()
    {
        $overdue_time = "";
        if ($this->finish_time && !is_null($this->expiration_date)){
            if (date('Y-m-d', strtotime($this->finish_time)) > $this->expiration_date){
                $overdue_time = Carbon::parse($this->finish_time)->diffInDays($this->expiration_date);
            }
        } else if (date('Y-m-d', time())> $this->expiration_date && !is_null($this->expiration_date)){
            $overdue_time = Carbon::parse($this->finish_time)->diffInDays($this->expiration_date);
        }
        return [
            'type'                => 'design',
            'number'              => $this->number,
            'principal_user_name' => $this->principal_user_name,
            'follower_name'       => "",
            'expiration_date'     => $this->expiration_date,
            'start_date'          => $this->start_time,
            'finish_date'         => $this->finish_time,
            'expected_time'       => $this->expiration_date ? Carbon::parse($this->created_at)->diffInDays($this->expiration_date) + 1 : '',
            'actual_time'         => $this->start_time && $this->finish_time ? Carbon::parse($this->start_time)->diffInDays($this->finish_time) + 1 : "",
            'overdue_time'        => $overdue_time,
            'status'              => $this->status,
            'status_desc'         => $this->status_desc,
            'task_type'           => TaskType::TYPE_MAIN,
            'role_type'           => '',
        ];
    }


    public function getPartData($item)
    {
        $overdue_time = "";
        if ($item->finish_time && !is_null($item->expiration_date)){
            if (date('Y-m-d', strtotime($item->finish_time)) > $item->expiration_date){
                $overdue_time = Carbon::parse($item->finish_time)->diffInDays($item->expiration_date);
            }
        } else if (date('Y-m-d', time())> $item->expiration_date && !is_null($item->expiration_date)){
            $overdue_time = Carbon::parse($item->finish_time)->diffInDays($item->expiration_date);
        }
        return [
            'type'                => 'design',
            'number'              => $item->number,
            'principal_user_name' => $item->principal_user_name,
            'follower_name'       => "",
            'expiration_date'     => $item->expiration_date,
            'start_date'          => $item->start_time,
            'finish_date'         => $item->finish_time,
            'expected_time'       => $this->expiration_date ? Carbon::parse($item->created_at)->diffInDays($item->expiration_date) + 1 : '',
            'actual_time'         => $item->start_time && $item->finish_time ? Carbon::parse($item->start_time)->diffInDays($item->finish_time) + 1 : "",
            'overdue_time'        => $overdue_time,
            'status'              => $item->status,
            'status_desc'         => $item->status_desc,
            'task_type'           => TaskType::TYPE_PART,
            'role_type'           => $item->type,
        ];
    }


    public function getSubTasKData($item, $part)
    {
        $overdue_time = "";
        if ($item->finish_time && !is_null($item->expiration_date)){
            if (date('Y-m-d', strtotime($item->finish_time)) > $item->expiration_date){
                $overdue_time = Carbon::parse($item->finish_time)->diffInDays($item->expiration_date);
            }
        } else if (date('Y-m-d', time())> $item->expiration_date && !is_null($item->expiration_date)){
            $overdue_time = Carbon::parse($item->finish_time)->diffInDays($item->expiration_date);
        }
        return [
            'type'                => 'design',
            'number'              => $item->number,
            'principal_user_name' => $part->principal_user_name,
            'follower_name'       => $item->handler_name,
            'expiration_date'     => $item->expiration_date,
            'start_date'          => $item->start_time,
            'finish_date'         => $item->finish_time,
            'expected_time'       => $item->expiration_date ? Carbon::parse($item->created_at)->diffInDays($item->expiration_date) + 1 : '',
            'actual_time'         => $item->start_time && $item->finish_time ? Carbon::parse($item->start_time)->diffInDays($item->finish_time) + 1 : "",
            'overdue_time'        => $overdue_time,
            'status'              => empty($item->handler_id) ? $part->status : $item->status,
            'status_desc'         => empty($item->handler_id) ? $part->status_desc : $item->status_desc,
            'is_main'             => $item->is_main,
            'role_type'           => $part->type,
            'task_type'           => TaskType::TYPE_SUB_TASK,
        ];
    }
}
