<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
  /**
  * A list of the exception types that should not be reported.
  *
  * @var array
  */
  protected $dontReport = [
    HttpException::class,
    ModelNotFoundException::class,
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
    return parent::report($e);
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
    //check if exception is an instance of ModelNotFoundException.
    if ($e instanceof ModelNotFoundException) {
      // ajax 404 json feedback
      if ($request->ajax()) {
        return response()->json(['error' => 'Not Found'], 404);
      }
    }

    if($this->isHttpException($e))
    {
      switch ($e->getStatusCode()) {
        // not found
        case 404:
          return response()->view('errors.404',[],404);
        break;

        // internal server error
        case 500:
          return response()->view('errors.500',[],500);
        break;

        default:
          return $this->renderHttpException($e);
        break;
      }
    }else {
      return $this->renderHttpException($e);
    }
  }
}
