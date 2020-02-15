<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Notification;
use Illuminate\Http\Request;
use Validator;

class NotificationController extends ApiController
{
    public function __construct(Request $request)
    {
        $this->setLang($request);
    }

    /**
     *  set token device in database
     *
     * @param Request $request
     * @return string
     */
    public function getNotifications(Request $request)
    {
        $user = auth()->guard('api')->user();

        $offset = (isset($request->offset) && !empty($request->offset)) ? $request->offset : 0;
        $limit = (isset($request->limit) && !empty($request->limit)) ? $request->limit : 10;

        // Find token with the same platform
        $notifications = Notification::orderBy('created_at', 'desc')->where('receiver_id', $user->id)
            ->select('id', app()->getLocale() . '_title as title', app()->getLocale() . '_message as message', 'is_read', 'product_id', 'created_at')
            ->offset($offset)
            ->limit($limit)
            ->get();

        if (!$notifications) {
            return self::jsonResponse(false, self::CODE_FAILED, trans('api.notifications-not-found'));
        }
        return self::jsonResponse(true, self::CODE_OK, trans('api.notifications-list'), '', $notifications);

    }


    /**
     *  set notification as read
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setRead(Request $request)
    {
        $user = auth()->guard('api')->user();
        if ($user == null) {
            return self::jsonResponse(false, self::CODE_NOT_FOUND, trans('api.unauthorized'));
        }
        // Validation area
        $validator = Validator::make($request->all(), [
            'notification_id' => 'required|numeric|exists:notifications,id',
        ]);
        if ($validator->fails()) {
            return self::jsonResponse(false, self::CODE_VALIDATION, trans('api.validation_err'), $validator->errors(), '');
        }
        Notification::where('id', $request->get('notification_id'))->update([
            'is_read' => 1
        ]);
        return self::jsonResponse(true, self::CODE_OK, trans('api.notifications-read-ok'));
    }

    /**
     *  notifications count
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnreadNotificationsCount(Request $request)
    {
        $user = auth()->guard('api')->user();
        if ($user == null) {
            return self::jsonResponse(false, self::CODE_NOT_FOUND, trans('api.unauthorized'));
        }

        try {
            $count = Notification::where('receiver_id', $user->id)->where('is_read', 0)->count() ?? 0;
        } catch (\Exception $e) {
            self::logErr($e->getMessage());
            return self::jsonResponse(false, self::CODE_NOT_FOUND, trans('api.login_error'));
        }

        return self::jsonResponse(true, self::CODE_OK, trans('notifications-count'), '', $count);
    }
}
