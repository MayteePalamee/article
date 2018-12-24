<?php

namespace App\Http\Controllers\Views;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ViewController extends Controller
{
    //
    public function views(){
        /**select carosel */
        $carousel = DB::select('select * from carousel Order by create_at DESC limit 3');
        /**select news limit 3 */
        $news = DB::select('select * from article where type = 1 Order by create_at DESC limit 3');
        foreach($news as $new){
            $new->topic = strlen($new->topic) > 30 ? substr( $new->topic,0, 30) . '...': $new->topic ;
            $new->content = strlen($new->content) > 130 ? substr( $new->content,0, 130) . '...' : $new->content;
        }
        /**select article * */
        $articles = DB::select('select * from article where type = 0 Order by create_at DESC limit 6');
        foreach($articles as $article){
            $article->topic = strlen($article->topic) > 30 ? substr( $article->topic,0, 30) . '...': $article->topic ;
            $article->content = strlen($article->content) > 130 ? substr( $article->content,0, 130) . '...' : $article->content;
        }
        return view('pages.views.articles.views')->with(['carousels'=> $carousel,'news' => $news,'articles' => $articles]);
    }
    //view news page
    public function viewNews(){
        session()->flash('activeNews' , 'active-news');
        return view('pages.views.articles.topic')->with(['hnews'=>'News']);
    }
    /**list news */
    public function listNews(){
        $news = DB::select('select * from article where type = 1 Order by create_at DESC');
        foreach($news as $new){
            $new->topic = strlen($new->topic) > 100 ? substr( $new->topic,0, 100) . '...': $new->topic ;
            $new->content = strlen($new->content) > 300 ? substr( $new->content,0, 300) . '...' : $new->content;
        }
        return response()->json($news);
    }
    //view article page
    public function viewArticle(){
        session()->flash('activeArticle' , 'active-article');
        return view('pages.views.articles.topic')->with(['hnews'=>'Articale']);
    }
    //list articale
    public function listArticle(){
        $articales = DB::select('select * from article where type = 0 Order by create_at DESC');
        foreach($articales as $articale){
            $articale->topic = strlen($articale->topic) > 100 ? substr( $articale->topic,0, 100) . '...': $articale->topic ;
            $articale->content = strlen($articale->content) > 300 ? substr( $articale->content,0, 300) . '...' : $articale->content;
        }
        return response()->json($articales);
    }
    //view contact page
    public function contact(){
        $data = DB::select('select * from contact');
        session()->flash('onload','load');
        return view('pages.views.articles.contact')->with(['data' => $data]);
    }
}
