$(document).ready(function(){ 

    hideLabels();
    
    $(".delete-row").livequery(function(){
        $(this).click(function(){
            //alert("lala");
           var input = $(this).attr("input");
           //alert(input);
           var contenedor = $(this).attr("div");
                    
           var cantidad = $("#" + contenedor).children(".div-form-row").length;
           var eliminados = $("#" + contenedor).children(".div-hide").length;
           //alert(cantidad+" "+eliminados);
           
           var requerido = $(this).attr("requerido");
           
           console.log(cantidad + " " + eliminados);
           if((cantidad-eliminados)>1 || requerido == 1){
               $("#" + input).val(1);
               
               var divform = $(this).parent().parent();
               divform.addClass("div-hide");
              
               if($(this).parent().next(".checkbox").children("input:checkbox").attr("checked") == "checked" ){
                  var ok = false;
                  $("#" + contenedor).children(".div-form-row").each(function(){
                      if(!$(this).is(".div-hide") && !ok){
                          ok = true;
                          $(this).children(".checkbox").children("input:checkbox").attr("checked", true);
                      }
                  })
               }
           }
           hideLabels();
        })        
    })
    
   /* if(typeof window.loadUploader == 'function'){
        loadUploader("entity_image", "category_button_save"); 
    }*/
     
    
    $("#add-phone").click(function(){
        var html =  sending_form_html("/entitymanager/index/add-phone","");
        $("#phone-content").append(html);
        setCheck("entity_checkbox_phone");
         hideLabel("div-phone");
         $("#phone-content :input:text").setMask({mask : '999999999999999999'}); 
    })
    
    $("#add-email").click(function(){
        var html =  sending_form_html("/entitymanager/index/add-email","");
        $("#email-content").append(html);
        setCheck("entity_checkbox_email");
        hideLabel("div-email"); 
    })
    
    $("#add-address").click(function(){
        var html =  sending_form_html("/entitymanager/index/add-address","");
        $("#address-content").append(html);
        setCheck("entity_checkbox_address");
        hideLabel("div-address");
    })
    
    $("#add-profile").click(function(){
        var html =  sending_form_html("/admin/entities/add-profile/id/"+$("#entity_id").val(),"");
        $("#profile-content").append(html);
        hideLabel("div-profile");
    })
    
    setCheck("entity_checkbox_phone");
    setCheck("entity_checkbox_email");
    setCheck("entity_checkbox_address");
    $("#phone-content :input:text").setMask({mask : '999999999999999999'}); 
    
})


function hideLabels(){
    hideLabel("div-address");
    hideLabel("div-phone");
    hideLabel("div-email"); 
}

function hideLabel(clase){
    var sw = false;
    $("." + clase).each(function(){
        if(sw == false){
            if(!$(this).is(".div-hide")){
                sw = true;
                $(this).children(".element").children("label").show();
            }
        } else {
            $(this).children(".element").children("label").hide();
        }
    })
}

function setCheck(clase){
    $("." + clase).click(function(){
            if($(this).attr("checked")){
                $("." + clase).attr("checked",false);
                $(this).attr("checked",true);
            } else{
                $(this).attr("checked",true);
            }
    })
}
