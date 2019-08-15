<?php 
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Article extends Model{
    protected $fillable =['title','article','slug','published','user_id','category_id','cover_image','comment_count'];

    public function users(){
        return $this->belongsTo('App\Users');
    }
    public function categories(){
        return $this->belongsTo('App\Categories');
    }
}

?>
