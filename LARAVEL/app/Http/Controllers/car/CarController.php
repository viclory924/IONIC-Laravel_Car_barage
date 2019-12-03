<?php

namespace App\Http\Controllers\car;

use App\Models\car\Car;
use App\Models\car\CarHistory;
use App\Traits\validation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Storage;
use DB;
use thiagoalessio\TesseractOCR\TesseractOCR;

class CarController extends Controller
{
    use validation;

    private $requerdFileds = [
        'model',
        'origin',
        'eng_no',
        'vehicle_type',
        'chassis_no',
        'user_id'
    ];

    function mobIndex()
    {
        $data = Car::where('user_id', '=', Auth::id())
            ->where('deleted', '<>', 1)
            ->get()
            ->toArray();
        if (isset($data) && !empty($data)) {
            return response()->json(['error' => 'success', 'data' => $data], 200);
        } else {
            return response()->json(['error' => 'no_data_found', 'data' => ''], 200);
        }
    }

    function mobStore(Request $request)
    {
        $request->user_id = Auth::id();
        if ($this->checkRequiredFields($request, $this->requerdFileds)) {
            $data = new Car();
            $data['user_id'] = $request->user_id;
            $data['model'] = strtoupper($request->model);
            $data['origin'] = strtoupper($request->origin);
            $data['eng_no'] = strtoupper($request->eng_no);
            $data['vehicle_type'] = strtoupper($request->vehicle_type);
            $data['chassis_no'] = strtoupper($request->chassis_no);
            $data->save();
            return response()->json(['error' => 'success', 'data' => ''], 200);
        } else {
            return response()->json(['error' => 'bad_request', 'data' => ''], 400);
        }
    }

    function mobCarImage(Request $request, $id)
    {
        if (isset($request->image) && !empty($request->image)
            && isset($id) && !empty($id)) {
            $data = Car::where('id', '=', $id)
                ->where('user_id', '=', Auth::id())
                ->first();
            if (isset($data) && !empty($data)) {
                $image = $request->input('image'); // image base64 encoded
                preg_match("/data:image\/(.*?);/", $image, $image_extension); // extract the image extension
                $image = preg_replace('/data:image\/(.*?);base64,/', '', $image); // remove the type part
                $image = str_replace(' ', '+', $image);
                $imageName = $id . '_' . time() . '.' . 'jpeg';
                $path = 'car/' . Auth::id() . '/' . $imageName;
                Storage::disk('public')->put($path, base64_decode($image));
                if (isset($data->image) & !empty($data->image)) {
                    if (file_exists(env('CONTENT') . $data->image)) {
                        unlink(env('CONTENT') . $data->image);
                    }
                }
                $data['image'] = $path;
                $data->save();
                return response()->json(['error' => 'success', 'data' => $path], 200);
            } else {
                return response()->json(['error' => 'bad_request'], 400);
            }
        } else {
            return response()->json(['error' => 'bad_request'], 400);
        }
    }

    function mobDeleteCar($id)
    {
        if (isset($id) && !empty($id)) {
            $data = Car::where('id', '=', $id)
                ->where('user_id', '=', Auth::id())
                ->first();
            if (isset($data) && !empty($data)) {
                $data['deleted'] = 1;
                $data->save();
                return response()->json(['error' => 'success'], 200);
            } else {
                return response()->json(['error' => 'bad_request'], 401);
            }
        } else {
            return response()->json(['error' => 'bad_request'], 400);
        }
    }

    function mobCarHistory($carId)
    {
        if (isset($carId) && !empty($carId)) {
            if (Auth::check()) {
                $data = DB::table('car_history as h')
                    ->select('c.image', 'c.vehicle_type', 'h.note', DB::raw("DATE_FORMAT(h.date_out,'%d/%M/%Y') as date_out"), 'w.en_name', 'w.ar_name', 'h.price')
                    ->leftJoin('workshop as w', 'w.id', '=', 'h.workshop_id')
                    ->leftJoin('car as c', 'c.id', '=', 'h.car_id')
                    ->where('h.car_id', '=', $carId)
                    ->get();
                if (isset($data) && !empty($data)) {
                    return response()->json(['error' => 'success', 'data' => $data], 200);
                } else {
                    return response()->json(['error' => 'no_data_found', 'data' => ''], 200);
                }
            } else {
                return response()->json(['error' => 'bad_request', 'data' => ''], 401);
            }
        } else {
            return response()->json(['error' => 'bad_request', 'data' => ''], 400);
        }
    }

    function mobCarScan(Request $request)
    {
//        if (isset($request->image) && !empty($request->image)) {
//            $image = $request->input('image'); // image base64 encoded
//            preg_match("/data:image\/(.*?);/", $image, $image_extension); // extract the image extension
//            $image = preg_replace('/data:image\/(.*?);base64,/', '', $image); // remove the type part
//            $image = str_replace(' ', '+', $image);
//            $imageName = time() . '.' . 'jpeg';
//            $path = 'car-scan/' . Auth::id() . '/' . $imageName;
//            Storage::disk('public')->put($path, base64_decode($image));

//            $ocr = new TesseractOCR();
//            $ocr->image(env('CONTENT').$path)->run();
//            $data = $ocr;
//            $data = \OCR::scan(env('CONTENT').$path);

            $data['model'] = '2016';
            $data['origin'] = 'JAPAN';
            $data['veh_type'] = 'MITSUBISHI';
            $data['eng_no'] = '6G74YL9272';
            $data['chassis_no'] = 'JMYLYV95WGJ730934';

            return response()->json(['error' => 'success', 'data' => $data], 200);

//        } else {
//            return response()->json(['error' => 'bad_request'], 400);
//        }
    }
}
