<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Variation;
use App\Models\Pattern;
use DB;
use App\Models\UserPattern;

class MemberController extends Controller
{
    public function getBaseMember()
    {
        $variations = Variation::where('status', '1')->get();
        return view('leader.baseMember')->withVariations($variations);
    }

    public function getVariationDefault(Request $request)
    {
        if ($request->ajax()) {
            $variationDefault = $request->variationDefault;
            $pattern = Pattern::where('variation_id', $variationDefault)->get();
            return $pattern;
        }
    }

    public function getAssignMember(Request $request)
    {
        $this->validate($request, [
            'variationDefault' => 'required',
            'variationGet' => 'required',
            'member' => 'required'
        ]);
        $members=$request->member;
        $variation=$request->variationDefault;
        $patterns=$request->variationGet;
        try{
            foreach ($members as $member){
                foreach ($patterns as $pattern){
                    $userPattern=new UserPattern();
                    $userPattern->user_id=$member;
                    $userPattern->pattern_id=$pattern;
                    $userPattern->save();
                }
            }
            return redirect()->back()->withInput()->withErrors(['notice'=>'member assigned']);
        }catch (\Exception $ex){
            return redirect()->back()->withInput()->withErrors(['error'=>$ex->getMessage()]);
        }

    }

    public function getDeleteBaseAssign($id)
    {
        DB::table('user_patterns')->where('user_id', '=', $id)->delete();
        return redirect()->back()->withInput()->withErrors(['notice'=>'remove base assign successfully']);
    }

    public function getIndex(){
        return view('member.index');
    }

    public function getCreateBase(){
        $path='C:\xampp\htdocs\MyThesis\base_pattern\Apri 2017';
       $fs=$this->openDir($path);
        return view('member.createBase')->withFs($fs)->withPath($path);
    }


    public function getListFolder(Request $request){
        if($request->ajax()){
            $folder=$request->f;
            $list=$this->openDir($folder);
            return $list;
        }
    }

    public function getReadFile($pathNew,$fileName){
        $replace='"\"';
        $replace=str_replace('"',"",$replace);
        $pF=$pathNew.$replace.$fileName;
        $path='C:\xampp\htdocs\MyThesis\base_pattern\Apri 2017';
        $fs=$this->openDir($path);
        $mode="readFile";
        $ls=$this->openDir($pathNew.'/'.$fileName);
        return view('member.createBase')->withFs($fs)->withPath($path)->withLs($ls)->with('fileName',$fileName)->with('newPaths',$pF)->with('mode',$mode);
    }

    public function getEditFile(Request $request){
        $oldPath=$request->oldPath;
        $newPaths=$request->path;
        $oldFileName=$request->oldFileName;
        $newFileName=$request->fileName;
        $path='C:\xampp\htdocs\MyThesis\base_pattern\Apri 2017';
        $fs=$this->openDir($path);
        $ls=$this->openDir($oldPath.'/'.$oldFileName);
        return view('member.createBase')->withFs($fs)->withPath($path)->withLs($ls)->with('fileName',$oldFileName)->with('newFileName',$newFileName)->with('oldPath',$oldPath)->with('newPaths',$newPaths);
    }
    public function postSaveFile(Request $request ){
        try{
            $fp=fopen($request->fileName,"w");
            fwrite($fp,$request->editor);
            fclose($fp);
            return redirect()->back()->withInput()->withErrors(['notice'=>'file saved']);
        }catch (\Exception $ex){
            return redirect()->back()->withInput()->withErrors(['error'=>$ex->getMessage()]);
        }


    }

    public function getReadDirectory(Request $request){

        $replace='"\"';
        $replace=str_replace('"',"",$replace);
        $fullPath=$request->fullPath;
        $fullPath=str_replace("/",$replace,$fullPath);
        $filePaths=$this->openDir($fullPath);
        return view('member.memberSubDirectory')->with('fullPath',$fullPath)->with('filePaths',$filePaths);
    }

    public function getEditFileSubDirectory(Request $request){
        $fullPath=$request->fullPath;
        $filePaths=$this->openDir($fullPath);
        $fileName=$request->fileName;
        return view('member.memberSubDirectory')->with('fullPath',$fullPath)->with('filePaths',$filePaths)->with('fileName',$fileName);
    }
    public function postSaveDirectoryFile(Request $request){
        try{
            $fp=fopen($request->fileName,"w");
            fwrite($fp,$request->editor);
            fclose($fp);
            return redirect()->back()->withInput()->withErrors(['notice'=>'file saved']);
        }catch (\Exception $ex){
            return redirect()->back()->withInput()->withErrors(['error'=>$ex->getMessage()]);
        }
    }


    public function getCreateFolder(Request $request){
        if($request->ajax()){
            $path=$request->path;
            $fileName=$request->fileName;
            try{
                if(mkdir($path.'/'.$fileName,0777,true)){
                    return "Directory has been created!";
                }
            }catch (\Exception $ex){
                return $ex->getMessage();
            }
        }
    }

    public function getCreateFile(Request $request){
        if($request->ajax()){
            $path=$request->path;
            $fileName=$request->fileName;
            try{
                $myFile = fopen($path.'/'.$fileName,"w");
                fwrite($myFile,$fileName);
                fclose($myFile);
                return "File has been created!";
            }catch (\Exception $ex){
                return $ex->getMessage();
            }

        }
    }

    public function openDir($dir=null){
        try{
            $folders="";
            if(!empty($dir)){
                $ds=scandir($dir);
                foreach ($ds as $d){
                    if($d!="." && $d!=".."){
                        $folders[]=$d;
                    }
                }
                return $folders;

            }
        }catch (\Exception $ex){
            return $ex->getMessage();
        }
    }
}
