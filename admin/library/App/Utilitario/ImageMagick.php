<?php
class App_Utilitario_ImageMagick extends App_Utilitario_Exec{
    
    /**
     * Ejecuta el comando convert
     * @return string 
     */
    public function convert(){
        $this->_exec("convert");
    }
    
    /**
     * 
     * @param string $path
     */
    public function imagenOriginal($path){
        $this->_armaParametros("\"".$path."\"");
    }
    
    /**
     * 
     * @param string $path
     */
    public function imagenDestino($path){
        $this->_armaParametros("\"".$path."\"");
    }
    
    /**
     * Calidad de la imagen final
     * @return string
     */
    public function setCompressQuality(){
        return "-colors 256 -quality 95 -depth 8";
    }
    
    /**
     * Hace que el comando Convert sea ejecutado en segundo plano
     * liberando al script php 
     * @return string 
     */
    public function setConvertNull(){
        if (PHP_SHLIB_SUFFIX == "dll") {
            $this->_armaParametros("> NUL");
        }else{
            $this->_armaParametros("> /dev/null &");
        }
        
    }
    
     /**
     * Retorna los parametros de Convert
     * Para setear donde estara el centro de la imagen
     * @return string 
     */
    public function setGravity(){
        $this->_armaParametros("-gravity center");
    }
    
    /**
     * Setea el tamaño de la imagen
     * @param type $width
     * @param type $height
     */
    public function setSize($width = 100, $height = 100){
        if($width<=0){
            $width = 100;
        }
        
        if($height<=0){
            $height = 100;
        }
        
        $this->_armaParametros("-resize ".(int)$width."x".(int)$height);
    }
        
}
?>
