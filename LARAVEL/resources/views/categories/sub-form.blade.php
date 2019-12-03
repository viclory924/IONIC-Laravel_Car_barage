@extends('layouts.app')

@section('content')

    <div class="card-header">User Management system</div>

    <div class="card-body">
        <form method="post"
              action="{{isset($data->id) && !empty($data->id)?url('sub-save/'.$data->id):url('sub-save')}}"
              class="needs-validation" novalidate enctype="multipart/form-data" id="form" name="form">
            <div class="row">
                <div class="col-12">
                    <label for="validationCustom01"><b>Category</b></label>
                    <select name="cat_id" id="cat_id" class="form-control" required>
                        <option value="">---SELECT Category---</option>
                        @if(isset($catList) && !empty($catList))
                            @foreach($catList as $item)
                                <option value="{{$item->id}}" {{isset($data) && !empty($data) && $data->cat_id==$item->id?'selected': ''}}>{{$item->en_name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="clear"></div>
            <div class="row">
                <div class="col-12">
                    <label for="validationCustom01"><b>Arabic Name</b></label>
                    <input type="text" name="ar_name" class="form-control" id="ar_name"
                           placeholder="Arabic Name"
                           value="{{isset($data->ar_name) && !empty($data->ar_name)? $data->ar_name:''}}"
                           required>
                </div>
            </div>
            <div class="clear"></div>
            <div class="row">
                <div class="col-12">
                    <label for="validationCustom01"><b>English Name</b></label>
                    <input type="text" name="en_name" class="form-control" id="en_name"
                           placeholder="English Name"
                           value="{{isset($data->en_name) && !empty($data->en_name)? $data->en_name:''}}"
                           required>
                </div>
            </div>
            <div class="clear"></div>
            <div class="row">
                @if(isset($data->image) && !empty($data->image))
                    <div class="col-12 text-center">
                        <img class="small-img" src="{{url('content/'.$data->image)}}"/>
                    </div>
                @endif
                <div class="col-12">
                    <label for="validationCustom01"><b>Icon</b></label>
                    <input type="file" name="image" class="form-control" id="image"
                           value=""
                        {{isset($data->image) && !empty($data->image)? '':'required'}}>
                </div>
            </div>
            <div class="clear"></div>


            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="col-12 text-center">
                    <button class="btn btn-primary btn-sm" type="submit">Save</button>
                </div>
            </div>
        </form>
    </div>

@endsection



<script>

</script>
