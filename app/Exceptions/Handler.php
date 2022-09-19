<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
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

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {

        if (isset($exception->validator)) {
            $msg = [];

            foreach ((array) $exception->validator->messages() as $k => $value) {
                if (\is_array($value)) {
                    foreach ($value as $key_v => $val) {
                        array_push($msg, $val[0]);
                    }
                }
            }
            return response()->json(['error' => $msg], 400);
        }

        if (intval($exception->getCode()) >= 400) {
            return response()->json(
                [
                    'message' => $exception->getMessage(),
                    'error' => true,
                ], $exception->getCode());
        }

        return response()->json(['error' => $exception->getMessage() ?? 'Internal Error'], 500);

    }
}
