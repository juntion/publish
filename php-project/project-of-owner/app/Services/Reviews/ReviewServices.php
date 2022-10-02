<?php
/**
 * Notes:
 * File name:ReviewServices
 * Create by: Jay.Li
 * Created on: 2020/5/7 0007 16:18
 */


namespace App\Services\Reviews;

use App\Models\Currency;
use App\Models\Product;
use App\Models\Review;
use App\Models\ReviewsComment;
use App\Models\ReviewsCommentsDescription;
use App\Models\ReviewsToPidRelatedPid;
use App\Models\ReviewsDescription;
use App\Models\ProductsInstockOtherCustomizedRelated;
use App\Models\ProductsInstockCustomizedRelated;
use App\Models\ProductsInstockAddRelated;
use App\Models\ProductsInstockAddModel;
use App\Models\ProductDescription;
use App\Models\ReviewLikeOrNot;
use App\Services\BaseService;
use App\Models\ReviewsImageThumb;
use App\Services\Categories\CategoryService;
use App\Models\ReviewsImage;
use App\Services\Common\CurrencyService;
use App\Services\Products\ProductService;
use App\Models\Order;
use App\Models\ProductThumbImage;
use App\Models\ReviewsLabel;
use App\Models\ReviewsLabelDesc;
use App\Models\ReviewsImageAnchor;
use App\Models\OrderProduct;
use App\Services\Reviews\ReviewAttributeService;

//use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Integer;
//use app\Services\Common\Redis\RedisService;

use Illuminate\Database\Capsule\Manager as DB;

class ReviewServices extends BaseService
{
    private $review;

    private $reviewComment;

    private $product;

    private $reviewsCommentsDescription;

    private $productsInstockOtherCustomizedRelated;

    private $productsInstockCustomizedRelated;

    private $productsInstockAddRelated;

    private $reviewsToPidRelatedPid;

    private $productsInstockAddModel;

    private $productDescription;

    private $reviewLikeOrNot;

    private $reviewDescription;

    private $reviewsImageThumb;

    private $categories;

    private $reviewAttributeService;

    //评论标签关联表
    private $reviewsLabel;

    //评论标签描述表
    private $reviewsLabelDesc;

    //tag图锚点表
    private $reviewsImageAnchor;

    public $where = [];

    public $relatedArr = [];


    public function __construct()
    {
        parent::__construct();

        $this->review = new Review();  //评论表

        $this->product = new Product();  //产品表

        $this->reviewComment = new ReviewsComment();  //评论回复表

        $this->productsInstockAddModel = new ProductsInstockAddModel();  //模块关联副表

        $this->reviewsCommentsDescription = new ReviewsCommentsDescription();  //评论回复描述表

        $this->productDescription = new ProductDescription(); //产品描述表

        $this->reviewLikeOrNot = new ReviewLikeOrNot(); //评论点赞表

        $this->categories = new CategoryService();

        $this->reviewAttributeService = new ReviewAttributeService();

        $this->reviewsLabel = new ReviewsLabel();

        $this->reviewsLabelDesc = new ReviewsLabelDesc();

        $this->reviewsImageAnchor = new ReviewsImageAnchor();

        $this->where = [
            'customers_id' => $this->customer_id,
            'status' => 1,
//            'check_status' => 1
        ];

        $this->relatedArr = [];
    }

    public function getImagePath()
    {
        return $imagePath = self::trans('HTTPS_PRODUCTS_SERVER') . self::trans('DIR_WS_IMAGES') . 'products/';
    }

    public function getReviewImgPath()
    {
        return $imagePath = self::trans('HTTPS_IMAGE_SERVER') . self::trans('DIR_WS_IMAGES') . 'reviews/';
    }

