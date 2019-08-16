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

    /**
     * Generate a random UUID version 4
     *
     * Warning: This method should not be used as a random seed for any cryptographic operations.
     * Instead you should use the openssl or mcrypt extensions.
     *
     * @see http://www.ietf.org/rfc/rfc4122.txt
     * @return string RFC 4122 UUID
     * @copyright Matt Farina MIT License https://github.com/lootils/uuid/blob/master/LICENSE
     */
    public  function uuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            // 16 bits for "time_mid"
            mt_rand(0, 65535),
            // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
            mt_rand(0, 4095) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535)
        );
    }
    //Create Article
    public function add(Request $request)
    {
        $article = new Article;
        $article->id = $this->uuid();
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

            return ResponseBuilder::result(200, 'success', $article);
        }
        return ResponseBuilder::result(201, 'Error saving article', $article);
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
