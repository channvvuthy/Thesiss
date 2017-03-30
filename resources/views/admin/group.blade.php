@extends('layout.admin.master')
@section('content')
    @include('layout.admin.widget.header')
    @include('layout.admin.widget.navbar')
    <div class="col-md-9">
        <div class="pangasu float">
            <ul class="list-unstyled">
                <li><a href="/administrator/index"><img src="{{asset('icon/1489862497_house.png')}}" alt=""></a></li>
                <li><a href="">Group</a></li>
            </ul>
        </div>
        <div class="clearfix clear-top-simple"></div>
        <form action="" class="SystemForm">
            <input type="hidden" name="_token" value="{{Session::token()}}">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4> Group</h4>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-2">
                            <label for="">Group Name</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="" id="" class="form-control">
                        </div>
                    </div>
                    <div class="clearfix clear-top-simple"></div>
                    <div class="form-group">
                        <div class="col-md-2">
                            <label for="">Group Type</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="" id="" class="form-control">
                        </div>
                    </div>
                    <div class="clearfix clear-top-simple"></div>
                    <div class="form-group">
                        <div class="col-md-2">
                            <label for="">Description</label>
                        </div>
                        <div class="col-md-10">
                            <textarea name="" id="" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop