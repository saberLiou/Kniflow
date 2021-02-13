<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($request->wantsJson()) {
            switch (get_class($e)) {
                case ModelNotFoundException::class:
                    return error_response(
                        [Response::$statusTexts[Response::HTTP_NOT_FOUND] => "Cannot find the resource."],
                        Response::HTTP_NOT_FOUND
                    );
                case NotFoundHttpException::class:
                    return error_response(
                        [Response::$statusTexts[Response::HTTP_NOT_FOUND] => "Unavailable route."],
                        Response::HTTP_NOT_FOUND
                    );
                case MethodNotAllowedHttpException::class:
                    return error_response(
                        [Response::$statusTexts[Response::HTTP_METHOD_NOT_ALLOWED] => $e->getMessage()],
                        Response::HTTP_METHOD_NOT_ALLOWED
                    );
                default:
                    return error_response(
                        [Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR] => $e->getMessage()],
                        Response::HTTP_INTERNAL_SERVER_ERROR
                    );
            }
        }
        return parent::render($request, $e);
    }
}
