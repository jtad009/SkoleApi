<?php

namespace App\Http\Controllers;
use App\Model\Tag;

use Illuminate\Http\Request;
use App\Http\Helper\ResponseBuilder;

class TagsController extends Controller
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
    public function add(Request $request){
        $Tag = new Tag;
        $Tag->tag = $request['tag'];
        // $Tag->article_count = 0;
        if($Tag->save()){
            return ResponseBuilder::result(200,'Tag Saved', $Tag);
        }
        return ResponseBuilder::result(201,'Error saving Tag' );
    }
    public function edit(Request $request, $id){
        $Tag =  Tag::find($id);
        $Tag->tag = $request['tag'];
        // $Tag->article_count = 0;
        if($Tag->save()){
            return ResponseBuilder::result(200,'Tag Updated', $Tag);
        }
        return ResponseBuilder::result(201,'Error updating Tag' );
    }

    public function view($id){
        // dd($id);
        try{
            $Tag =  Tag::findOrFail($id)->with('articles','articles.comments','articles.categories')->where('tags.id', $id)->get();
        
        if($Tag != null){
            return ResponseBuilder::result(200,'Tags', $Tag);
        }
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { 
        return response()->json(ResponseBuilder::result(404, 'Tag not found', $e->getMessage()), 404);
    }
        
    }

    public function index(){
        $tags = Tag::all();
        if($tags != null){
            return ResponseBuilder::result(200,'Tags', $tags);
        }
        return ResponseBuilder::result(201,'Tag not found' );
    }
    //
}
