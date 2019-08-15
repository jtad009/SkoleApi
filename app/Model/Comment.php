<?php 
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model{
    protected $fillable =['article_id','comment','published','name','email','website'];
}

?>
