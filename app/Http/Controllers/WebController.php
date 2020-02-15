<?php
namespace App\Http\Controllers;

use Log;
use MercurySeries\Flashy\Flashy;

class WebController extends \App\Http\Controllers\Controller
{

    // Roles number as constant
    const ROLE_ADMIN = 1;
    const ROLE_SALE = 2;
    const ROLE_USER = 3;

    const STATUS_OK  = true;
    const STATUS_ERR  = false;

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

    public static function catchExceptions($msg)
    {
        self::logErr($msg);
        // send mail to developer
        return false;
    }


    /**
     *  method used when call destroy method in all web controllers
     *
     * @param $model
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    protected function deleteItem($model, $id)
    {
        $item = $model::find($id);
        if (!$item) {
            return response()->json(['msg' => false], 200);
        }
        try {
            $item->delete();
        } catch (\Exception $e) {
            self::logErr($e->getMessage());
            return response()->json(['msg' => false], 200);
        }
        return response()->json(['msg' => true], 200);
    }

    /**
     *  redirect to route || redirect back
     *  print ok message || error message || no message at all
     *
     * @param $message_type
     * @param $msg
     * @param string $route
     * @param array $parameters
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function messageAndRedirect($message_type, $msg = '', $route = '', $parameters = [])
    {
        if ($message_type == self::STATUS_OK) {
            Flashy::message($msg);
        } else if ($message_type == self::STATUS_ERR) {
            Flashy::error($msg);
        }
        if (empty($route)) {
            return redirect()->back();
        }
        return redirect()->route($route, $parameters);
    }

    /**
     * return view and flashy message
     * @param $message_type
     * @param string $msg
     * @param $view
     * @param $parameters
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function messageAndReturnView($message_type, $msg = '', $view , $parameters)
    {
        if ($message_type == self::STATUS_OK) {
            Flashy::message($msg);
        } else if ($message_type == self::STATUS_ERR) {
            Flashy::error($msg);
        }
        return view($view, $parameters);
    }

    /**
     * if not value put n/a
     * @param $value
     */
    public static function getProperty($value)
    {
        if (!$value || $value == null || empty($value || !isset($value))) {
            echo 'N/A';
        } else {
            echo $value;
        }
    }
}
