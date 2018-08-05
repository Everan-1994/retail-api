<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        InvalidRequestException::class,
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
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Exception $exception
     * @return Response|\Symfony\Component\HttpFoundation\Response
     * @throws InternalException
     * @throws InvalidRequestException
     */
    public function render($request, Exception $exception)
    {
        // 参数验证错误的异常，我们需要返回 400 的 http code 和一句错误信息
        if ($exception instanceof ValidationException) {
            throw new InvalidRequestException($exception->errors(), Response::HTTP_BAD_REQUEST);
        }
        // 用户认证的异常，我们需要返回 401 的 http code 和错误信息
        if ($exception instanceof UnauthorizedHttpException) {
            throw new InvalidRequestException($exception->getMessage(), Response::HTTP_UNAUTHORIZED);
        }
        // 频繁访问接口，我们需要返回 429 的 http code 和错误信息
        if ($exception instanceof TooManyRequestsHttpException) {
            throw new InternalException($exception->getMessage(), Response::HTTP_TOO_MANY_REQUESTS);
        }

        return parent::render($request, $exception);
    }
}
