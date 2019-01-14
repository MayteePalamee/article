<?php

namespace App\Http\Controllers\Article;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    //view manage article.
    public function manageArticle(){
        return view('pages.management.article.viewArticle')->with(['articleTarget' => 'load'] );
    }
    //view create article
    public function createArticle(){
        return view('pages.management.article.createArticle');
    }
    //list all article
    public function selectArticle(){
        /**fine article from DB. */
        $article = DB::select('select * from article where type = 0 Order by create_at DESC');
        return response()->json($article);  
    }
    //edit article with id
    public function editArticle(Request $request, $id){
        $imageContent = array();
        $spilt;
        if($id){
            $lists = DB::select('select * from article where type = 0 and id = ?',[$id]);
            foreach($lists as $list){
                $spilt = explode(",",$list->content_picture);  
            }
            unset($spilt[sizeof($spilt) -1]);
            array_push($imageContent,$spilt);
        }
        return view('pages.management.article.editArticle')->with(['articles' => $lists,'imageContent' => $imageContent]);
    }
    //edit and replace article with id
    public function replaceArticle(Request $request, $id){
        try{
            $imageA = null;
            $imageB = null;            

            $imageA = $this->compareImagesA($request,$id);
            $imageB = $this->compareImagesB($request,$id);

            $topic = $request->input('article-topic');
            $content = $request->input('article-content');

            /**store topic content images to DB. */
            DB::update('update article set topic=?, content = ?, topic_picture = ?, content_picture = ? where id = ? and type = 0', 
            [$topic, $content, $imageA, $imageB, $id]);

            //return redirect()->action('News\NewsController@viewNews');
            return redirect('/article/view')->with('status', 'update article successfully');
        
        }catch(Exception $e){
            /**if error rollBack DB and delete files */
            Log::notice("these was a problem DB is RollBack.");
            DB::rollBack();         
            return redirect('/article/edit/'.$id)->with('error', 'these was a probleam create article!');
        } 
        return redirect('/article/edit/'.$id)->with('error', 'these was a probleam create article!');
    }
    /**checking image */
    function compareImagesA($request, $id){
        /**image store path*/
        $destinationPath = public_path('storage/gallery/');
        $imageTopic = null;
       try{           
           if ($request->hasFile('topic-image')){
               /**delete old image */
               $filetmp = $destinationPath.$request->input('topic-image-temp');
               if($request->input('topic-image-temp')){
                    if (file_exists($filetmp)) {
                        File::delete($filetmp);
                    }
               }
               /**validate file type */
               $rules = [
                   'topic-image' => 'required',
                   'topic-image.*' => 'mimes:jpeg,png,jpg,bmp,gif,svg',
               ];
               $validator = Validator::make($request->all(), $rules);
               if ($validator->fails()) {
                   Log::error($validator->errors()->all());
                   return redirect('/article/edit/'.$id)->withErrors($validator); 
               }
               $fileTopic = $request->file('topic-image');
               /**create new the image name*/
               $imageTopic = pathinfo($fileTopic->getClientOriginalName(), PATHINFO_FILENAME).time();
               $imageTopic = base64_encode($imageTopic);
               $imageTopic = $imageTopic.'.'.$fileTopic->getClientOriginalExtension();
               /** move file to storeage */
               if(!$fileTopic->move($destinationPath, $imageTopic)){
                   Log::error("these was a problem save file topic.");  
                   if (file_exists($destinationPath.$imageTopic)) {
                       Log::notice("these was a problem files is delete.");       
                        try{
                            File::delete($destinationPath.$imageTopic);
                        }catch(Exception $e){
                            Log::error('file image topic has delete probleam.');
                            return redirect('/article/create')->with('error', 'these was a probleam create Article!');
                        }            
                   }  
                   return redirect('/article/edit/'.$id)->with('error', 'these was a probleam create article!'); 
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
                    return redirect('/article/create')->with('error', 'these was a probleam create Article!');
                }             
           }           
           return redirect('/article/edit/'.$id)->with('error', 'these was a probleam create article!');
       }
       return $imageTopic;
    }
    function compareImagesB($request, $id){
       /**image store path*/
       $destinationPath = public_path('storage/gallery/');
       $imageContent = null;
       $tmpContent = "";
       $fileContent;
       try{            
           if ($request->hasFile('content-image')){
               /**delete old image */
               if($request->input('content-image-temp')){
               $tmpinput = $request->input('content-image-temp');
                    foreach($tmpinput as $val){
                    $filetmp = $destinationPath.$val;
                        if (file_exists($filetmp)) {
                            File::delete($filetmp);
                        }
                    }
                }
               /**validate file type */
               $rules = [
                   'content-image' => 'required',
                   'content-image.*' => 'mimes:jpeg,png,jpg,bmp,gif,svg',
               ];
               $validator = Validator::make($request->all(), $rules);
               if ($validator->fails()) {
                   Log::error($validator->errors()->all());
                   return redirect('/article/edit/'.$id)->withErrors($validator); 
               }
               $fileContent = $request->file('content-image');
               foreach($fileContent as $file){
                $imageContent = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).time();
                $imageContent = base64_encode($imageContent);
                $imageContent = $imageContent.'.'.$file->getClientOriginalExtension();
                $tmpContent = $tmpContent.$imageContent.",";
                /** move file to storeage */
                if(!$file->move($destinationPath, $imageContent)){
                    Log::error("these was a problem save file content."); 
                    if(file_exists($destinationPath.$imageContent)){
                     Log::notice('file image Content has delete.');
                     try{
                         File::delete($destinationPath.$imageContent);
                     }catch(Exception $e){
                         Log::error('file image topic has delete probleam.');
                         return redirect('/article/create')->with('error', 'these was a probleam create Article!');
                     }                
                 }
                    return redirect('/article/edit/'.$id)->with('error', 'these was a probleam create article!'); 
                };
               }              
           }else{
               $files = $request->input('content-image-temp');
               foreach($files as $file ){
                  $tmpContent = $tmpContent.$file.",";
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
                return redirect('/article/create')->with('error', 'these was a probleam create Article!');
            }            
           }           
           return redirect('/article/edit/'.$id)->with('error', 'these was a probleam create article!');
       } 
       return $tmpContent;
    }
    //delete article with id
    public function deleteArticle(Request $request, $id){
        $pathfile = public_path('storage/gallery/');
        if($id){
            $imagesTopic = null;
            $spilts;
            $articles = DB::select('select * from article where type = 0 and id = ? Order by create_at DESC', [$id]);
            foreach ($articles as $article) {
                $imagesTopic = $article->topic_picture;
                $spilts = explode(",",$article->content_picture); 
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
                    session()->flash('error', 'these was a probleam create Article!');
                    return response()->json(['error' => 'these was a probleam create Article!']);
                }                
            }

            foreach ($spilts as $spilt) {Log::notice($spilt);
                if(file_exists($pathfile.$spilt)){
                    Log::notice('file image content has delete.');
                    try{
                        File::delete($pathfile.$spilt);
                    }catch(Exception $e){
                        Log::error('file image topic has delete probleam.');
                        session()->flash('error', 'these was a probleam create Article!');
                        return response()->json(['error' => 'these was a probleam create Article!']);
                    }    
                }
            } 

            $deleted = DB::delete('delete from article where id = ?',[$id]);
            if($deleted > 0){
                //return redirect('/article/view')->with('status', 'News delete successfully!');
                session()->flash('status', 'News delete successfully!');
                return response()->json(['status' => 'News delete successfully!']);
            }
        }
        session()->flash('error', 'these was probleam delete news -> status code : '.app('Illuminate\Http\Response')->status());
        return response()->json(['error' => 'these was probleam delete news -> status code : '.app('Illuminate\Http\Response')->status()]);      
    }
    //store article
    public function storeArticle(Request $request){
        /**image store path*/
        $destinationPath = public_path('storage/gallery/');
        $imageTopic = null;
        $imageContent = null;
        $contentCombine= null;
        $contentArray = array();
        try{
            /**validate file type */
            $rules = [
            'topic-image' => 'required',
            'topic-image.*' => 'mimes:jpeg,png,jpg,bmp,gif,svg',
            'content-image' => 'required',
            'content-image.*' => 'mimes:jpeg,png,jpg,bmp,gif,svg',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                Log::error($validator->errors()->all());  
                return redirect('/article/create')->withErrors($validator); 
            }      

            if ($request->hasFile('topic-image') && $request->hasFile('content-image')) {
                
                $fileTopic = $request->file('topic-image');
                /**create new the image name*/
                $imageTopic = pathinfo($fileTopic->getClientOriginalName(), PATHINFO_FILENAME).time();
                $imageTopic = base64_encode($imageTopic);
                $imageTopic = $imageTopic.'.'.$fileTopic->getClientOriginalExtension();
                /** move file to storeage */
                 if(!$fileTopic->move($destinationPath, $imageTopic)){
                    Log::error("these was a problem save file topic.");   
                    if (file_exists($destinationPath.$imageTopic)) {
                        Log::notice("these was a problem files is delete.");       
                        try{
                            File::delete($destinationPath.$imageTopic);
                        }catch(Exception $e){
                            Log::error('file image topic has delete probleam.');
                            return redirect('/article/create')->with('error', 'these was a probleam create Article!');
                        }            
                    }  
                    return redirect('/article/create')->with('error', 'these was a probleam create Article!'); 
                };

                $fileContents = $request->file('content-image');
                foreach($fileContents as $file){
                    $imageContent = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).time();
                    $imageContent = base64_encode($file);
                    $imageContent = $imageContent.'.'.$file->getClientOriginalExtension();

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
                                return redirect('/article/create')->with('error', 'these was a probleam create Article!');
                            }              
                        }  
                        return redirect('/article/create')->with('error', 'these was a probleam create Article!'); 
                    };
                }

                $topic = $request->input('article-topic');
                $content = $request->input('article-content');

                /**store topic content images to DB. */
                DB::insert('insert into article (topic, content, topic_picture, content_picture, type) values (?, ?, ?, ?, ?)', 
                    [$topic, $content, $imageTopic, $contentCombine,0]);
    
                return redirect('/article/view')->with('status', 'Article create successfully');
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
                    return redirect('/article/create')->with('error', 'these was a probleam create Article!');
                }            
            }  
            foreach($contentArray as $file){
                if (file_exists($file)) {
                    Log::notice("these was a problem files is delete.");       
                    try{
                        File::delete($destinationPath.$file);
                    }catch(Exception $e){
                        Log::error('file image topic has delete probleam.');
                        return redirect('/article/create')->with('error', 'these was a probleam create Article!');
                    }            
                } 
            }          
            return redirect('/article/create')->with('error', 'these was a probleam create news!');
        } 
        return redirect('/article/create')->with('error', 'these was a probleam create news!');
    }
}
