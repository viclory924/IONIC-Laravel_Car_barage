@extends('layouts.app')

@section('content')

    <div class="card-header">Setting</div>

    <div class="card-body">
        @if(isset($data) && !empty($data))
            <form method="post" action="{{url('setting')}}" class="needs-validation" novalidate>
                @foreach($data as $item)
                    <div class="row">
                        <div class="col-12">
                            <label for="validationCustom01"><b>{{$item->field}}</b></label>
                            <input type="text" name="setting[{{$item->id}}]" class="form-control" id="validationCustom01"
                                   placeholder="{{$item->field}}" value="{{$item->value}}"
                                   required>

                        </div>
                    </div>
                    <div class="clear"></div>
                @endforeach
                <div class="row">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="col-12 text-center">
                        <button class="btn btn-primary btn-sm" type="submit">Save</button>
                    </div>
                </div>
            </form>
        @endif
    </div>

@endsection



<script>
    (function () {
        'use strict';
        window.addEventListener('load', function () {
// Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
// Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
