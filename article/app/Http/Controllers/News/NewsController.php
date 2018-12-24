<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use File;

class NewsController extends Controller
{
    //show news page.
    public function viewNews(){
        return view('pages.management.news.viewNews')->with(['newsTarget' => 'load']);
    }
    //show create news page.
    public function createNews(){
        return view('pages.management.news.createNews');
    }
    //select news from DB.
    public function selectNews(){
        /**fine news from DB. */
        $news = DB::select('select * from article where type = 1 Order by create_at DESC');
        return response()->json($news);  
    }
    //Edit news 
    public function editNews(Request $request, $id){
        $imageContent = array();
        $spilt;
        if($id){
            $lists = DB::select('select * from article where type = 1 and id = ?',[$id]);
            foreach($lists as $list){
                $spilt = explode(",",$list->content_picture);  
            }
            unset($spilt[sizeof($spilt) -1]);
            array_push($imageContent,$spilt);
        }
        return view('pages.management.news.editNews')->with(['news' => $lists,'imageContent' => $imageContent]);
    }
    /**checking image */
    function compareImagesA($request, $id){
         /**image store path*/
         $destinationPath = public_path('storage/gallery/');
         $imageTopic = null;
        try{           
            if ($request->hasFile('news-topic-image')){
                /**validate file type */
                $rules = [
                    'news-topic-image' => 'required',
                    'news-topic-image.*' => 'mimes:jpeg,png,jpg,bmp,gif,svg',
                ];
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    Log::error($validator->errors()->all());
                    return redirect('/news/editNews/'.$id)->withErrors($validator); 
                }
                $fileTopic = $request->file('news-topic-image');
                /**create new the image name*/
                $imageTopic = pathinfo($fileTopic->getClientOriginalName(), PATHINFO_FILENAME).time().'.'.$fileTopic->getClientOriginalExtension();
                /** move file to storeage */
                if(!$fileTopic->move($destinationPath, $imageTopic)){
                    Log::error("these was a problem save file topic.");  
                    if (file_exists($destinationPath.$imageTopic)) {
                        Log::notice("these was a problem files is delete.");       
                        try{
                            File::delete($destinationPath.$imageTopic);
                        }catch(Exception $e){
                            Log::error('file image topic has delete probleam.');
                            return redirect('/news/editNews')->with('error', 'these was a probleam create Article!');
                        }               
                    }  
                    return redirect('/news/editNews/'.$id)->with('error', 'these was a probleam create news!'); 
                }
            }else{
                $imageTopic = $request->input('topic-image-temp'); 
            }
        }catch(Exception $e){
            if (file_exists($destinationPath.$imageTopic)) {
                Log::notice("these was a problem files is delete.");       
                try{
                    File::delete($destinationPath.$imageTopic);
                }catch(Exception $e){
                    Log::error('file image topic has delete probleam.');
                    return redirect('/news/editNews')->with('error', 'these was a probleam create Article!');
                }              
            }           
            return redirect('/news/editNews/'.$id)->with('error', 'these was a probleam create news!');
        }
        return $imageTopic;
    }

    function compareImagesB($request, $id){
        /**image store path*/
        $destinationPath = public_path('storage/gallery/');
        $imageContent = null;
        $fileContent;
        try{            
            if ($request->hasFile('news-detail-image')){
                /**validate file type */
                $rules = [
                    'news-detail-image' => 'required',
                    'news-detail-image.*' => 'mimes:jpeg,png,jpg,bmp,gif,svg',
                ];
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    Log::error($validator->errors()->all());
                    return redirect('/news/editNews/'.$id)->withErrors($validator); 
                }
                $fileContent = $request->file('news-detail-image');
                foreach($fileContent as $file){
                    $imageContent = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).time().'.'.$file->getClientOriginalExtension();
                    /** move file to storeage */
                    if(!$file->move($destinationPath, $imageContent)){
                        Log::error("these was a problem save file content."); 
                        if (file_exists($destinationPath.$imageContent)) {
                            Log::notice("these was a problem files is delete.");       
                            try{
                                File::delete($destinationPath.$imageContent);
                            }catch(Exception $e){
                                Log::error('file image topic has delete probleam.');
                                return redirect('/news/editNews')->with('error', 'these was a probleam create Article!');
                            }              
                        }  
                        return redirect('/news/editNews/'.$id)->with('error', 'these was a probleam create news!'); 
                    };
                }                
            }else{
                /**spilt files */
                $files = $request->input('content-image-temp');
                foreach($files as $file ){
                    $imageContent = $imageContent.$file.",";
                }                    
            }
        }catch(Exception $e){
            if (file_exists($destinationPath.$imageContent)) {
                Log::notice("these was a problem files is delete.");       
                try{
                    foreach($fileContent as $file ){
                        File::delete($destinationPath.$file);
                    }                    
                }catch(Exception $e){
                    Log::error('file image topic has delete probleam.');
                    return redirect('/news/editNews')->with('error', 'these was a probleam create Article!');
                }             
            }           
            return redirect('/news/editNews/'.$id)->with('error', 'these was a probleam create news!');
        } 
        return $imageContent;
    }
    //edit and Store News
    public function replaceNews(Request $request, $id){
        try{
            $imageA = null;
            $imageB = null;            

            $imageA = $this->compareImagesA($request,$id);
            $imageB = $this->compareImagesB($request,$id);

            $topic = $request->input('news-topic');
            $content = $request->input('news-content');

            /**store topic content images to DB. */
            DB::update('update article set topic=?, content = ?, topic_picture = ?, content_picture = ? where id = ? and type = 1', 
            [$topic, $content, $imageA, $imageB, $id]);

            //return redirect()->action('News\NewsController@viewNews');
            return redirect('/news/view')->with('status', 'update news successfully');
        
        }catch(Exception $e){
            /**if error rollBack DB and delete files */
            Log::notice("these was a problem DB is RollBack.");
            DB::rollBack();         
            return redirect('/news/editNews/'.$id)->with('error', 'these was a probleam create news!');
        } 
        return redirect('/news/editNews/'.$id)->with('error', 'these was a probleam create news!');
    }

    //Delete news from DB
    public function deleteNew(Request $request, $id){
        $pathfile = public_path('storage/gallery/');
        if($id){
            $imagesTopic = null;
            $spilts;
            $news = DB::select('select * from article where type = 1 and id = ? Order by create_at DESC', [$id]);
            foreach ($news as $new) {
                $imagesTopic = $new->topic_picture;
                $spilts = explode(",",$new->content_picture); 
            }
            if(sizeof($spilts) > 0){
                unset($spilts[sizeof($spilts) -1]);
            }           

            $fileCombineTopic = $pathfile.$imagesTopic;
            if(file_exists($fileCombineTopic)){
                Log::notice('file image topic has delete.');
                try{
                    File::delete($fileCombineTopic);
                }catch(Exception $e){
                    Log::error('file image topic has delete probleam.');
                    session()->flash('error', 'these was a probleam create News!');
                    return response()->json(['error' => 'these was a probleam create News!']);
                }                
            }
            
            foreach ($spilts as $spilt) {Log::notice($spilt);
                    if(file_exists($pathfile.$spilt)){
                        Log::notice('file image content has delete.');
                        try{
                            File::delete($pathfile.$spilt);
                        }catch(Exception $e){
                            Log::error('file image topic has delete probleam.');
                            //return redirect('/news/view')->with('error', 'these was a probleam create News!');
                            session()->flash('error', 'these was a probleam create News!');
                            return response()->json(['error' => 'these was a probleam create News!']);
                        }    
                    }
            }

            $deleted = DB::delete('delete from article where id = ?',[$id]);
            if($deleted > 0){
                //return redirect('/news/view')->with('status', 'News delete successfully!');
                session()->flash('status', 'News delete successfully!');
                return response()->json(['status' => 'News delete successfully!']);
            }
        }
        session()->flash('error', 'these was probleam delete news -> status code : '.app('Illuminate\Http\Response')->status());
        return response()->json(['error' => 'these was probleam delete news']);
        //return redirect('/news/view')->with('error', 'these was probleam delete news -> status code : '.app('Illuminate\Http\Response')->status());       
    }
    //store news to DB.
    public function storeNews(Request $request){
        /**image store path*/
        $destinationPath = public_path('storage/gallery/');
        $imageTopic = null;
        $imageContent = null;
        $contentCombine= null;
        $contentArray = array();
        try{
            /**validate file type */
            $rules = [
            'news-topic-image' => 'required',
            'news-topic-image.*' => 'mimes:jpeg,png,jpg,bmp,gif,svg',
            'news-detail-image' => 'required',
            'news-detail-image.*' => 'mimes:jpeg,png,jpg,bmp,gif,svg',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                Log::error($validator->errors()->all());
                return redirect('/news/create')->withErrors($validator); 
            }           

            if ($request->hasFile('news-topic-image') && $request->hasFile('news-detail-image')) {
            /**topic image process */
                $fileTopic = $request->file('news-topic-image');
            /**create new the image name*/
            $imageTopic = pathinfo($fileTopic->getClientOriginalName(), PATHINFO_FILENAME).time().'.'.$fileTopic->getClientOriginalExtension();
            
            $fileContent = $request->file('news-detail-image');
            foreach($fileContent as $file){
                $imageContent = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).time().'.'.$file->getClientOriginalExtension();
                $contentCombine = $contentCombine . $imageContent . ",";
                array_push($contentArray ,$imageContent);

                if(!$file->move($destinationPath, $imageContent)){
                    Log::error("these was a problem save file content."); 
                    if (file_exists($destinationPath.$imageContent)) {
                        Log::notice("these was a problem files is delete.");       
                        try{
                            File::delete($destinationPath.$imageContent);
                        }catch(Exception $e){
                            Log::error('file image topic has delete probleam.');
                            return redirect('/news/create')->with('error', 'these was a probleam create Article!');
                        }               
                    }  
                    return redirect('/news/create')->with('error', 'these was a probleam create news!'); 
                };
            }
            /** move file to storeage */
            if(!$fileTopic->move($destinationPath, $imageTopic)){
                Log::error("these was a problem save file topic.");  
                if (file_exists($destinationPath.$imageTopic)) {
                    Log::notice("these was a problem files is delete.");       
                    try{
                        File::delete($destinationPath.$imageTopic);
                    }catch(Exception $e){
                        Log::error('file image topic has delete probleam.');
                        return redirect('/news/create')->with('error', 'these was a probleam create Article!');
                    }            
                }  
                return redirect('/news/create')->with('error', 'these was a probleam create news!'); 
            };            

            $topic = $request->input('news-topic');
            $content = $request->input('news-content');
            
            /**store topic content images to DB. */
            DB::insert('insert into article (topic, content, topic_picture, content_picture, type) values (?, ?, ?, ?, ?)', 
                [$topic, $content, $imageTopic, $contentCombine,1]);
        
           //return redirect()->action('News\NewsController@viewNews');
           return redirect('/news/view')->with('status', 'News create successfully');
        }       
        }catch(Exception $e){
            /**if error rollBack DB and delete files */
            Log::notice("these was a problem DB is RollBack.");
            DB::rollBack(); 
            if (file_exists($destinationPath.$imageTopic)) {
                Log::notice("these was a problem files is delete.");       
                try{
                    File::delete($destinationPath.$imageTopic);
                }catch(Exception $e){
                    Log::error('file image topic has delete probleam.');
                    return redirect('/news/create')->with('error', 'these was a probleam create Article!');
                }             
            }  
            foreach($contentArray as $file){
                if (file_exists($destinationPath.$file)) {
                    Log::notice("these was a problem files is delete.");       
                    try{
                        File::delete($destinationPath.$file);
                    }catch(Exception $e){
                        Log::error('file image topic has delete probleam.');
                        return redirect('/news/create')->with('error', 'these was a probleam create Article!');
                    }              
                }   
            }        
            return redirect('/news/create')->with('error', 'these was a probleam create news!');
        } 
        return redirect('/news/create')->with('error', 'these was a probleam create news!');
    }   
}