<?php

namespace App\Http\Controllers\workshop;

use App\Jobs\MailQueue;
use App\Models\Categories\Category;
use App\Models\Categories\SubCategory;
use App\Models\Lists\Brand;
use App\Models\Lists\City;
use App\Models\Lists\Country;
use App\Models\setting\Setting;
use App\Models\Users\User;
use App\Models\Users\UsersValidation;
use App\Models\Workshop\Workshop;
use App\Models\Workshop\WorkshopCategory;
use App\Traits\uploadFile;
use App\Traits\validation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Input;
use Mail;
use Lang;
use Auth;

class workshopController extends Controller
{

    use uploadFile, validation;

    private $requerdFileds = [
        'ar_name',
        'en_name',
        'country_id',
        'city_id',
        'ar_address',
        'en_address',
        'mobile',
        'sub_cat_id',
        'start_from',
        'end_at',
        'email'
    ];

    function index()
    {
        $data = DB::table('workshop as w')
            ->leftJoin('list_country as co', 'co.id', '=', 'w.country_id')
            ->leftJoin('list_city as ci', 'ci.id', '=', 'w.city_id')
            ->select([
                'w.id',
                'ci.ar_name AS ar_city',
                'ci.en_name as en_city',
                'co.ar_name as ar_country',
                'co.en_name as en_name',
                'w.*'
            ])
            ->whereNotNull('w.google_lat')
            ->whereNotNull('w.google_lng')
            ->paginate();
        if (isset($data) && !empty($data)) {
            return view('workshop.index', [
                'data' => $data
            ]);
        } else {
            return view('errors.429');
        }
    }

    function form($id = null)
    {
        if (isset($id) && !empty($id)) {
            $data = DB::table('workshop as w')->leftJoin('list_country as co', 'co.id', '=', 'w.country_id')
                ->leftJoin('list_city as ci', 'ci.id', '=', 'w.city_id')
                ->leftJoin('workshop_categories as wc', 'wc.workshop_id', '=', 'w.id')
                ->select([
                    'w.id',
                    'ci.ar_name AS ar_city',
                    'ci.en_name as en_city',
                    'co.ar_name as ar_country',
                    'co.en_name as en_name',
                    'w.*',
                    'w.id as workshop_main_id'
                ])
                ->where('w.id', '=', $id)
                ->first();
            $workshopCatData = WorkshopCategory::where('workshop_id', '=', $id)->get();
            $workshopCat = [];
            foreach ($workshopCatData as $item) {
                array_push($workshopCat, $item->sub_cat_id);
            }
        } else {
            $data = '';
            $workshopCat = '';
        }
        $countyList = Country::all();
        $cityList = City::all();
        $categoryList = Category::all();
        $subCategoryList = SubCategory::all();
        $brandList = Brand::all();

        return view('workshop.form', [
            'data' => $data,
            'countyList' => $countyList,
            'cityList' => $cityList,
            'categoryList' => $categoryList,
            'subCategoryList' => $subCategoryList,
            'workshopCat' => $workshopCat,
            'brandList' => $brandList
        ]);
    }

