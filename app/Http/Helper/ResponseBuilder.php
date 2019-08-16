<?php
namespace App\Http\Helper;

class ResponseBuilder {

    public static function result($status = "", $information = "", $data=""){
        return [
            'status'=>$status,
            'message'=>$information,
            'data'=>$data
        ];
    }
}
?>
