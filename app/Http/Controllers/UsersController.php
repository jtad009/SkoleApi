<?php

namespace App\Http\Controllers;

use App\Http\Helper\ResponseBuilder;
use App\Http\Helper\UploadHelper;
use App\User ;
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
        $pwd = app('hash')->make($request['pasword']);
        
        $user = new User;
        $user->image = UploadHelper::upload($_FILES['image']);
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->api_token = $request['api_token'];
        $user->password = $pwd;
        $user->article_count = 1;
        $user->bio = $request['bio'];
        if($user->save()){
            return ResponseBuilder::result(200, 'User Saved', $user);
        }
        
         return ResponseBuilder::result(201, 'User Not Saved', null);
    }

    //Edit Article
    public function edit(Request $request, $id){
        $request['api_token'] = uniqid(str_random(60));
        $pwd = app('hash')->make($request['pasword']);
        $user = User::find($id);
        $user->username = $request->input('username');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->bio = $request->input('bio');
        $user->image = UploadHelper::upload($_FILES['image']);
        $user->api_token = $request['api_token'];
        $user->password = $pwd;
       
        $user->bio = $request['bio'];
       
        if($user->save()){
            return ResponseBuilder::result(200, 'User Updated', $user);
        }
        return response()->json([
            'message' => 'Error updating  user.','status'=>201],201);
    }

    //Delete Article
    public function delete($id){
        $user = User::find($id);
        if(!is_null($user)){
            $user->delete();
        return response()->json('Article Deleted');
        }
        return response()->json([
            'message' => 'Error deleting this user, user not found','status'=>404], 404);
    }

    //List all articles
    public function index(){
        $user = User::all();
        return response()->json($user,200);
    }

    //view post
    public function view($id){
        $user = User::find($id);
        
        return is_null($user) ? response()->json([ 'message' => 'User does not exist','status'=>404], 404) : response()->json($user);
    }

    //View author along with all their posts
    public function viewWithArticles($id){
        $user = User::with('articles','articles.comments','articles.tags','articles.categories')->where('id',$id)->get();
        return  is_null($user) || $user->count() == 0 ? response()->json([ 'message' => 'User does not exist','status'=>404], 404) : response()->json($user);
    }
}
