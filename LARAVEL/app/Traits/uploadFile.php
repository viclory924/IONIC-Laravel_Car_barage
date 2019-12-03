<?php


namespace App\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

trait uploadFile
{
    function checkFileType(Request $request, $input)
    {
        if (Input::hasFile($input)) {
            $validator = Validator::make($request->all(), [
                $input => 'mimetypes:image/jpeg,image/png,image/jpg|max:2000|dimensions:max_width=650,max_height=420'
            ]);
            if ($validator->passes()) {
                return true;
            } else {
                return false;
            }
        }
    }
}
