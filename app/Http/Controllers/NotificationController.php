<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;

class NotificationController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $notifications = Notification::where('user_id',auth()->user()->id)->orderBy('created_at', 'desc')->get();
        $notifications_not_read = Notification::where('user_id',auth()->user()->id)->where('read_at',null)->get();
        $count_notifications = count($notifications_not_read);

        return response(['data' => $notifications, 'count_notifications' => $count_notifications],200);
    }


    /**
     * Display a listing of the resources only for the mobile app.
     *
     * @return \Illuminate\Http\Response
     */
    public function list_app_notifications()
    {
        $notifications = Notification::where('user_id',auth()->user()->id)->where('category',4)->orWhere('category',5)->get();
        $count_notifications = count($notifications);

        return response(['data' => $notifications, 'count_notifications' => $count_notifications],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function read_all()
    {
        Notification::where('user_id',auth()->user()->id)->whereNull('read_at') ->update(['read_at' => Carbon::now()]);
        $notifications = Notification::where('user_id',auth()->user()->id)->orderBy('created_at', 'desc')->get();
        $notifications_not_read = Notification::where('user_id',auth()->user()->id)->where('read_at',null)->get();
        $count_notifications = count($notifications_not_read);

        return response(['data' => $notifications, 'count_notifications' => $count_notifications],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function read_one(Request $request)
    {
        Notification::where('id',$request->get('notification_id')) ->update(['read_at' => Carbon::now()]);
        $notifications = Notification::where('user_id',auth()->user()->id)->orderBy('created_at', 'desc')->get();
        $notifications_not_read = Notification::where('user_id',auth()->user()->id)->where('read_at',null)->get();
        $count_notifications = count($notifications_not_read);

        return response(['data' => $notifications, 'count_notifications' => $count_notifications],200);
    }
}
