<?php


namespace App\Request;

use App\Request\BaseRequest;

/**
 * 订单评论页面
 *
 * Class OrdersReviewRequest
 * @package App\Request
 */
class OrdersReviewRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'reviews_rating' => ['required', 'in:1,2,3,4,5'],
            'reviews_text' => ['required'],
//            'reviews_headline' => ['required'],
            'product_quality' => ['in:0,1,2,3,4,5'],
            'price' => ['in:0,1,2,3,4,5'],
            'pre_sale_service' => ['in:0,1,2,3,4,5'],
            'logistics_service' => ['in:0,1,2,3,4,5'],
            'others' => ['in:0,1,2,3,4,5'],
        ];
    }

    public function message()
    {
        return [
            'reviews_rating.required' => self::trans('FS_REVIEW_RATING_REQUIRED_TIP'),
            'reviews_rating.in' => 'invalid code',
            'reviews_text.required' => self::trans("FS_REVIEW_CONTENT_REQUIRED_TIP_NEW"),
//            'reviews_headline.required' => self::trans('FS_REVIEW_TITLE_REQUIRED_TIP_NEW'),
            'product_quality.in' => 'invalid code',
            'price.in' => 'invalid code',
            'pre_sale_service.in' => 'invalid code',
            'logistics_service.in' => 'invalid code',
            'others.in' => 'invalid code',
        ];
    }
}
