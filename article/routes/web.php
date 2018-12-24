<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/**Front views Article */
Route::get('/', 'Views\ViewController@views');
Route::get('/contact', 'Views\ViewController@contact')->name('contact');
Route::post('/mail', 'Mail\MailController@htmlmail');

Route::prefix('/views')->group(function () {
    Route::get('/news', 'Views\ViewController@viewNews');
    Route::get('/listnews', 'Views\ViewController@listNews');
    Route::get('/articale', 'Views\ViewController@viewArticle');
    Route::get('/listarticale', 'Views\ViewController@listArticle');
});

Route::prefix('/views')->group(function () {
    Route::get('/news/detail/{id}', 'Views\DetailController@newdetail');
    Route::get('/articale/detail/{id}', 'Views\DetailController@articledetail');
});
/**Management Article */
Route::get('/management', function () {
    return view('pages.management.welcome')->with(['contactTarget' => 'load']);
});

/**Contact store*/
Route::prefix('/contact')->group(function () {
    Route::post('/create', 'Contact\ContactController@storeContact');
    Route::get('/create', 'Contact\ContactController@viewsContact');
    Route::get('/select', 'Contact\ContactController@selectContact');
    Route::get('/views', 'Contact\ContactController@viewsContact');
    Route::get('/edit/{id}', 'Contact\ContactController@editContact');
    Route::post('/update/{id}', 'Contact\ContactController@updateContact');
    Route::get('/delete/{id}', 'Contact\ContactController@deleteContact');
});

/**Manage Bandner */
/**Adding Bandner */
Route::prefix('/banner')->group(function () {
    Route::get('/views', 'Banner\BannerController@viewsBanner');
    Route::get('/delete/{id}', 'Banner\BannerController@deleteBanner');
    Route::get('/banner', 'Banner\BannerController@createBanner');
    Route::post('/banner', 'Banner\BannerController@storeBanner');
});
/**Manage Article */
/**view page article */
Route::prefix('/article')->group(function () {
    Route::get('/view', 'Article\ArticleController@manageArticle');
    Route::get('/select', 'Article\ArticleController@selectArticle');
    /**view create article */
    Route::get('/create', 'Article\ArticleController@createArticle');
    Route::post('/store', 'Article\ArticleController@storeArticle');
    /**delete article */
    Route::get('/delete/{id}', 'Article\ArticleController@deleteArticle');
    /**edit aritcle */
    Route::get('/edit/{id}', 'Article\ArticleController@editArticle');
    Route::post('/replace/{id}', 'Article\ArticleController@replaceArticle');
});
/**Manage News */
/**view page news  */
Route::prefix('/news')->group(function () {
    Route::get('/view', 'News\NewsController@viewNews');
    Route::get('/select', 'News\NewsController@selectNews');
    /**view create news */
    Route::get('/create', 'News\NewsController@createNews');
    Route::post('/store', 'News\NewsController@storeNews');
    /**delete news */
    Route::get('/delete/{id}', 'News\NewsController@deleteNew');
    /**edit bews */
    Route::get('/edit/{id}', 'News\NewsController@editNews');
    Route::post('/replace/{id}', 'News\NewsController@replaceNews');
});