<?php 
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Article extends Model{
    protected $fillable =['title','article','slug','published','user_id','category_id','cover_image','comment_count'];
}

?>
