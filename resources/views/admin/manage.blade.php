@extends('layout.admin.master')
@section('content')
    @include('layout.admin.widget.header')
    @include('layout.admin.widget.navbar')
    <div class="col-md-10">
        <div class="pangasu float">
            <ul class="list-unstyled">
                <li><a href="/administrator/index"><img src="{{asset('icon/1489862497_house.png')}}" alt=""></a></li>
                <li><a href="{{route('createGroup')}}">Dashboard</a></li>
            </ul>
        </div>
        <div class="clearfix clear-top-normal" style="margin-top:15px;"></div>
        @if($errors->first('notice'))
            <div class="alert alert-success">
                {{$errors->first('notice')}}
            </div>
        @endif
        <br>
        <div class="col-md-3 blockManage" style="border-left:0px;">
            <a href="{{route('createUser')}}"><sub><i class="glyphicon glyphicon-user"></i> User</sub><sup>{{$user}}</sup></a>
        </div>
        <div class="col-md-3 blockManage">
            <a href="{{route('createGroup')}}"><sub><i class="glyphicon glyphicon-user"></i> Group</sub> <sup>{{$group}}</sup></a>
        </div>
        <div class="col-md-3 blockManage">
            <a href="{{route('createRole')}}"><sub><i class="glyphicon glyphicon-lock"></i>Role</sub> <sup>{{$role}}</sup> </a>
        </div>
        <div class="col-md-3 blockManage" style="border-right:0px;">
            <a href="{{route('AccountAdmin')}}"><sub><i class="glyphicon glyphicon-lock"></i>Account</sub> </a>
        </div>

    </div>
@stop