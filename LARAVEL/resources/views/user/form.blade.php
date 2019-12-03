@extends('layouts.app')

@section('content')

    <div class="card-header">User Management system</div>

    <div class="card-body">
        <form method="post" action="{{isset($data->id) && !empty($data->id)?url('user-save/'.$data->id):url('user-save')}}" class="needs-validation" novalidate>
            <div class="row">
                <div class="col-12">
                    <label for="validationCustom01"><b>Name</b></label>
                    <input type="text" name="name" class="form-control" id="name"
                           placeholder="Name" value="{{isset($data->name) && !empty($data->name)? $data->name:''}}"
                           required>
                </div>
            </div>
            <div class="clear"></div>
            <div class="row">
                <div class="col-12">
                    <label for="validationCustom01"><b>Email</b></label>
                    <input type="email" name="email" class="form-control" id="email"
                           placeholder="Email" value="{{isset($data->email) && !empty($data->email)? $data->email:''}}"
                           required>
                </div>
            </div>
            <div class="clear"></div>
            @if($data==null)
                <div class="row">
                    <div class="col-12">
                        <label for="validationCustom01"><b>Password</b></label>
                        <input type="password" name="password" class="form-control" id="password"
                               placeholder="Password" value=""
                               required>
                    </div>
                </div>
                <div class="clear"></div>
            @endif
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
