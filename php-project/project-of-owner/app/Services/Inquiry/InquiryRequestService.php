<?php
/**
 * @Notes:
 *
 * @File name:InquiryRequestService
 * Create by: Jay.Li
 * Created on: 2020/8/14 0014 11:04
 */


namespace App\Services\Inquiry;

use App\Models\CustomerInquiry;
use App\Models\CustomerInquiryInfo;
use App\Models\CustomerInquiryProducts;
use App\Models\CustomerInquiryProductsAttributes;
use App\Models\CustomerInquiryProductsLength;
use App\Models\ServiceProcessFile;
use App\Services\BaseService;
use App\Services\Products\ProductAttributeService;
use App\Services\Products\ProductService;
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager;

class InquiryRequestService extends BaseService
{
    const FILE_PRODUCT_OR_ONLY_FILE = 7;

    const INQUIRY_STATUS_COMMIT = 1;
    const INQUIRY_STATUS_INQUIRY = 2;
    const INQUIRY_STATUS_ORDER = 3;
    const INQUIRY_STATUS_CANCEL = 4;
    const INQUIRY_STATUS_CART = 5;

    private $customerInquiry;

    private $customerInquiryProducts;

    private $customerInquiryInfo;

    private $inquiryProductAttributes;

    private $inquiryProductLength;

    private $productService;
    public $productAttrService;

    public function __construct()
    {
        parent::__construct();
        $this->customerInquiry = new CustomerInquiry();
        $this->customerInquiryProducts = new CustomerInquiryProducts();
        $this->customerInquiryInfo = new CustomerInquiryInfo();
        $this->inquiryProductAttributes = new CustomerInquiryProductsAttributes();
        $this->inquiryProductLength = new CustomerInquiryProductsLength();
        $this->productService = new ProductService();
        $this->productAttrService = new ProductAttributeService();
    }

    private function dump($data)
    {
        echo "<pre style='background-color: #2379c34f; width: 100%;height: auto;font-size: 16px;'>";
        echo "<code>";
        var_export($data);
        echo "<code>";
        echo "<pre>";
    }

    public function findInquiry($where, $field = ["*"])
    {
        try {
            $result = $this->customerInquiry->newQuery()
                ->where('customers_id', $this->customer_id)
                ->where($where)
                ->first($field);
            if (empty($result)) {
                throw new \Exception("error!");
            }
            $result = $result->toArray();
        } catch (\Exception $e) {
            //var_dump($e);
            $result = [];
        }

        return $result;
    }

    /**
     * Notes:
     * User: LiYi
     * Date: 2020/9/7 0007
     * Time: 16:30
     * @param array $where
     * @param array $fields
     * @param bool $type
     * @return array|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|null|
     * Illuminate\Database\Eloquent\Collection|
     * \Illuminate\Database\Eloquent\Model
     */
    public function findInquiryProduct($where, $fields = ['*'], $type = true)
    {
        $result = $this->customerInquiryProducts->newQuery()->where($where);
        if ($type) {
            $result = $result->first($fields);
        } else {
            $result = $result->get($fields);
        }

        if (!empty($result)) {
            $result = $result->toArray();
        }

        return $result;
    }

    public function findInquiryProductAttributes($where, $fields = ['*'])
    {
        try {
            $result = $this->inquiryProductAttributes->newQuery()->where($where)->get($fields)->toArray();
        } catch (\Exception $e) {
            $result = [];
        }

        return $result;
    }

