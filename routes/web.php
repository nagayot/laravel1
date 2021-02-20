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

// 記事一覧画面の表示
Route::get('/article/index', 'ArticleController@showIndex')->name('articles');

// 記事投稿画面の表示
Route::get('/article/letter', 'ArticleController@showPost')->name('letter');

// 記事の登録
Route::post('/article/post', 'ArticleController@doPost')->name('post');

// 記事詳細ページの表示
Route::get('/article/{id}', 'ArticleController@showDetail')->name('detail');

// 記事編集ページの表示
Route::get('/article/edit/{id}', 'ArticleController@showEdit')->name('edit');

// 記事を更新
Route::post('/article/update', 'ArticleController@doEdit')->name('update');

// 記事の削除
Route::post('/article/delete/{id}', 'ArticleController@doDelete')->name('delete');

// ユーザー関連

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

// 非同期検索機能
Route::get('/article/index/{keyword}', 'ArticleController@showIndex')->name('keyword');