<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
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

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return response()->json(['success' => false, 'errors' => 'Not Found'], Response::HTTP_NOT_FOUND);
        }
        if ($exception instanceof AccessDeniedException) {
            return response()->json(['success' => false, 'errors' => 'Access denied'], Response::HTTP_FORBIDDEN);
        }
        if ($exception instanceof \PDOException) {
            return response()->json(['success' => false, 'errors' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        if ($exception instanceof UnauthorizedHttpException) {
            return response()->json(['success' => false, 'errors' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return parent::render($request, $exception);
    }
}