    public function findInquiryProductLength($where, $fields = ['*'], $type = true)
    {
        try {
            $result = $this->inquiryProductLength->newQuery()->where($where);
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

    public function updateInquiry($id, $data)
    {
        try {
            $result = $this->customerInquiry->where('id', $id)->update($data);
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }

    public function insertInquiry($data)
    {
        try {
            $result = $this->customerInquiry->create($data)->toArray();
        } catch (\Exception $e) {
            $result = [];
        }

        return $result;
    }

    public function existsInquiryAccount($inquiryId)
    {
        try {
            $result = $this->customerInquiry->where('id', $inquiryId)
                ->where('customers_id', $this->customer_id)->exists();
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }

    protected function existsInquiryProduct($inquiryId, $productId = 0)
    {
        $result = $this->customerInquiryProducts->where('inquiry_id', $inquiryId);

        if (!empty($productId)) {
            $result->where('products_id', $productId);
        }

        return $result->exists();
    }

    public function deleteInquiryProduct($inquiryId, $productId = 0)
    {
        try {
            if (!$this->existsInquiryProduct($inquiryId, $productId)) {
                throw new \Exception("[{$inquiryId}] not exists!");
            }
            $result = $this->customerInquiryProducts->where('inquiry_id', $inquiryId);

            if (!empty($productId)) {
                $result->where('products_id', $productId);
            }

            $result->delete();
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }

    public function updateInquiryProduct($where, $data)
    {
        try {
            if (!$this->existsInquiryProduct($where['inquiry_id'])) {
                throw new \Exception("[{$where['inquiry_id']}] not exists!");
            }
            $result = $this->customerInquiryProducts->newQuery()->where($where)->update($data);
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }

    public function insertInquiryInfo($data)
    {
        try {
            $result = $this->customerInquiryInfo->create($data);
        } catch (\Exception $e) {
            $result = [];
        }

        return $result;
    }

    public function insertInquiryProduct($data)
    {
        try {
            $result = Manager::connection()->table('customer_inquiry_products')
                ->insertGetId($data);
        } catch (\Exception $e) {
            $result = 0;
        }

        return $result;
    }

    public function insertInquiryProductLength($data)
    {
        try {
            //customer_inquiry_products_length
            $result = Manager::connection()->table('customer_inquiry_products_length')
                ->insertGetId($data);
        } catch (\Exception $e) {
            $result = 0;
        }

        return $result;
    }

    public function insertInquiryProductAttributes($data)
    {
        try {
            //customer_inquiry_products_attributes
            $result = Manager::connection()->table('customer_inquiry_products_attributes')
                ->insertGetId($data);
        } catch (\Exception $e) {
            $result = 0;
        }

        return $result;
    }

    /**
     * Notes: 删除后台关于inquiry数据表
     * User: LiYi
     * Date: 2020/9/9 0009
     * Time: 11:03
     * @param $adminInquiryId
     */
    protected function deleteManageCustomerInquiryData($adminInquiryId)
    {
        Manager::connection()->table('manage_customer_inquiry')
            ->where('inquiry_id', $adminInquiryId)->delete();
        $manageCIP = Manager::connection()->table('manage_customer_inquiry_products')
            ->where('inquiry_id', $adminInquiryId)->get(['id']);
        if (!empty($manageCIP)) {
            foreach ($manageCIP as $item) {
                Manager::connection()->table('manage_customer_inquiry_products_attributes')
                    ->where('products_info_id', $item['id'])->delete();
                Manager::connection()->table('manage_customer_inquiry_products_length')
                    ->where('products_info_id', $item['id'])->delete();
            }
        }
        Manager::connection()->table('manage_customer_inquiry_products')
            ->where('inquiry_id', $adminInquiryId)->delete();

        Manager::connection()->table('manage_customer_inquiry_file')
            ->where('inquiry_id', $adminInquiryId)->delete();
    }

    /**
     * Notes:删除和添加服务流程图片
     * User: LiYi
     * Date: 2020/9/9 0009
     * Time: 12:26
     * @param $processFile
     * @param $serviceProcessNumber
     * @param $files
     * @param $data
     * @return bool
     */
    protected function insertOrDeleteProcessFile($processFile, $serviceProcessNumber, $files, $data)
    {
        if (empty($serviceProcessNumber)) {
            return false;
        }

        if (!empty($files)) {
            foreach ($files as $file) {
                $temp = explode('/', $file['attachment_path']);
                $num = count($temp);
                if ($num < 2) {
                    continue;
                }
                $processFile->newQuery()->where('storage_path', $temp[$num - 2])
                    ->where('storage_name', $temp[$num - 1])
                    ->where('service_process_number', $serviceProcessNumber)
                    ->delete();
            }
        }

        if (empty($data)) {
            return false;
        }

        foreach ($data as $item) {
            $processFile->create($item);
        }

        return true;
    }

    public function updateInquiryInfo(
        $inquiryId,
        $inquiryData,
        $productsId = [],
        $inquiryFilesId = [],
        $newFilesArray = [],
        $serviceProcessFilesNew = [],
        $adminInquiryId = 0
    ) {
        try {
            $oldProductsIdData = $this->findInquiryProduct(['inquiry_id' => $inquiryId], ['id'], false);

            $oldInquiryFilesIdData = $this->inquiryFileInfo($inquiryId);

            if (empty($oldInquiryFilesIdData)) {
                $oldInquiryFilesId = [];
            } else {
                $oldInquiryFilesId = array_column($oldInquiryFilesIdData, 'id');
            }

            $deleteFilesId = array_diff($oldInquiryFilesId, $inquiryFilesId);

            if (empty($oldProductsIdData)) {
                $oldProductsIdArr = [];
            } else {
                $oldProductsIdArr = array_column($oldProductsIdData, 'id');
            }

            Manager::connection()->transaction(function () use (
                $inquiryId,
                $inquiryData,
                $productsId,
                $oldProductsIdArr,
                $deleteFilesId,
                $newFilesArray,
                $adminInquiryId,
                $serviceProcessFilesNew
            ) {
                $tempInquiryProductsId = [];
                $processFile = new ServiceProcessFile();
                //主
                $this->customerInquiry->newQuery()
                    ->where('id', $inquiryId)
                    ->update($inquiryData);
                //报价产品数量
                if (!empty($productsId)) {
                    foreach ($productsId as $item) {
                        $tempArr = explode('-', $item);
                        if (count($tempArr) !== 3 || $tempArr[0] != $inquiryId) {
                            continue;
                        }
                        $tempInquiryProductsId[] = $tempArr[1];
                        $this->customerInquiryProducts->newQuery()
                            ->where('id', $tempArr[1])
                            ->update([
                                'product_num' => (int)$tempArr[2],
                                'updated_person' => $this->customer_id,
                                'updated_at' => Carbon::now()
                            ]);
                    }
                }

                $deleteInquiryProductsId = array_diff($oldProductsIdArr, $tempInquiryProductsId);

                if (!empty($deleteInquiryProductsId)) {
                    foreach ($deleteInquiryProductsId as $item) {
                        $this->deleteProductRelated($inquiryId, $item);
                    }
                }

                if (!empty($deleteFilesId)) {
                    $tempFiles = $this->customerInquiryInfo->whereIn('id', $deleteFilesId)
                        ->where('inquiry_id', $inquiryId)->get(['attachment_path'])->toArray();
                    $this->insertOrDeleteProcessFile(
                        $processFile,
                        $serviceProcessFilesNew['serviceProcessNumber'],
                        $tempFiles,
                        []
                    );
                    foreach ($deleteFilesId as $item) {
                        $this->customerInquiryInfo->newQuery()
                            ->where('id', $item)
                            ->where('inquiry_id', $inquiryId)
                            ->delete();
                    }
                }

                $this->insertOrDeleteProcessFile(
                    $processFile,
                    $serviceProcessFilesNew['serviceProcessNumber'],
                    [],
                    $serviceProcessFilesNew['list']
                );

                if (!empty($newFilesArray)) {
                    foreach ($newFilesArray as $item) {
                        $this->insertInquiryInfo($item);
                    }
                }

                if ($adminInquiryId) {
                    $this->deleteManageCustomerInquiryData($adminInquiryId);
                }
            });
            $result = true;
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }

    public function deleteProductRelated($inquiryId, $productPrimaryId)
    {
        try {
            $inquiryProductsId = $this->customerInquiryProducts->newQuery()
                ->where('inquiry_id', $inquiryId)->where('id', $productPrimaryId)
                ->first(['products_id']);

            if (empty($inquiryProductsId)) {
                throw new \Exception('error1!');
            }
            $inquiryProductsId = $inquiryProductsId->toArray()['products_id'];

            $attributesExists = $this->inquiryProductAttributes->newQuery()
                ->where('inquiry_products_id', $productPrimaryId)
                ->where('products_id', $inquiryProductsId)
                ->exists();
            $lengthExists = $this->inquiryProductLength->newQuery()
                ->where('inquiry_products_id', $productPrimaryId)
                ->where('products_id', $inquiryProductsId)
                ->exists();
            $this->customerInquiryProducts->newQuery()
                ->where('inquiry_id', $inquiryId)
                ->where('id', $productPrimaryId)
                ->delete();
            if ($attributesExists) {
                $this->inquiryProductAttributes->newQuery()
                    ->where('inquiry_products_id', $productPrimaryId)
                    ->where('products_id', $inquiryProductsId)->delete();
            }
            if ($lengthExists) {
                $this->inquiryProductLength->newQuery()
                    ->where('inquiry_products_id', $productPrimaryId)
                    ->where('products_id', $inquiryProductsId)
                    ->delete();
            }
            $result = true;
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }

    public function inquiryFileInfo($inquiryId)
    {
        try {
            $result = $this->customerInquiryInfo->newQuery()
                ->where('inquiry_id', $inquiryId)
                ->get([
                    'id',
                    'inquiry_id',
                    'attachment_path',
                    'origin_file_name'
                ])->toArray();
            if (empty($result)) {
                throw new \Exception('报价文件为空！');
            }
            foreach ($result as $key => $item) {
                $result[$key]['origin_file_name'] = $this->strReplace($item['origin_file_name']);
            }
        } catch (\Exception $e) {
            $result = [];
        }

        return $result;
    }

    private function strReplace($value)
    {
        $len = mb_strlen($value);
        if ($len < 20) {
            return $value;
        }

        $start = mb_substr($value, 0, 8);
        $end = mb_substr($value, -8, 8);

        return $start . '...'. $end;
    }
}
