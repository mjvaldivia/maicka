<?php
Abstract class App_Utilitario_Exec{
    
    /**
     * String con los comandos a ejecutar
     * @var string
     */
    protected $_command_line = ""; 
    
    /**
     * Ejecuta el comando en Shell
     * @param string $comando 
     */
    protected function _exec($cmd){
               
       $results = array();
       $return_code = NULL;
       fb($cmd . $this->_command_line);
       exec($cmd . $this->_command_line, $results, $return_code);
       
       if($return_code!=0){
           throw new Exception("La ejecucion del comando " . $cmd . " ha fallado con codigo de error " . $return_code . "<br>"
                               . $cmd . $this->_command_line);
       }
       

    }
    
    
     /**
     * Arma los parametros dados a las funciones
     * @param type $parametros
     * @return string 
     */
    protected function _armaParametros($parametro){
        $this->_command_line .= " " . $parametro;
    }
}
?>