@extends('layout.leaders.master')
@section('title')
    Leader
@stop
@section('content')
    @include('layout.leaders.widget.header')
    @include('layout.leaders.widget.navbar')
    <div class="col-md-10">
        <div class="pangasu float">
            <ul class="list-unstyled">
                <li><a href="/administrator/index"><img src="{{asset('icon/1489862497_house.png')}}" alt=""></a></li>
                <li><a href="{{route('createUser')}}" style="width:150px;">Type</a></li>
            </ul>
        </div>
        <div class="clearfix clear-top-normal" style="margin-top:15px;"></div>

        <form action="{{route('uploadVersion')}}" class="SystemForm" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{Session::token()}}">
            @if($errors->first('notice'))
                <div class="alert alert-success">{{$errors->first('notice')}}</div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Type</h4>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-2" style="padding-left: 0px;">
                            <label for="">Version</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="version" id="" class="form-control">
                            <span class="text-danger">{{$errors->first('version')}}</span>
                        </div>
                    </div>
                    <div class="clearfix clear-top-simple"></div>
                    <div class="form-group">
                        <div class="col-md-2" style="padding-left: 0px;">
                            <label for="">Description</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="description" id="" class="form-control">
                            <span class="text-danger">{{$errors->first('description')}}</span>
                        </div>
                    </div>
                    <div class="clearfix clear-top-simple"></div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-2">
                            <button type="submit" class="btn btn-success addPadding">Save</button>
                        </div>
                    </div>
                    <div class="clearfix clear-top-simple"></div>
                </div>
                <div class="panel-footer"><h1></h1></div>
            </div>
        </form>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Version</h4>
            </div>
            <div class="panel-body">
                @if(!empty($versions))
                    <table class="table table-responsive">
                        <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Variation</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($versions as $version)
                            <tr>
                                <td>
                                    <a href="{{route('editVersion',['id'=>$version->id])}}"><img src="{{asset('icon/1489864471_Edit-01.png')}}" alt=""></a>
                                    <a href="{{route('deleteVersion',['id'=>$version->id])}}" onclick="return confirm('Are want to delete?')"><img src="{{asset('icon/1489864883_Streamline-70.png')}}" alt=""></a>
                                </td>
                                <td>{{$version->id}}</td>
                                <td>{{$version->name}}</td>
                                <td>{{$version->description}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@stop