<?php

namespace App\Http\Controllers\Lists;

use App\Models\Lists\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    public function index()
    {
        $data=Brand::all();
        return view('lists.brand.index', ['data'=>$data]);
    }

    public function create()
    {
        return view('lists.brand.create');
    }

    public function store(Request $request)
    {
        if(isset($request->country) && !empty($request->country)
        && isset($request->brand) && !empty($request->brand)){
            $row = new Brand();
            $row['country']=$request->country;
            $row['brand']=$request->brand;
            $row['model']=$request->model;
            $row->save();
            return $this->index();
        }else{
            return view('errors.404');
        }
    }

    public function update($id)
    {
        $data=Brand::where('id', '=', $id)->first();
        return view('lists.brand.update', ['data'=>$data]);
    }

    public function edit(Request $request, $id)
    {
        if(isset($id) && !empty($id)
            && isset($request->country) && !empty($request->country)
            && isset($request->brand) && !empty($request->brand)){
            $row = Brand::where('id', '=', $id)->first();
            $row['country']=$request->country;
            $row['brand']=$request->brand;
            $row['model']=$request->model;
            $row->save();
            return $this->index();
        }else{
            return view('errors.404');
        }
    }

    public function destroy($id)
    {
        if(isset($id) && !empty($id)){
            $row = Brand::where('id', '=', $id)->first();
            if(isset($row) && !empty($row)){
                $row->delete();
            }
            return $this->index();
        }else{
            return view('errors.404');
        }
    }
}
