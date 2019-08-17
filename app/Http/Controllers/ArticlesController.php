<?php

namespace App\Http\Controllers;

use App\Model\Article;
use App\Model\Tag;
use Illuminate\Http\Request;
use App\Http\Helper\ResponseBuilder;
use App\Http\Helper\UploadHelper;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
    public function add(Request $request)
    {
        // dd($request->input('cover_image'));
        // dd($_FILES);
        $article = new Article;
        $article->id = strlen($request->input('id')) > 0 ? $request->input('id'): UploadHelper::uuid();
        $article->title = $request->input('title');
        $article->article = $request->input('article');
        $article->published = $request->input('published');
        $article->view_count = $request->input('view_count');
        $article->user_id = $request->input('user_id');
        $article->cover_image = UploadHelper::upload($_FILES["cover_image"], 'blog');
        $article->slug = str_replace(' ', '-', $request->input('title'));
        $article->category_id = $request->input('category_id');
       
        if ($article->save()) {
            $tags = Tag::find($request->input('tag_id'));
            $article->tags()->attach($tags);

            return response()->json(ResponseBuilder::result(200, 'Article Saved', $article), 200);
        }
        return response()->json(ResponseBuilder::result(201, 'Error saving article', $article), 201);
    }

    //Edit Article
    public function edit(Request $request, $id)
    {
        try {
            $article = Article::findOrFail($id);

            $article->title = $request->input('title');
            $article->article = $request->input('article');
            $article->published = $request->input('published');
            $article->view_count = $request->input('view_count');
            $article->user_id = $request->input('user_id');
            $article->cover_image = UploadHelper::upload($_FILES["cover_image"], 'blog');
            $article->slug = str_replace(' ', '-', $request->input('title'));
            $article->category_id = $request->input('category_id');
            if ($article->save()) {
                return ResponseBuilder::result(200, 'success', $article);
            }
            return ResponseBuilder::result(201, 'Error saving data', $article);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { 
            return response()->json(ResponseBuilder::result(404, 'Not Found', $e->getMessage()), 404);
        }
    }

    //Delete Article
    public function delete($id)
    {
        try {
            $article = Article::findOrFail($id);
            $article->delete();
            return response()->json(ResponseBuilder::result(200, 'success', 'Article Deleted'), 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                ResponseBuilder::result(404, 'Not Found', $e->getMessage()),
                404
            );
        }
    }

    //List all articles
    public function index()
    {
        $article = Article::all();
        return response()->json(ResponseBuilder::result(200, 'success', $article), 200);
    }

    //view post
    public function view($id)
    {
        try {
            $article = Article::findOrFail($id)->with('categories', 'users', 'comments', 'tags')->get();
            // dd($id);
            return response()->json(ResponseBuilder::result(200, 'success', $article), 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(ResponseBuilder::result(404, 'Not Found', $e->getMessage()), 404);
        }
    }
}
