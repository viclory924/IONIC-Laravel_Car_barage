@extends('layouts.app')

@section('content')

    <div class="card-header">Brands</div>

    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <a href="{{url('brand-create')}}">
                    <button class="btn btn-success btn-sm" type="button">
                        <i class="fas fa-plus"></i> Add new
                    </button>
                </a>
            </div>
        </div>
        <div class="clear"></div>
        <div class="clear"></div>
        <div class="row">
            <div class="col-12">
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Country</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Model</th>
                        <th scope="col" colspan="2">Action</th>
                    </tr>
                    </thead>
                    @if(isset($data) && !empty($data))
                        @foreach($data as $item)
                            <tr class="cat-row">
                                <th scope="row">{{$item->id}}</th>
                                <td>{{$item->country}}</td>
                                <td>{{$item->brand}}</td>
                                <td>{{$item->model}}</td>
                                <td style="padding-top: 20px;">
                                    <a href="{{url('brand-update/'.$item->id)}}" data-toggle="tooltip" data-placement="top" title="Edit category">
                                        <i class="fas fa-edit info"></i>
                                    </a>
                                </td>
                                <td style="padding-top: 20px;">
                                    <a href="{{url('brand-destroy/'.$item->id)}}" data-toggle="tooltip" data-placement="top" title="Delete category">
                                        <i class="fas fa-trash-alt danger"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
    </div>

@endsection



<script>

</script>
