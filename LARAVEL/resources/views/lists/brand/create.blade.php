@extends('layouts.app')

@section('content')

    <div class="card-header">Brands</div>

    <div class="card-body">
        <form method="post"
              action="{{url('brand-store')}}"
              class="needs-validation" novalidate enctype="multipart/form-data" id="form" name="form">
            <div class="row">
                <div class="col-12">
                    <label for="validationCustom01"><b>Country</b></label>
                    <input type="text" name="country" class="form-control" id="country"
                           placeholder="Country"
                           value=""
                           required>
                </div>
            </div>
            <div class="clear"></div>
            <div class="row">
                <div class="col-12">
                    <label for="validationCustom01"><b>Brand</b></label>
                    <input type="text" name="brand" class="form-control" id="brand"
                           placeholder="Brand"
                           value=""
                           required>
                </div>
            </div>
            <div class="clear"></div>
            <div class="row">
                <div class="col-12">
                    <label for="validationCustom01"><b>Model</b></label>
                    <input type="text" name="model" class="form-control" id="model"
                           placeholder="Model"
                           value=""
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
