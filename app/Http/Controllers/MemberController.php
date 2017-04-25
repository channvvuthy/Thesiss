<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Variation;
use App\Models\Pattern;
use DB;
use App\Models\UserPattern;
use App\Models\Path;
use Auth;
use App\Models\Base;

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
        $members = $request->member;
        $variation = $request->variationDefault;
        $patterns = $request->variationGet;
        try {
            foreach ($members as $member) {
                foreach ($patterns as $pattern) {
                    $userPattern = new UserPattern();
                    $userPattern->user_id = $member;
                    $userPattern->pattern_id = $pattern;
                    $userPattern->save();
                }
            }
            return redirect()->back()->withInput()->withErrors(['notice' => 'member assigned']);
        } catch (\Exception $ex) {
            return redirect()->back()->withInput()->withErrors(['error' => $ex->getMessage()]);
        }

    }

    public function getDeleteBaseAssign($id)
    {
        DB::table('user_patterns')->where('user_id', '=', $id)->delete();
        return redirect()->back()->withInput()->withErrors(['notice' => 'remove base assign successfully']);
    }

    public function getIndex()
    {
        return view('member.index');
    }

    public function getCreateBase()
    {
        $path = "";
        try {
            $path = Auth::user()->path->path;
        } catch (\Exception $ex) {
            $replace = '"\"';
            $replace = str_replace('"', "", $replace);
            $path = "C:" . $replace;
        }


        $leaderPath = Path::where('path_for', 'base')->first();
        $fs = $this->openDir($path);
        return view('member.createBase')->withFs($fs)->withPath($path)->with('leaderPath', $leaderPath);
    }


    public function getListFolder(Request $request)
    {
        if ($request->ajax()) {
            $folder = $request->f;
            $list = $this->openDir($folder);
            return $list;
        }
    }

    public function getReadFile($pathNew, $fileName)
    {

        $replace = '"\"';
        $replace = str_replace('"', "", $replace);
        $pF = $pathNew . $replace . $fileName;
        $path = Auth::user()->path->path?:"C:".$replace;
        $fs = $this->openDir($path);
        $mode = "readFile";
        $ls = $this->openDir($pathNew . '/' . $fileName);
        return view('member.createBase')->withFs($fs)->withPath($path)->withLs($ls)->with('fileName', $fileName)->with('newPaths', $pF)->with('mode', $mode);
    }

    public function getEditFile(Request $request)
    {
        $oldPath = $request->oldPath;
        $newPaths = $request->path;
        $oldFileName = $request->oldFileName;
        $newFileName = $request->fileName;
        $path = Auth::user()->path->path;
        $fs = $this->openDir($path);
        $ls = $this->openDir($oldPath . '/' . $oldFileName);
        return view('member.createBase')->withFs($fs)->withPath($path)->withLs($ls)->with('fileName', $oldFileName)->with('newFileName', $newFileName)->with('oldPath', $oldPath)->with('newPaths', $newPaths);
    }

    public function postSaveFile(Request $request)
    {
        try {
            $fp = fopen($request->fileName, "w");
            fwrite($fp, $request->editor);
            fclose($fp);
            return redirect()->back()->withInput()->withErrors(['notice' => 'file saved']);
        } catch (\Exception $ex) {
            return redirect()->back()->withInput()->withErrors(['error' => $ex->getMessage()]);
        }


    }

    public function getReadDirectory(Request $request)
    {

        $replace = '"\"';
        $replace = str_replace('"', "", $replace);
        $fullPath = $request->fullPath;
        $fullPath = str_replace("/", $replace, $fullPath);
        $filePaths = $this->openDir($fullPath);
        return view('member.memberSubDirectory')->with('fullPath', $fullPath)->with('filePaths', $filePaths);
    }

    public function getEditFileSubDirectory(Request $request)
    {
        $fullPath = $request->fullPath;
        $filePaths = $this->openDir($fullPath);
        $fileName = $request->fileName;
        return view('member.memberSubDirectory')->with('fullPath', $fullPath)->with('filePaths', $filePaths)->with('fileName', $fileName);
    }

    public function postSaveDirectoryFile(Request $request)
    {
        try {
            $fp = fopen($request->fileName, "w");
            fwrite($fp, $request->editor);
            fclose($fp);
            return redirect()->back()->withInput()->withErrors(['notice' => 'file saved']);
        } catch (\Exception $ex) {
            return redirect()->back()->withInput()->withErrors(['error' => $ex->getMessage()]);
        }
    }


    public function getCreateFolder(Request $request)
    {
        if ($request->ajax()) {
            $path = $request->path;
            $fileName = $request->fileName;
            try {
                if (mkdir($path . '/' . $fileName, 0777, true)) {
                    return "Directory has been created!";
                }
            } catch (\Exception $ex) {
                return $ex->getMessage();
            }
        }
    }

    public function getCreateFile(Request $request)
    {
        if ($request->ajax()) {
            $path = $request->path;
            $fileName = $request->fileName;
            try {
                $myFile = fopen($path . '/' . $fileName, "w");
                fwrite($myFile, $fileName);
                fclose($myFile);
                return "File has been created!";
            } catch (\Exception $ex) {
                return $ex->getMessage();
            }

        }
    }

    /*
     * Create path for store file of user
     */
    public function getCreatePath()
    {
        $path = Path::where('user_id', Auth::user()->id)->first();
        return view('member.createPath')->with('path', $path);
    }

    public function postCreatePath(Request $request)
    {
        $this->validate($request, [
            'pathName' => 'required',
            'pathDescription' => 'required'
        ]);
        $path = Path::where('user_id', Auth::user()->id)->first();
        $pathName = $request->pathName;
        $pathDescription = $request->pathDescription;
        if (!empty($path)) {
            $path->path = $pathName;
            $path->user_id = Auth::user()->id;
            $path->description = $pathDescription;
            $path->save();
            return redirect()->back()->withInput()->withErrors(['notice' => 'Path has been updated']);
        } else {
            $path = new Path();
            $path->path = $pathName;
            $path->user_id = Auth::user()->id;
            $path->description = $pathDescription;
            $path->save();
            return redirect()->back()->withInput()->withErrors(['notice' => 'Path saved']);
        }
    }

    /*
     * Copy and save order to Leader and Database
     */
    public function getCopyAndSave(Request $request)
    {
        $leaderPath = $request->leaderPath;
        $userPath = $request->path;
        $replace = '"\"';
        $replace = str_replace('"', "", $replace);
        $orders = $request->string;
        $leaderPath = str_replace("/", $replace, $leaderPath);
        if (!empty($orders)) {
            $orders = rtrim($orders, ",");
            $orders = explode(",", $orders);
            $variation=$request->variation;
            $variation=explode("-",$variation);
            $variation_id=$variation[0];
            $patter_id=$variation[1];
            foreach ($orders as $order) {
                $file = fopen('auth/' . Auth::user()->name . '.bat', "w");
                fwrite($file, "mkdir " . $leaderPath . $replace . $order);
                exec('auth/' . Auth::user()->name . '.bat');
                $file = fopen('auth/' . Auth::user()->name . '.bat', "w");
                $copy = "xcopy ";
                $replace = '"\"';
                $replace = str_replace('"', "", $replace);
                $from = $request->path;
                $from = str_replace("/", $replace, $from);
                $to = $request->leaderPath;
                $to = str_replace("/", $replace, $to);
                fwrite($file, $copy . '"' . $from . $replace . $order . '"' . ' ' . '"' . $to . $replace . $order . '"' . ' /h/i/c/k/e/r/y');
                fclose($file);
                exec('auth/' . Auth::user()->name . '.bat');
                $base =new Base();
                $base->user_id=Auth::user()->id;
                $base->pattern_id=$patter_id;
                $base->variation_id=$variation_id;
                $base->name=$order;
                $base->save();
            }
        }

    }

    /*
     * Read directory
     */

    public function openDir($dir = null)
    {
        try {
            $folders = "";
            if (!empty($dir)) {
                $ds = scandir($dir);
                foreach ($ds as $d) {
                    if ($d != "." && $d != "..") {
                        $folders[] = $d;
                    }
                }
                return $folders;

            }
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}
