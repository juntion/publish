<?php


namespace App\Enums\ProjectManage;


final class QueryType
{
    const EQUAL_TYPE = 'is'; // 等于
    const NOT_EQUAL_TYPE = 'notIs'; // 不等于
    const IN_LIST_TYPE = 'inList'; // 在列表
    const NOT_IN_LIST_TYPE = 'notInList'; // 不在列表
    const GREAT_THAN_TYPE = 'gt'; // >
    const GREAT_EQUAL_THAN_TYPE = "geq"; // >=
    const LESS_THAN_TYPE = 'lt'; // <
    const LESS_EQUAL_THAN_TYPE = 'leq'; // <=
    const BETWEEN_TYPE = 'between'; // 在之间
    const LIKE_TYPE = 'like'; // like
    const NOT_LIKE_TYPE = 'notLike'; // not like
}
