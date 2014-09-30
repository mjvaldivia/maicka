$(document).ready(function() {
    $("#order_status").change(function(){
        $.ajax({         
                    dataType: "json",
                    cache: false,
                    async: true,
                    data: "id=" + $("#id_order").val() + "&status=" + $(this).val() + "&format=json",
                    type:"post",
                    url: "/order/ajax/change-status", 
                    error: function(xhr, textStatus, errorThrown){  
                    },
                    success:function(data){
                    }
                });
    });
});


