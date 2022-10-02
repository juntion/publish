<?php

return [
    'failed' => '用户名或密码错误。',
    'throttle' => '您的尝试登录次数过多，请 :seconds 秒后再试。',
    'forbid' => '非常抱歉，您的账号已被禁用。',
    'update_pass' => '你已很久没有更新密码,请重置密码！',
    'code' => '验证码错误',
    'need_validate' => '本次登录需要验证，验证码已发送到您的邮箱 (:email)！',
    'email_throttle' => '操作频繁，请稍后再试。',
    'expired' => '您的登录已过期，请重新登录',
    'user_not_found' => '账户不存在或已被删除!',

    'reset_password_email' => [
        'first_info' => '您之所以收到此电子邮件，是因为我们收到了您帐户的密码重置请求。',
        'reset_button' => '重置密码',
        'last_info' => '如果您没有请求密码重置，则不需要进一步的操作。',
    ],

    'validate_login_email' => [
        'subject' => '登录验证',
        'line1' => '验证码是：',
        'line2' => '若您没有登录请求，您的账户存在风险，请及时修改您的密码。',
    ],

    'notifications' => [
        'email' => [
            'subcopy' => "若点击按钮无效，请复制此链接并将其粘贴至浏览器的地址栏中，或在地址栏中通过键盘输入此链接: [:actionURL](:actionURL)",
        ]
    ]
];
