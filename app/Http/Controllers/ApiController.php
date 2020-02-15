<?php
namespace App\Http\Controllers;

class ApiController extends \App\Http\Controllers\Controller
{
    // here we will include all the helpers for the api controllers part


    // error codes
    const CODE_OK = 20;
    const CODE_CREATED = 21;
    const CODE_FAILED = 22;
    const CODE_NOT_FOUND = 23;
    const CODE_VALIDATION = 24;
    const CODE_INTERNAL_ERR = 25;
    const CODE_RECORD_EXISTS = 26;
    const CODE_NOT_ACTIVE = 27;
    const CODE_METHOD_NOT_ALLOWED = 28;
    const CODE_NOT_MATCH = 29;
    const CODE_SAME_PASSWORD = 30;
    const CODE_UNAUTHORIZED = 42;

    // Roles number as constant
    const ROLE_ADMIN = 1;
    const ROLE_SALE = 2;
    const ROLE_USER = 3;

    const ACTIVE = 1;

    const TRUE = 1;
    const FALSE = 0;

    //
    /**
     *  log error message
     *
     * @param string $msg
     * @param string $page
     */

    protected static $currentLocation = '';
    protected static $lang = '';


    /**
     *  log error message in log file in case of try and catch
     *
     * @param string $msg
     */
    public static function logErr($msg)
    {
        self::$currentLocation = ' class [ ' . get_called_class() . ' ] and in method [ ' . debug_backtrace()[1]['function'] . ' ] ';
        \Log::error(" \n--------------------- \n this error in => " . self::$currentLocation . "\n says: \n $msg \n -------------------- \n");
    }


    public static function catchExceptions($msg)
    {
        self::logErr($msg);
        // send mail to developer
        return false;
    }

    public static function jsonResponse($status, $error_code, $message, $validation = "", $response = "", $token = "")
    {
        $response = ($response === "") ? new \stdClass() : $response;
        $validation = ($validation == "") ? new \stdClass() : $validation;

        return response()->json([
            'Error' => [
                'status' => $status,
                'code' => $error_code,
                'validation' => $validation,
                'desc' => $message,
                'token' => $token
            ],
            'Response' => $response,
        ], 200);
    }

    public function setLang($request)
    {
        // update Language
        if (!in_array($request->headers->get('Lang'), ['en', 'ar'])) {
            self::$lang = 'en';
        } else {
            self::$lang = $request->headers->get('Lang');
        }
        app()->setLocale(self::$lang);
    }
}
