$(document).ready(function(){

    $(".grid_active_deactive").livequery(function(){
        $(this).click(function(){
            var indice = $(this).attr("indice");
            var column = $(this).attr("column")
            var grid_name = $(this).attr("grid");
            var yo = this;
            $.ajax({         
                    dataType: "json",
                    cache:false,
                    async: true,
                    data:"id=" + indice + "&column=" + column + "&format=json",
                    type:"post",
                    url: "/grid/index/active-deactive/name/" + grid_name, 
                    error: function(xhr, textStatus, errorThrown){
                       
                    },
                    success:function(data){
                      // console.log(data);
                       if(data.result){
                           $(yo).html("Active");
                           $(yo).addClass("label-success");
                       } else {
                           $(yo).html("Inactive");
                           $(yo).removeClass("label-success");
                       }
                    }
            });
        })
    });
       
       
    $(".grid_delete").livequery(function(){
        $(this).confirmar({
            onYes:function(element){
                $.ajax({         
                    dataType: "json",
                    cache:false,
                    async: true,
                    data: "format=json",
                    type:"post",
                    url: $(element).attr("href"), 
                    error: function(xhr, textStatus, errorThrown){
                       
                    },
                    success:function(data){
                        $("#" + $(element).attr("table")).flexReload();
                    }
                });                
            }
        })
    })
})