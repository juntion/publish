<?php


namespace App\Services\Subscription;

use App\Services\BaseService;
use GuzzleHttp\Client;

/**
 * 订阅信息接口
 *
 * @author aron
 * @date 2019.11.11
 * Class SubscriptionService
 * @package App\Services\Subscription
 */
class SubscriptionService extends BaseService
{
    //传送数据
    private $data = [];
    //请求url
    private $baseUrl = 'https://data-api.dmartech.cn/api/v1/api/import?secret=5264e587-1299-402a-9b09-7555682a28bd';

    public function setData($data = [])
    {
        $this->data['update'] = [
            'email' => $data['customers_email_address'],
            'name' => $data['customers_firstname'] . " " . $data['customers_lastname'],
            "customers_number_new" => $data['customers_number_new'],
            "countries_chinese_name" => $data['country']['countries_chinese_name'],
            "birthday" => $data['customers_birthday'],
            "position_name" => $data['position']['position_name'],
            "customers_level" => $data['customers_level'],
            "customer_create_date" => date('Y-m-d h:i:s', time()),
            "user_type" => "线上客户",
            "admin_name" => $data['admin_name'],
            "admin_id" => $data['admin_id'],
        ];
        $this->data['del'] = [
            'email' => $data['customers_email_address'],
        ];
        return $this;
    }

    /**
     * 请求第三方，修改第三方数据源
     *
     * @param int $type
     * @return bool|void
     */
    public function requestApi($type = 0)
    {
        $data = $this->data;
        if ($type == 0) {
            $type_str = 'user_delete';
            $data_info = $data['del'];
        } elseif (in_array($type, ['1', '2', '3'])) {
            $type_str = 'user';
            $data_info = $data['update'];
        } else {
            return;
        }
        $client = new Client();
        try {
            $item = ["type" => $type_str, "properties" => $data_info];
            $response = $client->post($this->baseUrl, [
                'headers' => [
                    'accept' => 'application/json',
                    'content-type' => 'application/json'
                ],
                'body' => json_encode($item),
            ]);
            $res = $response->getBody()->getContents();
            $res = json_decode($res, true);
            if ($res['errcode'] == 0) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
