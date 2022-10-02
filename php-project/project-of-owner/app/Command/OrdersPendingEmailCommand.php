<?php
require_once 'CommandBaseRequired.php';

use App\Models\OrdersPendingEmailQueue;
use App\Services\Email\Base\SendEmailService;
use App\Services\Email\Base\EmailTemplateService;

$model = new OrdersPendingEmailQueue();
$sendService = new SendEmailService();
$templateService = new EmailTemplateService();
while (true) {
    $data = $model->onWriteConnection()->where('is_send', 0)->first();
    if (empty($data)) {
        time_sleep_until(30 + time());
        continue;
    }
    try {
        $option = json_decode($data->data, true);
        $response = $sendService->setConfig([
            'sendEmail'        => $option['user_email'],
            'emailDescription' => $option['email_name'],
            'emailTemplate'    => $templateService->getEmailTemplate($option),
            'sender'           => $option['email'],
            'title'            => $option['title'],
        ])->sendEmail();
        queueLogReport('success', [
            'orders_id' => $data->orders_id,
            'email'     => $option['user_email'],
        ]);
        $model->where('id', $data->id)->update(['is_send' => 1, 'response' => json_encode($response, true)]);
    } catch (Exception $e) {
        $error = $e->getMessage();
        queueLogReport('fail', [
            'orders_id' => $data->orders_id,
            'email'     => $option['user_email'],
            'reason'    => $error,
        ]);
        $model->where('id', $data->id)->update(['is_send' => 2, 'exception' => $error]);
    }
}
