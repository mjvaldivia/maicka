var cuandocargue = "";

function showPopup(title, width, height, php, params, onload){
    cuandocargue = onload;
    popup(title, width, height, php, params, onload);
    return false;
}

function popuploading(){
    $("#popup-content").hide();
    $("#popup-loading").show();
}

function popuploaded(){
    $("#popup-content").show();
    $("#popup-loading").hide();
}

function popup(title, width, height, php, params, tipo){
    
    $("#popup").dialog("destroy");
    $("#popup-content").hide();
    $("#popup-loading").css({'margin-top':(height/2)-30+'px','text-align':'center'})
    $("#popup-loading").show();

    $("#popup").attr("title", title);
    $("#popup" ).dialog({
                 resizable: false,
                 width: width,
                 height: height,
                 modal: true,
                 position:"center"
    });
    popup_load(sending_form_html(php, params));
}




function popup_load(data){
    $("#popup-content").html(data);
//    $("#popup-loading").hide("slide",{},"normal", function(){});
    $("#popup-loading").css("display", "none");
    $("#popup-content").css("display", "block");
   
    if(cuandocargue!="") window[cuandocargue]();
    return false;
}

function popup_unload(){
    $("#popup").dialog("close");
}