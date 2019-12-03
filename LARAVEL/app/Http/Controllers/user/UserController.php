<?php

namespace App\Http\Controllers\user;

use App\Jobs\MailQueue;
use App\Jobs\SMS;
use App\Models\Users\OauthClients;
use App\Models\Users\User;
use App\Models\Users\UsersValidation;
use App\Models\Workshop\Workshop;
use App\Traits\validation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Lang;
use Mail;
use Auth;
use Storage;

class UserController extends Controller
{
    use validation;

    private $requerdFileds = [
        'name',
        'mobile',
        'email',
        'password'
    ];

    function index()
    {
        $data = User::all();
        return view('user.index', ['data' => $data]);
    }

    function form($id = null)
    {
        if (isset($id) && !empty($id)) {
            $data = User::where('id', '=', $id)->first();
            if (isset($data) && !empty($data)) {
                return view('user.form', ['data' => $data]);
            } else {
                return view('errors.404');
            }
        } else {
            return view('user.form', ['data' => '']);
        }

    }

    function create(Request $request)
    {
        if (isset($request->name) && !empty($request->name)
            && isset($request->email) && !empty($request->email)
            && isset($request->password) && !empty($request->password)) {
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['password'] = \Hash::make($request->password);
            $data['active'] = 1;
            $data['type'] = 'admin';
            User::create($data);
            return $this->index();
        } else {
            return view('errors.429');
        }
    }

    function update(Request $request, $id)
    {
        if (isset($request->name) && !empty($request->name)
            && isset($request->email) && !empty($request->email)
            && isset($id) && !empty($id)) {
            User::where('id', '=', $id)
                ->update(['name' => $request->name, 'email' => $request->email]);
            return $this->index();
        } else {
            return view('errors.429');
        }
    }

    function suspend($id)
    {
        if (isset($id) && !empty($id)) {
            User::where('id', '=', $id)
                ->update(['active' => 0]);
            return $this->index();
        } else {
            return view('errors.429');
        }
    }

    function unsuspend($id)
    {
        if (isset($id) && !empty($id)) {
            User::where('id', '=', $id)
                ->update(['active' => 1]);
            return $this->index();
        } else {
            return view('errors.429');
        }
    }

    function reset($id)
    {
        if (isset($id) && !empty($id)) {
            $data = User::where('id', '=', $id)->first();
            if (isset($data) && !empty($data)) {
                return view('user.reset', ['data' => $data]);
            } else {
                return view('errors.419');
            }
        } else {
            return view('errors.429');
        }
    }

    function password(Request $request, $id)
    {
        if (isset($id) && !empty($id)) {
            User::where('id', '=', $id)
                ->update(['password' => \Hash::make($request->password)]);
            return $this->index();
        } else {
            return view('errors.429');
        }
    }

