<?php

namespace Modules\Tag\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;

class SignatureAuthentication
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->authorization($request)) {
            throw new InvalidSignatureException();
        }

        return $next($request);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getSignature(Request $request)
    {
        $authorization = $request->header('authorization');
        return trim(substr(trim($authorization), 6)); // Authorization: Oauth 签名
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function authorization(Request $request)
    {
        $signature = $this->getSignature($request);
        $tmp = explode(':', $signature);
        if (empty($signature) || empty($tmp)) return false;
        $verify = md5(config('tag.signature.token') . $tmp[1] . $tmp[2]);
        if ($tmp[2] + config('tag.signature.ttl') <= microtime(true)
            || $verify !== $tmp[0]) {
            return false;
        }

        return true;
    }
}
