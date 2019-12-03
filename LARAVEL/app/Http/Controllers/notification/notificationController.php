<?php

namespace App\Http\Controllers\notification;

use App\Models\Notification\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class notificationController extends Controller
{
    public function mobGetNoti()
    {
        $data = Notification::where('to_id', '=', Auth::id())
            ->where('status', '=', 'new')
            ->get();
        if (isset($data) && !empty($data)) {
            return response()->json(['error' => 'success', 'data' => $data], 200);
        } else {
            return response()->json(['error' => 'no_data_found', 'data' => ''], 200);
        }
    }

    public function mobOpenNotiPage(){
        $data=DB::table('notification as n')
            ->leftJoin('users as u', 'u.id', '=', 'n.form_id')
            ->select('u.name', 'n.*')
            ->where('to_id', '=', Auth::id())
            ->paginate();
        if (isset($data) && !empty($data)) {
            Notification::where('to_id', '=', Auth::id())
                ->update(['status'=>'old']);
            return response()->json(['error' => 'success', 'data' => $data], 200);
        } else {
            return response()->json(['error' => 'no_data_found', 'data' => ''], 200);
        }
    }
}
