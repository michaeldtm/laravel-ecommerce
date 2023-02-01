<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                /** @var ModelNotFoundException $modelNotFoundException */
                $modelNotFoundException = $e->getPrevious();
                $name = Str::snake(class_basename($modelNotFoundException->getModel()), ' ');

                $response = [
                    'error' => __('errors.not_found', ['name' => $name])
                ];

                if (config('app.debug')) {
                    $response['exception'] = [
                        'message' => $e->getMessage(),
                        'trace' => $e->getTrace(),
                    ];
                }

                return response()->json($response, 404);
            }
        });
    }
}
