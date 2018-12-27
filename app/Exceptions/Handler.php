<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\Debug\Exception\FlattenException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param Exception $exception
     * @return mixed|void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    protected function prepareJsonResponse($request, Exception $exception)
    {
        if ($exception instanceof ValidatorException) {
            return response()->json([
                'error'     =>  'true',
                'exception'  => $this->getExceptionClass($exception),
                'message'    => $exception->getMessageBag(),
            ], 400);
        }

        $exception = FlattenException::create($exception);

        if (config('app.debug')) {
            $message = $exception->getMessage();
        } else {
            $message = Response::$statusTexts[$exception->getStatusCode()];
        }

        return response()->json([
            'error'     =>  'true',
            'exception'  => $this->getExceptionClass($exception),
            'http_code'       => $exception->getStatusCode(),
            'message'    => $message,
            'trace'      => $this->getTrace($exception),
        ], $exception->getStatusCode());
    }

    private function getTrace($exception)
    {
        if (config('app.debug')) {
            return 'file: ' . $exception->getFile() . ' line: ' . $exception->getLine();
        }

        return null;
    }

    private function getExceptionClass($exception)
    {
        if (config('app.debug')) {
            return get_class($exception);
        }

        return null;
    }
}
