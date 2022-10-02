<?php


namespace App\Services\Orders;

use App\Models\ReviewsImage;
use App\Services\BaseService;
use App\Services\Orders\OrderService;
use App\Services\Orders\OrderProductService;
use App\Services\Products\ProductService;
use App\Models\Review;
use Illuminate\Database\Capsule\Manager as DB;
use App\Models\ReviewsDescription;
use App\Models\ReviewLikeOrNot;
use App\Models\ProductDescription;
use App\Services\Common\Upload\UploadService;
use App\Services\Country\CountryService;
use App\Models\ProductThumbImage;
use App\Models\ReviewsImageAnchor;

/**
 * 订单评价service
 *
 * @author aron
 * @date 2019.11.19
 * Class OrderReviewService
 * @package App\Services\Orders
 */
class OrderReviewService extends BaseService
{
    public $order;
    private $orderProduct;
    private $orderId;
    private $orderProductId;
    private $review;
    private $reviewsDescription;
    private $reviewsLikeOrNot;
    private $reviewImage;
    private $country;
    private $image;
    private $products;
    private $productDescription;
    private $reviewsImageAnchor;

    public function __construct()
    {
        parent::__construct();
        $this->order = new OrderService();
        $this->orderProduct = new OrderProductService();
        $this->review = new Review();
        $this->reviewsDescription = new ReviewsDescription();
        $this->reviewsLikeOrNot = new ReviewLikeOrNot();
        $this->reviewImage = new ReviewsImage();
        $this->country = new CountryService();
        $this->image = new ProductThumbImage();
        $this->products = new ProductService();
        $this->productDescription = new ProductDescription();
        $this->reviewsImageAnchor = new ReviewsImageAnchor();
    }

    /**
     * 设置查询 order_id && orderProductId
     *
     * @param array $ids
     * @return $this
     */
    public function setId(array $ids)
    {
        $this->orderId = $ids['order_id'];
        $this->orderProductId = $ids['ordersProductId'];
        return $this;
    }

    /**
     * 判断当前客户是否有权限访问该页面
     *
     * @param int $orders_id
     * @return bool
     */
    public function isAllowVisit($orders_id = 0)
    {
        return $check = $this->order->checkCustomerVisitOrdersLimit($orders_id);
    }


    /**
     * 根据评价产品id 获取评价信息
     *
     * @param int $orderId
     * @param int $orderPid
     * @return \App\Services\Orders\OrderProductService | array
     */
    public function getReviewInfo($orderId = 0, $orderPid = 0)
    {

        if (empty($orderId)) {
            return [];
        }
        //同时传入 orders id 和orders products id 则返回当前orders_products id 数据
        $data = $this->orderProduct->isLoadReview(true)->getOrderProductsInfo($orderId, $orderPid);
        if (!empty($data)) {
            foreach ($data as &$item) {
                $order_info = $this->order->getOrdersFieldsInfo($orderId, ['date_purchased', 'delivery_country_id']);
                $item['date_purchased'] = $order_info['date_purchased'];
                $item['delivery_country_code'] = $this->country->getCountryCodeById($order_info['delivery_country_id']);
            }
        }
        return $data;
    }

