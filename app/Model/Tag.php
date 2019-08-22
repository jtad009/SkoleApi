<?php 
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model{
    protected $fillable =['tag'];

    public function articles(){
        return $this->belongsToMany('App\Model\Article','article_tag','tag_id','article_id')->withTimestamps();;
    }
}

?>
