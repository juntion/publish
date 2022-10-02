<?php

namespace App\Exceptions;

use App\Exceptions\Company\CompanyException;
use App\Exceptions\Demand\DemandPermissionException;
use App\Exceptions\Demand\InvaildParameterException;
use App\Exceptions\Project\ProjectPermissionException;
use App\Exceptions\System\InvalidStatusException;
use App\Traits\ResponseTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Router;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        InvalidStatusException::class,
        DemandPermissionException::class,
        InvaildParameterException::class,
        \App\Exceptions\Project\InvaildParameterException::class,
        ProjectPermissionException::class,
        CompanyException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Throwable $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param Throwable $e
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|FoundationResponse
     */
    public function render($request, Throwable $e)
    {
        // return parent::render($request, $exception);

        if (method_exists($e, 'render') && $response = $e->render($request)) {
            return Router::toResponse($request, $response);
        } elseif ($e instanceof Responsable) {
            return $e->toResponse($request);
        }

        $e = $this->prepareException($e);

        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        } elseif ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        } elseif ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        } elseif ($e instanceof NotFoundHttpException) {
            return $this->failedWithMessage(__('error.not_found'), $e->getStatusCode());
        } elseif ($e instanceof UnauthorizedException) {
            return $this->failedWithMessage(__($e->getMessage()), $e->getStatusCode());
        }

        return $request->expectsJson()
            ? $this->prepareJsonResponse($request, $e)
            : $this->prepareResponse($request, $e);
    }

    /**
     * Convert exceptions to a specific JSON format
     *
     * @param \Illuminate\Http\Request $request
     * @param Throwable $e
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function prepareJsonResponse($request, Throwable $e)
    {
        return $this->failedWithMessageAndErrors(
            $this->convertExceptionToArray($e),
            __($e->getMessage()),
            $this->isHttpException($e) ? $e->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Validation\ValidationException $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return $this->failedWithMessageAndErrors($exception->errors(), __($exception->getMessage()), $exception->status);
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->failedWithMessage(__($exception->getMessage()), FoundationResponse::HTTP_UNAUTHORIZED);
    }
}
