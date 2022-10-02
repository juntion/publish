<?php

namespace App\Models;

use App\Models\BaseModel;

class ProductThumbImage extends BaseModel
{
    //
    protected $table = 'products_additional_thumb_images';
    /*
   * 设置产品缩略图配置
   * size_w img的宽度
   * size_h img的高度
   * local_img 本地的img路径，兼容处理时使用
   * alt_val img标签的alt
   * title_val img标签的title
   * param img标签内的其他参数x
   * is_main 是否主图
   * additional_id 指定缩略图id
   */
    private static $thumb_image_config = ['size_w' => '', 'size_h' => '', 'local_img' => '',
        'alt_val' => '', 'title_val' => '', 'param' => '', 'is_main' => 1, 'additional_id' => ''];


    /**
     * 获取产品缩略图
     *
     * @param Product $product
     * @return string
     */
    public function getResourceImage($products_id = 0, $show = false, $product_status = 1)
    {
        $imagePath = self::trans('HTTPS_PRODUCTS_SERVER').self::trans('DIR_WS_IMAGES');
        $size_array = array('60', '80', '120', '180', '550');
        $size_w = self::$thumb_image_config['size_w'];
        $size_h = self::$thumb_image_config["size_h"];
        $alt_val = self::$thumb_image_config['alt_val'];
        $title_val = self::$thumb_image_config['title_val'];
        $param = self::$thumb_image_config['param'];
        $additional_id = self::$thumb_image_config['additional_id'];
        $is_main = self::$thumb_image_config['is_main'];
        $local_img = self::$thumb_image_config['local_img'];
        $size_rel_w = "";
        $size_rel_h = "";
        for ($i = 0; $i < count($size_array); $i++) {
            if ($size_array[$i] >= $size_w) {
                $size_rel_w = $size_array[$i];
                $size_rel_h = $size_array[$i];
                break;
            };
        };
        if (empty($alt)) {
            $alt = ' alt="' . $alt_val . '"';
        }
        if (empty($title)) {
            $title = ' title="' . $title_val . '"';
            $param .= $title;
        }
        $query = self::where('products_id', $products_id);
        if (!empty($additional_id)) {
            $query->where('additional_images_id', $additional_id);
        }
        if (in_array($is_main, [0, 1])) {
            $query->where('is_main', $is_main);
        }
        if (!empty($size_w) && !empty($size_h)) {
            $query->where('size_w', $size_rel_w)->where('size_h', $size_rel_h);
        }

        $thumb = $query->get()->toArray();

        if (!empty($thumb)) {
            $image_src = $imagePath . 'products/' . $thumb['0']['thumb_images'];
            $image = '<img src="' . $image_src . '" ' . $alt . $title . ' width="' . $size_w . '" height="' . $size_h . '"' . $param . '>';
        } else {
            //当没有图片时都调用默认图片
            $image_src = self::trans('HTTPS_PRODUCTS_SERVER').'includes/templates/fiberstore/images/logo_trad.jpg';
            $image = '<img src="'.$image_src.'" width="' . $size_w . '" height="' . $size_h . '"' . $image_src . '>';

           /* if ((in_array($_GET['main_page'], array('manage_orders','account_history_info')) || $_GET['handler']='ajax_manage_orders_new') && $product_status==1) {
                $image_src = self::trans('HTTPS_PRODUCTS_SERVER').'includes/templates/fiberstore/images/logo_trad.jpg';
                $image = '<img src="'.$image_src.'" width="' . $size_w . '" height="' . $size_h . '"' . $image_src . '>';
                $imagePath="";
            } else {
                $image_src = 'no_picture.gif';
                $image = '<img src="'.
                    $imagePath . $image_src . '"' . $alt . $title .
                    ' width="' . $size_w . '" height="' . $size_h . '"' . $param . '>';
            }*/
        }

        if ($show) {
            return $image;
        }

        return $image_src;
    }

    /**
     * 设置产品缩略图属性
     *
     * @param array $config
     * @return self
     */
    public function setThumbImage(array $config)
    {
        self::$thumb_image_config = array_merge(self::$thumb_image_config, $config);
        return $this;
    }

    public function getThumbImagesBySize($product_id = 0, $size_w = ['60','550'], $size_h = ['60','550'])
    {
        $small_image_src = $big_image_src = 'no_picture.gif';
        $small_thumb_image = $big_thumb_image = '';
        $small_w = $small_h = '60';
        $big_w = $big_h = '550';

        $imagePath = self::trans('HTTPS_PRODUCTS_SERVER').self::trans('DIR_WS_IMAGES');
        if ($product_id) {
            $query =  self::select(['thumb_images','size_w','size_h']);
            $query->where('products_id', $product_id)->where('is_main', 1);
            if (!empty($size_w) && !empty($size_h)) {
                if (!is_array($size_w)) {
                    $size_w = [$size_w];
                }
                if (!is_array($size_h)) {
                    $size_h = [$size_h];
                }
                $query->whereIn('size_w', $size_w)->whereIn('size_h', $size_h);
            }
            $sizeImages = $query->orderBy('size_w', 'ASC')
                          ->get();
            if (!empty($sizeImages)) {
                $thumb = $sizeImages->toArray();
                $small_image_src = 'products/' . $thumb['0']['thumb_images'];
                $big_image_src = 'products_cache/' . $thumb['1']['thumb_images'];
                $small_w = $thumb[0]['size_w'];
                $small_h = $thumb[0]['size_h'];
                $big_w = $thumb[1]['size_w'];
                $big_h = $thumb[1]['size_h'];
            }
        }
        $small_thumb_image = '<img src="' .$imagePath . $small_image_src . '" width="' . $small_w . '" height="' . $small_h . '">';
        $big_thumb_image = '<img src="' . $imagePath . $big_image_src . '" width="' . $big_w . '" height="' . $big_h . '">';
        return ['small_thumb_image'=>$small_thumb_image,'big_thumb_image'=>$big_thumb_image];
    }
}
