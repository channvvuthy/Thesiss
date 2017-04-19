<?php

namespace App\Http\Controllers;

use App\Models\Pattern;
use Illuminate\Http\Request;
use Auth;
use App\Models\Variation;

class LeaderController extends Controller
{
    public function getIndex()
    {
        return view('leader.index');
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
        $patterns=Pattern::where('status','1')->paginate(10);
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

    }
}
