<?php 
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class ArticlesTags extends Model{
    protected $table = 'article_tag';
    protected $fillable =['article_id','tag_id'];

    public function articles(){
        return $this->belongsTo('App\Model\Article','article_id');
    }
    public function tags(){
        return $this->belongsTo('App\Model\Tag','tag_id');
    }
}

?>
