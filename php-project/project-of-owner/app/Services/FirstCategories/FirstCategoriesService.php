<?php


namespace App\Services\FirstCategories;

use App\Models\FsFirstCategoriesBannerManage;
use App\Models\FsFirstCategoriesManage;
use App\Models\CategoriesDescription;
use App\Services\BaseService;
use App\Models\ProductsListTags;
use Illuminate\Database\Capsule\Manager as DB;

class FirstCategoriesService extends BaseService
{
    private $fsFirstCategoriesBannerManage;
    private $fsFirstCategoriesManage;
    private $productsListTags;
    private $categoriesId = 0;
    private $productsIds = [];
    private $languagesId;
    private $artcleIds = [];

    function __construct($cid = '')
    {
        parent::__construct();

        $this->fsFirstCategoriesBannerManage = new FsFirstCategoriesBannerManage();

        $this->fsFirstCategoriesManage = new FsFirstCategoriesManage();

        $this->productsListTags = new ProductsListTags();

        $this->languagesId = !in_array($this->language_id, [1, 9]) ? $this->language_id : 1;

        $this->categoriesId = $cid ? (int)$cid : 911;
    }


    /**
     * @Notes: 获取一级分类banner数据
     *
     * @return array
     * @auther: Dylan
     * @Date: 2021/1/6
     * @Time: 18:35
     */
    function getFirstCategoriesBanner()
    {
        $bannerInfo = $this->fsFirstCategoriesBannerManage
            ->where('languages_id', $this->languagesId)
            ->where('categories_id', $this->categoriesId)
            ->orderBy('sort','ASC')
            ->get()
            ->toArray();
        $bannerData = [];
        foreach ($bannerInfo as $key => $value) {
            if ($value['banner_path']) {
                $value['banner_path'] = self::trans('HTTPS_IMAGE_SERVER').$value['banner_path'];
            }
            $bannerData[$value['type']][] = $value;
        }
        return $bannerData;
    }

    /**
     * @Notes: 获取一级分类对应的板块数据
     *
     * @return array
     * @auther: Dylan
     * @Date: 2021/1/6
     * @Time: 19:18
     */
    function getFirstCategoriesPlate()
    {
        $plateInfo = $this->fsFirstCategoriesManage
            ->where('languages_id', $this->languagesId)
            ->where('categories_id', $this->categoriesId)
            ->orderBy('sort','ASC')
            ->get()
            ->toArray();
        $plateData = [];
        foreach ($plateInfo as $key => $value) {
            if ($value['path']) {
                $value['path'] = self::trans('HTTPS_IMAGE_SERVER').$value['path'];
            }
            $plateData[$value['type']][] = $value;
            if ($value['type'] == 2 && $value['products_id']) { //best sellers板块
                $this->productsIds[] = (int)$value['products_id'];
            }

            if ($value['type'] == 4) {
                $this->artcleIds[] = $value['action_id'] ? $value['action_id'] : 0;
            }
        }


        return $plateData;
    }

    /** 获取分类名
     * @Notes:
     *
     * @return mixed
     * @auther: Dylan
     * @Date: 2021/1/7
     * @Time: 12:17
     */
    function getCategoriesName()
    {
        return (new CategoriesDescription())
            ->where('categories_id', $this->categoriesId)
            ->where('language_id', $this->language_id)
            ->first(['categories_name']);
    }

    /**
     * @Notes: 获取产品tag标签
     *
     * @return array
     * @auther: Dylan
     * @Date: 2021/1/8
     * @Time: 18:37
     */
    function getProductTagInfo()
    {
        $tagData = [];
        if (!$this->productsIds) {
            return $tagData;
        }
        if (in_array($this->language_code, array('uk', 'dn' , 'au', 'en'))){
            $languageId = 1;
        } else {
            $languageId = $this->language_id;
        }
        $tagInfo = $this->productsListTags
            ->where('languages_id', $languageId)
            ->whereIn('products_id', $this->productsIds)
            ->get(['tags', 'vice_tags', 'products_id'])
            ->toArray();
        foreach ($tagInfo as $k => $v) {
            $tagData[$v['products_id']] = $v;
        }
        return $tagData;
    }

    /**
     * @Notes:获取文章当前一级分类下的所有文章id
     *
     * @auther: Dylan
     * @Date: 2021/1/15
     * @Time: 19:31
     */
    function getActionIds()
    {
        $actionInfo = $this->fsFirstCategoriesManage
            ->where('languages_id', $this->languagesId)
            ->where('categories_id', $this->categoriesId)
            ->where('type', 5)
            ->get()
            ->toArray();
        foreach ($actionInfo as $value) {
            $this->artcleIds[] = $value['action_id'] ? $value['action_id'] : 0;
        }
    }

    /**
     * @Notes: 获取community文章视频时间
     *
     * @return array
     * @auther: Dylan
     * @Date: 2021/1/15
     * @Time: 19:42
     */
    function getArticleData()
    {
        try {
            $article_ids = $this->artcleIds ? $this->artcleIds : $this->getActionIds();
            $community_db = DB::connection('community');
            if(in_array($this->language_code,['de','es','fr','it','jp','ru'])){
                $detail_table = 'post_'.$this->language_code.'_details';
            }else{
                $detail_table = 'post_details';
            }
            $result = $community_db->table($detail_table.' as pd')
                ->leftJoin('authors as a', 'pd.virtual_author', '=', 'a.id')
                ->whereIn('pd.post_id', $article_ids)
                ->where('post_type', 'post')
                ->whereIn('post_status', ['publish', 'future'])
                ->get(['pd.post_id', 'a.name', 'a.photo', 'pd.read_account', 'pd.video_time']);
            $etn_data = [];
            foreach ($result as $value){
                //$etn_data['data'][$value['post_id']]['name'] = $value['name'];
                //$etn_data['data'][$value['post_id']]['photo'] = HTTPS_IMAGE_SERVER.$value['photo'];
                //$etn_data['data'][$value['post_id']]['read_account'] = $value['read_account'];
                if(!in_array($value['video_time'],['','00:00'])){
                    $etn_data['data'][$value['post_id']]['video_time'] = $value['video_time'];
                }
            }
            return $etn_data;
        } catch (\Exception $e) {
            echo "<div style='display: none;'>".$e->getMessage()."</div>";
        }
    }
}