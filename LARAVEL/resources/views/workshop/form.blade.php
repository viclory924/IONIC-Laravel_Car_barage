@extends('layouts.app') @section('content')

    <div class="card-header">Workshop Management system</div>

    <div class="card-body">
        <form method="post"
              action="{{isset($data->id) && !empty($data->id)?url('workshop-save/'.$data->id):url('workshop-save')}}"
              class="needs-validation" novalidate enctype="multipart/form-data"
              id="form" name="form">
            <div class="row">
                <div class="col-6">
                    <label for="validationCustom01"><b>Arabic Name</b></label> <input
                        type="text" name="ar_name" class="form-control" id="ar_name"
                        placeholder="Arabic Name"
                        value="{{isset($data->ar_name) && !empty($data->ar_name)? $data->ar_name:''}}"
                        required>
                </div>

                <div class="col-6">
                    <label for="validationCustom01"><b>English Name</b></label> <input
                        type="text" name="en_name" class="form-control" id="en_name"
                        placeholder="English Name"
                        value="{{isset($data->en_name) && !empty($data->en_name)? $data->en_name:''}}"
                        required>
                </div>
            </div>
            <div class="clear"></div>
            <div class="row">
                @if(isset($data->logo) && !empty($data->logo))
                    <div class="col-12 text-center">
                        <img class="small-img" src="{{url('content/'.$data->logo)}}"/>
                    </div>
                @endif
                <div class="col-12">
                    <label for="validationCustom01"><b>Logo</b></label> <input
                        type="file" name="image" class="form-control" id="image" value=""
                        {{isset($data->logo) && !empty($data->logo)? '':'required'}}>
                </div>
            </div>
            <div class="clear"></div>
            <div class="row">
                <div class="col-6">
                    <label for="validationCustom01"><b>Country</b></label> <select
                        name="country_id" id="country_id" class="form-control" required>
                        <option value="">---SELECT ONE---</option> @if(isset($countyList)
					&& !empty($countyList)) @foreach($countyList as $item)
                            <option value="{{$item->id}}"
                                {{isset($data) && !empty($data) && $data->country_id==$item->id?'selected':
                                ''}}>{{$item->en_name}}</option> @endforeach @endif
                    </select>
                </div>
                <div class="col-6">
                    <label for="validationCustom01"><b>City</b></label> <select
                        name="city_id" id="city_id" class="form-control" required>
                        <option value="">---SELECT ONE---</option> @if(isset($cityList) &&
					!empty($cityList)) @foreach($cityList as $item)
                            <option value="{{$item->id}}"
                                {{isset($data) && !empty($data) && $data->city_id==$item->id?'selected':
                                ''}}>{{$item->en_name}}</option> @endforeach @endif
                    </select>
                </div>
            </div>
            <div class="clear"></div>
            <div class="row">
                <div class="col-6">
                    <label for="validationCustom01"><b>Arabic Address</b></label> <input
                        type="text" name="ar_address" class="form-control" id="ar_address"
                        placeholder="English Address"
                        value="{{isset($data->ar_address) && !empty($data->ar_address)? $data->ar_address:''}}"
                        required>
                </div>
                <div class="col-6">
                    <label for="validationCustom01"><b>English Address</b></label> <input
                        type="text" name="en_address" class="form-control" id="en_address"
                        placeholder="English Address"
                        value="{{isset($data->en_address) && !empty($data->en_address)? $data->en_address:''}}"
                        required>
                </div>
            </div>
            <div class="clear"></div>
            <div class="row">
                <div class="col-6">
                    <label for="validationCustom01"><b>Mobil</b></label> <input
                        type="number" name="mobile" class="form-control" id="mobile"
                        placeholder="Mobil"
                        value="{{isset($data->mobile) && !empty($data->mobile)? $data->mobile:''}}"
                        required>
                </div>
                <div class="col-6">
                    <label for="validationCustom01"><b>Telephone</b></label> <input
                        type="number" name="telephone" class="form-control" id="telephone"
                        placeholder="Telephone"
                        value="{{isset($data->telephone) && !empty($data->telephone)? $data->telephone:''}}">
                </div>
            </div>
            <div class="clear"></div>
            <div class="row">
                <div class="col-6">
                    <label for="validationCustom01"><b>Email</b></label> <input
                        type="email" name="email" class="form-control" id="email"
                        placeholder="Email"
                        value="{{isset($data->email) && !empty($data->email)? $data->email:''}}" required>
                </div>
                <div class="col-6">
                    <label for="validationCustom01"><b>Website</b></label> <input
                        type="text" name="website" class="form-control" id="website"
                        placeholder="Website"
                        value="{{isset($data->website) && !empty($data->website)? $data->website:''}}">
                </div>
            </div>
            <div class="clear"></div>
            <div class="row">
                <div class="col-12">

                    <div id="map"></div>

                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <label for="validationCustom01"><b>Google latitude</b></label> <input
                        type="text" name="google_lat" class="form-control" id="google_lat"
                        placeholder="Google latitude"
                        value="{{isset($data->google_lat) && !empty($data->google_lat)? $data->google_lat:''}}">
                </div>
                <div class="col-6">
                    <label for="validationCustom01"><b>Google longitude</b></label> <input
                        type="text" name="google_lng" class="form-control" id="google_lng"
                        placeholder="Google longitude"
                        value="{{isset($data->google_lng) && !empty($data->google_lng)? $data->google_lng:''}}">
                </div>
            </div>
            <div class="clear"></div>
            <div class="row">
                <div class="col-md-6">
                    <label for="cat_id"><b>Category</b></label> <select name="cat_id"
                                                                        id="cat_id"
                                                                        class="form-control mdb-select colorful-select dropdown-primary md-form"
                                                                        multiple searchable="Search here..">
                        <option value="" disabled>---Choose Which Categories---</option>
                        @if(isset($categoryList) && !empty($categoryList))
                            @foreach($categoryList as $item)
                                <option value="{{$item->id}}">{{$item->en_name}}</option>
                            @endforeach @endif
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="sub_cat_id"><b>Sub Category</b></label> <select
                        name="sub_cat_id[]" id="sub_cat_id[]"
                        class="form-control mdb-select colorful-select dropdown-primary md-form"
                        multiple searchable="Search here.." required>
                        <option value="" disabled>Choose Which SubCategories</option>
                        @if(isset($subCategoryList) && !empty($subCategoryList))
                            @foreach($subCategoryList as $item)
                                <option value="{{$item->id}}"
                                        @if(isset($workshopCat) && !empty($workshopCat))
                                        @if(in_array($item->id,
                            $workshopCat)) selected @endif @endif >{{$item->en_name}}</option>
                            @endforeach @endif
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="validationCustom01"><b>Start At</b></label> <input
                        type="time" name="start_from" class="form-control" id="start_from"
                        placeholder="Start At"
                        value="{{isset($data->start_from) && !empty($data->start_from)? $data->start_from:''}}"
                        required>
                </div>
                <div class="col-6">
                    <label for="validationCustom01"><b>End At</b></label> <input
                        type="time" name="end_at" class="form-control" id="end_at"
                        placeholder="End At"
                        value="{{isset($data->end_at) && !empty($data->google_lng)? $data->end_at:''}}" required>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="validationCustom01"><b>Brand</b></label> <select
                        name="brand_id" id="brand_id" class="form-control mdb-select colorful-select dropdown-primary md-form" required multiple>
                        <option value="">---SELECT ONE---</option> @if(isset($brandList)
					&& !empty($brandList)) @foreach($brandList as $item)
                            <option value="{{$item->id}}"
                                {{isset($data) && !empty($data) && $data->brand_id==$item->id?'selected':
                                ''}}>{{$item->country}} - {{$item->brand}}
                                - {{$item->model}}</option> @endforeach @endif
                    </select>
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
    // Note: This example requires that you consent to location sharing when
    // prompted by your browser. If you see the error "The Geolocation service
    // failed.", it means you probably did not give permission for the browser to
    // locate you.
    var map, infoWindow;


    function initMap() {

        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -34.397, lng: 150.644},
            zoom: 15
        });
        infoWindow = new google.maps.InfoWindow;
        // Try HTML5 geolocation.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                    @if(isset($data->google_lat) && !empty($data->google_lat) &&
                            isset($data->google_lng) && !empty($data->google_lng) )
                var pos = {
                        lat: {{$data->google_lat}},
                        lng: {{$data->google_lng}}
                    };
                    @else
                var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                @endif

                $("#google_lat").val(pos.lat);
                $("#google_lng").val(pos.lng);

                infoWindow.setPosition(pos);
                infoWindow.setContent('Your location here.');
                infoWindow.open(map);
                map.setCenter(pos);
            }, function () {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        }


        google.maps.event.addListener(map, 'click', function (event) {

            marker = new google.maps.Marker({position: event.latLng, map: map});

            $("#google_lat").val(event.latLng.lat());
            $("#google_lng").val(event.latLng.lng())
        });
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }

</script>
