@extends('layouts.app')

@section('content')

    <div class="card-header">User Management system</div>

    <div class="card-body">
        <form method="post"
              action="{{isset($data->id) && !empty($data->id)?url('cat-save/'.$data->id):url('cat-save')}}"
              class="needs-validation" novalidate enctype="multipart/form-data" id="form" name="form">
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
