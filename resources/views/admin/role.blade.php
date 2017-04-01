@extends('layout.admin.master')
@section('content')
    @include('layout.admin.widget.header')
    @include('layout.admin.widget.navbar')
    <div class="col-md-9">
        <div class="pangasu float">
            <ul class="list-unstyled">
                <li><a href="/administrator/index"><img src="{{asset('icon/1489862497_house.png')}}" alt=""></a></li>
                <li><a href="">Role</a></li>
            </ul>
        </div>
        <div class="clearfix clear-top-normal" style="margin-top:15px;"></div>
        @if($errors->first('notice'))
            <div class="alert alert-success">
                {{$errors->first('notice')}}
            </div>


        @endif
        <form action="{{route('createRole')}}" class="SystemForm" method="post">
            <input type="hidden" name="_token" value="{{Session::token()}}">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Role</h4>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-2" style="padding-left: 0px;">
                            <label for="">Role Name</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="roleName" id="" class="form-control">
                        </div>
                    </div>
                    <div class="clearfix clear-top-simple"></div>
                    <div class="form-group">
                        <div class="col-md-2" style="padding-left: 0px;">
                            <label for="">Description</label>
                        </div>
                        <div class="col-md-8">
                            <textarea name="roleDescription" id="" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                    </div>


                    <div class="clearfix clear-top-simple"></div>
                    <div class="form-group">
                        <div class="col-md-2" style="padding-left: 0px;">
                            <label for="">Permission</label>
                        </div>
                        <div class="col-md-8">
                            <p><input type="radio" name="rolePermission" value="admin" checked><b>Administrator</b></p>
                            <p><input type="radio" name="rolePermission" value="manager"><b> Manager</b></p>
                            <p><input type="radio" name="rolePermission" value="leader"><b>Leader </b></p>
                            <p><input type="radio" name="rolePermission" value="member"><b>Member </b></p>
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
        <div class="panel panel-default SystemForm">
            <div class="panel-heading">
                <img src="{{asset('icon/1489866801_icon-111-search.png')}}" alt="" id="isearch">
                <input type="text" name="" id="search" placeholder="search..,">
            </div>
            <div class="panel-body">
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Permission</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td><a href="{{route('editRole',['id'=>$role->id])}}"><img src="{{asset('icon/1489864471_Edit-01.png')}}" alt=""></a><a href="{{route('deleteRole',['id'=>$role->id])}}"><img src="{{asset('icon/1489864883_Streamline-70.png')}}" alt=""></a></td>
                            <td>{{$role->id}}</td>
                            <td>{{$role->name}}</td>
                            <td>{{$role->permission}}</td>
                            <td>{{$role->description}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{$roles->render()}}

    </div>
@stop