<?php 
/**
 require_once "Encryption.class.php";
 $oEncryption = new Encryption;
 echo "加 密: ".$oEncryption->_encrypt("sudhir");
 echo "<br/>";
 echo "解 密: ".$oEncryption->_decrypt($oEncryption->enc("sudhir"));
*/
class Encryption { 
    /** 
     *  tollent 
     * 
     *  @access public 
     */ 
    var $skey = "-_-donthackit-_-";
    /**
     *  set cookie
     * 
     *  @access public 
     */ 
    public function safe_b64encode($string) {
        $data = base64_encode($string); 
        $data = str_replace(array('+','/','='),array('-','_',''),$data); 
        return $data; 
    } 
    /** 
     *  decrypt Cookie
     * 
     *  @access public 
     */ 
    public function safe_b64decode($string) { 
        $data = str_replace(array('-','_'),array('+','/'),$string); 
        $mod4 = strlen($data) % 4; 
        if ($mod4) { 
            $data .= substr('====', $mod4); 
        } 
        return base64_decode($data); 
    } 
    /** 
     *  mcrypt library
     * 
     *  @access public 
     */ 
    public static function _encrypt($value){
        $secrect_key = md5("skey");
        if(PHP_VERSION < '5.6'){
            if(!$value){return false;}
            $text = $value;
            $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
            $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, skey, $text, MCRYPT_MODE_ECB, $iv);
            return trim(self::safe_b64encode($crypttext));
        }else{
            if(!$value){return false;}
            $text = $value;
            $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
            $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $secrect_key, $text, MCRYPT_MODE_ECB, $iv);
            return trim(self::safe_b64encode($crypttext));
        }
    } 
    /** 
     * 
     *  @access public 
     */ 
    public static function _decrypt($value){
        $secrect_key = md5("skey");
        if(PHP_VERSION < '5.6') {
            if (!$value) {
                return false;
            }
            $crypttext = self::safe_b64decode($value);
            $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
            $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, skey, $crypttext, MCRYPT_MODE_ECB, $iv);
            return trim($decrypttext);
        }else{
            if (!$value) {
                return false;
            }
            $crypttext = self::safe_b64decode($value);
            $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
            $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $secrect_key, $crypttext, MCRYPT_MODE_ECB, $iv);
            return trim($decrypttext);
        }
    } 
    
    
} 



