<?php

/**
 * Shorthill
 *
 * @category    Bamopo
 * @package     Bank
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class App_Utilitario_Form_Select{
    /**
     * Convierte una salida Doctrine o FieldType en el formato para un input select
     * @param type $data
     * @param type $defaultText
     * @return array
     */
    static function setFormat($data, $defaultText = "Select"){
        $new = array();
        //$new[''] = $defaultText;
        foreach($data as $key){
              if(is_object($key)) $new[$key->getId()] = $key->getName();
              else $new[] = $key;
        }
        return $new;
    }


    static function setFormatMethod($data, $idMethod, $nameMethod, $defaultText = "Select"){
        $new = array();
      /*  if (!is_null($defaultText)){
            $new[''] = $defaultText;
        }
        if ($defaultText == "none") {
            unset($new[""]);
        }*/
        $new[''] = "";
        if($data){
            foreach($data as $key){
                  if(is_object($key)) $new[$key->{$idMethod}()] = $key->{$nameMethod}();
                  else $new[] = $key;
            }
        }
        return $new;
    }

    static function getJsonMethod($data, $idMethod, $nameMethod) {
        $json = "";
        if ($data) {
            foreach ($data as $key => $value) {
                $json .= ($key > 0) ? "," : "";
                $json .= "{";
                if (is_object($value)) {
                    $json .= "value : \"".$value->{$idMethod}()."\",";
                    $json .= "label : \"".$value->{$nameMethod}()."\"";
                } else {
                    $json .= "value : \"" . $key . "\",";
                    $json .= "label : \"" . $value . "\"";
                }
                $json .= "}";
            }
        }
        return $json;
    }


}
?>
