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
/**
     * Generate a random UUID version 4
     *
     * Warning: This method should not be used as a random seed for any cryptographic operations.
     * Instead you should use the openssl or mcrypt extensions.
     *
     * @see http://www.ietf.org/rfc/rfc4122.txt
     * @return string RFC 4122 UUID
     * @copyright Matt Farina MIT License https://github.com/lootils/uuid/blob/master/LICENSE
     */
    public  function uuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            // 16 bits for "time_mid"
            mt_rand(0, 65535),
            // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
            mt_rand(0, 4095) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535)
        );
    }
}
?>