    function create(Request $request)
    {
        $request->email = strtolower($request->email);
        if ($this->emailExist($request->email) && $this->mobileExist($request->mobile)) {
            if ($this->checkRequiredFields($request, $this->requerdFileds)) {
                if ($this->checkFileType($request, 'image')) {
                    $data = new Workshop();
                    $data['ar_name'] = $request->ar_name;
                    $data['en_name'] = $request->en_name;
                    $data['country_id'] = $request->country_id;
                    $data['city_id'] = $request->city_id;
                    $data['brand_id'] = $request->brand_id;
                    $data['ar_address'] = $request->ar_address;
                    $data['en_address'] = $request->en_address;
                    $data['mobile'] = $request->mobile;
                    $data['telephone'] = $request->telephone;
                    $data['website'] = $request->website;
                    $data['email'] = $request->email;
                    $data['google_lat'] = $request->google_lat;
                    $data['google_lng'] = $request->google_lng;
                    $data['start_from'] = $request->start_from;
                    $data['end_at'] = $request->end_at;
                    $path = $request->file('image')->store('/workshop');
                    $data['logo'] = $path;
                    $data->save();
                    if (is_array($request->sub_cat_id)) {
                        foreach ($request->sub_cat_id as $item) {
                            $row = new WorkshopCategory();
                            $row['sub_cat_id'] = $item;
                            $row['workshop_id'] = $data->id;
                            $row->save();
                        }
                    } else {
                        $row = new WorkshopCategory();
                        $row['sub_cat_id'] = $request->sub_cat_id;
                        $row['workshop_id'] = $data->id;
                        $row->save();
                    }

                    $saveUser = new User();
                    $saveUser['name'] = $request->en_name;
                    $saveUser['email'] = $request->email;
                    $saveUser['mobile'] = $request->mobile;
                    $pass = $this->randomPassword();
                    $saveUser['password'] = \Hash::make($pass);
                    $saveUser['type'] = 'workshop';
                    $saveUser['workshop_id'] = $data->id;
                    $saveUser->save();
                    $userInfo = ['email' => $request->email, 'id' => $saveUser->id];

                    $emailInfo['subject'] = Lang::get('messages.email_validation');
                    $emailInfo['body'] = Lang::get('messages.email_validation_message');
                    $emailInfo['link'] = $this->createEmailValidationCode($userInfo);
                    Mail::to($request->email)->queue(new MailQueue($emailInfo));
                    return $this->index();
                } else {
                    return view('errors.image');
                }
            } else {
                return view('errors.required');
            }
        } else {
            return view('errors.email_exist');
        }
    }

