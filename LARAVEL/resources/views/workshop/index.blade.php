@extends('layouts.app')

@section('content')

    <div class="card-header">Workshop Management system</div>

    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <a href="{{url('workshop-form')}}">
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
                        <th scope="col">Arabic Name</th>
                        <th scope="col">English Name</th>
                        <th scope="col" colspan="5">Action</th>
                    </tr>
                    </thead>
                    @if(isset($data) && !empty($data))
                        @foreach($data as $item)
                            <tr>
                                <th scope="row">{{$item->id}}</th>
                                <td>{{$item->ar_name}}</td>
                                <td>{{$item->en_name}}</td>
                                <td>
                                    <a href="{{url('workshop-view/'.$item->id)}}" data-toggle="tooltip"
                                       data-placement="top" title="View details">
                                        <i class="fas fa-binoculars waring"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{url('workshop-view/'.$item->id)}}" data-toggle="tooltip"
                                       data-placement="top" title="View comments">
                                        <i class="fas fa-comments waring"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{url('workshop-view/'.$item->id)}}" data-toggle="tooltip"
                                       data-placement="top" title="View workshop calendar">
                                        <i class="fas fa-calendar-week info"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{url('workshop-edit/'.$item->id)}}" data-toggle="tooltip" data-placement="top"
                                       title="Edit workshop">
                                        <i class="fas fa-edit info"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{url('workshop-delete/'.$item->id)}}" data-toggle="tooltip"
                                       data-placement="top" title="Delete workshop">
                                        <i class="fas fa-trash-alt danger"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                {{!! $data->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')}}
            </div>
        </div>
    </div>

@endsection



<script>

</script>
