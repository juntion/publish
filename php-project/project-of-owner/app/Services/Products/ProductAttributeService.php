<?php

namespace App\Services\Products;

use App\Models\ProductOption;
use App\Models\ProductAttribute;
use App\Models\ProductLength;
use App\Models\ProductsOptionsValues;
use App\Services\BaseService;
use App\Models\ProductRelatedAttributesRelation;
use App\Models\TableColumnLanguages;
use Illuminate\Database\Capsule\Manager;

class ProductAttributeService extends BaseService
{
    private $optionObj;
    private $attributeObj;
    private $lengthObj;
    private $productRelatedAttributesRelation;
    private $productsOptionsValues;

    public function __construct()
    {
        parent::__construct();

        $this->optionObj = new ProductOption();
        $this->attributeObj = new ProductAttribute();
        $this->lengthObj = new ProductLength();
        $this->productsOptionsValues = new ProductsOptionsValues();
    }

    /**
     * 获取产品的所有属性个数
     * @param int $products_id
     * @return int
     */
    public function getProductAttributeTotal($products_id = 0)
    {
        $total = 0;
        if ($products_id) {
            $total = $this->attributeObj
                ->leftJoin(
                    'products_options',
                    'products_attributes.options_id',
                    '=',
                    'products_options.products_options_id'
                )
                ->where('products_attributes.products_id', $products_id)
                ->where('products_attributes.attributes_status', 1)
                ->where('products_options.products_options_status', 1)
                ->count();
        }
        return $total;
    }

    /**
     * 获取产品长度属性个数
     * @param int $products_id
     * @return int
     */
    public function getProductLengthTotal($products_id = 0)
    {
        $total = 0;
        if ($products_id) {
            $total = $this->lengthObj
                ->where('product_id', $products_id)
                ->where('custom', 0)
                ->count();
        }
        return $total;
    }


    /**
     * Note: 获取模块产品的关联属性
     * @author: Dylan
     * @Date: 2020/7/27
     *
     * @param array $products_id
     * @return array
     */
    public function getModuleModelRelated($products_id = [])
    {
        $relatedAttr = $relatedData = [];
        if (!$products_id) {
            return [];
        }
        $this->productRelatedAttributesRelation = new ProductRelatedAttributesRelation();
        $relatedObj = $this->productRelatedAttributesRelation
            ->leftJoin('product_related_attributes as A', 'product_related_attributes_relation.related_attribute_id', '=', 'A.id')
            ->leftJoin('table_column_languages as L', 'A.name_language_id', '=', 'L.unique_id')
            ->select(
                [
                    'product_related_attributes_relation.id',
                    'product_related_attributes_relation.attribute_val as r_eng_name',
                    'product_related_attributes_relation.related_attribute_id',
                    'product_related_attributes_relation.attribute_val_language_id',
                    'product_related_attributes_relation.product_id',
                    'A.name as a_eng_name',
                    'L.content as name',
                ]
            )
            ->whereIn('product_id', $products_id)
            ->where('L.language_id', $this->language_id)
            ->where('A.is_show_detail', 1)
            ->orderBy('A.sort', 'ASC')
            ->orderBy('A.id', 'ASC')
            ->groupBy('attribute_val')
            ->get();

        $productsModel = $this->getProductsModel($products_id);
        if (!empty($relatedObj)) {
            $relatedAttr = $relatedObj->toArray();
            $attributeValueLanguageId = $languageNameAttr = [];
            foreach ($relatedAttr as $item) {
                $attributeValueLanguageId[] = $item['attribute_val_language_id'];
            }

            if (!empty($attributeValueLanguageId)) {
                $tableColumnLanguages = new TableColumnLanguages();
                $languageNameAttr = $tableColumnLanguages
                    ->select('content', 'unique_id')
                    ->whereIn('unique_id', $attributeValueLanguageId)
                    ->where('language_id', $this->language_id)
                    ->get()
                    ->toArray();
            }


            foreach ($relatedAttr as $relatedKey => $attr) {
                $transceiver_type_model = [];
                //属性项transceiver type 调取products的model名称
                if (in_array(strtolower($attr['a_eng_name']), ['transceiver type'])) {
                    $transceiver_type_model = $productsModel[$attr['product_id']];
                }

                $related_attribute_content = $attr['name'];
                if (in_array(strtolower($attr['a_eng_name']), ['compatible'])) {
                    $related_attribute_content = FS_REVIEW_ATTRIBUTE_CONTENT;
                }
                $languageName = '';
                foreach ($languageNameAttr as $item) {
                    if ($item['unique_id'] == $attr['attribute_val_language_id']) {
                        $languageName = $item['content'];
                    }
                }

                $relatedData[] = array(
                    'product_id' =>$attr['product_id'],
                    'related_attribute_id' => $attr['related_attribute_id'],
                    'related_attribute_content' => $related_attribute_content,
                    'attributes_relation_id' => $attr['id'],
                    'attributes_relation_content' => $languageName ? $languageName : $attr['r_eng_name'],  //属性值
                    'transceiver_type_model' => $transceiver_type_model
                );
            }
        }
        return $relatedData;
    }


