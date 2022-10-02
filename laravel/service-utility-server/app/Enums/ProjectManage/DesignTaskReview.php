<?php

namespace App\Enums\ProjectManage;

final class DesignTaskReview
{
    // 设计走查；0：不需要走查；1：需要走查；2：待走查；3：待确认；4：已确认
    const REVIEW_NO_NEED = 0;
    const REVIEW_NEED = 1;
    const REVIEW_WAIT = 2;
    const REVIEW_TO_CONFIRM = 3;
    const REVIEW_CONFIRMED = 4;

    // 设计走查结果；0：无差异；1：差异已调整；2：差异未全部调整；
    const REVIEW_RESULT_OK = 0;
    const REVIEW_RESULT_ADJUSTED = 1;
    const REVIEW_RESULT_DIFFERENCE = 2;
}
