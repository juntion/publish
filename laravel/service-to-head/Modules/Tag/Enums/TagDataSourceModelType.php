<?php

namespace Modules\Tag\Enums;

use Modules\Tag\Exceptions\TagDataSourceException;

final class TagDataSourceModelType
{
    // 数据类型：1：产品分类 ；2：产品；3：news；4；blog；5：ideas；6：insight；

    // 产品分类
    const PRODUCT_CATEGORY = 1;

    // 产品
    const PRODUCT = 2;

    const NEWS = 3;

    const BLOG = 4;

    const IDEAS = 5;

    const INSIGHT = 6;

    /**
     * 模型type中文名
     * @param $type
     * @return string
     * @throws TagDataSourceException
     */
    public static function getModelTypeCNName($type)
    {
        switch ($type) {
            case self::PRODUCT_CATEGORY:
                return '产品分类';
            case self::PRODUCT:
                return '产品';
            case self::NEWS:
                return 'News推荐';
            case self::BLOG:
                return 'Blog推荐';
            case self::IDEAS:
                return 'idea推荐';
            case self::INSIGHT:
                return 'insight推荐';
            default:
                throw new TagDataSourceException(__('tag::tagBinding.model_type_err', ['type' => $type]));
        }
    }
}
