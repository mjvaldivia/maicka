<?php

Abstract Class Vendor_LiveDoc_Base{
    
    /**
     * Template utilizado para el servicio LiveDocs
     * @var string
     */
    protected $_template = "";
    
    /**
     * usuario para el servicio LiveDocx
     * @var string 
     */
    protected $_user = 'antonio.ulloa';
    
    /**
     * password para el servicio LiveDocx
     * @var string 
     */
    protected $_password = '15751716';
    
    /**
     *
     * @var \Zend_Service_LiveDocx_MailMerge 
     */
    protected $_live_docx;
    
     /**
     * Constructor
     */
    public function __construct() {
        $this->_live_docx = new Zend_Service_LiveDocx_MailMerge();
        $this->_live_docx->setUsername($this->_user)
                         ->setPassword($this->_password);
        $this->_live_docx->setRemoteTemplate($this->_template);
    }
    
    /**
     * Abre el PDF en el navegador
     */
    public function open($path, $filename = "order.pdf"){
        $this->save($path);
        
        $mm_type="application/pdf"; // modify accordingly to the file type of $path, but in most cases no need to do so

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: " . $mm_type);
        header("Content-Length: " .(string)(filesize($path)) );
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header("Content-Transfer-Encoding: binary\n");

        readfile($path); // outputs the content of the file

        @unlink($path);
        exit();
    }
    
    /**
     * Guarda el documento en la ruta especificada
     * @param string $path
     */
    public function save($path){
        $this->_live_docx->createDocument();
        $document = $this->_live_docx->retrieveDocument('pdf');
        file_put_contents($path, $document);
    }
}

