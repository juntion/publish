<?php
require_once 'CommandBaseRequired.php';

use App\Models\AvaTaxQueues;
use App\Services\Avatax\AvaTaxService;
use App\Models\AvaTaxRecords;

$model = new AvaTaxQueues();
$avaTax = new AvaTaxService();
$avaTaxRecord = new AvaTaxRecords();

//捕获所有异常
while (true) {
    $data = $model->where('is_success', 0)
        ->where('attempt', '<', 3)
        ->orderBy('id', 'desc')->limit(1)
        ->get()->toArray();
    if (!empty($data)) {
        foreach ($data as $item) {
            try {
                $model->where('orders_id', $item['orders_id'])->increment('attempt');
                $option = json_decode($item['data'], true);
                if (empty($option) || !is_array($option)) {
                    throw new Exception('invalid json');
                }
                $avaTax = $avaTax->setAddress([
                    'address_book_id' => 0,
                    'postalCode' => $option['address']['postcode'],
                    'line1' => $option['address']['useUpsDefaultAddress'] == 1 ? $avaTax->defaultLine
                        : $option['address']['street_address'],
                    'region' => $option['address']['state'],
                    'city' => $option['address']['city'],
                    'country' => $option['address']['country']['iso_code_2'],
                    'line2' => $option['address']['suburb']
                ])->setOrders($option['products'])->setCreatedOrderInfo(
                    [
                        'admin_id' => $option['admin_id'],
                        'orders_number' => $option['orders_number'],
                        'currency' => $option['currency'],
                        'currency_value' => $option['currency_value'],
                        'customerCode' => $option['customerCode'],
                        'documentCode' => $option['orders_number']
                    ]
                );
                $result = $avaTax->createTransition('SalesOrder');
                $record = $avaTaxRecord->where('orders_id', $item['orders_id'])
                    ->where('source', 1)->first();
                if ($result['status']) {
                    $model->where('orders_id', $item['orders_id'])->update(
                        [
                            'is_success' => 1,
                            'response' => json_encode($result['data'])
                        ]
                    );
                    $responseData = $avaTax->formatResponseData($result['data']);
                    if (!empty($responseData) && empty($record)) {
                        $responseJson = json_encode($responseData);
                        $avaTaxRecord->create([
                            'orders_id' => $item['orders_id'],
                            'products_info' => $responseJson,
                            'document_code' => $option['orders_number'],
                            'transition_id' => $responseData['transition_id'],
                            'is_use_ups_address' => $option['address']['useUpsDefaultAddress'],
                            'source' => 1
                        ]);
                    }
                } else {
                    $result = $avaTax->setCreatedOrderInfo([
                        'admin_id' => $option['admin_id'],
                        'orders_number' => $option['orders_number'],
                        'currency' => $option['currency'],
                        'currency_value' => $option['currency_value'],
                        'customerCode' => $option['customerCode'],
                        'documentCode' => $option['orders_number'],
                        'adjustmentReason' => ['adjustmentReason' => 'Offline']
                    ])->createTransition('SalesOrder');
                    if ($result['status']) {
                        $responseData = json_encode($result['data']);
                        $model->where('orders_id', $item['orders_id'])->update(
                            [
                                'is_success' => 1,
                                'response' => $responseData,
                            ]
                        );
                        $responseData = $avaTax->formatResponseData($result['data']);
                        if (!empty($responseData) && empty($record)) {
                            $responseJson = json_encode($responseData);
                            $avaTaxRecord->create([
                                'orders_id' => $item['orders_id'],
                                'products_info' => $responseJson,
                                'document_code' => $option['orders_number'],
                                'transition_id' => $responseData['transition_id'],
                                'is_use_ups_address' => $option['address']['useUpsDefaultAddress'],
                                'source' => 1
                            ]);
                        }
                    } else {
                        $model->where('orders_id', $item['orders_id'])->update([
                            'is_success' => 0,
                            'exception' => $result['message']
                        ]);
                    }
                }
            } catch (Exception $e) {
                $model->where('orders_id', $item['orders_id'])
                    ->update(
                        [
                            'is_success' => 0,
                            'exception' => $e->getMessage()
                        ]
                    );
            }
        }
    } else {
        time_sleep_until(30 + time());
    }
}