    public function getProductsModel($products_id = [])
    {
        $productsModel = [];
        if (!$products_id) {
            return [];
        }
        $products = new ProductService();
        $data =  $products->getProductsModel($products_id);
        foreach ($data as $model) {
            $productsModel[$model['products_id']] = array(
                'products_MFG_PART' => $model['products_MFG_PART'],
                'products_model' => $model['products_model'],
            );
        }
        return $productsModel;
    }

    public function findProductsOptionsValues($where, $fields = ['*'])
    {
        try {
            $result = $this->productsOptionsValues->newQuery()
                ->where($where)
                ->get($fields)->toArray();
        } catch (\Exception $e) {
            $result = [];
        }

        return $result;
    }

    public function findProductsOptionsValuesCount($where)
    {
        try {
            $result = $this->productsOptionsValues->newQuery()
                ->where($where)
                ->count();
        } catch (\Exception $e) {
            $result = 0;
        }

        return $result;
    }

    public function findProductsOptions($where, $fields = ['*'], $type = true)
    {
        try {
            $result = $this->optionObj->where($where);
            if ($type) {
                $result = $result->get($fields)->toArray();
            } else {
                $result = $result->first($fields);

                if (!empty($result)) {
                    $result = $result->toArray();
                }
            }
        } catch (\Exception $e) {
            $result = [];
        }

        return $result;
    }

    /**
     * 获取当前产品的所有属性数据
     * @param int $products_id
     * @return array
     */
    public function getProductsAttributesInfo($products_id = 0)
    {
        $info = [];
        if($products_id){
            $result = $this->attributeObj
                ->leftJoin(
                    'products_options',
                    'products_attributes.options_id',
                    '=',
                    'products_options.products_options_id'
                )
                ->where('products_attributes.products_id', $products_id)
                ->where('products_attributes.attributes_status', 1)
                ->where('products_options.products_options_status', 1)
                ->where('products_options.language_id', 1)
                ->select(['products_attributes.options_id','products_attributes.options_values_id'])
                ->get()
                ->toArray();
            if($result){
                foreach($result as $key=>$value){
                    $info[$value['options_id']][] = $value['options_values_id'];
                }
            }
        }
        return $info;
    }

    /**
     * 检验产品属性的有效性
     * @param $products_id
     * @param array $attributes 多维数组$attributes[options_id] = [value_id_1,value_id_2];
     * @return bool
     */
    public function checkProductsAttributesValid($products_id, $attributes=[])
    {
        $valid = true;
        if ($products_id && $attributes) {
            $allAttributes = $this->getProductsAttributesInfo($products_id);
            $allOptionsKey = array_keys($allAttributes);    //获取当前产品拥有的所有属性项ID数据
            $OptionsKey = array_keys($attributes);          //获取当前产品传递过来的属性数据的所有属性项ID
            if (!array_diff($OptionsKey, $allOptionsKey)) {
                //当前产品传递过来的属性项ID当前产品都有
                foreach ($allAttributes as $key => $value) {
                    //对比产品传递过来的属性项下的属性值是否有效
                    if (array_diff($attributes[$key], $value)) {
                        //有属性值已经失效
                        $valid = false;
                        break;
                    }
                }
            } else {
                $valid = false;
            }
        } else {
            $valid = false;
        }
        return $valid;
    }
     /**
     * 根据属性项id获取属性项文案
     *
     * @param $options_id
     * @param string[] $fields
     * @param string $language_id
     * @return mixed
     */
    public function getOptionsNameById($options_id, $fields = ['*'], $language_id = '')
    {
        $language_id = empty($language_id) ? $this->language_id : $this->language_id;
        return $this->optionObj->select($fields)
            ->where('products_options_id', $options_id)
            ->where('language_id', $language_id)
            ->first();
    }

    /**
     * 根据属性值id获取属性值文案
     *
     * @param $options_values_id
     * @param string[] $fields
     * @param string $language_id
     * @return mixed
     */
    public function getOptionsValuesNameById($options_values_id, $fields = ['*'], $language_id = '')
    {
        $language_id = empty($language_id) ? $this->language_id : $this->language_id;
        return $this->productsOptionsValues->select($fields)
            ->where('products_options_values_id', $options_values_id)
            ->where('language_id', $language_id)
            ->first();
    }

    /**
     * 获取长度属性值
     *
     * @param $options_length_id
     * @param $fields
     * @return mixed
     */
    public function getOptionsLengthById($options_length_id, $fields = ['*'])
    {
        return $this->lengthObj->select($fields)
            ->where('id', $options_length_id)
            ->first();
    }
}
