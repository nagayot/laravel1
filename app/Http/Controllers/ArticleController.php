<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\User;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * 記事一覧画面の表示 & 検索機能
     * @param str $keyword
     * @return view
     */
    public function showIndex(Request $request)
    {
        $user = Auth::user();            // ログインユーザーの情報を取得

        $articles = Article::with('user')->get();

        $keyword = $request->keyword;    // name = "keyword"の検索窓に入力されたワードを$requestにして$keywordへ代入

        if(!empty($keyword)){
            $articles = Article::where('id','LIKE','%'.$keyword.'%')
                        ->orwhere('title','LIKE','%'.$keyword.'%')
                        ->orwhere('content','LIKE','%'.$keyword.'%')
                        ->orderBy('created_at','desc')->paginate(5);
            return response()->json($articles);
        }else {
            $articles = Article::orderBy('created_at','desc')->paginate(5);
        };

        return view('article.index', ['user' => $user, 'articles' => $articles, 'keyword' => $keyword]);
    }

    /**
     * 記事詳細画面の表示
     * @param int $id
     * @return view
     */
    public function showDetail(Request $request, $id)
    {
        $article = Article::find($id);      //記事IDの取得

        $user = Auth::user();               // ログインユーザーの情報を取得

        $user_id = Auth::id();

        $articleUserId = optional($article)->user_id; //記事に結びついてるユーザーIDの取得

        if($user_id != $articleUserId)
        {
            \Session::flash('err_msg', 'あなたの記事ではないので閲覧できません');
            return redirect(route('articles'));
        }

        if(is_null($article))
        {
            \Session::flash('err_msg', '該当する記事がありません');
            return redirect(route('articles'));
        }

        return view('article.detail', ['user' => $user, 'user_id' => $user_id, 'article' => $article]);
    }

    /**
     * 記事登録画面を表示する
     *
     * @return view
     */
    public function showPost()
    {
        return view('article.form');
    }

    /**
     * 記事を登録する(画像付き)
     * 
     * @return view
     */
    public function doPost(ArticleRequest $request)
    {
        $article = new Article;

        $user_id = Auth::id();               // ログイン中のユーザーidの取得

        $article = $request->all();          // 記事のデータを受け取る

        $article['user_id'] = $user_id;

        $image_name = $request->file('image');
        if(!empty($image_name)){
            $image_name = $request->file('image')->getPathname();        // 画像のpathnameをgetPathname()で取得して、storeAsで$imageに渡す。
            $image = $request->file('image')->storeAs('', $image_name);
        }

        // 記事を登録
        \DB::beginTransaction();
        try {
            Article::create($article);
            \DB::commit();
        } catch(\Throwable $e){
            \DB::rollback();
            //abort(500);
            return ['e' => $e];       //エラー内容を表示してくれる
        }

        \Session::flash('err_msg', '記事を投稿しました！');

        return redirect(route('articles'));
    }

    /**
     * 記事編集画面を表示する
     * @param int $id
     * @return view
     */
    public function showEdit($id)
    {
        $article = Article::find($id);      //記事IDの取得
        $user = Auth::user();               // ログインユーザーの情報を取得
        $user_id = Auth::id();
        $articleUserId = $article->user_id; //記事に結びついてるユーザーIDの取得

        if($user_id != $articleUserId)
        {
            \Session::flash('err_msg', 'あなたの記事ではないので編集できません');
            return redirect(route('articles'));
        }

        if(is_null($article)){
            \Session::flash('err_msg', '該当するデータがありません');
            return redirect(route('articles'));
        }
        return view('article.edit', ['article' => $article]);
    }

    /**
     * 記事を更新する
     * 
     * @return view
     */
    public function doEdit(ArticleRequest $request ,Article $article)
    {
        $inputs = $request->all();

        $user = Auth::user();               // ログインユーザーの情報を取得
        $user_id = Auth::id();

        \DB::beginTransaction();

        try {
            $article = Article::find($inputs['id']);
            $article->fill([
                'title' => $inputs['title'],
                'content' => $inputs['content']
            ]);
            $article->save();
            \DB::commit();
        } catch(\Throwable $e){
            \DB::rollback();
            abort(500);
        }

        \Session::flash('err_msg', '記事を更新しました！');
        return redirect(route('articles'));
    }

    /**
     * 記事を削除する
     * @param int $id
     * @return view
     */
    public function doDelete($id)
    {
        $article = Article::find($id);      //記事IDの取得
        $user = Auth::user();               // ログインユーザーの情報を取得
        $user_id = Auth::id();
        $articleUserId = $article->user_id; //記事に結びついてるユーザーIDの取得

        if($user_id != $articleUserId)
        {
            \Session::flash('err_msg', 'あなたの記事ではないので削除できません');
            return redirect(route('articles'));
        }

        if(empty($id)){
            \Session::flash('err_msg', '該当するデータがありません');
            return redirect(route('articles'));
        }

        try {
            Article::destroy($id);
        } catch(\Throwable $e){
            abort(500);
        }

        \Session::flash('err_msg', '削除しました');
        return redirect(route('articles'));
    }

}