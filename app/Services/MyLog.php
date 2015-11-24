<?php namespace App\Services;

use Exception;
use Request;
use Input;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Log\Writer;

class MyLog{

    // 所有的LOG都要求在这里注册
    const LOG_ERROR = 'error';
    const LOG_QUERY_ERROR = 'query_error';
    const LOG_QUERY_ALL = 'query_all';
    const LOG_SIMPLE_ERROR = 'simple_error';

    private static $loggers = [];

    // 获取一个实例
    public static function getLogger($type = MyLog::LOG_ERROR, $day = 30)
    {
        if (empty(self::$loggers[$type])) {
            self::$loggers[$type] = new Writer(new Logger($type));
            self::$loggers[$type]->useDailyFiles(storage_path().'/logs/'. $type . '.log', $day);
        }

        $log = self::$loggers[$type];
        return $log;
    }


    public static function queryError(Exception $exception)
    {
	    $err = [
			'message'	=> $exception->getMessage(),
			'sql'		=> $exception->getSql(),
			'bindings'	=> $exception->getBindings(),
			'file'		=> $exception->getFile(),
			'line'		=> $exception->getLine(),
			'code'		=> $exception->getCode(),
	    ];
	    return self::getLogger(MyLog::LOG_QUERY_ERROR)->error($err);
    }

    public static function simpleError(Exception $exception)
    {
        $err = [
            'message'   => $exception->getMessage(),
            'file'      => $exception->getFile(),
            'line'      => $exception->getLine(),
            'code'      => $exception->getCode(),
            'url'       => Request::url(),
            'input'     => Input::all(),
        ];
        return self::getLogger(MyLog::LOG_SIMPLE_ERROR)->error($err);
    }

    public static function queryAll($sql, $bindings, $time)
    {
        $err = [
            'sql'      => $sql,
            'bindings' => $bindings,
            'time'     => $time,
        ];
        return self::getLogger(MyLog::LOG_QUERY_ALL)->info($err);
    }

}
