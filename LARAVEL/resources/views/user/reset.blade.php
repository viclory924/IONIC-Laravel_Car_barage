@extends('layouts.app')

@section('content')

    <div class="card-header">User Management system</div>

    <div class="card-body">
        <form method="post"
              action="{{url('user-reset/'.$data->id)}}"
              class="needs-validation" novalidate>

            <div class="row">
                <div class="col-12">
                    <label for="validationCustom01"><b>Password</b></label>
                    <input type="password" name="password" class="form-control" id="password"
                           placeholder="Password" value=""
                           required>
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
