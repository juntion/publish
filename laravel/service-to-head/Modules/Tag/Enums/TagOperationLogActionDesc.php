<?php

namespace Modules\Tag\Enums;

final class TagOperationLogActionDesc
{
    const ACTIONS = [
        'tag.tags.store' => '添加一级标签',
        'tag.tags.addChild' => '添加下级标签',
        'tag.tags.update' => '更新标签',
        'tag.tags.updateStatus.open' => '开启标签',
        'tag.tags.updateStatus.close' => '关闭标签',
        'tag.tags.move' => '转移标签',
        'tag.tags.upload' => '上传标签',
        'tag.tags.delete' => '删除标签',

        //绑定相关
        'tag.binding.store' => '添加绑定关系',
        'tag.binding.update' => '更新绑定',
        'tag.binding.unbind' => '解除绑定',
        'tag.binding.batchUnbind' => '批量解除绑定',
        'tag.binding.upload' => '上传绑定关系',
    ];

    /**
     * @param $actionName
     * @return mixed|string
     */
    public static function getActionDesc($actionName)
    {
        if (empty($actionName)) {
            return '';
        }
        return self::ACTIONS[$actionName] ?? '';
    }
}
