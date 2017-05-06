<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Path;
use App\Models\Pattern;
use Illuminate\Http\Request;
use Auth;
use App\Models\Variation;
use File;
use App\Models\Base;
use App\Models\Layout;
use DB;

class LeaderController extends Controller
{
    public function getIndex()
    {
        $groups=Group::where('status','1')->get();
        return view('leader.index')->withGroups($groups);
    }

    public function getCreateBaseType()
    {
        $variations = Variation::paginate(10);
        return view('leader.baseType')->withVariations($variations);
    }

    public function postCreateVariation(Request $request)
    {
        $this->validate($request, [
            'variationName' => 'required',
            'variationDescription' => 'required'
        ]);
        $variation = new Variation();
        $variation->name = $request->variationName;
        $variation->description = $request->variationDescription;
        $variation->save();
        return redirect()->back()->withInput()->withErrors(['notice' => 'variation has been created']);
    }

    public function getEditVariation(Request $request, $id)
    {
        $variation = Variation::find($id);
        return view('leader.editVariation')->withVariation($variation);
    }

    public function postUpdateVariation(Request $request)
    {
        $id = $request->id;
        $name = $request->variationName;
        $description = $request->variationDescription;
        $variation = Variation::find($id);
        $variation->name = $name;
        $variation->description = $description;
        $variation->save();
        return redirect()->route('createBaseType')->withInput()->withErrors(['notice' => 'variation has been update complete']);
    }

    public function getDeleteVariation($id)
    {
        $variation = Variation::find($id);
        $variation->delete();
        return redirect()->back()->withInput()->withErrors(['notice' => 'variation has been deleted']);
    }

    public function getActiveVariation($id)
    {
        $variation = Variation::find($id);
        if ($variation->status == 1) {
            $variation->status = "0";
        } else {
            $variation->status = "1";
        }
        $variation->save();
        return redirect()->back()->withInput()->withErrors(['notice' => 'variation has been update']);

    }

    public function getCreatePattern()
    {

        $variations = Variation::where('status', '1')->get();
        $patterns=Pattern::paginate(10);
        return view('leader.pattern')->withVariations($variations)->withPatterns($patterns);
    }

    public function postCreatePattern(Request $request)
    {
        $this->validate($request, [
            'patternName' => 'required',
            'patternURL' => 'required',

        ]);
        $patternFile=$request->patternFile;
        if(!empty($patternFile)){
            $fileName=time().$patternFile->getClientOriginalName();
            $ex=explode(".",$fileName);
            $ex=end($ex);
            if($ex=="zip" || $ex=="ra"){
                $patternFile->move('uploads/',$fileName);

            }else{
                return redirect()->back()->withInput()->withErrors(['patternFile'=>'File allow only zip and ra']);
            }
            $pattern=new Pattern();
            $pattern->variation_id=$request->variation;
            $pattern->name=$request->patternName;
            $pattern->url=$request->patternURL;
            $pattern->file_name=$fileName;
            $pattern->description=$request->patternDescription;
            $pattern->save();
        }else{
            $pattern=new Pattern();
            $pattern->variation_id=$request->variation;
            $pattern->name=$request->patternName;
            $pattern->url=$request->patternURL;
            $pattern->description=$request->patternDescription;
            $pattern->save();
        }
        return redirect()->route('createPattern')->withErrors(['notice'=>'pattern has been created']);


    }
    public function getEditPattern($id){
        $pattern=Pattern::find($id);
        $variations = Variation::where('status', '1')->get();
        return view('leader.editPattern')->withPattern($pattern)->withVariations($variations);
    }
    public function postUpdatePattern(Request $request){
        $pattern=Pattern::find($request->id);
        $patternFile=$request->patternFile;
        if(!empty($patternFile)){
            $fileName=time().$patternFile->getClientOriginalName();
            $ex=explode(".",$fileName);
            $ex=end($ex);
            if($ex=="zip" || $ex=="ra"){
                $patternFile->move('uploads/',$fileName);

            }else{
                return redirect()->back()->withInput()->withErrors(['patternFile'=>'File allow only zip and ra']);
            }
            $pattern->variation_id=$request->variation;
            $pattern->name=$request->patternName;
            $pattern->url=$request->patternURL;
            $pattern->file_name=$fileName;
            $pattern->description=$request->patternDescription;
            File::delete('uploads/'.$pattern->file_name);
            $pattern->save();
        }else{

            $pattern->variation_id=$request->variation;
            $pattern->name=$request->patternName;
            $pattern->url=$request->patternURL;
            $pattern->description=$request->patternDescription;
            $pattern->save();
        }
        return redirect()->route('createPattern')->withInput()->withErrors(['notice'=>'pattern update complete']);
    }

