<?php

class Helper_ListImages extends Zend_Controller_Action_Helper_Abstract{
    
    /**
     * Lista 50 imagenes de acuerdo a la busqueda
     * @param string $search
     * @return \Model\Entity\Photos array
     */
    public function listImages($search, $inicio = 0, $limite = 50){
        $repository = App_Doctrine_Repository::repository("Photos");
        $query = $repository->listAll(array("file_name" => $search));
        $query->setMaxResults($limite)
              ->setFirstResult($inicio);
        return $query->getQuery()->getResult();
    }
    
    /**
     * Devuelve el total de imagenes encontradas
     * @param string $search
     */
    public function getTotal($search){
        $repository = App_Doctrine_Repository::repository("Photos");
        $query = $repository->listAll(array("file_name" => $search));
        return   $query->resetDQLParts(array('select', "orderBy"))
                       ->select('COUNT(p)')
                       ->getQuery()
                       ->getSingleScalarResult();
        
    }
    
    /**
     * Retorna la galeria para elemento imagen del formulario
     * sin funcionalidad en el html
     * @param \Model\Entity\Photos $images array
     * @return string
     */
    public function formGalleryHtml($images){
        $html = "";
        foreach($images as $photo){
            $name_corto = substr($photo->getName(), 0, 10) . "...";
            $imageSize = "";
            if (is_file(APPLICATION_PATH . "/../public" . $photo->getUrlSmall())) {
                $imageInfo = getimagesize(APPLICATION_PATH . "/../public" . $photo->getUrlSmall());
                $imageWidth = 112;
                $imageHeight = ($imageInfo[1] * $imageWidth) / $imageInfo[0];
                $imageSize = sprintf("width=\"%d\" heigth=\"%d\"", $imageWidth, $imageHeight);
            }

            $html .= "<li class=\"item-gallery\" indice=\"".$photo->getId()."\" uploadname=\"".$this->getName()."\">
                        <div class=\"imgholder\">
                            <img ".$imageSize." id=\"img-gallery-".$photo->getId()."\" src=\"".$photo->getUrlSmall()."\">
                        </div>
                        <p>
                            <span data-placement=\"top\" data-toggle=\"tooltip\" data-original-title=\"".$photo->getName()."\">".$name_corto."</span>
                        </p>
                     </li>";
            
            
        }
        return $html;
    }
}

