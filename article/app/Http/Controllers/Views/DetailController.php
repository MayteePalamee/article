<?php

namespace App\Http\Controllers\Views;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DetailController extends Controller
{
    //
    public function newdetail(Request $request, $id){
        $news = DB::select('select * from article where id = ? and type = 1 Order by create_at DESC', [ $id]);
        session()->flash('activeNews' , 'active-news');
        return view('pages.views.articles.detail')->with(['datas' => $news]);
    }

    public function articledetail(Request $request, $id){
        $article = DB::select('select * from article where id = ? and type = 0 Order by create_at DESC', [ $id]);  
        session()->flash('activeArticle' , 'active-article');
        return view('pages.views.articles.detail')->with(['datas' => $article]);
    }
}
