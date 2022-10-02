<?php


namespace App\Services\ElasticSearch;

use App\Models\Product;
use App\Services\BaseService;

class ElasticSearch extends BaseService
{
    private $user_beta = 'quest';
    private $password_beta = 'W2752063q#';
    private $es_url_beta = 'https://search-elkdemo-pcfaz2dbduipgyce6fl2cxu6oq.cn-northwest-1.es.amazonaws.com.cn/';
    private $user = 'quest';
    private $password = 'W2752063q#';
    private $es_url = 'https://search-elkdemo-pcfaz2dbduipgyce6fl2cxu6oq.cn-northwest-1.es.amazonaws.com.cn/';
    private $auth;
    private $is_test = false;

    private $products_m;

    public function __construct()
    {
        $this->is_test = strstr($_SERVER['HTTP_HOST'],'fs.com') ? false : true;
        $this->auth = $this->is_test ? $this->user_beta.':'.$this->password_beta : $this->user.':'.$this->password;
        $this->products_m = new Product();
    }

    /**
     * $Notes: 获取ES搜索结果
     *
     * $author: Quest
     * $Date: 2021/1/26
     * $Time: 11:22
     * @param $str
     * @param int $type
     * @param $sort_type
     * @param $current_num
     * @param $page
     * @param $scr_str
     * @return array
     */
    public function getSearchData($str, $type = 3, $sort_type, $current_num, $page, $scr_str)
    {
        $products_name = 'products_name'.(in_array($_SESSION['languages_code'], ['en','sg','au','dn']) ? '' : '_'.$_SESSION['languages_code']);
        switch ($type){
            case 1://产品id
                $select_arr = array(
                    'must' => [
                        ['match' => ['show_type' => 0]],
                        ['match' => ['products_id' => $str]]
                    ]
                );
                break;
            case 2://产品筛选项
                $str_arr = explode(',', $scr_str);
                $str_n = '';
                foreach ($str_arr as $n_v) {
                    $str_n .= '*' . $n_v;
                }
                $str_n .= '*';
                $select_arr = array(
                    'must' => [
                        ['match' => ['products_status' => 1]],
                        ['match' => ['show_type' => 0]],
                        ['wildcard' => ['products_narrow_id' => ["value" => $str_n]]],
                        [
                            'bool' => [
                                'should' => [
                                    [
                                        'match' => [
                                            $products_name => ["query" => $str, "operator" => 'and']
                                        ]
                                    ],
                                    ['match_phrase' => ['products_model' => $str]],
                                    ['match_phrase' => ['products_SKU' => $str]]
                                ]
                            ]
                        ]
                    ]
                );
                break;
            default://产品名和产品model
                $select_arr = array(
                    'must' => [
                        ['match' => ['products_status' => 1]],
                        ['match' => ['show_type' => 0]],
                        [
                            'bool' => [
                                'should' => [
                                    [
                                        'match' => [
                                            $products_name => ["query" => $str, "operator" => 'and']
                                        ]
                                    ],
                                    ['match_phrase' => ['products_model' => $str]],
                                    ['match_phrase' => ['products_SKU' => $str]]
                                ]
                            ]
                        ]
                    ]
                );
                break;
        }

        $data = [
            "query" => [
                'bool' => $select_arr
            ]
        ];
        switch ($sort_type){
            case 'rate':
                $data['sort'] = ['reviews_num' => ['order' => 'desc']];
                break;
            case 'price':
                $data['sort'] = ['products_price' => ['order' => 'asc']];
                break;
            case 'priced':
                $data['sort'] = ['products_price' => ['order' => 'desc']];
                break;
            case 'new':
                $data['sort'] = ['products_date_added' => ['order' => 'desc']];
                break;
            default:
                $data['sort'] = ['products_sales_num' => ['order' => 'desc']];
                break;
        }

        $url = ($this->is_test ? $this->es_url_beta : $this->es_url).'fs_products/products/_search';
        $p_search_data = array_merge($data, [ "from" => ($page - 1) * $current_num, "size" => $current_num]);
        $res_obj = $this->getEsCurlPost($p_search_data, $url);

        $res_data = [];
        $res_count = 0;
        if(!isset($res_obj->error)){
            $data_obj = $res_obj->hits->hits;
            $res_count = $res_obj->hits->total->value;
            $res_count = $res_count > 3000 ? 3000 : $res_count;

            foreach ($data_obj as $item){
                $res_data[] = array(
                    'products_id' =>  $item->_source->products_id,
                    'products_model' =>  $item->_source->products_model,
                    'products_name' =>  $item->_source->products_name,
                    'products_name_es' =>  $item->_source->products_name_es,
                    'products_name_fr' =>  $item->_source->products_name_fr,
                    'products_name_ru' =>  $item->_source->products_name_ru,
                    'products_name_de' =>  $item->_source->products_name_de,
                    'products_name_jp' =>  $item->_source->products_name_jp,
                    'products_name_it' =>  $item->_source->products_name_it,
                    'products_name_uk' =>  $item->_source->products_name_uk,
                    'products_status' =>  $item->_source->products_status,
                    'offline_replace_products_id' =>  $item->_source->offline_replace_products_id,
                    'offline_replace_products_type' =>  $item->_source->offline_replace_products_type,
                    'offline_sales_num' =>  $item->_source->offline_sales_num,
                    'product_sales_total_num' =>  $item->_source->product_sales_total_num,
                    'products_sales_num' =>  $item->_source->products_sales_num,
                    'integer_state' =>  $item->_source->integer_state,
                    'is_min_order_qty' =>  $item->_source->is_min_order_qty,
                    'products_sort_order' =>  $item->_source->products_sort_order,
                    'products_image' =>  $item->_source->products_image,
                    'products_price' =>  $item->_source->products_price,
                    'products_SKU' =>  $item->_source->products_SKU,
                    'is_inquiry' =>  $item->_source->is_inquiry,
                    'new_products_tag' =>  $item->_source->new_products_tag,
                    'new_products_time' =>  $item->_source->new_products_time,
                    'composite_products' =>  $item->_source->composite_products,
                    'us_status' =>  $item->_source->us_status,
                    'de_status' =>  $item->_source->de_status,
                    'au_status' =>  $item->_source->au_status,
                    'sg_status' =>  $item->_source->sg_status,
                    'ru_status' =>  $item->_source->ru_status,
                    'cn_status' =>  $item->_source->cn_status,
                    'products_narrow_id' =>  $item->_source->products_narrow_id,
                    'reviews_num' =>  $item->_source->reviews_num,
                   );
            }
        }

        $count_url = ($this->is_test ? $this->es_url_beta : $this->es_url).'fs_products/products/_search?_source=products_id';
        $p_count_data = array_merge($data, [ "from" => 0, "size" => 3000]);
        $count_obj = $this->getEsCurlPost($p_count_data, $count_url);
        $products_id_count = [];
        if(!isset($count_obj->error)){
            $data_obj = $count_obj->hits->hits;
            foreach ($data_obj as $item){
                $products_id_count[] = $item->_source->products_id;
            }
        }

        return ['data' => $res_data, 'count' => $res_count, 'all_products_id' => $products_id_count];
    }

