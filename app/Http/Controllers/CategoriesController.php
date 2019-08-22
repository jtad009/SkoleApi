<?php

namespace App\Http\Controllers;
use App\Model\Category;

use Illuminate\Http\Request;
use App\Http\Helper\ResponseBuilder;


use Illuminate\Database\Eloquent\ModelNotFoundException;
class CategoriesController extends Controller
{
    public function add(Request $request){
        $category = new Category;
        $category->category = $request['category'];
        $category->article_count = 0;
        if($category->save()){
            return response()->json(ResponseBuilder::result(200,'Category Saved', $category), 200);
        }
        return response()->json(ResponseBuilder::result(201,'Error saving category' ), 201);
    }
    public function edit(Request $request, $id){
        try{
            $category =  Category::findOrFail($id);
        $category->category = $request['category'];
        $category->article_count = 0;
        if($category->save()){
            return response()->json(ResponseBuilder::result(200,'Category Updated', $category), 200);
        }
        return response()->json(ResponseBuilder::result(201,'Error updating category') , 201);
    }catch(ModelNotFoundException $e){
        return response()->json(ResponseBuilder::result(404,'Category not found.', $e->getMessage()) , 404);
    }
        
    }

    public function view($id){
        try{
            $category =  Category::findOrFail($id)->with('articles','articles.tags','articles.comments', 'articles.categories')->where('id',$id)->get();
        
        if($category != null){
            return response()->json( ResponseBuilder::result(200,'Categories', $category),  200);
        }
    }catch(ModelNotFoundException $e){
        return response()->json(ResponseBuilder::result(404,'Category not found.',$e->getMessage()) , 404);
    }
    }

    public function index(){
        $categories = Category::all();
        if($categories != null){
            return ResponseBuilder::result(200,'Categories', $categories);
        }
        return ResponseBuilder::result(201,'Category not found' );
    }
}
