<?php 
namespace App\Http\Helper;

class UploadHelper{
     
    /**
     * Upload Image data to the server
     * @param type $data
     * @return string
     * @throws InternalErrorException
     */
    public static function upload($data, $blog="user") {
        // dd($data);
        // $filename = "";
        $allowed = array('png', 'jpg','jpeg','pdf','doc','docx','xls','xlsx','ppt','csv');
        // if (!in_array(substr(strrchr($data['name'], '.'), 1), $allowed)):
        //    // throw new InternalErrorException("Error Processing Request", 1);
        // elseif (is_uploaded_file($data['tmp_name'])) :
            $filename =  uniqid().'-'.$data['name'];
            // echo $filename.'dfd';
            switch($blog){
                case 'blog':
                    move_uploaded_file($data['tmp_name'], '../public/uploads/blog/'. $filename);
                break;
                case 'user':
                    move_uploaded_file($data['tmp_name'], '../public/uploads/'. $filename);
                break;
            }
            
        // endif;
        return $filename;
    }

}
?>