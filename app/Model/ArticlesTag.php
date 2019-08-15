<?php 
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class ArticlesTag extends Model{
    protected $fillable =['article_id','tag_id'];
}

?>
