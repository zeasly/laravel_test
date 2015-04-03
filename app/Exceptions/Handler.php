<?php namespace App\Exceptions;

use Exception;
use Psr\Log\LoggerInterface;
use App\Services\MyLog;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException',
	];

	private $MyLog;

	public function __construct(LoggerInterface $log, MyLog $MyLog)
	{
		$this->log = $log;
		$this->MyLog = $MyLog;
	}


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
		// 处理自定义
		$this ->MyLog ->simpleError($e);
		// if ($e instanceof \Illuminate\Database\QueryException) {
		// 	\App\Services\MyLog::queryError($e);
		// }
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
		return parent::render($request, $e);
	}

}
