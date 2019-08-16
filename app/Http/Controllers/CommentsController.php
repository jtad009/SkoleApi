<?php

namespace App\Http\Controllers;

use App\Http\Helper\ResponseBuilder;
use App\Model\Comment;
use App\Model\Article;
use Illuminate\Http\Request;
class CommentsController extends Controller
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

    //add comment
    public function add(Request $request){
        $comment = new Comment;
        $comment->article_id = $request['article_id'];
        $comment->comment = $request['comment'];
        $comment->published = 1;
        $comment->name = $request['name'];
        $comment->email = $request['email'];
        $comment->website = $request['website'];
        if($comment->save()){
            $article = Article::find($request['article_id']);
            $article->comment_count = ((int) $article->comment_count)+1;
            $article->update();
            //dd($article->comment_count);
            //$comment->articles()->where('id',$request['article_id'])->update(['comment_count',(((int) $article->comment_count)+1)]);
            return ResponseBuilder::result(200,'Comment Saved', $comment);
        }
        return ResponseBuilder::result(201, 'Comment not saved');
    }
    public function delete($id){
        $comment = Comment::find($id);
        if(!is_null($comment)){
            $comment->delete();
            return ResponseBuilder::result(200,'success', 'Comment Deleted');
            }
          
         return response()->json([
            'message' => 'Error deleting this comment, comment not found','status'=>404], 404);
    }
}
