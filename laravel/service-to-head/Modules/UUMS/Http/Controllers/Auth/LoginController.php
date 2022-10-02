<?php

namespace Modules\UUMS\Http\Controllers\Auth;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\Admin;
use Modules\UUMS\Entities\Admin as UUMSAdmin;
use Modules\UUMS\Http\Controllers\Controller;
use Modules\UUMS\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
//        return ['ticket' => $request->post('ticket')];

        $response = Http::post(config('app.service_uums_url') . '/getUserByTicket', [
            'ticket' => $request->post('ticket')
        ]);

        if ($response->successful() && ($data = $response->json())) {
            if ($data['status'] == 'success' && ($uuid = $data['data']['uuid'])) {

                $user = Admin::find($uuid);
                if (!$user && ($UUMSuser = UUMSAdmin::where('uuid', '=', $uuid)->first())) {
                    $user = Admin::create($UUMSuser->export());
                    $user->refresh();
                }

                if ($user) {
                    $guard = Auth::guard('admin');
                    $token = $guard->login($user);
                    $expiration = $guard->getPayload()->get('exp');
                    $admin = $guard->user();

                    $data = [
                        'accessToken' => $token,
                        'tokenType' => 'Bearer',
                        'expiresIn' => $expiration,
                        'admin' => $admin,
                    ];

                    return $this->successWithData($data);
                }
            }
        }

        return $this->failedWithMessage(__('uums::auth.failed'));
    }
}
