@extends('admin.layout.master')
@section('page_title','Dashboard')
@section('container')

<div class="">
    <div class="row mt-3">
        <div class="col-md-3">
            <a href="{{route('user.index')}}">
            <div class="card no-margin text-white bg-primary">
                <div class="card-header ">
                    <div class="card-title">
                        <span class="font-montserrat fs-11 all-caps">Total Users</span>
                    </div>
                </div>
                <div class="p-l-20 pb-2">
                    <h3 class="no-margin p-b-5">{{$user_count}}</h3>
                </div>
            </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{route('role.index')}}">
            <div class="card no-margin text-white bg-success">
                <div class="card-header ">
                    <div class="card-title">
                        <span class="font-montserrat fs-11 all-caps">Total Roles</span>
                    </div>
                </div>
                <div class="p-l-20 pb-2">
                    <h3 class="no-margin p-b-5">{{$feature_count}}</h3>
                </div>
            </div>
            </a>
        </div>

    </div>
</div>



@endsection