<?php

namespace Modules\Tag\Observers;

use Illuminate\Support\Str;
use Modules\Tag\Entities\TagOperationLog;
use Modules\Tag\Enums\TagDataSourceModelType;

class TagOperationLogObserver
{
    public function creating(TagOperationLog $log)
    {
        $log->description = $this->generateHumanDesc($log);
    }

    /**
     * 生成操作文字描述
     * @param TagOperationLog $log
     * @return string
     * @throws \Exception
     */
    private function generateHumanDesc(TagOperationLog $log): string
    {
        if (Str::contains($log->action_name, 'store')) {
            $desc = "由 {$log->admin_name} 创建" . PHP_EOL;
        } elseif (Str::contains($log->action_name, 'delete')) {
            $desc = "由 {$log->admin_name} 删除" . PHP_EOL;
        } else {
            $desc = "由 {$log->admin_name} 编辑" . PHP_EOL;
        }
        if (!empty($log->properties)) {
            if (Str::contains($log->action_name, 'tag.binding')) {
                if ($log->properties['action'] == 'bind') {
                    $desc = "由 {$log->admin_name} 绑定：";
                } else {
                    $desc = "由 {$log->admin_name} 解除绑定：";
                }
                $changes = [];
                foreach ($log->properties['data'] as $item) {
                    $modelTypeDesc = TagDataSourceModelType::getModelTypeCNName($item['model_type']);
                    $changes[] = "{$item['model_desc']} ({$modelTypeDesc})";
                }
                $desc .= implode('，', $changes);
            } else {
                foreach ($log->properties as $item) {
                    $oldValue = is_array($item['old']) ? json_encode($item['old'], JSON_UNESCAPED_UNICODE) : $item['old'];
                    $newValue = is_array($item['new']) ? json_encode($item['new'], JSON_UNESCAPED_UNICODE) : $item['new'];
                    $desc .= "修改了{$item['name']}，旧值为\"{$oldValue}\"，新值为\"{$newValue}\"" . PHP_EOL;
                }
            }
        }
        return $desc;
    }
}