    function update(Request $request, $id)
    {
        if ($this->checkRequiredFields($request, $this->requerdFileds)) {
            $data = Workshop::where('id', '=', $id)->first();
            if (isset($data) && !empty($data)) {
                if (Input::hasFile('image')) {
                    if ($this->checkFileType($request, 'image')) {
                        if (file_exists(env('CONTENT') . $data['logo'])) {
                            unlink(env('CONTENT') . $data['logo']);
                        }
                        $path = $request->file('image')->store('/workshop');
                        $data['logo'] = $path;
                    }
                }
                $data['ar_name'] = $request->ar_name;
                $data['en_name'] = $request->en_name;
                $data['country_id'] = $request->country_id;
                $data['city_id'] = $request->city_id;
                $data['brand_id'] = $request->brand_id;
                $data['ar_address'] = $request->ar_address;
                $data['en_address'] = $request->en_address;
                $data['mobile'] = $request->mobile;
                $data['telephone'] = $request->telephone;
                $data['website'] = $request->website;
                $data['email'] = $request->email;
                $data['google_lat'] = $request->google_lat;
                $data['google_lng'] = $request->google_lng;
                $data['start_from'] = $request->start_from;
                $data['end_at'] = $request->end_at;
                $data->save();
                WorkshopCategory::where('workshop_id', '=', $id)->delete();
                if (is_array($request->sub_cat_id)) {
                    foreach ($request->sub_cat_id as $item) {
                        $row = new WorkshopCategory();
                        $row['sub_cat_id'] = $item;
                        $row['workshop_id'] = $data->id;
                        $row->save();
                    }
                } else {
                    $row = new WorkshopCategory();
                    $row['sub_cat_id'] = $request->sub_cat_id;
                    $row['workshop_id'] = $data->id;
                    $row->save();
                }
                return $this->index();
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.404');
        }
    }

    function delete($id)
    {
        if (isset($id) && !empty($id)) {
            $data = Workshop::where('id', '=', $id)->first();
            if (isset($data) && !empty($data) && $data->logo) {
                WorkshopCategory::where('workshop_id', '=', $id)->delete();
                UsersValidation::where('send_to', '=', $data->email)->delete();
                User::where('workshop_id', '=', $id)->where('type', '=', 'workshop')->delete();
                if (file_exists(env('CONTENT') . $data->logo)) {
                    unlink(env('CONTENT') . $data->logo);
                }
            }
            $data->delete();
            return $this->index();
        } else {
            return view('errors.429');
        }
    }

    function mobView(Request $request)
    {
        $data = DB::table('workshop as w')
            ->leftJoin('list_country as co', 'co.id', '=', 'w.country_id')
            ->select([
                'w.id',
                'w.ar_name AS ar_name',
                'w.en_name AS en_name',
                'w.logo AS logo',
                'w.google_lat',
                'w.google_lng',
                'w.start_from',
                'w.end_at',
                'w.totl_rate as rate'
            ])
            ->whereNotNull('w.google_lat')
            ->whereNotNull('w.google_lng')
            ->paginate();

        if (isset($data) && !empty($data)) {
            foreach ($data as $key => $item) {
                $distance = $this->getDistance($request->lat, $request->lng, $item->google_lat, $item->google_lng);
                $item->distance = $distance;
            }
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

    function getDistance($lat1, $long1, $lat2, $long2)
    {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat1 . "," . $long1 . "&destinations=" . $lat2 . "," . $long2 . "&mode=driving&key=" . env('GOOGLE_API_KEY');
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        $content = json_decode($response->getBody(), true);
        $dist = $content['rows'][0]['elements'][0]['distance']['text'];

        return $dist;
    }

    function getDistanceBetweenPoints($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $kilometers = $miles * 1.609344;
        return $kilometers;
    }

    function modShow($id)
    {
        if (isset($id) && !empty($id)) {
            $settingShow = Setting::where('id', '=', '1')->first()->value;
            if (isset($settingShow) && !empty($settingShow)) {
                if (strtolower($settingShow) == 'free') {
                    return $this->modShowFull($id);
                } else {
                    return $this->modShowShort($id);
                }
            } else {
                return response()->json(['error' => 'bad_request'], 400);
            }
        } else {
            return response()->json(['error' => 'bad_request'], 400);
        }
    }

    function modShowDetails($id)
    {
        if (isset($id) & !empty($id)) {

            $data = DB::table('workshop as w')
                ->leftJoin('list_country as co', 'co.id', '=', 'w.country_id')
                ->leftJoin('users as u', 'u.workshop_id', '=', 'w.id')
                ->leftJoin('list_city as ci', 'ci.id', '=', 'w.city_id')
                ->select([
                    'w.*',
                    'u.image',
                    'co.ar_name as ar_country_name',
                    'co.en_name as en_country_name',
                    'ci.ar_name as ar_city_name',
                    'ci.en_name as en_city_name',
                ])
                ->where('w.id', '=', $id)
                ->first();
            if (isset($data) & !empty($data)) {
                return response()->json(['error' => 'success', 'data' => $data], 200);
            } else {
                return response()->json(['error' => 'success'], 400);
            }
        } else {
            return response()->json(['error' => 'bad_request'], 400);
        }
    }

    function mobGarageInfo()
    {
        if (Auth::check()) {
            $data = DB::table('workshop as w')
                ->where('w.id', '=', Auth::user()->workshop_id)
                ->leftJoin('list_country as co', 'co.id', '=', 'w.country_id')
                ->leftJoin('list_city as ci', 'ci.id', '=', 'w.city_id')
                ->select([
                    'w.id',
                    'ci.ar_name AS ar_city',
                    'ci.en_name as en_city',
                    'co.ar_name as ar_country',
                    'co.en_name as en_name',
                    'w.*',
                    'w.id as workshop_main_id'
                ])
                ->first();

            $countryList = Country::all();
            $cityList = City::all();
            $categoryList = Category::all();
            $subCategoryList = SubCategory::all();
            if (isset($data) && !empty($data)) {
                return response()->json(['error' => 'success',
                    'data' => $data,
                    'countryList' => $countryList,
                    'cityList' => $cityList,
                    'categoryList' => $categoryList,
                    'subCategoryList' => $subCategoryList], 200);
            } else {
                return response()->json(['error' => 'success',
                    'data' => '',
                    'countryList' => $countryList,
                    'cityList' => $cityList,
                    'categoryList' => $categoryList,
                    'subCategoryList' => $subCategoryList], 200);
            }
        } else {
            return response()->json(['error' => 'bad_request'], 400);
        }
    }

    function mobGarageImg(Request $request)
    {
        if (isset($request->image) && !empty($request->image)
            && isset($id) && !empty($id)) {
            $data = Workshop::where('id', '=', Auth::user()->workshio_id)
                ->first();
            if (isset($data) && !empty($data)) {
                $image = $request->input('image'); // image base64 encoded
                preg_match("/data:image\/(.*?);/", $image, $image_extension); // extract the image extension
                $image = preg_replace('/data:image\/(.*?);base64,/', '', $image); // remove the type part
                $image = str_replace(' ', '+', $image);
                $imageName = $id . '_' . time() . '.' . 'jpeg';
                $path = 'workshop/' . Auth::id() . '/' . $imageName;
                \Storage::disk('public')->put($path, base64_decode($image));
                if (isset($data->image) & !empty($data->image)) {
                    if (file_exists(env('CONTENT') . $data->image)) {
                        unlink(env('CONTENT') . $data->image);
                    }
                }
                $data['logo'] = $path;
                $data->update();
                return response()->json(['error' => 'success', 'data' => $data], 200);
            } else {
                return response()->json(['error' => 'bad_request'], 400);
            }
        } else {
            return response()->json(['error' => 'bad_request'], 400);
        }
    }

    function mobGarageSaveData(Request $request)
    {
        $data = Workshop::where('id', '=', Auth::user()->workshop_id)
            ->first();
        if (isset($data) && !empty($data)) {
            $workShopKey = ['country_id', 'city_id', 'ar_name', 'en_name',
                'ar_description', 'en_description', 'ar_address', 'en_address',
                'mobile', 'email', 'telephone', 'website',
                'google_lat', 'google_lng', 'start_from', 'end_at'];
            foreach ($workShopKey as $item) {
                if (isset($request->$item) && !empty($request->$item)) {
                    $data[$item] = $request->$item;
                    $data->update();
                }
            }


            WorkshopCategory::where('workshop_id', '=', Auth::user()->workshop_id)->delete();
            if (is_array($request->sub_cat_id)) {
                foreach ($request->sub_cat_id as $item) {
                    $row = new WorkshopCategory();
                    $row['sub_cat_id'] = $item;
                    $row['workshop_id'] = $data->id;
                    $row->save();
                }
            } else {
                $row = new WorkshopCategory();
                $row['sub_cat_id'] = $request->sub_cat_id;
                $row['workshop_id'] = $data->id;
                $row->save();
            }

            return response()->json(['error' => 'success', 'data' => $data], 200);
        } else {
            return response()->json(['error' => 'bad_request'], 400);
        }
    }

    function mobGarageSavePlace(Request $request){
        $data = Workshop::where('id', '=', Auth::user()->workshop_id)
            ->first();
        if (isset($data) && !empty($data)) {
            if(isset($request->latitude) && !empty($request->latitude)
            && isset($request->longitude) && !empty($request->longitude)){
                $data['google_lat']=$request->latitude;
                $data['google_lng']=$request->longitude;
                $data->update();
            }else{
                return response()->json(['error' => 'bad_request'], 400);
            }
        }else {
            return response()->json(['error' => 'bad_request'], 400);
        }
    }

    function view($id)
    {
    }

    function rate(Request $request, $id)
    {
    }

    function feedback(Request $request, $id)
    {
    }
}