    public function getActivePattern($id){
        $pattern=Pattern::find($id);
        if($pattern->status=="1"){
            $pattern->status="0";
        }else{
            $pattern->status="1";
        }
        $pattern->save();
        return redirect()->route('createPattern')->withInput()->withErrors(['notice'=>'pattern has been updated']);
    }

    public function getDeletePattern($id){
        $pattern=Pattern::find($id);
        $pattern->delete();
        return redirect()->route('createPattern')->withInput()->withErrors(['notice'=>'pattern has been deleted']);
    }

    public function getBaseDirectory(){
        $path=Path::where('user_id',Auth::user()->id)->first();
        return view('leader.createPath')->with('path',$path);
    }

    public function postBaseDirectory(Request $request){
        $path=Path::where('user_id',Auth::user()->id)->first();
        $this->validate($request,[
            'pathName'=>'required',
            'pathDescription'=>'required'
        ]);
        if(!empty($path)){
            $path->path=$request->pathName;
            $path->user_id=Auth::user()->id;
            $path->description=$request->pathDescription;
            $path->path_for='base';
            $path->save();
            return redirect()->back()->withInput()->withErrors(['notice'=>'directory has been updated!']);
        }else{
            $path=new Path();
            $path->path=$request->pathName;
            $path->user_id=Auth::user()->id;
            $path->description=$request->pathDescription;
            $path->path_for='base';
            $path->save();
            return redirect()->back()->withInput()->withErrors(['notice'=>'directory has been created!']);

        }
    }

    public function getBaseList(Request $request){
        if(!empty($request->num_row)){
           $bases=Base::where('used',NULL)->paginate($request->num_row);
        }else{
            $bases=Base::where('used',NULL)->paginate(35);
        }
        
        $layouts=Layout::where('status','1')->get();
        $groups=Group::where('type','first')->get();
        return view('leader.getBaseList')->withBases($bases)->withLayouts($layouts)->withGroups($groups);
    }
    public function postBaseList(Request $request){

    }

    public function getSaveLayoutAjax(Request $request){
        $layout=$request->layout;
        $baseId=$request->baseId;
        if(!empty($layout)){
            foreach($layout as $l){
                DB::table('base_layout')->insert(['base_id'=>$baseId,'layout_id'=>$l]);
            }
        }
        return "Save Success";
        
    }

    public function getLeaderUpdateBase(Request $request){
        if(!empty($request->listFolder)){
          $select=$this->openDir($request->listFolder);
          if(!empty($select)){
              $bases =Base::whereIn('name',$select)->get();
              return view('leader.listFolder')->with('bases',$bases);
          }
          return redirect()->back();
        }
        if(!empty($request->search)){
            $search=$request->search;
            $bases=Base::where('name','LIKE','%'.$search.'%')->get();
            $layouts=Layout::where('status','1')->get();
            $groups=Group::where('type','first')->get();
            return view('leader.getBaseSearch')->withBases($bases)->withLayouts($layouts)->withGroups($groups);

        }
        if(!empty($request->from && !empty($request->to))){
            $from=$request->from;
            $from=explode("-",$from);
            $yearFrom=$from[0];
            $monthFrom=$from[1];
            $dateFrom=$from[2];
            $dateFrom;
            $to=$request->to;
            $to=explode("-",$to); 
            $yearTo=$to[0];
            $monthTo=$to[1];
            $dateTo=$to[2];
            $bases=Base::whereMonth('created_at','>=', $monthFrom)->whereMonth('created_at','<=',$monthTo)->whereYear('created_at','>=',$yearFrom)->whereYear('created_at','<=',$yearTo)->get();
            $layouts=Layout::where('status','1')->get();
            $groups=Group::where('type','first')->get();
            return view('leader.getBaseSearch')->withBases($bases)->withLayouts($layouts)->withGroups($groups);
        }else if(!empty($request->from && empty($request->to))){
            $from=$request->from;
            $from=explode("-",$from);
            $yearFrom=$from[0];
            $monthFrom=$from[1];
            $dateFrom=$from[2];
            $dateFrom;
            $bases=Base::whereMonth('created_at','>=', $monthFrom)->whereYear('created_at','>=',$yearFrom)->get();
            $layouts=Layout::where('status','1')->get();
            $groups=Group::where('type','first')->get();
            return view('leader.getBaseSearch')->withBases($bases)->withLayouts($layouts)->withGroups($groups);
        }

        $ids=$request->id;
        $i=0;
        $version=$request->version;
        $note=$request->note;
        $used_by=$request->used_by;
        $used_by_id=$request->used_by_id;
        if(!empty($request->choose_action)){
            $action=$request->choose_action;
            if($action=="Update"){
                if(!empty($ids)){
                    foreach($ids as $id){
                        $base=Base::find($id);
                        $base->version=$version[$i];
                        $base->note=$note[$i];
                        $base->used_by=$used_by[$i];
                        $base->used_by_id=$used_by_id[$i];
                        $base->save();
                        $i++;
                    }
                    return redirect()->back()->withInput()->withErrors(['notice'=>'update success']);
                }
            }elseif($action=="Delete"){
                if(!empty($request->check)){
                    foreach ($request->check as $key) {
                        $base=Base::find($key);
                        $base->delete();
                    }
                }
                return redirect()->back()->withInput()->withErrors(['notice'=>'Base delete success']);
            }
        }
        return redirect()->back();
        
    }
    public function getUpdateStatusBaseLeaderCheck(Request $request){
        $baseId=$request->baseId;
        $baseName=$request->baseName;
        $base=Base::find($baseId);
        $base->leader_check_result=$baseName;
        $base->save();
        return "Update Status Success";
    }
    public function getUpdateProblemBase(Request $request){
        $baseId=$request->baseId;
        $baseProblem=$request->val;
        if(!empty($baseId)){
            $base=Base::find($baseId);
            $base->leader_check_problem=$baseProblem;
            $base->save();
        }
        return $baseProblem;
    }

