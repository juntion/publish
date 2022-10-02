<?php
namespace App\Services\Image;

use App\Services\BaseService;
use App\Models\ImagesToWebp as ImagesToWebpModel;

class ImageService extends BaseService
{
    //表images_to_webp的模型对象
    protected $imagesTowebpObj = '';

    public function __construct()
    {
        parent::__construct();

        $this->imagesTowebpObj = new ImagesToWebpModel();
    }

    /**
     * @param array $origin_path 图片的原始路径
     * @param array $fields 获取的字段
     * @return array
     */
    //public function getwebppath($origin_paths = array(), $fields = array('origin_path', 'webp_path'))
    //{
    //    $temp = array();
    //    if ((!is_array($origin_paths)) || count($origin_paths) < 0) {
    //
    //        return $temp;
    //    }
    //
    //    //对传进来的origin_path进行处理
    //    $temp_origin_paths = array();
    //    foreach ($origin_paths as $key => $origin_path) {
    //
    //        $origin_path_array = explode('/', $origin_path);
    //        //去掉为空的
    //        $origin_path_array = array_filter($origin_path_array);
    //        //current获取第一个元素, 不要写成$origin_path_array[0], 第一个元素可能是下标为1的
    //        if (current($origin_path_array) != 'images') {
    //            array_unshift($origin_path_array, 'images');
    //            $temp_origin_paths[$origin_path] = '/'.implode('/', $origin_path_array);
    //        } else {
    //            //似乎不用作处理
    //            $temp_origin_paths[$origin_path] = '/'.implode('/', $origin_path_array);
    //        }
    //    }
    //
    //    $origin_paths = array_values($temp_origin_paths);
    //
    //    //键值互换
    //    $temp_origin_paths = array_flip($temp_origin_paths);
    //    $temp_origin_paths_keys = array_keys($temp_origin_paths);
    //
    //    $images = $this->imagesTowebpObj->whereIn('origin_path', $origin_paths)->select($fields)->get()->toArray();
    //
    //    if (count($images) > 0) {
    //        foreach ($images as $key => $image) {
    //            //避免webp_path为空
    //            if ($image['webp_path']) {
    //                if (in_array($image['origin_path'], $temp_origin_paths_keys)) {
    //                    $temp_key = $temp_origin_paths[$image['origin_path']];
    //
    //                    $temp[$temp_key] = $image['webp_path'];
    //                }
    //
    //            }
    //        }
    //    }
    //
    //    return $temp;
    //
    //}


    public function getwebppathbyids($type_ids, $type_label, $type_fields = array(), $language_id = 0, $fields = array(), $warehouse = 0)
    {
        $temp = array();
        if ((!is_array($type_ids)) || count($type_ids) < 0) {
            return $temp;
        }
        $query = $this->imagesTowebpObj->whereIn('type_id', $type_ids);
        if ($type_label) {
            $query = $query->where('type_label', $type_label);
        }
        if (is_array($type_fields) && $type_fields) {
            $query = $query->whereIn('table_field', $type_fields);
        }
        if ($language_id) {
            $query = $query->where('language_id', $language_id);
        } else {
            $query = $query->where('language_id', 1);
        }
        $warehouse = intval($warehouse);
        $query = $query->where('warehouse', $warehouse);

        $fields = array_merge($fields, array('type_id', 'table_field', 'origin_path', 'webp_path'));
        $fields = array_unique($fields);

        $images = $query->select($fields)->get()->toArray();
        if (count($images) > 0) {
            foreach ($images as $key => $image) {
                $temp[$image['type_id']][$image['table_field']] = $image['webp_path'];
            }
        }

        return $temp;
    }
}
