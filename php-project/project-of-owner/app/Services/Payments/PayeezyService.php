<?php


namespace App\Services\Payments;

use App\Models\payeezyToken;
use App\Services\BaseService;

class PayeezyService extends BaseService
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new payeezyToken();
    }

    /**
     * 存储token
     *
     * @param array $data
     * @return bool
     */
    public function storeToken($data = [])
    {
        if (empty($data)) {
            return false;
        }
        try {
            $this->model->create($data);
            return true;
        } catch (\Exception $e) {
            $filepath = DIR_FS_SQL_DEBUG . '/payLog.txt';
            file_put_contents($filepath, $e->getMessage().PHP_EOL);
            return false;
        }
    }

    /**
     * 获取token信息
     *
     * @param string $clientToken
     * @param string $nonce
     * @return array
     */
    public function getTokenInfo($clientToken = '', $nonce = '')
    {
        if (empty($clientToken) || empty($nonce)) {
            return [];
        }
        $data = $this->model->where('clientToken', $clientToken)->where('nonce', $nonce)->first();
        if (!empty($data)) {
            return $data->toArray();
        }
        return [];
    }
}