    /**
     * $Notes: 搜索分类
     *
     * $author: Quest
     * $Date: 2021/1/27
     * $Time: 16:40
     * @param $str
     * @return array
     */
    public function getCategoriesSearchData($str)
    {
        $data = [
            "query" => [
                'bool' => [
                    'must' => [
                        ['match_phrase' => ["language_id" => $_SESSION['languages_id']]],
                        [
                            'bool' => [
                                'should' => [
                                    ['wildcard' => ['categories_name' => ["value" => $str]]],
                                    ['wildcard' => ['categories_name_auto' => ["value" => $str]]]
//                                    ['match_phrase' => ['categories_name' => $str]],
//                                    ['match_phrase' => ['categories_name_auto' => $str]]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'aggs' => [
                'gb_cate' => ['terms' => ['field' => 'categories_id']]//对分类id执行group by操作
            ]
        ];
        $url = ($this->is_test ? $this->es_url_beta : $this->es_url).'fs_categories/categories/_search?_source=categories_id';
        $res_obj = $this->getEsCurlPost($data, $url);
        $cate_id_count = [];
        if(!isset($count_obj->error)){
            $data_obj = $res_obj->hits->hits;
            foreach ($data_obj as $item){
                $cate_id_count[] = $item->_source->categories_id;
            }
        }
        return $cate_id_count;
    }

    /**
     * $Notes: CURL请求ES服务器
     *
     * $author: Quest
     * $Date: 2021/1/22
     * $Time: 15:08
     * @param array $data
     * @param string $url
     * @return array|mixed|string
     */
    public function getEsCurlPost($data = array(), $url = '')
    {
        if(empty($url)){
            $url = ($this->is_test ? $this->es_url_beta : $this->es_url).'fs_products/products/_search';
        }
        $data = json_encode($data,JSON_UNESCAPED_UNICODE );

        $headers = ["Content-Type:application/json"];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $this->auth);//设置用户名密码
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);//设置json
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $data = curl_exec($ch);
        curl_close($ch);

        return json_decode($data);
    }

    /**
     * $Notes: 同步产品搜索数据
     *
     * $author: Quest
     * $Date: 2021/1/27
     * $Time: 16:20
     * @return array
     */
    public function SyProductsData()
    {
        $products_arr = $this->products_m
            ->selectRaw(
                'p.products_id, p.products_model, pd.products_name,
                pes.products_name AS products_name_es, pfr.products_name AS products_name_fr,
                pru.products_name AS products_name_ru, pde.products_name AS products_name_de,
                pjp.products_name AS products_name_jp, pit.products_name AS products_name_it,
                puk.products_name AS products_name_uk, p.products_status, p.offline_replace_products_id,
                p.offline_replace_products_type, p.offline_sales_num,
                (p.offline_sales_num + p.product_sales_total_num) AS products_sales_num,
                p.products_date_added, p.integer_state, p.is_min_order_qty, p.products_sort_order,
                p.products_image, p.products_price, p.products_SKU, p.is_inquiry, p.new_products_tag,
                p.new_products_time, pc.composite_products, p.show_type,
                p.us_status, p.de_status, p.au_status, p.sg_status, p.ru_status, p.cn_status,
                GROUP_CONCAT(
                DISTINCT(pn.products_narrow_by_options_values_id) 
                ORDER BY pn.products_narrow_by_options_values_id) AS products_narrow_id,
                COUNT(r.reviews_id) AS reviews_num'
            )
            ->from('products as p')
            ->leftjoin('products_description as pd  ', 'p.products_id', '=', 'pd.products_id')
            ->leftjoin('products_composite as pc  ', 'p.products_id', '=', 'pc.products_id')
            ->leftjoin('products_narrow_by_option_values_to_products as pn', 'p.products_id', '=', 'pn.products_id')
            ->leftjoin('reviews as r', 'p.products_id', '=', 'r.products_id')
            ->leftjoin('products_description_es as pes', 'p.products_id', '=', 'pes.products_id')
            ->leftjoin('products_description_fr as pfr', 'p.products_id', '=', 'pfr.products_id')
            ->leftjoin('products_description_ru as pru', 'p.products_id', '=', 'pru.products_id')
            ->leftjoin('products_description_de as pde', 'p.products_id', '=', 'pde.products_id')
            ->leftjoin('products_description_de as pjp', 'p.products_id', '=', 'pjp.products_id')
            ->leftjoin('products_description_de as pit', 'p.products_id', '=', 'pit.products_id')
            ->leftjoin('products_description_de as puk', 'p.products_id', '=', 'puk.products_id')
            ->groupBy('p.products_id')
            ->get()
            ->toArray();

        $cl = curl_init();
        curl_setopt($cl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($cl, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($cl, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($cl, CURLOPT_TIMEOUT, 0);
        curl_setopt($cl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($cl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cl, CURLOPT_USERPWD, $this->auth);
        curl_setopt($cl, CURLOPT_FORBID_REUSE, 0);
        curl_setopt($cl, CURLOPT_CUSTOMREQUEST, 'PUT'); //GET 获取 // DELETE 删除 //PUT 插入

        $res_bool = true;
        foreach ($products_arr as $p_info) {
            $p_info['is_min_order_qty'] = empty($p_info['is_min_order_qty']) ? '' : $p_info['is_min_order_qty'];
            $p_info['composite_products'] = empty($p_info['composite_products']) ? '' : $p_info['composite_products'];

            $p_info['products_id'] = intval($p_info['products_id']);
            $p_info['offline_sales_num'] = intval($p_info['offline_sales_num']);
            $p_info['product_sales_total_num'] = intval($p_info['product_sales_total_num']);
            $p_info['reviews_num'] = intval($p_info['reviews_num']);
            $p_info['products_price'] = floatval($p_info['products_price']);
            $p_info['products_status'] = floatval($p_info['products_status']);
            $p_info['show_type'] = floatval($p_info['show_type']);
            $p_info['products_sales_num'] = intval($p_info['products_sales_num']);
            $jsonStr = json_encode($p_info, JSON_UNESCAPED_UNICODE);
            $baseUri = $this->es_url . 'fs_products/products/' . $p_info['products_id'];

            try {
                curl_setopt($cl, CURLOPT_URL, $baseUri);
                curl_setopt($cl, CURLOPT_POSTFIELDS, $jsonStr);
                $response = curl_exec($cl);
                if(isset($response->error)){
                    $res_bool = false;
                }
            } catch (Exception $e) {
                $res_bool = false;
            }
        }
        curl_close($cl);

        return $res_bool;
    }

}
