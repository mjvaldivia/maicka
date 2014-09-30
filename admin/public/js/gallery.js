
$(document).ready(function(){
    $("body").tooltip({selector: '[data-toggle="tooltip"]'});
    $(".gallery.active").livequery(function(){
        
        var upload = $(this).attr("uploadname");
        var handler = $('#' + upload + '-tiles li');

        handler.wookmark({
              // Prepare layout options.
              autoResize: true, // This will auto-update the layout when the browser window is resized.
              container: $('#' + upload + '-wookmark-container'), // Optional, used for some extra CSS styling
             
              //flexibleWidth: true
        });
    });
    
    $(".item-gallery").livequery(function(){
        $(this).click(function(){
            var upload = $(this).parent().attr("uploadname");
            var id     = $(this).attr("indice");
            var img    = $("#img-gallery-" + id).attr("src");
            
            console.log(upload);

            $("#" + upload + "_id").val(id);
            $("#" + upload + "_thumbnail").attr("src", img);
            
        });
    });
    
    $(".gallery-search").keypress(function (evt) {
        
        var charCode = evt.charCode || evt.keyCode;
        if (charCode  == 13) { //Enter key's keycode
            var upload = $(this).attr("uploadname");
            $.ajax({         
                  dataType: "json",
                  cache:false,
                  async: true,
                  data: "search=" + $("#" + upload +"_search").val() + "&inicio=0&format=json",
                  type:"post",
                  url: "/imagegallery/index/load-more-form", 
                  error: function(xhr, textStatus, errorThrown){

                  },
                  success:function(data){
                    $("#" + upload + "-image-load-more").attr("indice", 30);
                    $("#" + upload + "-tiles").html(data.append);
                    var handler = $("#" + upload + "-tiles li");

                    handler.wookmark({
                        // Prepare layout options.
                        autoResize: true, // This will auto-update the layout when the browser window is resized.
                        container: $('#' + upload + '-wookmark-container'), // Optional, used for some extra CSS styling
                        
                    });
                  }
              });
            return false;
        }
    });
    
    $(".load-more").click(function(){
      var inicio = $(this).attr("indice");
      var upload = $(this).attr("uploadname");
      $.ajax({         
            dataType: "json",
            cache:false,
            async: true,
            data: "search=" + $("#" + upload +"_search").val() + "&inicio=" + inicio +  "&format=json",
            type:"post",
            url: "/imagegallery/index/load-more-form", 
            error: function(xhr, textStatus, errorThrown){
                
            },
            success:function(data){
                
                $("#" + upload + "-image-load-more").attr("indice", data.inicio);
                $("#" + upload + "-tiles").append(data.append);
                
                var handler = $("#" + upload + "-tiles li");

                handler.wookmark({
                        // Prepare layout options.
                        autoResize: true, // This will auto-update the layout when the browser window is resized.
                        container: $('#' + upload + '-wookmark-container'), // Optional, used for some extra CSS styling
                        
                  });
                  
               if(data.fin) {
                   $("#" + upload + "-image-load-more").hide();
               }
            }
        });  
    });

});