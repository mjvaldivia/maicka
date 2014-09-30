<?php

class Imagegallery_UploadController extends Zend_Controller_Action {
    
    /**
     * Actions llamados por ajax
     * @var array 
     */
    public $ajaxable = array("image" => array("json"));
        
    /**
     * Nombre del archivo original subido por
     * el usuario
     * @var string
     */
    protected $_original_file_name;
    
    /**
     * Ubicacion del archivo temporal
     * @var string
     */
    protected $_temp_path;
    
    /**
     * Ubicacion de la imagen original
     * @var string 
     */
    protected $_original_path;
    
    /**
     * Ubicacion de la imagen mediana
     * @var string 
     */
    protected $_medium_path;
    
    /**
     * Ubicacion de la imagen pequeña
     * @var string 
     */
    protected $_thumbnail_path;
    
    /**
     * Dice si hay que crear el thumbnail en segundo plano
     * @var boolean
     */
    protected $_thumbnail_segundo_plano = true;
    
    /**
     * Ruta absoluta donde se encuentra el archivo final
     * @var string
     */
    protected $_dir;
    
    /**
     * Ruta relativa donde se encuentra el archivo final
     * @var string
     */
    protected $_dir_relative;
    
    /**
     * Nombre del input con el cual
     * llega la foto
     */
    protected $_input_name = "file";
    
    /**
     * 
     */
    public function init() {
        $this ->_helper->getHelper('AjaxContext')->initContext();
    }
    
    /**
     * Recive y procesa la imagen
     */
    public function imageAction(){
        $this->_validarImagen();
        $this->_setearRutas();
        $file = $this->_recibeArchivo();
        $this->_covertImage($file);
        $this->_saveImage($file);
    }
    
    protected function _validarImagen(){
        $input_name = $this->_getParam("input_name");
      
        if(!is_null($input_name)){
            $this->_input_name = $input_name;
        }
        
        if(is_array($_FILES[$this->_input_name]['name'])){
            // Subido por Liteuploader
            // tambien se necesita que el thumbnail no se genere en segundo plano 
            $this->_original_file_name = $_FILES[$this->_input_name]['name'][0];
            $this->_temp_path          = $_FILES[$this->_input_name]['tmp_name'][0];
            $this->_thumbnail_segundo_plano = false;
        } else {
            $this->_original_file_name = $_FILES[$this->_input_name]['name'];
            $this->_temp_path          = $_FILES[$this->_input_name]['tmp_name'];
        }
 
        $extencion = $this->_getExtencion($this->_original_file_name);

        switch ($extencion) {
            case "jpg":
                $image = imagecreatefromjpeg($this->_temp_path);
                break;
            case "gif":
                $image = imagecreatefromgif($this->_temp_path);
                break;
            case "png":
                $image = imagecreatefrompng($this->_temp_path);
                break;
            case "bmp":
                $image = true;
                break;
            default:
                
                break;
        }
        
        //fb($image);
        
        if($image == False) { // si es falso quiere decir que no se pudo cargar la foto en memoria
            throw new Exception('Photo uploaded appears to be corrupt, unable to upload.');
        }
    }
    
    /**
     * Setea las rutas donde se guardaran las imagenes
     */
    protected function _setearRutas(){
        $this->_dir_relative = "/upload/image/" . $this->_rand_string(9);
        $this->_dir = APPLICATION_PATH . "/../public" . $this->_dir_relative;
        
        if(!is_dir($this->_dir)){
            mkdir($this->_dir ,0755 ,true);
        }
        
        $this->_thumbnail_path = $this->_dir_relative."/thumbnail.jpg";
        $this->_medium_path    = $this->_dir_relative."/medium.jpg";
    }
    
    /**
     * Guarda la imagen en la BD
     * @param string $file
     */
    protected function _saveImage($file){
        $size = filesize($file);
     
        $image = New \Model\Entity\Photos;
        $image->setName($this->_original_file_name);
       // $image->setProcessed(false);
        $image->updateDateCreated();
        $image->setSize($size);
        $image->setType("image");
        
        // Si es en segundo plano es porque viene de gallery
        if($this->_thumbnail_segundo_plano){
            $image->setGallery(true);
        }
        
        $image->setPathOriginal($this->_original_path);
        $image->setPathMedium($this->_medium_path);
        $image->setPathSmall($this->_thumbnail_path);
        
        list($width, $height, $type, $attr) = getimagesize($file);
        
        $image->setHeight($height);
        $image->setWidth($width);
        
        $entity_manager = App_Doctrine_Repository::entityManager();
        $entity_manager->persist($image);
        $entity_manager->flush();
        
        $this->view->photo_id = $image->getId();
        $this->view->thumbnail = $this->_thumbnail_path;
        $this->view->original  = $this->_original_path;
        $this->view->image     = true;
    }
    
    /**
     * Convierte la imagen
     * a mediana y thumbnail
     * @param string $image_path
     */
    protected function _covertImage($image_path){
        $this->_convertThumbnail($image_path); 
        $this->_convertMedium($image_path);     
    }
    
    /**
     * Crea la imagen pequeña
     * @param string $image_path
     */
    protected function _convertThumbnail($image_path){
        $ejecutar = New App_Utilitario_ImageMagick();
        $ejecutar->imagenOriginal($image_path);   
        $ejecutar->setSize(100, 100);
        $ejecutar->imagenDestino($this->_dir."/thumbnail.jpg");
        $ejecutar->setCompressQuality();
        if($this->_thumbnail_segundo_plano){
            $ejecutar->setConvertNull();
        }
        $ejecutar->convert();
    }
    
    /**
     * Crea la imagen mediana
     * @param type $image_path
     */
    protected function _convertMedium($image_path){
        $ejecutar = New App_Utilitario_ImageMagick();
        $ejecutar->imagenOriginal($image_path);   
        $ejecutar->setSize(500, 500);
        $ejecutar->imagenDestino($this->_dir."/medium.jpg");
        $ejecutar->setCompressQuality();
        $ejecutar->setConvertNull();
        $ejecutar->convert();
    }
    
    /**
     * Recibe el archivo subido
     * y lo guarda en ubicacion final
     * @return string
     */
    protected function _recibeArchivo(){
        
        $temp = $this->_temp_path;
        $extencion = $this->_getExtencion($this->_original_file_name);

        $this->_original_path = $this->_dir_relative."/original." .  $extencion;
        
        $file = $this->_dir . "/original." .  $extencion;
        move_uploaded_file($temp, $file);
        return $file;
    }
    
    /**
     * devuelve la extencion del archivo
     * @param string $file_name
     * @return string
     */
    protected function _getExtencion($file_name){
        $separado = explode(".", $file_name);
        return strtolower($separado[count($separado)-1]);
    }
        
    /**
     * Genera un nombre aleatorio para el archivo temporal
     * @param int $length
     * @return string
     */
    protected function _rand_string( $length ) {
        $str = "";
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}

	return $str;
    }
        
    
    

    
    
}

