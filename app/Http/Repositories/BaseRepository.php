<?php
namespace App\Http\Repositories;
use Log;
class BaseRepository
{
    protected static $currentLocation = '';

    /**
     *  log error message in log file in case of try and catch
     *
     * @param string $msg
     */
    public static function logErr($msg)
    {
        self::$currentLocation = ' class [ ' . get_called_class() . ' ] and in method [ ' . debug_backtrace()[1]['function'] . ' ] ';
        Log::error(" \n--------------------- \n this error in => " . self::$currentLocation . "\n says: \n $msg \n -------------------- \n");
    }

    /**
     *  generate error in the Log File
     *
     * @param $msg
     * @return bool
     */
    public static function catchExceptions($msg)
    {
        self::logErr($msg);
        // send mail to developer
        return false;
    }
}
