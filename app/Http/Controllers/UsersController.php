<?php

namespace App\Http\Controllers;
use App\Model\User ;
use Illuminate\Http\Request;
use Illuminate\Hashing\BcryptHasher;

class UsersController extends Controller
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
        $request['api_token'] = uniqid(str_random(60));
        $request['password'] = app('hash')->make($request['pasword']);
        $user = User::create($request->all());
        return response()->json($user);
    }

    //Edit Article
    public function edit(Request $request, $id){
        $article = User::find($id);
        $article->username = $request->input('username');
        $article->first_name = $request->input('first_name');
        $article->last_name = $request->input('last_name');
        $article->email = $request->input('email');
        $article->bio = $request->input('bio');
        $article->image = $request->input('image');
        
       
        $article->update($request->all());
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
