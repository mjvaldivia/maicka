<?php

Class App_Modulo_Encriptar_Base{
    
    /**
     * Variables que se van a usar en la encriptacion 
     */
    protected $_llave 		= "Ftk5jdnDtpRdssWs3sW/$";// Llave encriptacion
    protected $_iv 		= "jTjdSfYf$";
    protected $_input 		= "";// texto a encriptar
    protected $_bit_check	= 128; // bit amount for diff algor.
    
    /*
     * Encriptar
     */
    public function encriptar($texto){
        $tc_encrypt = $this->_encrypt($texto, $this->_llave, $this->_iv, $this->_bit_check);
        return $tc_encrypt;
    }
    
     /**
     * Desencriptando...
     * @param string $numero
     * @return string 
     */
    public function desencriptar($string){
        $tc_desencrypt 	= $this->decrypt($string, $this->_llave, $this->_iv, $this->_bit_check);
        return $datos;
    }
    
    /**
     * Funcion para encriptar 
     * @param string $text texto a encriptar
     * @param string $key
     * @param string $iv
     * @param int $bit_check
     * @return string 
     */
    private function _encrypt($text, $key, $iv, $bit_check) {
        $text_num 	= str_split($text,$bit_check);
        $text_num 	= $bit_check-strlen($text_num[count($text_num)-1]);
        for($i=0;$i<$text_num; $i++) {
            $text = $text . chr($text_num);
        }
        $cipher 	= \mcrypt_module_open(MCRYPT_TRIPLEDES,'','cbc','');
        \mcrypt_generic_init($cipher, $key, $iv);
        $decrypted 	= \mcrypt_generic($cipher,$text);
        \mcrypt_generic_deinit($cipher);
        return base64_encode($decrypted);
    }
    
    /**
     * Funcion para desencriptar 
     * @param string $encrypted_text
     * @param string $key
     * @param string $iv
     * @param int $bit_check
     * @return string 
     */
    private function _decrypt($encrypted_text,$key,$iv,$bit_check){
        $cipher 	= \mcrypt_module_open(MCRYPT_TRIPLEDES,'','cbc','');
        \mcrypt_generic_init($cipher, $key, $iv);
        $decrypted 	= mdecrypt_generic($cipher,base64_decode($encrypted_text));
        \mcrypt_generic_deinit($cipher);
        $last_char	= substr($decrypted,-1);

        for($i=0;$i<$bit_check-1; $i++){
            if(chr($i)==$last_char){
                $decrypted = substr($decrypted,0,strlen($decrypted)-$i);
                break;
            }
        }
        return $decrypted;
    }
}

