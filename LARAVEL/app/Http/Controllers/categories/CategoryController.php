<?php

namespace App\Http\Controllers\categories;

use App\Models\Categories\Category;
use App\Models\Categories\SubCategory;
use App\Traits\uploadFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class CategoryController extends Controller
{
    use uploadFile;

    function index()
    {
        $data = Category::all();
        return view('categories.cat-main', ['data' => $data]);
    }

    function form($id = null)
    {
        if (isset($id) && !empty($id)) {
            $data = Category::where('id', '=', $id)->first();
        } else {
            $data = '';
        }
        return view('categories.form', ['data' => $data]);
    }

    function create(Request $request)
    {
        if ($this->checkFileType($request, 'image')
            && isset($request->ar_name) && !empty($request->ar_name)
            && isset($request->en_name) && !empty($request->en_name)) {
            $path = $request->file('image')->store('/categories/main');
            $data = new Category();
            $data['ar_name'] = $request->ar_name;
            $data['en_name'] = $request->en_name;
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

                $data = Category::where('id', '=', $id)->first();
                if (isset($data) && !empty($data)) {
                    if (Input::hasFile('image')) {
                        if ($this->checkFileType($request, 'image')) {
                            if (file_exists(env('CONTENT') . $data['image'])) {
                                unlink(env('CONTENT') . $data['image']);
                            }
                            $path = $request->file('image')->store('/categories/main');
                            $data['image'] = $path;
                        }
                    }
                    $data['ar_name'] = $request->ar_name;
                    $data['en_name'] = $request->en_name;
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
        $data = Category::where('id', '=', $id)->first();
        if (isset($data) && !empty($data)) {
            if (file_exists(env('CONTENT') . $data['image'])) {
                unlink(env('CONTENT') . $data['image']);
            }
            $subData = SubCategory::where('cat_id', '=', $id)->get();
            if(isset($subData) && !empty($subData)){
                foreach ($subData as $item){
                    if (file_exists(env('CONTENT') . $item['image'])) {
                        unlink(env('CONTENT') . $item['image']);
                    }
                    SubCategory::where('id', '=', $item['id'])->delete();
                }
            }
            $data->delete();
            return $this->index();
        } else {
            return view('errors.404');
        }
    }

    function mobView(){
        $data = Category::all();
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
