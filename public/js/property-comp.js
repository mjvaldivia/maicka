$(document).ready(function(){  
    
    $(".comp-input-number").each(function(){
        var format = $(this).attr("format");
       $(this).mask(format, {reverse: true}); 
    }) 
    
    $( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
    $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
    
    // guarda elemento boolean
    $('.input-checkbox').livequery(function(){
        $(this).iphoneStyle({
            onChange: function(elem, value) {
              //alert(value.toString());
              var checkbox = 0;
              if(value){
                  checkbox = 1;
              }
              var parametros = _getCompParametros(elem) + "&valor=" + checkbox;
              saveCompField(elem, parametros, true);
            }
        });
    });
    
    
    setFileElementArchivo();
    
    setFileElementImagen();
    
    setFileElementVideo();
        
    $('.element-video a').livequery(function(){
        $(this).colorbox({rel:'element-video a', 
                          transition:"elastic", 
                          maxWidth:"100%", 
                          maxHeight:"100%"});
    });
        
    // agrega un elemento multiline
    $(".add-line").click(function(){
        var data_section_field = $(this).attr("indice");
        $.ajax({         
                dataType: "json",
                cache:false,
                async:true,
                data: "data_section_field=" + data_section_field + "&format=json",
                type:"post",
                url: '/admin/property-comp/add-multiline', 
                error: function(xhr, textStatus, errorThrown){
                },
                success:function(data){  
                    $("#data-section-field-" + data_section_field + "-lines").append(data.elemento);
                    
                    switch (data.field_type) {
                        case 4:
                           setFileElementArchivo();
                           break
                        case 8:
                           setFileElementVideo();
                           break
                        case 9:
                           setFileElementImagen();
                           break
                        default:
                           break;
                    } 
                    
                }
        });
    });
    
    // quita un elemento multiline
    $(".remove-line").livequery(function(){
        $(this).click(function(){
            
            var parametros = "field=" + $(this).attr("indice");
          
            $.ajax({         
                dataType: "json",
                cache:false,
                async:true,
                data: parametros + "&format=json",
                type:"post",
                url: '/admin/property-comp/remove-multiline', 
                error: function(xhr, textStatus, errorThrown){
                },
                success:function(data){}
            });
            
            $(this).parent().parent().hide();
            
        });
    });
    
    
    // guarda campos de texto
    $('.comp-input-text').livequery(function(){
        $(this).typing({
            stop: function (event, $elem) {
                saveCompField($elem, getCompParametros($elem), true);
            },
            delay: 400
        });
    });
    
    // guarda campos de fecha
    $('.comp-input-date').livequery(function(){
        $(this).change(function(){
            saveCompField($(this), getCompParametros($(this), true));
        });     
    });

    // guarda combos
    $(".comp-input-select").livequery(function(){
        $(this).change(function(){
            saveCompField($(this), getCompParametros($(this)), false);

            var name = $(this).attr("name");
            //var parent = $(this).attr("parent")
            var parametros = "combo=" + name + "&combo_value=" + $(this).val();
            var combo = $(this);
            $.ajax({         
                dataType: "json",
                cache:false,
                async:true,
                data: parametros + "&format=json",
                type:"post",
                url: '/admin/property-comp/load-subcombo', 
                error: function(xhr, textStatus, errorThrown){
                },
                success:function(data){  

                    combo.parent().parent().children(".sub-combo").html(data.subcombo);

                }
            });
        
        
        })
    })
});

function setFileElementArchivo(){
    // Inicializa elementos tipo file
    $(".comp-input-file").each(function() {
        var $elemento = $(this);
        if($elemento.attr("activado")!="si"){
            setFileElement($elemento,"application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword,application/pdf,text/plain,application/vnd.ms-excel,application/vnd.ms-powerpoint");
        }
    });
}

function setFileElementImagen(){
    // Inicializa elementos tipo imagen
    $(".comp-input-image").each(function() {
        var $elemento = $(this);
        if($elemento.attr("activado")!="si"){
            setFileElement($elemento,"image/png,image/jpg,image/jpeg,image/bmp");
        }
    });
}

function setFileElementVideo(){
        // Inicializa elementos tipo video
    $(".comp-input-video").each(function() {
        var $elemento = $(this);
        if($elemento.attr("activado")!="si"){
            setFileElement($elemento,"video/mp4,video/x-flv,video/webm");
        }
    });
}

/**
 * Setea el elemento tipo file
 * @param {type} $elemento
 * @returns {undefined}
 */
function setFileElement($elemento, filetypes){
    var parametros = _getCompParametros($elemento);
    var nombre = $elemento.attr("name");

    var $thumbnail = $elemento.parent().children(".thumbnail").children("a").children("img");
    var $image     = $elemento.parent().children(".thumbnail").children("a");
    
    var $video     = $elemento.parent().children(".element-video").children("a");
    
    var $filename      = $elemento.parent().children(".filename");
    var $fileurl       = $elemento.parent().children(".fileurl");
    var $download_icon = $elemento.parent().children(".download-icon");
    var $error_message = $elemento.parent().parent().children(".error-input-message");
    var $progress_bar  = $elemento.parent().parent().children(".progress-bar");
    var $contenedor = $elemento.parent().parent();

    if($filename.val()!=""){
        $elemento.uniform({fileButtonHtml: 'Change File',
                           fileDefaultHtml: $filename.val()}); 
        $download_icon.click(function(e){
                  e.preventDefault();  //stop the browser from following
                  window.location.href = $fileurl.val(); 
        });
    } else {
        $elemento.uniform({fileButtonHtml: 'Choose File'});
    }
    
    $elemento.attr("activado", "si");

    $elemento.liteUploader({
            script: '/admin/property-comp/save-comp?' + parametros,
            allowedFileTypes: filetypes,
            maxSizeInBytes: 0,
            customParams: {
                'valor' : nombre,
                'format': 'json'
            },
            before: function (files) {
                $error_message.hide();
                $progress_bar.children(".bar").css("width","0%");
                $progress_bar.children(".bar").html("0%");
                $progress_bar.show();
            },
            each: function (file, errors){
                if (errors.length > 0){ 
                    $error_message.show();
                    $error_message.html("<strong>Oh snap!</strong> One or more files did not pass validation");
                    $progress_bar.hide();
                } else {
                    $error_message.hide();
                    
                }            
            },
            progress: function (porcentaje){
                $progress_bar.children(".bar").css("width",porcentaje + "%");
                $progress_bar.children(".bar").html(porcentaje + "%");
            },
            success: function (response){  
                $progress_bar.children(".bar").css("width","100%");
                $progress_bar.children(".bar").html("100%");
                
                $download_icon.off("click");
                $download_icon.click(function(e){
                   e.preventDefault();  //stop the browser from following
                   window.location.href = response.url; 
                });

                if(response.recargar){
                    $contenedor.replaceWith(response.elemento);
                    setFileElement($("#field_" + response.field_id +"_" + response.data_section_field_id + "_" + response.comp_field_id));
                }
                
                if(response.image){
                   $thumbnail.attr("src", response.thumbnail);
                   $image.attr("href", response.url);
                }
                
                if(response.video){
                   $video.attr("href", "/admin/property-comp/load-video?format=html&url=" + response.url);
                   $video.attr("title", response.nombre);
                }
                
                $progress_bar.hide("slow");
            }
    });
}

/**
 * Guarda un field
 * @param {type} $elem
 * @returns {undefined}
 */
function saveCompField($elem, parametros, async){
    //var parametros = getCompParametros($elem);
    $.ajax({         
        dataType: "json",
        cache:false,
        async:async,
        data: parametros + "&format=json",
        type:"post",
        url: '/admin/property-comp/save-comp', 
        error: function(xhr, textStatus, errorThrown){
        },
        success:function(data){  
            setCompField(data, $elem);
        }
    })
    
    return;
}

/**
 * Setea el field que fue guardado
 * @param {json} data
 * @param {type} $elem
 * @returns {undefined}
 */
function setCompField(data, $elem){
    $("#property_comp").val(data.comp_id);
                    
    $elem.attr("name", "field_" + data.field_id + "_" + data.data_section_field_id + "_" + data.comp_field_id);
    $elem.attr("id",   "field_" + data.field_id + "_" + data.data_section_field_id + "_" + data.comp_field_id);
}

/**
 * Genera los parametros para guardar un comp
 * @param {type} $elem
 * @returns {String}
 */
function getCompParametros($elem){
    
    var valor = $elem.val();
    var parametros = _getCompParametros($elem) +
                     "&valor=" + valor;
    return parametros;
}

function _getCompParametros($elem){
    var name = $elem.attr("name");

    var parametros = "field=" + name +
                     "&parent=" + $elem.attr("parent") +
                     "&new_update=" +  $("#comp_new_update").val() + 
                     "&property_id=" + $( "#property" ).val() + 
                     "&comp_id=" +     $( "#property_comp" ).val();
    return parametros;
}