    /**
     * 新增review 数据
     *
     * @param array $data
     * @return bool
     * @author aron
     * @date 2019.11.20
     */
    public function addReview($data = [])
    {

        $reviewData = $data['reviewData'];
        $reviewDescription = $data['reviewDescription'];
        $orders_id = $data['orders_id'];
        $files = $data['files'];
        $tagAnchorData = $data['tagAnchorData'];
        if (empty($reviewData) || empty($reviewDescription)) {
            return false;
        }
        try {
            //多张表更新时可以使用事务
            DB::transaction(function () use ($reviewData, $reviewDescription, $orders_id, $files, $tagAnchorData) {
                //更新review 表
                $review = $this->review->create($reviewData);
                $review_id = $review->reviews_id;
                $reviewDescription['reviews_id'] = $review_id;
                //更新review 描述表
                $this->reviewsDescription->create($reviewDescription);
                //更新点赞数量表
                $this->reviewsLikeOrNot->create([
                    'reviews_id' => $review_id,
                    'r_like' => 0
                ]);
                //评论图片 添加到数据库
                $upload = new UploadService();
                $upload->setConfig([
                    'savePath' => 'reviews/' . $reviewData['products_id'],
                    'fileExtension' => ['image/png', 'image/jpg', 'image/jpeg']
                ]);

                if (is_array($files)) {
                    $paths = $upload->uploads($files);
                    //图片批量上传成功
                    if (!empty($paths)) {
                        foreach ($paths as $k => $v) {
                            $file_array = array(
                                'reviews_id' => $review_id,
                                'reviews_image' => $reviewData['products_id'] . "/" . $v['fileName'],
                                'products_id' => $reviewData['products_id'],
                            );
                            $imgId = $this->reviewImage->insertGetId($file_array);
                            //场景tag数据插入

                            if (is_array($tagAnchorData[$k]) && $tagAnchorData[$k]) {
                                foreach ($tagAnchorData[$k] as $kk => $vv) {
                                    $tagAnchorData[$k][$kk]['reviews_image_id'] = $imgId;
                                    //场景图锚点表
                                    $this->reviewsImageAnchor->insert($tagAnchorData[$k][$kk]);
                                }
                            }
                        }
                    }
                }
                //获取所有关联订单id
                $orderInfo = $this->order->getAllOrdersIdByOrderId($orders_id);
                //获取订单是否全部以评价
                $isReviewed = $this->isReviewed($orderInfo);
                $isAllReviewed = $isReviewed['isAllReviewed'];
                $main_order_id = $orderInfo['main'];
                //判断当前订单是否已经评价完成
                $current = $isReviewed[$orders_id];
                if ($current['isReviewed']) {
                    $this->order->updateOrdersInfo($orders_id, ['is_reviewed' => 1]);
                }
                //如果所有分单 已经评论完成，则主单 更新为1
                if ($isAllReviewed && $main_order_id) {
                    $this->order->updateOrdersInfo($main_order_id, ['is_reviewed' => 1]);
                }
            });
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 获取当前以及关联分单reviewed 状态
     *
     * @param array $orderInfo
     * @return array
     */
    public function isReviewed($orderInfo = [])
    {
        // 所有产品都评价，才能设置订单为已经评价
        $data = [];
        $data['isAllReviewed'] = true;
        $orderInfo = $orderInfo['son'];
        if (!empty($orderInfo)) {
            foreach ($orderInfo as $items) {
                $currentAllProducts = $this->getReviewInfo($items);
                $data[$items]['isReviewed'] = true;
                if (!empty($currentAllProducts)) {
                    //只要一个产品未评论则当前订单为未评论状态
                    foreach ($currentAllProducts as $item) {
                        if (empty($item['review'])) {
                            $data[$items]['isReviewed'] = false;
                            break;
                        }
                    }
                }
            }
        }
        foreach ($data as $k => $v) {
            if ($k == "isAllReviewed") {
                continue;
            }
            if (!$v['isReviewed']) {
                $data['isAllReviewed'] = false;
                break;
            }
        }
        return $data;
    }

    /**
     * 获取评价产品数据
     * @param int $offset
     * @param string $search
     * @param int $limit
     * @return array
     * @author aron
     * @date 2019.11.23
     */
    public function getReviewList($offset = 1, $search = '', $limit = 15)
    {
        //获取关闭仓库where
        $warehouWhereFiled = $this->fsProductsWarehouseWhere($this->countries_iso_code)['code'] . '_status';
        $filed = '';
        //获取查询where
        if (!empty($search)) {
            //如果是数字，那么必定是产品id
            if (is_numeric($search)) {
                $filed = 'op.products_id';
            } elseif (is_string($search)) {
                $filed = "o.orders_number";
            }
        }
        $offset = ($offset - 1) * $limit;
        /**
         * 只查询未评价开启的产品
         */
        $query = $this->orderProduct->orderProductObj->from('orders_products as op')
            ->select(['op.orders_products_id', 'op.products_name', 'op.orders_id', 'o.orders_number', 'op.products_id', 'p.products_model'])
            ->leftJoin('orders as o', 'o.orders_id', '=', 'op.orders_id')
            ->leftJoin('products as p', 'p.products_id', '=', 'op.products_id')
            ->whereRaw('IF(o.`payment_module_code` IN ("purchase","rechnung")
                , o.orders_status IN (3,4,2), o.orders_status IN (3,4))')
            ->where('o.is_reviewed', 0)
            ->where('o.customers_id', $this->customer_id)
            ->where('p.' . $warehouWhereFiled, 1)
            ->where('p.products_status', 1)
            ->whereNotExists(function ($query) {
                $query->select('orders_products_id')->from('reviews as r')
                    ->whereRaw('op.orders_products_id = r.orders_products_id')
                    ->where('r.customers_id', $this->customer_id);
            })->orderByRaw('o.date_purchased DESC');
        //设置查询字段
        if (!empty($filed)) {
            $query->where($filed, $search);
        }
        $count = $query->count();
        $data = $query->limit($limit)->offset($offset)->get();
        $return = [];
        if (!empty($data)) {
            $return['data'] = $data->toArray();
            foreach ($return['data'] as &$item) {
                $item['image'] = $this->image->setThumbImage(['size_w' => 180, 'size_h' => 180])
                    ->getResourceImage($item['products_id']);
            }
            $return['count'] = $count;
        }
        return $return;
    }
}
