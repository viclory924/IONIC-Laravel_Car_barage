<?php

namespace App\Http\Controllers\workshop;

use App\Models\Notification\Notification;
use App\Models\Users\User;
use App\Models\Workshop\WorkshopRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class requestController extends Controller
{
    function mobBook(Request $request)
    {
        if (Auth::check()) {
            if (isset($request->carId) && !empty($request->carId)
                && isset($request->workshopId) && !empty($request->workshopId)) {
                $data = new WorkshopRequest();
                $data['car_id']=$request->carId;
                $data['workshop_id']=$request->workshopId;
                $data['request_dat']=Carbon::now();
                $data['action']='new';
                $data->save();

                $notiData = new Notification();
                $notiData['form_id']=Auth::id();
                $notiData['to_id']=User::where('workshop_id', '=', $request->workshopId)->first()['id'];
                $notiData['reques_id']=$data->id;
                $notiData['noti_text']='request';
                $notiData['noti_date']=Carbon::now();
                $notiData['status']='new';
                $notiData->save();
                return response()->json(['error' => 'success'], 200);
            }
        } else {
            return response()->json(['error' => 'bad_request'], 401);
        }
    }
}
