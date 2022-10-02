<?php


namespace App\Services\Products;

use App\Services\Products\BaseProductsService;

class ProductCompositeService extends BaseProductsService
{
    /**
     * @var array
     */
    protected $mainProducts;
    /**
     * @var array
     */
    private $relatedCompositeProducts = [];

    /**
     * @Notes: 设置组合产品信息
     *
     * @param array $products
     * @return $this
     * @author: aron
     * @Date: 2020-08-21
     * @Time: 11:41
     */
    public function setProducts($products)
    {
        //$this->mainProducts = $this->transMainId($products);
        $this->mainProducts = $products;
        $this->relatedCompositeProducts = $this->relatedCompositeProducts($this->mainProducts);
        return $this;
    }

    /**
     * @Notes: 关联组合产品信息
     *
     * @param array $mainProducts
     * @return array
     * @author: aron
     * @Date: 2020-08-21
     * @Time: 14:34
     */
    public function relatedCompositeProducts($mainProducts)
    {
        $trans_products = $this->uniqueRelatedId($mainProducts);
        $transData = [];
        $data = $this->ProductComposite->select([
            'products_id',
            'composite_B',
            'composite_C',
            'composite_D',
            'composite_E',
            'type',
            'composite_products'
        ])->whereIn('products_id', $trans_products)->get();
        if (!$data->isEmpty()) {
            $data = $data->toArray();
            foreach ($data as $key => $value) {
                $transData[$value['products_id']] = $value;
            }
        }

        foreach ($mainProducts as $k => &$v) {
            $v['compositeInfo'] = [];
            if (!empty($transData[$k])) {
                $v['compositeInfo']['related'] = $this->formatCompositeProducts($transData[$k]);
                $v['compositeInfo']['type'] = $transData[$k]['type'];
                $v['compositeInfo']['mainId'] = $transData[$k]['products_id'];
            }
        }
        return $mainProducts;
    }

    /**
     * @Notes: 对组合产品信息进行 逻辑格式处理
     *
     * @param array $compositeInfo
     * @return array
     * @author: aron
     * @Date: 2020-08-21
     * @Time: 14:49
     */
    private function formatCompositeProducts($compositeInfo = [])
    {
        $composite = [
            [
                'id' => 0,
                'num' => 0,
                'type' => ''
            ]
        ];
        if (empty($compositeInfo)) {
            return $composite;
        }
        switch ($compositeInfo['type']) {
            case 1:
                $composite = [
                    [
                        'id' => $compositeInfo['composite_B'], 'num' => 1, 'type' => 'composite_b'
                    ],
                    [
                        'id' => $compositeInfo['composite_C'], 'num' => 1, 'type' => 'composite_c'
                    ]
                ];
                break;
            case 2:
                $composite = [
                    [
                        'id' => $compositeInfo['composite_B'], 'num' => 1, 'type' => 'composite_b'
                    ],
                    [
                        'id' => $compositeInfo['composite_C'], 'num' => 2, 'type' => 'composite_c'
                    ]
                ];
                break;
            case 3:
                $composite = [
                    [
                        'id' => $compositeInfo['composite_B'], 'num' => 1, 'type' => 'composite_b'
                    ],
                    [
                        'id' => $compositeInfo['composite_C'], 'num' => 1, 'type' => 'composite_c'
                    ],
                    [
                        'id' => $compositeInfo['composite_D'], 'num' => 1, 'type' => 'composite_d'
                    ]
                ];

                break;
            case 4:
                $composite_products = $compositeInfo['composite_products'];
                $composite_products_array = explode(',', $composite_products);
                $composite = [];
                foreach ($composite_products_array as $key => $val) {
                    $composite_products_one = explode(':', $val);
                    $composite[] = [
                        'id' => (int)$composite_products_one[0],
                        'num' => $composite_products_one[1],
                        'type' => ''
                    ];
                }
                break;
            default:
                $composite = [
                    [
                        'id' => 0,
                        'num' => 0,
                        'type' => ''
                    ]
                ];
                break;
        }
        return $composite;
    }

    /**
     * @Notes: 获取处理后关联组合产品信息
     *
     * @return array
     * @author: aron
     * @Date: 2020-08-21
     * @Time: 15:21
     */
    public function getRelatedCompositeProducts()
    {
        return $this->relatedCompositeProducts;
    }
}
