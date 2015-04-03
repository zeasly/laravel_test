<?php namespace App\Services;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Log\Writer;

class MyLog{

    // 所有的LOG都要求在这里注册
    const LOG_ERROR = 'error';
    const LOG_QUERY = 'query';
    const LOG_SIMPLE_ERROR = 'simple_error';

    private $loggers = [];

    // 获取一个实例
    public function getLogger($type = MyLog::LOG_ERROR, $day = 30)
    {
        if (empty(self::$loggers[$type])) {
            $this ->$loggers[$type] = new Writer(new Logger($type));
            $this ->$loggers[$type]->useDailyFiles(storage_path().'/logs/'. $type . '_' . date('Y-m-d') . '.log', $day);
        }

        $log = $this ->$loggers[$type];
        return $log;
    }


    public function queryError(Exception $exception)
    {
	    $err = [
			'message'	=> $exception->getMessage(),
			'sql'		=> $exception->getSql(),
			'bindings'	=> $exception->getBindings(),
			'file'		=> $exception->getFile(),
			'line'		=> $exception->getLine(),
			'code'		=> $exception->getCode(),
	    ];
	    $this ->getLogger(MyLog::LOG_QUERY)->error($err);
    }

    public function simpleError(Exception $exception)
    {
        return 11;
	    $err = [
			'message'	=> $exception->getMessage(),
			'file'		=> $exception->getFile(),
			'line'		=> $exception->getLine(),
			'code'		=> $exception->getCode(),
			'url'		=> Request::url(),
			'input'		=> Input::all(),
	    ];
	    $this ->getLogger(MyLog::LOG_SIMPLE_ERROR)->error($err);
    }

}
