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

        /**
         * validate  request body
         */
        if (isset($exception->validator)) {
            $msg = [];

            foreach ((array) $exception->validator->messages() as $k => $value) {
                if (\is_array($value)) {
                    foreach ($value as $key_v => $val) {
                        array_push($msg, $val[0]);
                    }
                }
            }
            return response()->json(['error' => true,'message' => $msg[0]], 400);
        }

        if (method_exists($exception, 'getStatusCode')) {

            if (intval($exception->getStatusCode()) == 404) {

                return response()->json(
                    [
                        'message' => "Not Found",
                        'error' => true,
                    ], 404);
            }
        }

        if (intval($exception->getCode()) >= 400) {
            return response()->json(
                [
                    'message' => $exception->getMessage(),
                    'error' => true,
                ], $exception->getCode());
        }

        $resp = [
            "error" => true,
            "message" => $exception->getMessage() ?? 'Internal Error',
        ];
        return response()->json($resp,
            method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500);

    }
}
