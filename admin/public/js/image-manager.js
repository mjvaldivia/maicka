$(document).ready(function(){
    $("body").tooltip({selector: '[data-toggle="tooltip"]'});
    Dropzone.autoDiscover = false;
    
    var myDropzone = new Dropzone("#my-dropzone");

    myDropzone.on("complete", function() {
       // $("#photo_list").flexReload();
    });

    $("#clear-files").click(function() {
        var files = myDropzone.getAcceptedFiles();
        $.each(files, function( index, value ) {
            myDropzone.removeFile(value);
        });
    });


    var handler = $('#tiles li');

    handler.wookmark({
          // Prepare layout options.
          autoResize: true, // This will auto-update the layout when the browser window is resized.
          container: $('#wookmark-container'), // Optional, used for some extra CSS styling
          offset: 5, // Optional, the distance between grid items
          outerOffset: 5, // Optional, the distance to the containers border
          itemWidth: 150 // Optional, the width of a grid item
    });
    
   
    $(".delete-image").livequery(function(){
        $(this).confirmar({
            onYes:function(element){
                $.ajax({         
                    dataType: "json",
                    cache:false,
                    async: true,
                    data: "id=" + $(element).attr("indice") + "&format=json",
                    type:"post",
                    url: "/imagegallery/index/delete", 
                    error: function(xhr, textStatus, errorThrown){
                       
                    },
                    success:function(data){
                        $(element).parent().parent().remove();
                       
                    }
                });  
                
            }
        });
    });
    
    $("#image-load-more").click(function(){
       var inicio = $(this).attr("indice");
       $.ajax({         
            dataType: "json",
            cache:false,
            async: true,
            data: "search=" + $("#search").val() + "&inicio=" + inicio +  "&format=json",
            type:"post",
            url: "/imagegallery/index/load-more", 
            error: function(xhr, textStatus, errorThrown){
                
            },
            success:function(data){
                
                $("#image-load-more").attr("indice", data.inicio);
                $('#tiles').append(data.append);
                
                var handler = $('#tiles li');

                handler.wookmark({
                        // Prepare layout options.
                        autoResize: true, // This will auto-update the layout when the browser window is resized.
                        container: $('#wookmark-container'), // Optional, used for some extra CSS styling
                        offset: 5, // Optional, the distance between grid items
                        outerOffset: 5, // Optional, the distance to the containers border
                        itemWidth: 150 // Optional, the width of a grid item
                  });
                  
               if(data.fin) {
                   $("#image-load-more").hide();
               }
            }
        });  
    });
});

