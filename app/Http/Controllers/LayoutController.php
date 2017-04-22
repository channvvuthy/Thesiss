<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use App\Models\Layout;
use Illuminate\Support\Facades\Response;

class LayoutController extends Controller
{
    public function getLayout(){
        $layouts=Layout::paginate(10);
        return view('leader.layout')->withLayouts($layouts);

    }

    public function postLayout(Request $request){
        $layoutName=$request->layoutName;
        $layoutName=rtrim($layoutName,",");
        $layoutDescription=$request->layoutDescription;

        $arrayLayoutName=explode(",",$layoutName);
        foreach ($arrayLayoutName as $name){
            $layout=new Layout();
            $layout->name=$name;
            $layout->description=$layoutDescription;
            $layout->save();
        }

        return redirect()->route('createLayout')->withInput()->withErrors(['notice'=>'layout has been created']);
    }
    public function getActiveLayout($id){
        $layout=Layout::find($id);
        if($layout->status=="1"){
            $layout->status="0";
        }else if($layout->status=="0"){
            $layout->status="1";
        }
        $layout->save();
        return redirect()->route('createLayout')->withInput()->withErrors(['notice'=>'layout has been updated']);
    }
    public function getDeleteLayout($id){
        $layout=Layout::find($id);
        $layout->delete();
        return redirect()->route('createLayout')->withInput()->withErrors(['notice'=>'layout has been deleted']);
    }
    public function getEditLayout($id){
        $layout=Layout::find($id);
        return view('leader.editLayout')->withLayout($layout);
    }
    public function postUpdateLayout(Request $request){
        $id=$request->id;
        $name=$request->layoutName;
        $description=$request->layoutDescription;
        $layout=Layout::find($id);
        $layout->name=$name;
        $layout->description=$description;
        $layout->save();
        return redirect()->route('createLayout')->withInput()->withErrors(['notice'=>'layout has been updated']);
    }
    public function getUploadLayout(){
        $folders=$this->listFolderFiles('layout');
        return view('leader.uploadLayout')->withFolders($folders);
    }
    public function postUploadLayout(Request $request){
        $this->validate($request,[
           'layoutName'=>'required'
        ]);
        $file=$request->file('layoutName');
        $fileName=$file->getClientOriginalName();
        $fileName=time().$fileName;
        $ex=explode('.',$fileName);
        $ex=end($ex);
        if($ex!="pdf"){
            return redirect()->back()->withInput()->withErrors(['layoutName'=>'Please upload only pdf file']);
        }
        $file->move('layout',$fileName);

        return redirect()->back()->withInput()->withErrors(['notice'=>'layout has been upload']);
    }
    public function listFolderFiles($dir)
    {
        $ffs = scandir($dir);
        $folders="";
        foreach ($ffs as $ff) {
            if ($ff != '.' && $ff != '..') {
                if (is_dir($dir . '/' . $ff)) {
                    listFolderFiles($dir . '/' . $ff);

                }else{
                    $folders[]=$ff;
                }
            }
        }
        return $folders;
    }

    public function getPreview($name,$type){
        $filename = $name;
        $path = public_path("layout/".$filename);
        header('Content-Type', 'application/pdf');
        return response()->file($path);
    }
}