    public function getUpdatNote(Request $request){
        $baseId=$request->baseId;
        $baseProblem=$request->val;
        if(!empty($baseId)){
            $base=Base::find($baseId);
            $base->note=$baseProblem;
            $base->save();
        }
        return $baseProblem;
    }


    public function getSubmitQC(Request $request){
        $base=Base::find($request->baseId);
        if($base->get_it=="0"){
            $base->get_it="1";
        }else{
            $base->get_it="0";
        }
        $base->save();
        return "updated";
    }

    public function getNotificationLeader(){
        $bases = DB::table('bases')
            ->leftJoin('users', 'users.id', '=', 'bases.user_id')
            ->where('leader_check_result','2')
            ->select('users.name as userName','bases.*')
            ->get();
            return $bases;
    }

    public function getBaseReport(Request $request){
        $select_report=$request->select_report;
        $date=date("d");
        $month=date('m');
        $year=date('Y');
        $last_year=$year-1;
        if($select_report=="today"){
          return DB::select(DB::raw("select bases.id,bases.name as BaseName,bases.user_id,count(bases.user_id) as Total,users.name  from bases LEFT JOIN users on users.id=bases.user_id where day =$date AND year=$year GROUP BY bases.user_id"));
        }elseif($select_report=='month'){
            return DB::select(DB::raw("select bases.id,bases.name as BaseName,bases.user_id,count(bases.user_id) as Total,users.name  from bases LEFT JOIN users on users.id=bases.user_id where month =$month AND year=$year GROUP BY bases.user_id"));
        }else if($select_report=='year'){
             return DB::select(DB::raw("select bases.id,bases.name as BaseName,bases.user_id,count(bases.user_id) as Total,users.name  from bases LEFT JOIN users on users.id=bases.user_id where year=$year GROUP BY bases.user_id"));
        }elseif($select_report=='last_year'){
            return DB::select(DB::raw("select bases.id,bases.name as BaseName,bases.user_id,count(bases.user_id) as Total,users.name  from bases LEFT JOIN users on users.id=bases.user_id where year=$last_year GROUP BY bases.user_id"));
        }else{
            return DB::select(DB::raw("select bases.id,bases.name as BaseName,bases.user_id,count(bases.user_id) as Total,users.name  from bases LEFT JOIN users on users.id=bases.user_id  GROUP BY bases.user_id"));
        }
    }

    public function getLoadBaseReport(Request $request){
        $report=$request->report;
        $report=explode("-", $report);
        $year=$report[0];
        $month=$report[1];
        $date=$report[2];
        $bases=DB::select(DB::raw("select bases.id,bases.name as BaseName,bases.user_id,count(bases.user_id) as Total,users.name  from bases LEFT JOIN users on users.id=bases.user_id where day =$date AND month=$month AND  year=$year GROUP BY bases.user_id"));
        return $bases;
    }

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
