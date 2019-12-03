@extends('layouts.app')

@section('content')

    <div class="card-header">User Management system</div>

    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <a href="{{url('user-form')}}">
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
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Type</th>
                        <th scope="col" colspan="3">Action</th>
                    </tr>
                    </thead>
                    @if(isset($data) && !empty($data))
                        @foreach($data as $item)
                            <tr>
                                <th scope="row">{{$item->id}}</th>
                                <td>{{$item->name}}</td>
                                <td>{{$item->email}}</td>
                                <td>
                                    @if($item->type=='admin')
                                        <i class="fas fa-user-cog" data-toggle="tooltip" data-placement="top"
                                           title="Admin"></i>
                                    @elseif($item->type=='workshop')
                                        <i class="fas fa-car-alt" data-toggle="tooltip" data-placement="top"
                                           title="Workshop"></i>
                                    @else
                                        <i class="fas fa-user" data-toggle="tooltip" data-placement="top"
                                           title="Customer"></i>
                                    @endif
                                </td>
                                <td>
                                    @if($item->active==1)
                                        <a href="{{url('user-suspend/'.$item->id)}}" data-toggle="tooltip"
                                           data-placement="top" title="Suspend user">
                                            <i class="fas fa-lock-open danger"></i>
                                        </a>
                                    @else
                                        <a href="{{url('user-unsuspend/'.$item->id)}}" data-toggle="tooltip"
                                           data-placement="top" title="Unsuspend user">
                                            <i class="fas fa-lock waring"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{url('user-edit/'.$item->id)}}" data-toggle="tooltip" data-placement="top"
                                       title="Edit user">
                                        <i class="fas fa-edit info"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{url('user-reset/'.$item->id)}}" data-toggle="tooltip"
                                       data-placement="top" title="Reset user password">
                                        <i class="fas fa-fingerprint info"></i>
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
