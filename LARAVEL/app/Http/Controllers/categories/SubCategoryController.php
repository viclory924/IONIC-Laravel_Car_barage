<?php

namespace App\Http\Controllers\categories;

use App\Models\Categories\Category;
use App\Models\Categories\SubCategory;
use App\Traits\uploadFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use DB;

class SubCategoryController extends Controller
{
    use uploadFile;

    function index()
    {
        $data = DB::table('service_sub_category as s')
            ->leftJoin('service_category as c', 'c.id', '=', 's.cat_id')
            ->select(['s.ar_name', 's.en_name', 's.image', 'c.en_name as category', 'c.id as cat_id', 's.id'])
            ->get();

        return view('categories.sub-main', ['data' => $data]);
    }

    function form($id = null)
    {
        if (isset($id) && !empty($id)) {
            $data = SubCategory::where('id', '=', $id)->first();
        } else {
            $data = '';
        }
        $catList = Category::all();
        return view('categories.sub-form', ['data' => $data, 'catList' => $catList]);
    }

    function create(Request $request)
    {
        if ($this->checkFileType($request, 'image')
            && isset($request->ar_name) && !empty($request->ar_name)
            && isset($request->en_name) && !empty($request->en_name)) {
            $path = $request->file('image')->store('/categories/sub');
            $data = new SubCategory();
            $data['ar_name'] = $request->ar_name;
            $data['en_name'] = $request->en_name;
            $data['cat_id'] = $request->cat_id;
            $data['image'] = $path;
            $data->save();
            return $this->index();
        } else {
            return view('errors.upload');
        }
    }

    function update(Request $request, $id)
    {
        if (isset($id) && !empty($id)) {
            if (isset($request->ar_name) && !empty($request->ar_name)
                && isset($request->en_name) && !empty($request->en_name)) {

                $data = SubCategory::where('id', '=', $id)->first();
                if (isset($data) && !empty($data)) {
                    if (Input::hasFile('image')) {
                        if ($this->checkFileType($request, 'image')) {
                            if (file_exists(env('CONTENT') . $data['image'])) {
                                unlink(env('CONTENT') . $data['image']);
                            }
                            $path = $request->file('image')->store('/categories/sub');
                            $data['image'] = $path;
                        }
                    }
                    $data['ar_name'] = $request->ar_name;
                    $data['en_name'] = $request->en_name;
                    $data['cat_id'] = $request->cat_id;
                    $data->save();
                    return $this->index();
                } else {
                    return view('errors.404');
                }
            }

        } else {
            return view('errors.404');
        }
    }

    function delete($id)
    {
        $data = SubCategory::where('id', '=', $id)->first();
        if (isset($data) && !empty($data)) {
            if (file_exists(env('CONTENT') . $data['image'])) {
                unlink(env('CONTENT') . $data['image']);
            }

            $data->delete();
            return $this->index();
        } else {
            return view('errors.404');
        }
    }

    function mobView($id){
        $data = SubCategory::where('cat_id', '=', $id)->get();
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
