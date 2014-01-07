$(document).ready(function(){ 
    $(".datepicker").datepicker();
    $("img.lazy").lazyload();
    
    $(".element .error").livequery(function(){
        var error = $(this).next("ul").html();
        
        $(this).qtip({
            content: error ,
            style: { 
                name: 'red' 
            },
            position: {
                corner: {
                    target: 'topMidle',
                    tooltip: 'bottomLeft'
                }
            }
        });
    });
    
    
    $("#SoldAddress-label").hide();
    $("#ShipAddress-label").hide();
    
    $(".select-box-image").livequery(function(){
        $(this).msDropDown();
    })  
    
})

function addErrorInput(obj, errorMsg){
    if (obj.next("ul").length > 0){
        obj.next("ul").html(errorMsg);
    }else{
        obj.after("<ul class=\"errors\"><li>"+errorMsg+"</li></ul>");
    }
    
    obj.removeClass("error").addClass("error");
}