    /**
     * Notes:查询客户相关的评论是否存在
     * User: LiYi
     * Date: 2020/5/7 0007
     *
     * @param $searchProductId
     * @return bool
     */
    public function reviewExists($searchProductId)
    {
        try {
            $result = $this->review->where($this->where)->where(function ($query) use ($searchProductId) {
                if ($searchProductId) {
                    $query->where('products_id', $searchProductId);
                }
            })->exists();
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }

    /**
     * Note: 获取所有的带图片的评论id
     * @author: Dylan
     * @Date: 2020/7/14
     *
     * @param string $products_id
     * @return array
     */
    public function getAllReviewsImg($products_id = '')
    {
        if (!$products_id) {
            return [];
        }

        if ($this->relatedArr) {
            $relatedArr = $this->relatedArr;
        } else {
            $relatedArr = $this->allProductRelatedPid((int)$products_id);
            $relatedArr = $relatedArr['data'];
        }
        $reviewsImg = [];
        if (!$relatedArr) {
            return $reviewsImg;
        }

        $languageWhere = $this->setLanguagesWhere();
        $reviewsImage = new ReviewsImage();
        $reviewsImg = $reviewsImage
            ->leftJoin('reviews', 'reviews.reviews_id', '=', 'reviews_image.reviews_id')
            ->whereIn('reviews.products_id', $relatedArr)
            ->where('status', 1)
            ->where('check_status', 1)
            ->whereIn('reviews.languages_id', $languageWhere)
            ->distinct()
            ->get(['reviews_image.reviews_id', 'reviews_image_id'])
            ->toArray();
        return $reviewsImg ? $reviewsImg : [];
    }

    /**
     * Notes:得到评论数据
     * User: LiYi
     * Date: 2020/5/19 0019
     * Time: 10:28
     * @param $productId
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function reviewDescList($productId, $offset = 1, $limit = 15)
    {
        try {
            $offset = ($offset - 1) * $limit;
            $data = $this->review->where($this->where)
                ->where(function ($query) use ($productId) {
                    if ($productId) {
                        $query->where('products_id', $productId);
                    }
                })
                ->with(['customers' => function ($query) {
                    $query->select('customers_id', 'customers_firstname');
                }])
                ->with('reviewDescription')
                ->with(['reviewsImageThumb' => function ($query) {
                    $query->where('size_w', 500)->select('reviews_id', 'reviews_image_tb', 'size_w', 'size_h');
                }])
                ->with([
                    'product' => function ($query) {
                        $query->select(['products_id', 'products_model']);
                    }
                ])
                ->with([
                    'productDescription' => function ($query) {
                        $query->select(['products_id','products_name', 'products_name_url'])
                            ->where('language_id', $this->language_id);
                    }
                ])
                ->with([
                    'reviewsImage' => function ($query) {
                        $query->select(['reviews_id', 'reviews_image_id', 'reviews_image']);
                    }
                ])
                ->with([
                    'productThumbImage' => function ($query) {
                        $query->select(['products_id', 'thumb_images', 'id'])->where('is_main', 1)
                            ->where('size_w', 60)->where('size_h', 60);
                    }
                ])
                ->orderBy('reviews_id', 'DESC')
                ->orderBy('last_modified', 'DESC');
            $count = $data->count();

            $data = $data->limit($limit)->offset($offset)->get()->toArray();

            if (empty($data)) {
                throw new \Exception('评论数据为空');
            }

            $reviewsId = array_column($data, 'reviews_id');

            $reviewsImg = $resultImgTag = [];


            $commentFields = [
                'comments_id',
                'reviews_id',
                'products_id'

            ];
            $resultComment = $this->reviewComment->where('status', 1)->whereIn('reviews_id', $reviewsId)
                ->with(['reviewsCommentsDescription' => function ($query) {
                    $query->select('comments_id', 'customers_id', 'customers_name', 'comments_content');
                }])
                ->get($commentFields)->toArray();

            $resultImgTag = (new ReviewsImage())->whereIn('reviews_id', $reviewsId)
                ->with(['reviewsImageAnchor' => function ($query) {
                    $query->select('id', 'reviews_image_id', 'top', 'left', 'products_id', 'auto_desc', 'toward');
                }])->get(['reviews_image_id', 'reviews_id'])->toArray();

            $source_path = HTTPS_IMAGE_SERVER.'reviews/';
            foreach ($data as $k => $item) {
                $data[$k]['reviews_star'] = $this->setStar($item['reviews_rating']);
                $data[$k]['reviews_rating'] = sprintf('%.1f', $item['reviews_rating']);
                $data[$k]['customerFirstLetter'] = $this->firstLetter($item['customers']['customers_firstname']);
                $data[$k]['customerName'] = $this->encodeCustomer($item['customers']['customers_firstname']);

                if ($resultComment) {
                    foreach ($resultComment as $kk => $vv) {
                        if ($item['reviews_id'] != $vv['reviews_id']) {
                            continue;
                        }

                        $data[$k]['childComment'][] = $vv;
                    }
                }

                if ($resultImgTag) {
                    foreach ($resultImgTag as $img_k => $img_v) {
                        if ($item['reviews_id'] != $img_v['reviews_id']) {
                            continue;
                        }

                        if (!empty($img_v['reviews_image_anchor'])) {
                            foreach ($img_v['reviews_image_anchor'] as $ks => $ii_v) {

                                if (!empty($ii_v['products_id'])) {
                                    $products_service = new ProductService();
                                    $curr = new CurrencyService();
                                    $p_info = $products_service->getOneProductInfo($ii_v['products_id']);

                                    $img_v['reviews_image_anchor'][$ks]['product_description'] =
                                        $p_info['product_description']['products_name'];
                                    $img_v['reviews_image_anchor'][$ks]['products_price'] =
                                        $curr->format(
                                            $p_info['products_price'],
                                            2,
                                            true,
                                            $this->currency
                                        );
                                }

                            }
                        }

                        foreach ($data[$k]['reviews_image'] as $key => $val) {
                            if ($val['reviews_image_id'] == $img_v['reviews_image_id']) {
                                $data[$k]['reviews_image'][$key]['reviews_image_anchor'] =
                                    $img_v['reviews_image_anchor'];
                            }
                        }
                    }
                }
            }
            $result = [
                'count' => $count,
                'data' => $data
            ];
        } catch (\Exception $e) {
            $result = ['count' => 0, 'data' => []];
        }

        return $result;
    }

    /**
     * Note: 获取评论主表数据
     * @author: Dylan
     * @Date: 2020/6/30
     *
     * @param array $relatedArr
     * @param int $offset
     * @param string $limit
     * @param string $where
     * @param string $orderBy 排序
     * @return array
     */
    public function getReviewsInfo($relatedArr = [], $offset = 0, $limit = '', $where = '', $orderBy = '')
    {
        $relatedArr = $relatedArr ? $relatedArr : $this->relatedArr;
        $reviews = [];

        if (!$relatedArr) {
            return $reviews;
        }
        $languageWhere = $this->setLanguagesWhere();
        $reviews = $this->review
            ->where('status', 1)
            ->where('check_status', 1)
            ->whereIn('languages_id', $languageWhere)
            ->whereIn('products_id', $relatedArr)
            ->where(function ($query) use ($where) {
                if ($where) {
                    $query->whereRaw($where);
                }
            })
            ->with(['customers' => function ($query) {
                $query->select(
                    'customers_id',
                    'customers_firstname',
                    'customers_lastname',
                    'customer_country_id',
                    'customer_photo'
                )
                    ->with(['country' => function ($query) {
                        $query->select(['countries_id', 'countries_name']);
                    }]);
            }])
            ->with(['reviewsVirtualCustomer' => function ($query) {
                $query->select(
                    'id',
                    'customers_name as v_customers_name',
                    'is_buy',
                    'cus_contury as v_cus_contury',
                    'portrait as v_portrait',
                    'customers_name as v_customers_name'
                );
            }])
//            ->with(['reviewLikeOrNot' => function ($query) {
//                $query->select(['reviews_id', 'r_like']);
//            }]);
        ->leftJoin('reviews_like_or_not as rl', 'reviews.reviews_id', '=', 'rl.reviews_id');

        $select_param = ['rl.r_like','reviews.*'];
        if(strstr($where,'label_id')){
            $reviews = $reviews->leftJoin('reviews_to_label as rtl', 'reviews.reviews_id', '=', 'rtl.reviews_id')
                ->leftJoin('reviews_label_desc as rld', 'rtl.label_id', '=', 'rld.label_id');
        }
        //筛选排序
        if (in_array($orderBy, ['relevant', 'all'])) {
            $reviews = $reviews->orderBy('rev_top', 'DESC')
                ->orderBy('top', 'DESC')
                ->orderBy('date_added', 'DESC');
        }
        if ($orderBy == 'newest') {
            $reviews = $reviews->orderBy('date_added', 'DESC');
        }
        if ($orderBy == 'oldest') {
            $reviews = $reviews->orderBy('date_added', 'ASC');
        }
        if ($orderBy == 'helpful') {
            $reviews = $reviews->orderBy('rl.r_like', 'DESC')
                ->orderBy('date_added', 'DESC');
        }
        if ($orderBy == 'high_to_low') {
            $reviews = $reviews->orderBy('reviews_rating', 'DESC')
                ->orderBy('date_added', 'DESC');
        }
        if ($orderBy == 'low_to_high') {
            $reviews = $reviews->orderBy('reviews_rating', 'ASC')
                ->orderBy('date_added', 'DESC');
        }

        if ($limit) {
            $reviews = $reviews->limit($limit)->offset($offset);
        }
        $reviews = $reviews->select($select_param)->get()->toArray();
        return $reviews;
    }


    /**
     * @Notes:获取评论图片
     *
     * @param $products_id
     * @return array
     * @auther: Dylan
     * @Date: 2020/12/10
     * @Time: 11:58
     */
    public function getReviewImage($products_id)
    {
        $reviewsImageData = [];

        if (!$products_id) {
            return $reviewsImageData;
        }
        if ($this->relatedArr) {
            $relatedArr = $this->relatedArr;
        } else {
            $relatedArr = $this->allProductRelatedPid((int)$products_id);
            $relatedArr = $relatedArr['data'];
        }

        $reviewsImage = (new ReviewsImage())
            ->with([
                'reviewsImageThumb' => function ($query) {
                    $query->select('reviews_image_id', 'id', 'reviews_image_tb', 'size_w', 'size_h');
                }
            ])
            ->with([
                'reviewsImageAnchor' => function ($query) {
                    $query->select('reviews_image_id', 'top', 'left', 'products_id', 'auto_desc', 'toward')
                        ->orderBy('id', 'ASC');
                }
            ])
            ->leftJoin('reviews', 'reviews_image.reviews_id', '=', 'reviews.reviews_id')
            ->whereIn('reviews.products_id', $relatedArr)
            ->where('status', 1)
            ->where('check_status', 1)
            ->whereIn('reviews.languages_id', $this->setLanguagesWhere())
            ->get(['reviews_image.reviews_image_id', 'reviews_image.reviews_id', 'reviews_image.reviews_image'])
            ->toArray();

        $reviewsImage_v = $this->review->from('reviews as r')
            ->leftjoin('vc_reviews_tags_related as vr', 'r.reviews_id', '=', 'vr.reviews_id')
            ->leftjoin('fs_scene as fs', 'vr.tag_id', '=', 'fs.scene_id')
            ->leftjoin('fs_scene_points as fp', 'vr.tag_id', '=', 'fp.scene_id')
            ->whereIn('r.products_id', $relatedArr)
            ->whereNotNull('vr.id')
            ->whereIn('fp.direction',['向左','向右'])
            ->groupBy('r.reviews_id', 'fs.scene_id')
            ->get(['fs.images_url', 'fs.images_id', 'r.reviews_id'])
            ->toArray();

        if(!empty($reviewsImage_v)){
            foreach ($reviewsImage_v as $v_value) {
                //原图宽高为500
                $v_value['size_w'] = 500;
                $v_value['size_h'] = 500;
                $reviewsImageData[$v_value['reviews_id']][] =
                    [
                        'reviews_id' => $v_value['reviews_id'],
                        'reviews_image_id' => $v_value['images_id'],
                        'reviews_image' => $v_value['images_url'],
                        'reviews_image_thumb' => [],
                        'is_v_tag_type' => 1
                    ];
            }
        }

        foreach ($reviewsImage as $value) {
            //原图宽高为500
            $value['size_w'] = 500;
            $value['size_h'] = 500;
            $value['is_v_tag_type'] = 0;
            $reviewsImageData[$value['reviews_id']][] = $value;
        }

        return $reviewsImageData;
    }

    /**
     * Note: 评论描述表
     * @author: Dylan
     * @Date: 2020/6/30
     *
     * @param array $reviewsIds
     * @return array
     */
    public function getReviewsDesc($reviewsIds = [])
    {
        $reviewsDescriptionData = [];
        if (!$reviewsIds) {
            return $reviewsDescriptionData;
        }
        $this->reviewDescription = new ReviewsDescription(); //评论描述表
        $reviewsDescription = $this->reviewDescription
            ->whereIn('reviews_id', $reviewsIds)
            ->select(['reviews_id', 'reviews_text', 'reviews_headline'])
            ->get()
            ->toArray();

        foreach ($reviewsDescription as $value) {
            $reviewsDescriptionData[$value['reviews_id']] = $value;
        }
        return $reviewsDescriptionData;
    }

    /**
     * Note: 评论回复表
     * @author: Dylan
     * @Date: 2020/6/30
     *
     * @param array $reviewsIds
     * @return array
     */
    public function getReviewsComment($reviewsIds = [])
    {
        $reviewsCommentsData = [];

        if (!$reviewsIds) {
            return $reviewsCommentsData;
        }
        $reviewsComment = $this->reviewComment
            ->whereIn('reviews_id', $reviewsIds)
            ->where('status', 1)
            ->where('rpid', 0)
            ->with(['reviewsCommentsDescription' => function ($query) {
                $query->select('comments_id', 'comments_content', 'customers_name');
            }])
            ->select('reviews_id', 'comments_id')
            ->orderBy('is_fiberstore', 'DESC')
            ->orderBy('date_added', 'DESC')
            ->get()
            ->toArray();

        foreach ($reviewsComment as $value) {
            $reviewsCommentsData[$value['reviews_id']][] = $value['reviews_comments_description'];
        }
        return $reviewsCommentsData;
    }


    /**
     * Note: 得到详情页评论数据
     * @author: Dylan
     * @Date: 2020/7/14
     *
     * @param string $products_id
     * @param int $offset
     * @param int $limit
     * @param string $where
     * @param string  $orderBy  排序
     * @return array
     */
    public function reviewData($products_id = '', $offset = 0, $limit = 10, $where = '', $orderBy = '')
    {
        if (!$products_id) {
            return [];
        }

        if ($this->relatedArr) {
            $relatedArr['data'] = $this->relatedArr;
        } else {
            $relatedArr = $this->allProductRelatedPid($products_id);
        }
        $reviewsData = $mostHelpData = $products_ids= $modelAttrShow = [];
        $showModel = false;
        if ($relatedArr['data']) {
            $orderBy = $orderBy ? $orderBy : 'newest';
            $reviewsIds = $reviewsArr = [];
            /*评论相关数据*/
            $reviews = $this->getReviewsInfo($relatedArr['data'], $offset, $limit, $where, $orderBy);
            if (!$reviews) {
                return $reviewsData;
            }
            foreach ($reviews as $review_v) {
                $reviewsIds[] = $review_v['reviews_id'];
                //$customerIds[] = $review_v['customers_id'];
                $reviewsArr[$review_v['reviews_id']] = $review_v;
                $products_ids[] = $review_v['products_id'];
            }
            if (!$reviewsIds) {
                return $reviewsData;
            }

            $reviewsDescription = $this->getReviewsDesc($reviewsIds);
            $reviewsImageData = $this->getReviewImage($products_id);
            $reviewsComment = $this->getReviewsComment($reviewsIds);
            $showModel = $this->reviewAttributeService->getReviewIsShowModel($products_id);
            if ($showModel) {
                $modelAttrShow = $this->reviewAttributeService->getModelProductCategories($products_ids);
            }


            if (!$reviewsArr) {
                return $reviewsData;
            }

            foreach ($reviewsArr as $k => $v) {
                /*模块分类展示*/
                $productAttr = [];
                if (!empty($modelAttrShow)) {
                    foreach ($modelAttrShow as $modelKey => $modelAttr) {
                        if ($v['products_id'] == $modelAttr['product_id']) {
                            $productAttr[] = array(
                                'related_attribute_id' => $modelAttr['related_attribute_id'],
                                'related_attribute_content' => $modelAttr['related_attribute_content'],
                                'attributes_relation_id' => $modelAttr['attributes_relation_id'],
                                'attributes_relation_content' => $modelAttr['attributes_relation_content'],
                                'transceiver_type_model' => $modelAttr['transceiver_type_model'],
                            );
                        }
                    }
                }

                if ($v['customers_id']) {
                    $name = $v['customers']['customers_firstname'].$v['customers']['customers_lastname'];
                    $first_word = $this->firstLetter($v['customers']['customers_firstname']);
                    $country_name = $v['customers']['country']['countries_name'];
                    $customers_end = $this->lastLetter($v['customers_id']);
                    $customer_pic = $v['customers']['customer_photo'];
                } else {
                    $name = $v['reviews_virtual_customer']['v_customers_name'];
                    $first_word = $this->firstLetter($v['reviews_virtual_customer']['v_customers_name']);
                    $country_name = $v['reviews_virtual_customer']['v_cus_contury'];
                    $customers_end = $this->lastLetter($v['reviews_virtual_customer']['id']);
                    $customer_pic = $v['reviews_virtual_customer']['v_portrait'];
                }

                if (!$v['date_added'] || $v['date_added'] == '0000-00-00') {
                    $date = $v['last_modified'];
                } else {
                    $date = $v['date_added'];
                }
                $reviewsData[$v['reviews_id']] = array(
                    'rid' => $v['reviews_id'],
                    'products_id' => $v['products_id'],
                    'name' => $this->encodeCustomer($name),
                    //'country' => $v['cus_contury'],
                    'customersid' => $v['customers_id'],
                    'vcustomersid' => $v['v_customers_id'],
                    'time' => $this->getLanguageDate($date),
                    'rating' => $v['reviews_rating'],
                    'reviews_headline' => $reviewsDescription[$k]['reviews_headline'],
                    'content' => $this->getContent($reviewsDescription[$k]['reviews_text'], $v['label_text']),
                    //'v_is_buy' => $v['reviews_virtual_customer']['is_buy'],
                    'reviewsComment' => $reviewsComment[$k] ? (array)$reviewsComment[$k] : [],
                    'r_like' => $v['r_like'] ? $v['r_like'] : 0,
                    'country_name' => $country_name,
                    'firstWord' => $v['anonymity'] ? 'C' : $first_word,
                    'customers_end' => $customers_end,
                    'customer_pic' => $customer_pic,
                    'equipment_mode' => $v['equipment_mode'],
                    'modelAttr' => $productAttr,
                    'reviewsInfo' => $reviewsImageData[$v['reviews_id']],
                );


//                if ($v['review_like_or_not']['r_like'] >= 50 && count($mostHelpData) < 2 &&
//                    (($v['languages_id'] == 1 && $v['top'] == 1) ||
//                    ($v['languages_id'] != 1 && $v['rev_top'] == 1))
//                ) {
//                    $mostHelpData[] = $reviewsData[$v['reviews_id']];
//                }
            }
        }
        return [
            'reviewsData' => $reviewsData,
            'mostHelpData' => $mostHelpData,
        ];
    }

    /**
     * Note: 评论小于日期格式转化
     * @author: Dylan
     * @Date: 2020/6/29
     *
     * @param string $date
     * @return false|string
     */
    public function getLanguageDate($date = '')
    {
        $languagesCode = $this->language_code;

        if (!$date) {
            return '';
        }

        switch ($languagesCode) {
            case 'jp':
            case 'es':
            case 'mx':
                $temp_reviews_time = get_date_display($date,$this->language_id);
                break;
            case 'au':
                $temp_reviews_time = get_time_english_display($date,$this->language_id);
                break;
            case 'fr':
            case 'dn':
            case 'uk':
                $temp_reviews_time = date('d/m/Y', strtotime($date));
                break;
            case 'de':
                $temp_reviews_time = date('d.m.Y', strtotime($date));
                break;
            default:
                $temp_reviews_time = date('m/d/Y', strtotime($date));
                break;
        }
        return $temp_reviews_time;
    }

    /**
     * Note: 评论内容带转行进行转义
     * @author: Dylan
     * @Date: 2020/6/29
     *
     * @param string $content
     * @param string $label
     * @return mixed|string
     */
    public function getContent($content = '', $label = '')
    {
        $str = $content;
        if (strpos($str, '\n')) {
            $str = str_replace(['\r\n','\n'], '<br>', $str);
        } else {
            $str = json_decode(str_replace(['\r\n','\n'], '<br>', json_encode($str)));
        }

//        if(!empty($label)){
//            $label_arr = explode(' ',$label);
//            $label_arr[] = $label;
//
//            foreach ($label_arr as $l_val){
//                $str_light = '<b color="blue">'.$l_val.'</b>';
//                $str = str_replace($l_val, $str_light, $str);
//            }
//        }
        return $str;
    }


    /**
     * Note: 模块关联主表
     * @author: Dylan
     * @Date: 2020/6/22
     *
     * @param int $products_id
     * @return array
     */
    public function reviewProductsRelated($products_id = '')
    {
        $this->reviewsToPidRelatedPid = new ReviewsToPidRelatedPid();  //评论自定义产品关联表（推广维护）
        try {
            $pid = $this->reviewsToPidRelatedPid
                        ->where('pid', $products_id)
                        ->Orwhere('related_pid', $products_id)
                        ->first(['pid']);

            if (empty($pid)) {
                return $result = [ 'code' => 0, 'data' => $pid, 'msg'=> '无评论关联数据' ];
            }

            $data = $this->reviewsToPidRelatedPid
                        ->where('pid', $pid->pid)
                        ->lists('related_pid');

            if (empty($data)) {
                return $result = [ 'code' => 0, 'data' => $data, 'msg'=> '评论关联表数据为空' ];
            }

            $relatedData = $data;
            $relatedData[] = $pid->pid;

            $result = [ 'code' => 1, 'data' => $relatedData, 'msg' => '' ];
        } catch (\Exception $e) {
            $result = [ 'code' => 0, 'data' => '', 'msg' => '评论关联表查询数据出错' ];
        }
        return $result;
    }


    /**
     * Note: 定制产品关联数据
     * @author: Dylan
     * @Date: 2020/6/23
     *
     * @param string $products_id
     * @param array $related_arr
     * @return array
     */
    public function reviewCustomProductsRelated($products_id = '', $related_arr = [])
    {
        $relatedArr = $related_arr;
        if ($products_id) {
            $this->productsInstockCustomizedRelated = new ProductsInstockCustomizedRelated();  //定制产品关联新表
            $custom = $this->productsInstockCustomizedRelated
                ->where('customized_id', $products_id)
                ->Orwhere('products_id', $products_id)
                ->select(['customized_id'])
                ->limit(1)->get()->toArray();

            if ($custom[0]['customized_id']) {
                $modelRelated = $this->productsInstockCustomizedRelated
                                    ->where('customized_id', $custom[0]['customized_id'])
                                    ->lists('products_id');
                if (!empty($modelRelated)) {
                    $modelRelated[] = $products_id;
                    $relatedArr = array_merge($modelRelated, $relatedArr);
                    $relatedArr = array_unique($relatedArr);
                }
            }
        }
        return $relatedArr;
    }


    /**
     * Note: 模块关联组
     * @author: Dylan
     * @Date: 2020/6/19
     *
     * @param array $data
     * @return array|null
     */
    public function reviewModelProductsRelated($data = [])
    {
        $modelRelated = [];
        $relatedArr = $data;
        if (!empty($data)) {
            $this->productsInstockAddRelated = new ProductsInstockAddRelated();  //模块产品主表
            $model = $this->productsInstockAddRelated
                          ->whereIn('products_id', $data)
                          ->where('warehouse', '<>', 0)
                          ->lists('model_id');
            if ($model) {
                //一个model_id可能对应多个产品id
                $modelRelated = $this->productsInstockAddRelated
                                     ->whereIn('model_id', $model)
                                     ->where('warehouse', '<>', 0)
                                     ->lists('products_id');
            }
        }
        $relatedArr = array_merge($relatedArr, $modelRelated);
        $relatedArr = array_flip($relatedArr);
        $relatedArr = array_flip($relatedArr);//翻转两次，去重
        $relatedArr = array_merge($relatedArr);
        return $relatedArr;
    }

    /**
     * Note: 获取该产品id的所有关联产品
     * @author: Dylan
     * @Date: 2020/6/23
     *
     * @param string $products_id
     * @return array
     */
    public function allProductRelatedPid($products_id = '')
    {
        try {
            /*优先查询评论关联产品表*/
            $reviewProductsRelated = $this->reviewProductsRelated($products_id);
            if ($reviewProductsRelated['code'] == 1) {
                $this->relatedArr = $reviewProductsRelated['data'];
                $result  = [ 'data' => $reviewProductsRelated['data'] ];
            } else {
                //旧表查到数据关联
                $this->productsInstockOtherCustomizedRelated = new ProductsInstockOtherCustomizedRelated(); //定制产品关联旧表
                $customizedId = $this->productsInstockOtherCustomizedRelated
                                    ->where('products_id', $products_id)
                                    ->Orwhere('customized_id', $products_id)
                                    ->select(['customized_id'])
                                    ->orderBy('customized_related_id', 'ASC')->limit(1)->get()->toArray();
                /*如果存在关联*/
                if ($customizedId[0]['customized_id']) {
                    $customizedData = $this->productsInstockOtherCustomizedRelated
                                            ->where('customized_id', $customizedId[0]['customized_id'])
                                            ->lists('products_id');
                    $data = $this->reviewCustomProductsRelated($customizedId[0]['customized_id'], $customizedData);
                    $data[] = $customizedId[0]['customized_id'];
                    $data = $this->reviewModelProductsRelated($data);
                    $this->relatedArr = $data;
                    $result = [ 'data' => $data ];
                } else {
                    $data = $this->reviewCustomProductsRelated($products_id, array());
                    $data = $this->reviewModelProductsRelated($data);
                    $this->relatedArr = $data;
                    $result = [ 'data' => $data ];
                }
                if (!$this->relatedArr) {
                    $data = [$products_id];
                    $this->relatedArr = $data;
                    $result = [ 'data' => $data ];
                }
            }
        } catch (\Exception $e) {
            $result = [ 'status' => 0, 'msg' => 'error', 'data' => '' ] ;
        }

        return $result;
    }

    /**
     * Note: 各站点评论关联条件
     * @author: Dylan
     * @Date: 2020/6/22
     *
     * @return array
     */
    public function setLanguagesWhere()
    {
        $languageId = [1, 9];
        if ($this->language_id) {
            if (!in_array($this->language_id, [1, 9])) {
                $languageId = [1, 9, $this->language_id];
            }
        }
        return $languageId;
    }

    /**
     * Notes: 设置星星
     * User: LiYi
     * Date: 2020/5/11 0011
     * Time: 14:20
     * @param $num
     * @return string
     */
    protected function setStar($num)
    {
        switch ((int)$num) {
            case 1:
                $result = 'p_star05';
                break;
            case 2:
                $result = 'p_star04';
                break;
            case 3:
                $result = 'p_star03';
                break;
            case 4:
                $result = 'p_star02';
                break;
            case 5:
            default:
                $result = 'p_star01';
                break;
        }

        return $result;
    }

    /**
     * Notes:客户名加密显示
     * User: LiYi
     * Date: 2020/5/19 0019
     * Time: 10:18
     * @param $value
     * @return string
     */
    protected function encodeCustomer($value)
    {
        $start = '***';
        return $this->firstLetter($value) . $start . $this->lastLetter($value);
    }

    /**
     * Notes:得到第一个字母
     * User: LiYi
     * Date: 2020/5/19 0019
     * Time: 10:18
     * @param $value
     * @return false|string
     */
    protected function firstLetter($value)
    {
        if (function_exists('mb_substr')) {
            return mb_substr($value, 0, 1);
        } else {
            return substr($value, 0, 1);
        }
    }

    /**
     * Notes:得到最后一个字母
     * User: LiYi
     * Date: 2020/5/19 0019
     * Time: 10:18
     * @param $value
     * @return false|string
     */
    protected function lastLetter($value)
    {
        if (function_exists('mb_substr')) {
            return mb_substr($value, -1, 1);
        } else {
            return substr($value, -1, 1);
        }
    }

    /**
     * Note: 获取模块platform_support版块型号名
     * @author: Dylan
     * @Date: 2020/6/25
     *
     * @param string $products_id
     * @return array
     */
    public function getEquipmentMode($products_id = '')
    {
        $modelCate = $this->reviewAttributeService->getReviewIsShowModel($products_id);
        $result = [];
        if ($modelCate) {
            $platform_support = $this->productDescription
                ->where('products_id', $products_id)
                ->first(['platform_support']);
            if ($platform_support['platform_support']) {
                $regex4 = "/<span>.*?<\/span>/ism";
                preg_match_all($regex4, $platform_support['platform_support'], $result, PREG_PATTERN_ORDER);
            }
        }
        $result['is_show_equipmentMode'] = $modelCate;
        return $result;
    }

    /**
     * Note: 评论总个数
     * @author: Dylan
     * @Date: 2020/6/25
     *
     * @param array $relatedArr
     * @return int
     */
    public function getTotalReviews($relatedArr = [], $where = '')
    {
        $relatedArr = $relatedArr ? $relatedArr : $this->relatedArr;
        $whereLanguage = $this->setLanguagesWhere();
        $reviewsTotalNum = $reviewTotalRating = $reviewTotalImg = 0;

        if ($relatedArr) {
            $data = $this->review
                ->whereIn('reviews.products_id', $relatedArr)
                ->whereIn('languages_id', $whereLanguage)
                ->where('check_status', 1)
                ->where('status', 1)
                ->where(function ($query) use ($where) {
                    if ($where) {
                        $query->whereRaw($where);
                    }
                });
                if(strstr($where,'label_id')){
                    $data = $data->leftJoin('reviews_to_label as rtl', 'reviews.reviews_id', '=', 'rtl.reviews_id')
                        ->leftJoin('reviews_label_desc as rld', 'rtl.label_id', '=', 'rld.label_id');
                }
                $reviewsTotalNum = $data->count();
                $reviewTotalRating = $data->sum('reviews_rating');
                $reviewTotalImg = $data->rightJoin('reviews_image', function ($join) {
                    $join->on('reviews_image.reviews_id', '=', 'reviews.reviews_id');
                })
                ->distinct()
                ->get(['reviews_image.reviews_id'])
                ->count();
        }
        return [
            'reviewsTotalNum' => $reviewsTotalNum,
            'reviewTotalRating' => $reviewTotalRating,
            'reviewTotalImg' => $reviewTotalImg,
        ];
    }

    /**
     * Note:
     * @author: Dylan
     * @Date: 2020/6/30
     *
     * @param array $relatedArr
     * @return array
     */
    public function getReviewsTotalInfo($relatedArr = [])
    {
        $relatedArr = $relatedArr ? $relatedArr : $this->relatedArr;
        $rating = 0;

        if (!$relatedArr) {
            return [];
        }

        $reviewsTotalArr = $this->getTotalReviews($relatedArr);
        if ($reviewsTotalArr['reviewsTotalNum']) {
            $rating = $reviewsTotalArr['reviewTotalRating'] / $reviewsTotalArr['reviewsTotalNum'];
            $rating = number_format($rating, 1);
        }

        return [
            'rating' => $rating,
            'reviewsTotal' => $reviewsTotalArr['reviewsTotalNum'],
            'ratingTotal' => $reviewsTotalArr['reviewTotalRating'],
            'imgTotal' => $reviewsTotalArr['reviewTotalImg']
        ];
    }

    public function getStar($relatedArr = [])
    {
        $relatedArr = $relatedArr ? $relatedArr : $this->relatedArr;
        $whereLanguage = $this->setLanguagesWhere();
        $reviews = [];

        $data = $this->review
            ->where('check_status', 1)
            ->where('status', 1)
            ->whereIn('products_id', $relatedArr)
            ->whereIn('languages_id', $whereLanguage);
        $total = $data->count();

        if ($total) {
            $reviews = $data->get(['reviews_id','reviews_rating'])->toArray();
            $reviews =array_column($reviews, 'reviews_rating', 'reviews_id');
            $reviews = array_count_values($reviews);
            asort($reviews);
            $reviews['total'] = $total;
        }
        return $reviews;
    }

    public function getReviewsReviewNum($relatedArr = [])
    {
        $relatedArr = $relatedArr ? $relatedArr : $this->relatedArr;
        $stars_level = [];

        $getStar = $this->getStar($relatedArr['data']);
        if (!empty($getStar)) {
            foreach ($getStar as $k => $v) {
                if ($k != 'total') {
                    if ($k != 5) {
                        if ($getStar[5] > 0) {
                            if ($v > $getStar[5]) {
                                $stars_level['level_new_'.$k] = 100;
                            } else {
                                $stars_level['level_new_'.$k] = round(($getStar[$k] / $getStar[5]) * 100, 0);
                            }
                        } else {
                            $stars_level['level_new_'.$k] = $v>$getStar[5] ? 100 : 0;
                        }
                        $stars_level['rate'.$k] = 100 - $stars_level['rate1'] - $stars_level['rate2'] - $stars_level['rate3'] - $stars_level['rate4'];
                    } else {
                        $stars_level['rate'.$k] = round(($getStar[$k] / $getStar['total']) * 100, 0);
                        $stars_level['level_new_'.$k] = $v > 0 ? 100 : 0;
                    }
                    $stars_level['num'.$k] = $v;
                } else {
                    $stars_level['total'] = $v;
                }
            }
        }
        return $stars_level;
    }

    /**
     * @Notes:
     *
     * @param string $searchTag
     * @param string $source
     * @param string $orders_products_id
     * @return array|string
     * @auther: Dylan
     * @Date: 2020/10/29
     * @Time: 12:11
     */
    public function searchTagInfo($searchTag = ''){
        if (!is_numeric($searchTag)) {
            return [];
        }
        $curr = new CurrencyService();
        $searchTag = (int)$searchTag;
        $productInfo = (new ProductService())->getOneProductInfo($searchTag);
        $currency = $this->currency;
        $productInfo['products_price'] = $curr->format(
            $productInfo['products_price'],
            2,
            true,
            $currency,
            1
        );
        return $productInfo;
    }

    /**
     * @Notes: 通过$main_order_id 得到所有订单ID
     *
     * @param array $main_order_id
     * @return array
     * @auther: Dylan
     * @Date: 2020/11/5
     * @Time: 12:00
     */
    public function getSonOrderIds($main_order_id = [])
    {
        if (!$main_order_id) {
            return [];
        }
        $order = new Order();
        return $order
            ->whereIn('main_order_id', $main_order_id)
            ->get(['orders_id'])
            ->toArray();
    }

    /**
     * $Notes: 获取评论tag图列表
     *
     * $author: Quest
     * $Date: 2020/12/4
     * $Time: 18:29
     * @param $products_id
     * @return array
     */
    public function getReviewsTagList($products_id)
    {
        $p_service = new ProductService();
        $curr = new CurrencyService();

        if ($this->relatedArr) {
            $relatedArr = $this->relatedArr;
        } else {
            $relatedArr = $this->allProductRelatedPid((int)$products_id);
            $relatedArr = $relatedArr['data'];
        }

        $tag_res = $this->review->selectRaw(
            'r.reviews_id, ri.reviews_image, rd.reviews_text,
            rl.r_like, ri.reviews_image_id,
            r.reviews_type,r.reviews_rating, r.date_added, r.is_selected,
            ra.left,ra.top,ra.toward,ra.products_id,ra.auto_desc,
            cu.customers_firstname, cu.customers_lastname, rvc.customers_name, customer_photo'
        )
            ->from('reviews as r')
            ->leftJoin('reviews_image as ri', 'ri.reviews_id', '=', 'r.reviews_id')
            ->leftJoin('reviews_description as rd', 'r.reviews_id', '=', 'rd.reviews_id')
            ->leftJoin('reviews_like_or_not as rl', 'r.reviews_id', '=', 'rl.reviews_id')
            ->leftJoin('reviews_image_anchor as ra', 'ri.reviews_image_id', '=', 'ra.reviews_image_id')
            ->leftJoin('customers as cu', 'r.customers_id', '=', 'cu.customers_id')
            ->leftJoin('reviews_virtual_customer as rvc', 'r.v_customers_id', '=', 'rvc.id')
            ->where('r.check_status', 1)
            ->whereIn('r.products_id', $relatedArr)
            ->whereIn('rd.languages_id', $this->setLanguagesWhere())
            ->whereNotNull('ri.reviews_image_id')
            ->orderby('r.rev_top', 'DESC')
            ->orderby('r.top', 'DESC')
            ->orderby('rl.r_like', 'DESC')
            ->orderby('r.date_added', 'DESC')
            ->get();

        $reviewsImage_v = $this->review->from('reviews as r')
            ->selectRaw(
                'r.reviews_id, vr.tag_id, fs.images_url as reviews_image,
                fs.images_id as reviews_image_id, fp.points_left AS v_left, fp.points_top AS v_top,
                fp.direction AS toward, fp.main_products_id AS products_id, rvc.customers_name'
            )
            ->leftjoin('vc_reviews_tags_related as vr', 'r.reviews_id', '=', 'vr.reviews_id')
            ->leftjoin('fs_scene as fs', 'vr.tag_id', '=', 'fs.scene_id')
            ->leftjoin('fs_scene_points as fp', 'vr.tag_id', '=', 'fp.scene_id')
            ->leftJoin('reviews_virtual_customer as rvc', 'r.v_customers_id', '=', 'rvc.id')
            ->whereIn('r.products_id', $relatedArr)
            ->whereNotNull('vr.id')
            ->whereIn('fp.direction',['向左','向右'])
            ->where('r.check_status', 1)
            ->get()
            ->toArray();

        //格式化评论数组
        $collection = collect($reviewsImage_v);
        $reviewsImage_v_arr = $collection->groupBy('reviews_id');
        $reviewsImage_v_arr->toArray();

        $res_arr = [];
        if(!$tag_res->isEmpty()) {
            $tag_arr = $tag_res->toArray();

            //格式化评论数组
            $collection = collect($tag_arr);
            $tag_arr = $collection->groupBy('reviews_id');
            $tag_arr->toArray();

            $num = 0;
            foreach ($tag_arr as $k => $v_val) {

                $customers_name = '';
                $customer_photo = '';
                //虚拟tag图
                if (isset($reviewsImage_v_arr[$k])) {
                    $bas_info = $v_val[0];
                    $reviewsImage_new = $reviewsImage_v_arr[$k];
                    foreach ($reviewsImage_new as $key => $item){
                        $item['left'] = $item['v_left'];
                        $item['top'] = $item['v_top'];
                        $item['toward'] = ($item['toward'] == '向左' ? 1 : 2);
                        $item['reviews_text'] = $bas_info['reviews_text'];
                        $item['r_like'] = $bas_info['r_like'];
                        $item['reviews_rating'] = $bas_info['reviews_rating'];
                        $item['reviews_type'] = $bas_info['reviews_type'];
                        $item['date_added'] = $bas_info['date_added'];
                        unset($item['v_left']);
                        unset($item['v_top']);
                        $reviewsImage_new[$key] = $item;
                    }
                    $v_val = array_merge($reviewsImage_new, $v_val);
                }

                foreach ($v_val as $kk => $vv){
                    if($vv['reviews_type'] == 0){
                        strstr($v_val[$kk]['reviews_image'],'fs_scene_images');
                        if(!strstr($v_val[$kk]['reviews_image'],'fs_scene_images')){
                            $v_val[$kk]['reviews_image'] = '/images/reviews/'.$v_val[$kk]['reviews_image'];
                        }
                        $customers_name = $v_val[$kk]['customers_name'];
                    }else{
                        $v_val[$kk]['reviews_image'] = '/images/reviews/'.$v_val[$kk]['reviews_image'];
                        $customers_name =
                            $v_val[$kk]['customers_firstname'].'.'.$v_val[$kk]['customers_lastname'];
                    }
                    $customer_photo = $v_val[$kk]['customer_photo'];
                    $v_val[$kk]['reviews_image'] = self::trans('HTTPS_IMAGE_SERVER').$v_val[$kk]['reviews_image'];

                    if ((strpos($v_val[$kk]['reviews_image'], '.webp') !== false) && (!is_support_webp())) {
                        $v_val[$kk]['reviews_image'] = substr($v_val[$kk]['reviews_image'], 0, strrpos($v_val[$kk]['reviews_image'], '.webp'));
                    }

                    //删除多余的子数据
                    unset($v_val[$kk]['customer_photo']);
                    unset($v_val[$kk]['customers_name']);
                    unset($v_val[$kk]['customers_firstname']);
                    unset($v_val[$kk]['customers_lastname']);

                    unset($v_val[$kk]['reviews_id']);
                    unset($v_val[$kk]['reviews_text']);
                    unset($v_val[$kk]['r_like']);
                    unset($v_val[$kk]['reviews_rating']);
                    unset($v_val[$kk]['reviews_type']);
                    unset($v_val[$kk]['date_added']);
                }

                //格式化评论图片数组
                $collection = collect($v_val);
                $arr = $collection->groupBy('reviews_image_id');
                $arr->toArray();
                $images_info = [];
                foreach ($arr as $ka => $val_a) {

                    //获取产品信息
                    foreach ($val_a as $k_an => $v_anchor){
                        $p_info = $p_service->getOneProductInfo($v_anchor['products_id']);
                        $val_a[$k_an]['products_price'] = $curr->format(
                            $p_info['products_price'],
                            2,
                            true,
                            $this->currency
                        );
                        $val_a[$k_an]['product_description'] = $p_info['product_description']['products_name'];

                        if(!empty($val_a[$k_an]['left']) && !empty($val_a[$k_an]['top'])) {
                            $images_info[$ka]['anchor'] = $val_a;
                            unset($images_info[$ka]['anchor'][$ka]['reviews_image']);
                            unset($images_info[$ka]['anchor'][$ka]['reviews_image_id']);
                        }else{
                            $images_info[$ka]['anchor'] = [];
                        }
                    }

                    $images_info[$ka]['reviews_image'] = $val_a[0]['reviews_image'];
                    $images_info[$ka]['reviews_image_id'] = $val_a[0]['reviews_image_id'];
                }
                
                $res_arr[$num]['reviews_id'] = $vv['reviews_id'];
                $res_arr[$num]['reviews_text'] = $vv['reviews_text'];
                $res_arr[$num]['r_like'] = $vv['r_like'];
                $res_arr[$num]['reviews_rating'] = $vv['reviews_rating'];
                $res_arr[$num]['reviews_type'] = $vv['reviews_type'];
                $res_arr[$num]['is_selected'] = $vv['is_selected'];
                $res_arr[$num]['date_added'] = $this->getLanguageDate($vv['date_added']);
                $res_arr[$num]['customers_name'] = $this->encodeCustomer($customers_name);
                $res_arr[$num]['customer_photo'] = $customer_photo;

                $res_arr[$num]['images_info'] = $images_info;
                $num++;

            }
        }
        return $res_arr;
    }


    /**
     * @Notes: 获取精选图片数据
     *
     * @param array $data
     * @return array
     * @auther: Dylan
     * @Date: 2021/1/20
     * @Time: 19:45s
     */
    public function getSelectedReviewImage($data=[])
    {
        $reviewsSelectedTagList = [];
        if (!$data || !is_array($data)) {
            return $reviewsSelectedTagList;
        }
        $selectImageId = [];
        foreach ($data as $key => $value) {
            if ($value['is_selected'] && count($value['images_info']) > 0) {
                foreach ($value['images_info'] as $_image) {
                    $selectImageId[$_image['reviews_image_id']] = $_image['reviews_image_id'];
                }
            }
        }
        $selectImageInfo = [];
        if (count($selectImageId) > 0) {
            $selectImageInfo = fs_get_datas('reviews_image_thumb', 'reviews_image_id in( ' . implode(',', $selectImageId) . ')', 'reviews_image_id,reviews_image_tb,size_w,size_h');
        }
        foreach ($data as $value) {
            if ($value['is_selected'] && count($value['images_info']) > 0) {
                foreach ($value['images_info'] as $k => $_value) {
                    foreach ($selectImageInfo as $thumbImage) {
                        if ($_value['reviews_image_id'] == $thumbImage['reviews_image_id'] && empty($_value['anchor'])) {
                            if ($thumbImage['size_w'] == 500 || $thumbImage['size_h'] == 500) {
                                $value['images_info'][$k]['thumb_image'] = $thumbImage;
                            }
                        }
                    }
                }
                $reviewsSelectedTagList[] = $value;
            }
        }
        return $reviewsSelectedTagList;
    }

    public function getReviewsVirtualTag($tag_id)
    {
        $tag_res = $this->review->select(
            'r.reviews_id', 'ri.reviews_image', 'rd.reviews_text',
            'rl.r_like', 'ri.reviews_image_id', 'vr.tag_id', 'r.reviews_type',
            'r.reviews_rating'
        )
            ->from('reviews as r')
            ->leftJoin('reviews_image as ri', 'ri.reviews_id', '=', 'r.reviews_id');
    }

    /**
     * @Notes: 查询客户订单数据
     *
     * @param string $orders_products_id
     * @return mixed
     * @auther: Dylan
     * @Date: 2020/10/30
     * @Time: 19:59
     */
    public function getTagRelatedOrdersData($orders_products_id = '')
    {
        $order = new Order();
        $productThumbImage = new ProductThumbImage();
        $curr = new CurrencyService();
        $ordersInfo = $order
            ->leftJoin('orders_products as op', 'orders.orders_id', '=', 'op.orders_id')
            ->where('customers_id', $this->customer_id)->where('orders.orders_status', 4);
        if ($orders_products_id) {
            $ordersInfo = $ordersInfo->where('orders_products_id', $orders_products_id);
        } else {
            $ordersInfo = $ordersInfo->whereRaw('DATE_SUB(CURDATE(),  INTERVAL 1 MONTH)<= date(date_purchased)')
                ->where('orders.main_order_id', '<>', 1)->groupBy('orders.main_order_id', 'orders.orders_id');
        }
        $ordersInfo = $ordersInfo
            ->get(['main_order_id', 'orders.orders_id'])
            ->toArray();
        if (!$ordersInfo) {
            return [];
        }

        $orderIds = $mainIds = [];
        foreach ($ordersInfo as $value) {
            if ($value['main_order_id']) { //分单
                $mainIds[] = $value['main_order_id'];
            } else { //整单
                $orderIds[] = $value['orders_id'];
            }
        }
        $sonInfo = $this->getSonOrderIds($mainIds);

        foreach ($sonInfo as $v) {
            $orderIds[] = $v['orders_id'];
        }

        $ordersProductsInfo = $order
            ->leftJoin('orders_products as op', 'orders.orders_id', '=', 'op.orders_id')
            ->leftJoin('products as p', 'op.products_id', '=', 'p.products_id')
            ->where('p.products_status', 1)
            ->whereIn('orders.orders_id', $orderIds)
            ->groupBy('op.products_id')
            ->get(['op.products_id', 'op.products_name', 'p.products_price'])
            ->toArray();
        foreach ($ordersProductsInfo as $order_k => $order_v) {
            $ordersProductsInfo[$order_k]['source_image'] = $productThumbImage
                ->setThumbImage(['size_w'=>60,'size_h'=>60])
                ->getResourceImage($order_v['products_id'], true);
            $ordersProductsInfo[$order_k]['products_price'] = $curr->format(
                $order_v['products_price'],
                2,
                true,
                $this->currency,
                1
            );
        }

        return $ordersProductsInfo;
    }


    /**
     * @Notes:获取评论标签数据
     *
     * @param string $products_id
     * @return mixed
     * @auther: Dylan
     * @Date: 2020/12/4
     * @Time: 22:08
     */
    public function getReviewsLabel($products_id = '')
    {
        if ($this->relatedArr) {
            $relatedArr = $this->relatedArr;
        } else {
            $relatedArr = $this->allProductRelatedPid((int)$products_id);
            $relatedArr = $relatedArr['data'];
        }
         return $this->review->selectRaw(
                'count(reviews.reviews_id) as label_num, reviews_label_desc.label_text, reviews_label.id,reviews.reviews_id'
            )
            ->leftJoin('reviews_to_label', 'reviews.reviews_id', '=', 'reviews_to_label.reviews_id')
            ->leftJoin('reviews_label', 'reviews_to_label.label_id', '=', 'reviews_label.id')
            ->leftJoin('reviews_label_desc', 'reviews_label.id', '=', 'reviews_label_desc.label_id')
            ->where('reviews.check_status', 1)
            ->where('reviews.status', 1)
            ->whereIn('reviews.products_id', $relatedArr)
            ->whereIn('reviews.languages_id', $this->setLanguagesWhere())
            ->where('reviews_label_desc.language_id', $this->language_id==9 ? 1 : $this->language_id)
            ->where('reviews_label.parents_id', 0)
            ->orderBy('label_num', 'DESC')
            ->orderBy('reviews_label_desc.label_text')
            ->orderBy(DB::raw('CONVERT (reviews_label_desc.label_text USING gbk)'))
            ->groupBy('reviews_label_desc.label_text')
            ->get()
            ->toArray();
    }
}
