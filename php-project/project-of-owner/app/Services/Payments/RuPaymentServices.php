<?php
/**
 * Notes:
 * File name:RuPaymentServices
 * Create by: Jay.Li
 * Created on: 2020/5/27 0027 15:55
 */


namespace App\Services\Payments;

use App\Models\RuAlfaInformationAddress;
use App\Services\BaseService;
use App\Services\Common\Upload\UploadService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Collection;

class RuPaymentServices extends BaseService
{
    private $informationAddress;

    public function setInformationAddress()
    {
        $this->informationAddress = new RuAlfaInformationAddress();

        return $this;
    }

    /**
     * Notes: 删除地址信息
     * User: LiYi
     * Date: 2020/5/28 0028
     * Time: 16:48
     * @param $id
     * @param $customer_id
     * @return array
     */
    public function deletePaymentInformation($id, $customer_id)
    {
        try {
            $this->informationAddress->where('id', $id)->where('customers_id', $customer_id)->delete();
            $result = ['status' => 200, 'message' => ''];
        } catch (\Exception $exception) {
            $result = ['status' => 400, 'message' => ''];
        }

        return $result;
    }

    public function firstData($id)
    {
        try {
            $result = $this->informationAddress->where('customers_id', $this->customer_id)
                ->where('id', $id)
                ->orderBy('updated_at', 'desc')
                ->first();
            if (empty($result)) {
                throw new \Exception('empty data is last');
            }
            $result = $result->toArray();
        } catch (\Exception $exception) {
            $result = [];
        }

        return $result;
    }

    public function lastPaymentInformation()
    {
        try {
            $result = $this->informationAddress->where('customers_id', $this->customer_id)
                ->orderBy('updated_at', 'desc')
                ->first();
            if (empty($result)) {
                throw new \Exception('empty data is last');
            }
            $result = $result->toArray();
        } catch (\Exception $exception) {
            $result = [];
        }

        return $result;
    }

    public function allPaymentInformation($type = true)
    {
        try {
            $data = $this->informationAddress->where('customers_id', $this->customer_id)
                ->orderBy('updated_at', 'desc')->get(['*', 'card_path_name as card_path_upload']);
            if (empty($data)) {
                throw new \Exception('ru payment information is empty!');
            }

            if ($type) {
                $last = $this->lastPaymentInformation();
                $result = $this->dataReorganization($data, $last['id']);
            } else {
                $result = $data->toArray();
            }
        } catch (\Exception $e) {
            $result = [];
        }

        return $result;
    }

    /**
     * Notes:结果集处理
     * User: LiYi
     * Date: 2020/5/28 0028
     * Time: 11:25
     * @param Collection $data
     * @param $id
     * @return array
     */
    protected function dataReorganization(Collection $data, $id)
    {
        $result = [];
        $data->each(function ($item) use (&$result, $id) {
            $item = $item->toArray();
            if ($item['id'] != $id) {
                switch ($item['type']) {
                    case 1:
                        $result['text'][] = $item;
                        break;
                    case 2:
                        $result['file'][] = $item;
                        break;
                    case 3:
                        $result['textFile'][] = $item;
                        break;
                }
            }
        });

        return $result;
    }

    /**
     * Notes:俄罗斯对公支付上传card
     * User: LiYi
     * Date: 2020/5/27 0027
     * Time: 15:58
     * @param $config
     * @param $fileInput
     * @return string
     */
    public function uploadCard($config, $fileInput)
    {
        $upload = new UploadService();
        try {
            $result = $upload->setConfig($config)->newUpload($fileInput);
            if (!$result) {
                throw new \Exception('error !');
            }
            $path = $upload->storagePath;
        } catch (GuzzleException $e) {
            $path = '';
        } catch (\Exception $e) {
            $path = '';
        }

        return $path;
    }

    /**
     * Notes: 添加俄罗斯对公支付信息地址
     * User: LiYi
     * Date: 2020/5/27 0027
     * Time: 17:17
     * @param $data
     * @return array
     */
    public function createRuOrderInfo($data)
    {
        try {
            $data['customers_id'] = $this->customer_id;
            if (empty($data['card_path'])) {
                $data['type'] = 1;//文字
            } elseif (empty($data['alfa_phone'])) {
                $data['type'] = 2;//图片
            } else {
                $data['type'] = 0;//二者皆有
            }

            if (isset($data['primaryKeyId']) && !empty($data['primaryKeyId'])) {
                //update
                $model = $this->informationAddress->where('id', $data['primaryKeyId'])->first();

                foreach ($this->fillData($data) as $k => $item) {
                    $model->$k = $item;
                }
                $model->save();
            } else {
                //create
                $model = $this->informationAddress->create($this->fillData($data));
            }
            $result = $model;
        } catch (\Exception $e) {
            $result = [];
        }

        return $result;
    }

    public function encodeData($data)
    {
        if (empty($data)) {
            return $data;
        }

        return [
            'id' => $data['id'],
            'type' => $data['type'],
            'alfa_phone' => $data['alfa_phone'],
            'alfa_email' => $data['alfa_email'],
            'alfa_organization' => $data['alfa_organization'],
            'alfa_inn' => $data['alfa_inn'],
            'alfa_kpp' => $data['alfa_kpp'],
            'alfa_bic' => $data['alfa_bic'],
            'alfa_legal_address' => $data['alfa_legal_address'],
            'alfa_bank_name' => $data['alfa_bank_name'],
            'card_path' => $data['card_path'],
            'card_path_name' => $data['card_path_name'],
        ];
    }

    /**
     * Notes: 添加过略输出
     * User: LiYi
     * Date: 2020/5/27 0027
     * Time: 17:36
     * @param $data
     * @return mixed
     */
    protected function fillData($data)
    {
        foreach ($data as $key => $value) {
            if (!in_array($key, $this->informationAddress->fillable)) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    public function existsRuRub()
    {
        if (strtoupper($this->countries_iso_code) === 'RU' && strtoupper($this->currency) === 'RUB') {
            return true;
        }

        return false;
    }

    public function insertData($data)
    {
        if (empty($data)) {
            return $data;
        }

        return [
            'alfa_phone' => $data['alfa_phone'],
            'alfa_email' => $data['alfa_email'],
            'alfa_organization' => $data['alfa_organization'],
            'alfa_inn' => $data['alfa_inn'],
            'alfa_kpp' => $data['alfa_kpp'],
            'alfa_bic' => $data['alfa_bic'],
            'alfa_legal_address' => $data['alfa_legal_address'],
            'alfa_bank_name' => $data['alfa_bank_name'],
            'card_path' => $data['card_path'],
        ];
    }
}