    function mobLogin(Request $request)
    {
        $Oauth = OauthClients::where('id', '=', $request->client_id)
            ->where('secret', '=', $request->client_secret)
            ->first();
        if (isset($Oauth) && !empty($Oauth)) {
            if (Auth::attempt(['email' => $request->username, 'password' => $request->password])
                || Auth::attempt(['mobile' => $request->username, 'password' => $request->password])) {
                $user = Auth::user();
                if (!empty($user->active) && isset($user->active) && $user->active == 1) {
                    $success['token'] = $user->createToken('MyApp')->accessToken;
                    $success['name'] = $user->name;
                    $success['image'] = $user->image;
                    $success['type'] = $user->type;
                    return response()->json(['success' => $success], 200);
                } else {
                    return response()->json(['error' => 'notActive'], 200);
                }
            } else {
                return response()->json(['error' => 'Unauthorised'], 401);
            }
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    function mobRegister(Request $request)
    {
        if ($this->checkRequiredFields($request, $this->requerdFileds)) {
            if ($this->emailExist($request->email) && $this->mobileExist($request->mobile)) {
                $user = new User();
                if ($request->type == 'workshop') {
                    $workShop = new Workshop();
                    $workShop['email'] = $request->email;
                    $workShop['mobile'] = $request->mobile;
                    $workShop->save();
                    $user['workshop_id'] = $workShop->id;
                }
                $user['name'] = $request->name;
                $user['email'] = $request->email;
                $user['mobile'] = $request->mobile;
                $user['password'] = \Hash::make($request->password);
                $user['type'] = $request->type;

                $user->save();
                $userInfo = ['email' => $request->email, 'id' => $user->id];

                $code = $this->createEmailValidationMobCode($userInfo);
                unset($userInfo);
                $emailInfo['subject'] = Lang::get('messages.email_validation');
                $emailInfo['body'] = Lang::get('messages.email_validation_message');
                $emailInfo['code'] = $code;
                Mail::to($request->email)->queue(new MailQueue($emailInfo));

                $sms['mobile'] = $request->mobile;
                $userInfo = ['mobile' => $request->mobile, 'id' => $user->id];
                $code = $this->createMobileValidationMobCode($userInfo);
                $sms['code'] = $code;
                //SMS::dispatch($sms);

                return response()->json(['success' => 'need_active'], 200);
            } else {
                return response()->json(['error' => 'mob_email'], 200);
            }
        } else {
            return response()->json(['error' => 'bad_request'], 400);
        }
    }

    function mobValidMobile(Request $request)
    {
        if (isset($request->mobile) && !empty($request->mobile)
            && isset($request->code) && !empty($request->code)
            && strlen($request->code) == 4) {
            $data = UsersValidation::where('code', '=', $request->code)
                ->where('send_to', '=', $request->mobile)
                ->where('valid', '=', 1)
                ->first();
            $userData = User::where('mobile', '=', $request->mobile)->first();
            if (isset($userData) && !empty($userData)) {
                if (isset($data) && !empty($data)) {
                    if ($data->expired_date >= Carbon::now()) {
                        $data->valid = 0;
                        $data->save();
                        $userData->active = 1;
                        $userData->save();
                        return response()->json(['success' => 'user_active'], 200);
                    } else {
                        $data->valid = 0;
                        $data->save();
                        $sms['mobile'] = $request->mobile;
                        $userInfo = ['mobile' => $request->mobile, 'id' => $userData->id];
                        $code = $this->createMobileValidationMobCode($userInfo);
                        $sms['code'] = $code;
                        //SMS::dispatch($sms);
                        return response()->json(['error' => 'code_sent_again'], 200);
                    }
                } else {
                    $sms['mobile'] = $request->mobile;
                    $userInfo = ['mobile' => $request->mobile, 'id' => $userData->id];
                    $code = $this->createMobileValidationMobCode($userInfo);
                    $sms['code'] = $code;
                    //SMS::dispatch($sms);
                    return response()->json(['error' => 'code_sent'], 200);
                }
            } else {
                return response()->json(['error' => 'bad_mobile'], 400);
            }
        } else {
            return response()->json(['error' => 'bad_request'], 400);
        }
    }

    function mobValidEmail(Request $request)
    {
        if (isset($request->email) && !empty($request->email)
            && isset($request->code) && !empty($request->code)
            && strlen($request->code) == 4) {
            $data = UsersValidation::where('code', '=', $request->code)
                ->where('send_to', '=', $request->email)
                ->where('valid', '=', 1)
                ->first();
            $userData = User::where('email', '=', $request->email)->first();
            if (isset($userData) && !empty($userData)) {
                if (isset($data) && !empty($data)) {
                    if ($data->expired_date >= Carbon::now()) {
                        $data->valid = 0;
                        $data->save();
                        $userData->active = 1;
                        $userData->save();
                        return response()->json(['success' => 'user_active'], 200);
                    } else {
                        $data->valid = 0;
                        $data->save();
                        $userInfo = ['email' => $request->email, 'id' => $userData->id];
                        $code = $this->createEmailValidationMobCode($userInfo);
                        $emailInfo['subject'] = Lang::get('messages.email_validation');
                        $emailInfo['body'] = Lang::get('messages.email_validation_message');
                        $emailInfo['code'] = $code;
                        Mail::to($request->email)->queue(new MailQueue($emailInfo));
                        return response()->json(['error' => 'code_sent_again'], 200);
                    }
                } else {
                    $userInfo = ['email' => $request->email, 'id' => $userData->id];
                    $code = $this->createEmailValidationMobCode($userInfo);
                    $emailInfo['subject'] = Lang::get('messages.email_validation');
                    $emailInfo['body'] = Lang::get('messages.email_validation_message');
                    $emailInfo['code'] = $code;
                    Mail::to($request->email)->queue(new MailQueue($emailInfo));
                    return response()->json(['error' => 'code_sent'], 200);
                }
            } else {
                return response()->json(['error' => 'bad_email'], 400);
            }
        } else {
            return response()->json(['error' => 'bad_request'], 400);
        }
    }

    function mobResetByEmail(Request $request)
    {
        if (isset($request->email) && !empty($request->email)) {
            $data = User::where('email', '=', $request->email)->first();
            if (isset($data) && !empty($data)) {
                $userValidation = UsersValidation::where('send_to', '=', $request->email)
                    ->where('valid', '=', 1)
                    ->first();
                if (isset($userValidation) && !empty($userValidation)) {
                    if ($userValidation->expired_date < Carbon::now()) {
                        $userValidation->valid = 0;
                        $userValidation->save();
                        $userInfo = ['email' => $request->email, 'id' => $data->id];
                        $code = $this->createEmailValidationMobCode($userInfo);
                        $emailInfo['subject'] = Lang::get('messages.email_validation');
                        $emailInfo['body'] = Lang::get('messages.email_validation_message');
                        $emailInfo['code'] = $code;
                        Mail::to($request->email)->queue(new MailQueue($emailInfo));
                        return response()->json(['error' => 'code_sent'], 200);
                    }
                    return response()->json(['error' => 'code_sent'], 200);
                } else {
                    $userInfo = ['email' => $request->email, 'id' => $data->id];
                    $code = $this->createEmailValidationMobCode($userInfo);
                    $emailInfo['subject'] = Lang::get('messages.email_validation');
                    $emailInfo['body'] = Lang::get('messages.email_validation_message');
                    $emailInfo['code'] = $code;
                    Mail::to($request->email)->queue(new MailQueue($emailInfo));
                    return response()->json(['error' => 'code_sent'], 200);
                }
            } else {
                return response()->json(['error' => 'bad_email'], 200);
            }
        } else {
            return response()->json(['error' => 'bad_request'], 400);
        }
    }

    function mobResetByMobile(Request $request)
    {
        if (isset($request->mobile) && !empty($request->mobile)) {
            $data = User::where('mobile', '=', $request->mobile)->first();
            if (isset($data) && !empty($data)) {
                $userValidation = UsersValidation::where('send_to', '=', $request->mobile)
                    ->where('valid', '=', 1)
                    ->first();
                if (isset($userValidation) && !empty($userValidation)) {
                    if ($userValidation->expired_date < Carbon::now()) {
                        $userValidation->valid = 0;
                        $userValidation->save();
                        $sms['mobile'] = $request->mobile;
                        $userInfo = ['mobile' => $request->mobile, 'id' => $data->id];
                        $code = $this->createMobileValidationMobCode($userInfo);
                        $sms['code'] = $code;
                        //SMS::dispatch($sms);
                        return response()->json(['error' => 'code_sent'], 200);
                    }
                    return response()->json(['error' => 'code_sent'], 200);
                } else {
                    $sms['mobile'] = $request->mobile;
                    $userInfo = ['mobile' => $request->mobile, 'id' => $data->id];
                    $code = $this->createMobileValidationMobCode($userInfo);
                    $sms['code'] = $code;
                    //SMS::dispatch($sms);
                    return response()->json(['error' => 'code_sent'], 200);
                }
            } else {
                return response()->json(['error' => 'bad_mobile'], 200);
            }
        } else {
            return response()->json(['error' => 'bad_request'], 400);
        }
    }

    function mobCheckResetCode(Request $request)
    {
        if (!empty($request->item) && isset($request->item)
            && !empty($request->type) && isset($request->type)
            && !empty($request->code) && isset($request->code)) {
            //\DB::enableQueryLog();
            $dataValidation = UsersValidation::where('send_to', '=', $request->item)
                ->where('code', '=', $request->code)
                ->where('valid', '=', '1')
                ->where('expired_date', '>=', date('Y-m-d H:i:s', strtotime(Carbon::now())))
                ->first();
            //dd(\DB::getQueryLog());
            if (isset($dataValidation) && !empty($dataValidation)) {
                $dataValidation->valid = 0;
                $dataValidation->save();
                return response()->json(['error' => 'success', 'user_id' => $dataValidation->user_id], 200);
            } else {
                return response()->json(['error' => 'code_error'], 200);
            }
        } else {
            return response()->json(['error' => 'bad_request'], 400);
        }
    }

    function mobRestPass(Request $request)
    {
        if (isset($request->user_id) && !empty($request->user_id)
            && isset($request->password) && !empty($request->password)) {
            $data = User::where('id', '=', $request->user_id)->first();
            if (isset($data) && !empty($data)) {
                $data->password = \Hash::make($request->password);
                $data->save();
                return response()->json(['error' => 'success'], 200);
            } else {
                return response()->json(['error' => 'bad_request'], 400);
            }
        } else {
            return response()->json(['error' => 'bad_request'], 400);
        }
    }

    function mobChangePass(Request $request)
    {
        $userId = Auth::id();
        \Log::info($request->all());
        if (isset($request->password) && !empty($request->password)
            && isset($request->old_password) && !empty($request->old_password)) {
            $data = User::where("id", "=", $userId)->first();
            if (\Hash::check($request->old_password, $data->password)) {
                $data->password = \Hash::make($request->password);
                $data->save();
                return response()->json(['error' => 'success'], 200);
            } else {
                return response()->json(['error' => 'wrong_password'], 200);
            }
        } else {
            return response()->json(['error' => 'bad_request'], 400);
        }
    }

    function mobUploadProfileImg(Request $request)
    {
        \Log::info('start upload');
        if (isset($request->image) && !empty($request->image)) {
            \Log::info('request found');
            $data = User::where('id', '=', Auth::id())->first();
            if (isset($data) && !empty($data)) {
                \Log::info($data);
                $image = $request->input('image'); // image base64 encoded
                preg_match("/data:image\/(.*?);/", $image, $image_extension); // extract the image extension
                $image = preg_replace('/data:image\/(.*?);base64,/', '', $image); // remove the type part
                $image = str_replace(' ', '+', $image);
                $imageName = time() . '.' . 'jpeg';
                $path = 'profile/' . Auth::id() . '/' . $imageName;
                Storage::disk('public')->put($path, base64_decode($image));
                \Log::info('convert ');
                if (isset($data->image) & !empty($data->image)) {
                   \Log::info('check old ');
                    if (file_exists(env('CONTENT') . $data->image)) {
                        \Log::info('delete old ');
                        unlink(env('CONTENT') . $data->image);
                    }
                }
                $data['image'] = $path;
                $data->save();
                \Log::info('updated');
                return response()->json(['error' => 'success', 'data' => $path], 200);
            } else {
                return response()->json(['error' => 'bad_request'], 401);
            }
        } else {
            return response()->json(['error' => 'bad_request'], 400);
        }

    }
}
