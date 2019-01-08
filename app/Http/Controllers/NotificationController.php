<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
  /**
   * Create a new AuthController instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('JWT');
  }

  public function index()
  {
    //dd(auth()->user());
    //dd(auth()->user()->readNotifications);
    return [
      //'all' => NotificationResource::collection(auth()->user()->notifications),
      'read' => NotificationResource::collection(auth()->user()->readNotifications),
      'unread' => NotificationResource::collection(auth()->user()->unReadNotifications),
    ];
  }
  public function markAsRead(Request $request)
  {
    auth()->user()->notifications->where('id', $request->id)->markAsRead();
  }
}