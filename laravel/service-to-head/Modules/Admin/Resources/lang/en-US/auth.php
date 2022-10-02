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
    'unauthenticated' => 'Unauthenticated.',
    'unGuest' => 'Un Guest',
    'passwordResetBroadcast' => 'This user\'s password has been changed, all clients log out',

    'reset_password_email' => [
        'subject'=>'Reset Password',
        'greeting'=>'Hello!',
        'first_info' => 'You are receiving this email because we received a password reset request for your account.',
        'reset_button' => 'Reset Password',
        'last_info' => 'If you did not request a password reset, no further action is required.',
        'link_expire' => 'This password reset link will expire in :count minutes.',
    ],
];
