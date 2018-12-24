<?php

namespace App\Http\Controllers\Banner;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use File;
class BannerController extends Controller
{
    /** view-page management banner*/
    public function createBanner(){
        return view('pages.management.banner.addBanner')->with(['carousels' => 'load']);
    }
    //
    public function viewsBanner(){
        $carousel = DB::select('select * from carousel');
        return response()->json($carousel);
    }
    //
    public function deleteBanner(Request $request, $id){
        $destinationPath = public_path('storage/gallery/');
        try{
            $lists = DB::select('select * from carousel where id = ?', [$id]);
            if($lists){
                foreach($lists as $list){
                    if(file_exists($destinationPath.$list->carousel_picture)){
                        File::delete($destinationPath.$list->carousel_picture);
                    }
                    $del = DB::delete('delete from carousel where id = ? ',[$id]);
                }
                session()->flash('status', 'Deleteing Banner Successfully');
                return response()->json(['status' => 'Deleteing Banner Successfully']);
            }else{
                session()->flash('error', '404 file not found');
                return response()->json(['error' => '404 file not found']);
            }
        }catch(Exception $e){
            session()->flash('error', 'these was a probleam delete files.');
            return response()->json(['error' => 'these was a probleam delete files.']);
        }
    }
    /**upload image file */
    public function storeBanner(Request $request){
        try{
            /**validate file type */
            $rules = [
                'carousel' => 'required',
                'carousel.*' => 'mimes:jpeg,png,jpg,bmp,gif,svg',
           ];
           $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                Log::error($validator->errors()->all());  
                return redirect('/banner/banner')->withErrors($validator); 
            }  
            $name = null;
            $destinationPath = null;
            $tempName = array();
            /**image store path*/
            $destinationPath = public_path('storage/gallery/');
            if ($request->hasFile('carousel')) {
                $files = $request->file('carousel');
                foreach($files as $file){
                    /**create new the image name*/
                    $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $combineName = $name.time().'.'.$file->getClientOriginalExtension();
                    /**insert path image to DB. */
                    DB::insert('insert into carousel (carousel_picture) values (?)', [$combineName]);
                    /**move file to storage */
                    $file->move($destinationPath, $combineName);
                    $tempName = $destinationPath.$combineName;
                }
                return redirect('/banner/banner')->with('status', 'Adding Banner Successfully');
            }
        }catch(Exception $e){
            /**if error rollBack DB and delete files */
            Log::notice("these was a problem DB is RollBack.");
            DB::rollBack(); 
            foreach($tempName as $tmp){
                if (file_exists($tmp)) {
                    Log::notice("these was a problem files is delete.");       
                    try{
                        File::delete($tmp);
                    }catch(Exception $e){
                        Log::error('file image banner has delete probleam.');
                        return redirect('/banner/banner')->with('error', 'these was a probleam adding banner!');
                    }            
                }       
            }
            return redirect('/banner/banner')->with('status', 'these was a probleam adding banner.');
        }  
        return redirect('/banner/banner')->with('status', 'Banner File Not Found 404.');
      }
}
