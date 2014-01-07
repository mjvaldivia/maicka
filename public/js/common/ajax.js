
/**
 * Envia los datos y carga el HTML
 */
function sending_form_html(php, parametros){
   return send_data(php, parametros, "html", false);
}

/**
 * Envia los datos y carga el HTML asincronicamente
 */
function sending_form_html_async(php, parametros){
   return send_data(php, parametros, "html", true);
}

/**
 * Envia los datos y carga el json
 */
function sending_form_json(php, parametros){
   return send_data(php, parametros, "json", false); 
}

/**
 * Envia y carga los datos asincronicamente
 */
function sending_form_json_async(php, parametros){
   return send_data(php, parametros, "json", true); 
}
 
/**
 * Envia los datos por ajax
 */
function send_data(php, parametros, formato, async){
    var salida="";
    
    if(parametros.length == 0) parametros = "format="+formato;
    else parametros = parametros + "&format="+formato;
 
    $.ajax({         
         dataType: formato,
         cache:false,
         async:async,
         data:parametros,
         type:"post",
         url: php, 
         error: function(xhr, textStatus, errorThrown){
            salida = false;
            
            //document.location.href="/backoffice/login/index/logout";
         },
         success:function(data){
            salida = data;
         }
    });
    
    return salida;
}
