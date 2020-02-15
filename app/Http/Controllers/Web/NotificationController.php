<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;
use App\Http\Requests\SendNotificationsRequest;
use App\Http\Traits\NotificationTrait;
use App\Models\Notification;
use App\Models\Token;
use App\Models\User;

class NotificationController extends WebController
{

    use NotificationTrait;


    /**
     *  get notifications for
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function notificationsForm()
    {
        return view('admin.notifications.index');
    }

    /**
     *  change the language of the application
     *
     * @param SendNotificationsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendNotification(SendNotificationsRequest $request)
    {

        $title = $request->get(app()->getLocale() . '_title');
        $msg = $request->get(app()->getLocale() . '_message');
        $product_id = $request->get('product_id');

        $records = array();

        // loop all users who opens the notifications on the application to send notifications
        $all_users = User::where('role_id', '!=', self::ROLE_ADMIN)->where('is_notification', 1)->get();
        foreach ($all_users as $user) {
            $tokens = Token::where('user_id', $user->id)
                ->select('token')
                ->get()
                ->pluck('token')
                ->toArray();
            if (count($tokens) > 0) {
                // send notification
                $this->push_notification($title, $msg, $tokens, $product_id);
                // store in the database the notifications

                $records[] = array(
//                    'ar_title' => $request->get('ar_title'),
                    'en_title' => $request->get('en_title'),
                    'en_message' => $request->get('en_message'),
//                    'ar_message' => $request->get('ar_message'),
                    'product_id' => $product_id,
                    'receiver_id' => $user->id,
                    'created_at' => now('Africa/Cairo')->format('Y-m-d H:i:s')
                );
            }
        }

        if (count($records) > 0) {
            // bulk insert in the dataBase
            Notification::insert($records); // will take less time than doing insert query for every user
        }

        // send only notification for other users
        $tokens = Token::whereNull('user_id')
            ->select('token')
            ->get()
            ->pluck('token')
            ->toArray();
        if (count($tokens) > 0) {
            // send notification
            $this->push_notification($title, $msg, $tokens, $product_id);
        }

        return $this->messageAndRedirect(self::STATUS_OK, trans('admin.notifications-sent-successfully'));
    }
}
