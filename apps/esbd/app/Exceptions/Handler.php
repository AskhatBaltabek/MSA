<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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
        'current_password',
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

    public function render($request, Throwable $e)
    {
        if ($e instanceof BadRequestHttpException) {
            return response()->json([
                'success' => false,
                'message' => 'Плохой запрос.'
            ], Response::HTTP_NOT_FOUND);
        } else if ($e instanceof AccessDeniedHttpException) {
            return response()->json([
                'success' => false,
                'message' => 'Запрещено.'
            ], Response::HTTP_NOT_FOUND);
        } else if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'success' => false,
                'message' => 'Не найден.'
            ], Response::HTTP_NOT_FOUND);
        } else if ($e instanceof InternalErrorException) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'Внутренняя ошибка сервера.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return parent::render($request, $e);
    }
}
