<?php 
namespace App\Model;
use Illuminate\Database\Eloquent\Model;


class Article extends Model{
    
    protected $fillable =['title','article','slug','published','user_id','category_id','cover_image','comment_count'];
    
  
    public function getIncrementing()
    {
        return false;
    }
    public function users(){
        return $this->belongsTo('App\User','user_id');
    }
    public function categories(){
        return $this->belongsTo('App\Model\Category','category_id');
    }
    public function comments(){
        return $this->hasMany('App\Model\Comment');
    }
    public function tags(){
        return $this->belongsToMany('App\Model\Tag','article_tag','article_id','tag_id' )->withTimestamps();
    }
}

?>
