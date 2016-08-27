<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $data = [];
        $classException = get_class($e);

        switch ($classException) {
            case \League\OAuth2\Server\Exception\AccessDeniedException::class:
                $status = 403;
                break;
            case \Illuminate\Foundation\Validation\ValidationException::class:
                $data = $e->validator->errors()->toArray();
                $status = 422;
                break;
            case \Symfony\Component\Debug\Exception\FatalThrowableError::class:
                $status = 500;
                break;
            case \Illuminate\Database\Eloquent\ModelNotFoundException::class:
                $status = 404;
                break;
            case \League\OAuth2\Server\Exception\InvalidRequestException::class:
                $status = 400;
                $data = $e->getMessage();
                break;
            case \League\OAuth2\Server\Exception\InvalidCredentialsException::class:
                $status = 401;
                $data = $e->getMessage();
                break;
            default:
                $status = $e->getStatusCode();
                break;
        }

        return response()->json([
            'status_code' => $status,
            'data' => $data
        ], $status);
    }
}
