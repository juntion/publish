<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => '用户名或密码错误。',
    'throttle' => '您的尝试登录次数过多，请 :seconds 秒后再试。',
    "unauthenticated" => '未认证.',
    'unGuest' => '您不是访客，请退出登录',
    'passwordResetBroadcast' => '此用户密码已更改，所有客户端退出登录',

    'reset_password_email' => [
        'subject'=>'重置密码',
        'greeting'=>'您好!',
        'first_info' => '您之所以收到此电子邮件，是因为我们收到了您帐户的密码重置请求。',
        'reset_button' => '重置密码',
        'last_info' => '如果您没有请求密码重置，则不需要进一步的操作。',
        'link_expire' => '此密码重置链接将在 :count 分钟后过期。',
    ],
];
