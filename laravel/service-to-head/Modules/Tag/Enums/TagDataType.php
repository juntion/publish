<?php

namespace Modules\Tag\Enums;

use Modules\Tag\Exceptions\TagDataException;

class TagDataType
{
    // 标签类型：1：产品标签；2：话题标签
    public const PRODUCT = 1;
    public const TOPIC = 2;

    private const mapping = [
        1 => '产品',
        2 => '话题',
    ];

    public static function getTypeDesc($type)
    {
        switch ($type) {
            case self::PRODUCT:
                return '产品';
            case self::TOPIC:
                return '话题';
            default:
                return '';
        }
    }

    /**
     * @param $typeStr
     * @return int
     * @throws TagDataException
     */
    public static function getTypeValue($typeStr): int
    {
        foreach (self::mapping as $index => $item) {
            if ($typeStr == $item) {
                return $index;
            }
        }
        throw new TagDataException(__('tag::tag.type_error'));
    }
}
