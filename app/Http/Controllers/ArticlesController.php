<?php

namespace App\Http\Controllers;
use App\Model\Article;
use Illuminate\Http\Request;
class ArticlesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //Create Article
    public function add(Request $request){
        $article = Article::create($request->all());
        return response()->json($article);
    }

    //Edit Article
    public function edit(Request $request, $id){
        $article = Article::find($id);
        $article->title = $request->input('title');
        $article->article = $request->input('article');
        $article->published = $request->input('published');
        $article->view_count = $request->input('view_count');
        $article->user_id = $request->input('user_id');
        $article->cover_image = $request->input('cover_image');
        $article->slug = $request->input('slug');
        $article->category_id = $request->input('category_id');
        $article->save();
        return response()->json($article);
    }

    //Delete Article
    public function delete($id){
        $article = Article::find($id);
        $article->delete();
        return response()->json('Article Deleted');
    }

    //List all articles
    public function index(){
        $article = Article::all();
        return response()->json($article);
    }

    //view post
    public function view($id){
        $article = Article::find($id);
        return response()->json($article);
    }
}
