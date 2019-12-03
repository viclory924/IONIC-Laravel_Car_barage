<?php
/**
 * Created by PhpStorm.
 * User: Tariq
 * Date: 18/06/2019
 * Time: 22:18
 */

namespace App\Traits;


use App\Models\Users\User;
use App\Models\Users\UsersValidation;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Int_;


trait validation
{
    function createEmailValidationCode($userInfo)
    {
        $check = UsersValidation::where('send_to', '=', $userInfo['email'])
            ->where('valid', '=', 1)
            ->first();
        if (isset($check) && !empty($check)) {
            if (Carbon::now() > $check->expired_date) {
                $check->valid=0;
                $check->save();
                $code = $this->saveValidationCode($userInfo);
            } else {
                $code = $check->code;
            }
        } else {
            $code = $this->saveValidationCode($userInfo);
        }

        return $code;
    }

    function createEmailValidationMobCode($userInfo){
        $check = UsersValidation::where('send_to', '=', $userInfo['email'])
            ->where('valid', '=', 1)
            ->first();
        if (isset($check) && !empty($check)) {
            if (Carbon::now() > $check->expired_date) {
                $check->valid=0;
                $check->save();
                $code = $this->saveValidationMobCode($userInfo);
            } else {
                $code = $check->code;
            }
        } else {
            $code = $this->saveValidationMobCode($userInfo);
        }

        return $code;
    }

    function createMobileValidationMobCode($userInfo){
        $check = UsersValidation::where('send_to', '=', $userInfo['mobile'])
            ->where('valid', '=', 1)
            ->first();
        if (isset($check) && !empty($check)) {
            if (Carbon::now() > $check->expired_date) {
                $check->valid=0;
                $check->save();
                $code = $this->saveValidationMobCode($userInfo);
            } else {
                $code = $check->code;
            }
        } else {
            $code = $this->saveValidationMobCode($userInfo);
        }

        return $code;
    }

    function saveValidationCode($userInfo)
    {
        $dataValid = new UsersValidation();
        $dataValid['user_id'] = $userInfo['id'];
        $dataValid['send_to'] = $userInfo['email'];
        $dataValid['expired_date'] = Carbon::now()->addDay();
        $dataValid['valid'] = 1;
        $code = Str::random(32);
        $dataValid['code'] = $code;
        $dataValid->save();

        return $code;
    }

    function saveValidationMobCode($userInfo){
        $dataValid = new UsersValidation();
        $dataValid['user_id'] = $userInfo['id'];
        if(!empty($userInfo['email']) && isset($userInfo['email'])){
            $dataValid['send_to'] = $userInfo['email'];
        }else{
            $dataValid['send_to'] = $userInfo['mobile'];
        }
        $dataValid['expired_date'] = Carbon::now()->addMinutes(30);
        $dataValid['valid'] = 1;
        $code = $randNum = random_int(1000, 9999);
        $dataValid['code'] = $code;
        $dataValid->save();

        return $code;
    }

    function emailExist($email){
        $data = User::where('email', '=', strtolower($email))->first();
        if(isset($data) && !empty($data)){
            return false;
        }else{
            return true;
        }
    }

    function mobileExist($mobile){
        $data = User::where('mobile', '=', $mobile)->first();
        if(isset($data) && !empty($data)){
            return false;
        }else{
            return true;
        }
    }

    function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@#$%^&*()_+=";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    function checkRequiredFields(Request $request, $filedsArray)
    {
        if(!empty($filedsArray)){
            foreach ($filedsArray as $item){
                if(!isset($request->$item) || empty($request->$item)){
                    return false;
                }
            }
            return true;
        }else{
            return true;
        }
    }
}
