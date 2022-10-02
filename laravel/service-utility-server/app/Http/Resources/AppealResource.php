<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $appealData = parent::toArray($request);
        $appealData['labels'] = LabelResource::collection($this->whenLoaded('labels'));
        $appealData['products'] = ProductResource::collection($this->whenLoaded('products'));
        $appealData['user_attentions'] = UserAttentionResource::collection($this->whenLoaded('attentionAble'));
        $appealData['operation_logs'] = ActivityLogResource::collection($this->whenLoaded('activityLogs'));
        $appealData['media'] = MediaResource::collection($this->whenLoaded('media'));
        unset($appealData['attention_able']);
        unset($appealData['activity_logs']);
        return $appealData;
    }
}
