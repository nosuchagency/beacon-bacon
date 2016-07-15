<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
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
        if ($e instanceof TokenMismatchException){
            // Catch it here and do what you want. For example...
            return redirect()->back();
        } elseif ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        }

        if (config('app.debug') && $this->shouldReport($e) && !$request->wantsJson()) {
            return $this->renderExceptionWithWhoops($request, $e);
        }

        if ($request->wantsJson()) {
            if ($e instanceof ValidationException) {
                $code = 400;
                $error = 'Validation error';
            } elseif ($e instanceof ModelNotFoundException) {
                $code = 404;
                $error = 'Model not found';
            } elseif ($e instanceof MethodNotAllowedHttpException) {
                $code = 405;
                $error = 'Method not allowed';
            } else {
                $code = $e->getCode() ? $e->getCode() : 500;
                $error = 'An error occurred';
            }

            return response()->json([
                'code' => $code,
                'error' => $error,
                'description' => $e->getMessage()
            ], $code);
        }

        return parent::render($request, $e);
    }

    /**
     * Render an exception using Whoops.
     *
     * @param  Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    protected function renderExceptionWithWhoops($request, Exception $e)
    {
        $whoops = new \Whoops\Run;

        if ($request->ajax() || $request->wantsJson()) {
            $whoops->pushHandler(new \Whoops\Handler\JsonResponseHandler());
        } else {
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
        }

        return new \Illuminate\Http\Response(
            $whoops->handleException($e),
            $e->getCode() ? $e->getCode() : 404,
            $e->getHeaders()
        );
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $e)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response(['error' => 'Unauthorized.'], 401);
        } else {
            return redirect()->guest('login');
        }
    }
}
