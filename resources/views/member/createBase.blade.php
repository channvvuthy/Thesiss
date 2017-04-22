@extends('layout.member.master')
@section('title')
    Member
@stop
@section('content')
    @include('layout.member.widget.header')

    @include('layout.member.widget.navbar')
    <div class="col-md-10">
        <div class="pangasu float">
            <ul class="list-unstyled">
                <li><a href="/administrator/index"><img src="{{asset('icon/1489862497_house.png')}}" alt=""></a></li>
                <li><a href="{{route('createUser')}}">Create Base</a></li>
            </ul>
        </div>
        <div class="clearfix clear-top-normal" style="margin-top:15px;"></div>

        <form action="{{route('saveFile')}}" class="SystemForm" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{Session::token()}}">
            @if($errors->first('notice'))
                <div class="alert alert-success">{{$errors->first('notice')}}</div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Create Base</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-9">
                        @if(!empty($newFileName))
                            @if(strpos($newFileName,"."))
                                @php
                                    $fileNames=$newPaths.'/'.$newFileName;
                                    $read=fopen($fileNames,"r");
                                    $data=fread($read,filesize($fileNames));
                                    fclose($read);
                                @endphp
                                <input type="hidden" name="fileName" value="{{$fileNames}}">

                                <textarea name="editor" id="" cols="30" rows="10">{{$data}}</textarea>
                                <div id="editor" class="editor">
                                </div>
                                <div class="clearfix"></div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            @endif

                        @endif
                    </div>
                    <div class="col-md-3" style="padding-right: 0px;">
                        <form action="">
                            <div class="form-group">
                                <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="glyphicon glyphicon-home"></i></div>
                                    <input type="text" class="form-control folderList" id="exampleInputAmount"
                                           value="C:\xampp\htdocs\MyThesis\base_pattern\Apri 2017">

                                </div>
                            </div>

                        </form>
                        <div id="contextMenu" oncontextmenu="return customRightClick(event);">
                            <p><i class="glyphicon glyphicon-folder-open"></i> &nbsp;Base Management</p>
                            <ul class="list-unstyled" id="subContextMenu">
                                <li data="create_file" data-tile="Create New File"><i class="glyphicon glyphicon-file"></i>&nbsp;&nbsp;Create New
                                    File
                                </li>
                                <li data="create_folder" data-tile="Create New Folder"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;Create
                                    New Folder
                                </li>
                                <li data="delete_file" data-tile="Delete File"><i class="glyphicon glyphicon-file"></i>&nbsp;&nbsp;Delete File
                                </li>
                                <li data="delete_folder" data-tile="Delete Folder"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;Delete
                                    Folder
                                </li>
                                <li data="refresh_page" data-tile=""><i class="glyphicon glyphicon-refresh"></i>&nbsp;&nbsp;Refresh
                                    Page
                                </li>
                                <li data="exit"><i class="glyphicon glyphicon-home"></i>&nbsp;&nbsp;Exit</li>

                            </ul>
                            @foreach($fs as $f)
                                <div class="main">
                                    @if(!empty($fileName))
                                        @if($f==$fileName)
                                            @foreach($ls as $l)
                                                <div>
                                                    @if(strpos($l,"."))
                                                        <a href="{{route('editFile',['oldPath'=>$path,'path'=>$path.'/'.$f,'oldFileName'=>$f,'fileName'=>$l])}}"><i
                                                                    class="glyphicon glyphicon-file"></i>&nbsp;&nbsp;{{$l}}
                                                        </a>
                                                    @else
                                                        <a href="{{route('subDirectory',['fullPath'=>$newPaths."/".$l])}}"><i
                                                                    class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;{{$l}}
                                                        </a>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @endif
                                    @else
                                        <p><a href="{{route('readFile',['path'=>$path,'fileName'=>$f])}}"><i
                                                        class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;{{$f}}
                                            </a>
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="list" style="height: 200px;overflow-x: auto;"></div>
                    </div>
                </div>
                <div class="panel-footer"><h1></h1></div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var f = $(".folderList").val();
            if (f == "") {
                f = "C:\Users";
            }
            var list = "";
            jQuery.ajax({
                url: "{{route('listFolder')}}",
                type: "GET",
                dataType: "json",
                data: {f: f},
                success: function (data) {
                    for (var i = 0; i < data.length; i++) {
                        list += '<a href=""><p id="folderList" style="padding-left:3px;">' + data[i] + '</p></a>';
                    }
                    //$(".list").html(list);
                },
                error: function () {
                    alert("can not load folder");
                }
            });
        });
    </script>
    <style>
        #editor {
            height: 600px;
            width: 100%;
        }
    </style>
    <script type="text/javascript" src="{{asset('js/ace/ace.js')}}"></script>
    <script type="text/javascript">
        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/monokai");
        editor.getSession().setMode("ace/mode/php");
        editor.getSession().setTabSize(4);
        editor.getSession().setUseSoftTabs(true);
        editor.getSession().setUseWrapMode(true);
        var textarea = $('textarea[name="editor"]').hide();
        editor.getSession().setValue(textarea.val());
        editor.getSession().on('change', function () {
            textarea.val(editor.getSession().getValue());

        });

        function customRightClick(event) {
            event.preventDefault();
            $("#subContextMenu").css({"display": "block"});
            $("#subContextMenu").css({"margin-to": event.clientY + 'px'});
        }
    </script>
    <div class="modal fade" id="modal-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Path Name</label>
                        <input type="text" name="path" id="path" class="form-control">
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <label for="">Item Name</label>
                        <input type="text" name="" id="fileName" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveItem">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script type="text/javascript">
        $("#saveItem").click(function () {
            alert(1)
        });
    </script>
@stop
