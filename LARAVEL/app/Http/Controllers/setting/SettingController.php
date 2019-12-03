<?php

namespace App\Http\Controllers\setting;

use App\Models\setting\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    function index()
    {
        $data = Setting::all();

        return view('setting.setting', ['data'=>$data]);
    }

    function update(Request $request)
    {
        if(isset($request->setting) && !empty($request->setting)){
            foreach ($request->setting as $key => $value){
                Setting::where('id', '=', $key)
                    ->update(['value'=>$value]);
            }
            return $this->index();
        }else{
            return view('errors.429');
        }
    }
    
    function mobGetSetting(){
        $data = Setting::all();
        if (isset($data) && ! empty($data)) {
            return [
                'data' => $data,
                'error' => '200'
            ];
        } else {
            return [
                'data' => '',
                'error' => '400'
            ];
        }
    }
}
