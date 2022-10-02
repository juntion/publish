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

    'failed' => 'These credentials do not match our records.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'forbid' => 'Sorry, your account has been disabled.',
    'update_pass' => 'You have not updated your password for a long time. Please reset it!',
    'code' => 'Verification code error',
    'need_validate' => 'This login requires verification. The verification code has been sent to your mailbox (:email)!',
    'email_throttle' => 'Request is frequent, please try again later.',
    'expired' => 'Your login has expired, please login again',
    'user_not_found' => 'The account does not exist or has been deleted!',

    'reset_password_email' => [
        'first_info' => 'You are receiving this email because we received a password reset request for your account.',
        'reset_button' => 'Reset Password',
        'last_info' => 'If you did not request a password reset, no further action is required.',
    ],

    'validate_login_email' => [
        'subject' => 'Login certification',
        'line1' => 'Verification code is: ',
        'line2' => 'If you do not have the login request, your account is at risk, please timely change your password.',
    ],

    'notifications' => [
        'email' => [
            'subcopy' => "If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n" .
                'into your web browser: [:actionURL](:actionURL)',
        ]
    ]
];
