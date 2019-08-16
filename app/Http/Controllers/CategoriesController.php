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
            return ResponseBuilder::result(200,'Category Saved', $category);
        }
        return ResponseBuilder::result(201,'Error saving category' );
    }
    public function edit(Request $request, $id){
        $category =  Category::find($id);
        $category->category = $request['category'];
        $category->article_count = 0;
        if($category->save()){
            return ResponseBuilder::result(200,'Category Updated', $category);
        }
        return ResponseBuilder::result(201,'Error updating category' );
    }

    public function view($id){
        $category =  Category::find($id)->with('articles','articles.tags','articles.comments')->where('id',$id)->get();
        
        if($category != null){
            return ResponseBuilder::result(200,'Categories', $category);
        }
        return ResponseBuilder::result(201,'Category not found' );
    }

    public function index(){
        $categories = Category::all();
        if($categories != null){
            return ResponseBuilder::result(200,'Categories', $categories);
        }
        return ResponseBuilder::result(201,'Category not found' );
    }
}
?>
