$(document).ready(function(){
    
    
    
    $("#field_type").change(function(){
        //Si es un combo list
        if($(this).val() == 5){
            $("#combo_list").parent("div").parent("div").removeClass("hidden");
        } else {
            $("#combo_list").parent("div").parent("div").addClass("hidden"); 
        }
        
        if($(this).val() == 6){
           $("#subcombo_parent").parent("div").parent("div").removeClass("hidden"); 
           $("#subcombo_parent_values").removeClass("hidden");

        } else {
           $("#subcombo_parent").parent("div").parent("div").addClass("hidden");  
           $("#subcombo_parent_values").addClass("hidden");
        }
        
        if($(this).val() == 2 || $(this).val() == 10 || $(this).val() == 11){
           $(".number-options").parent("div").parent("div").removeClass("hidden"); 
        } else {
           $(".number-options").parent("div").parent("div").addClass("hidden");  
        }
        
        if($(this).val() == 10){
            $("#multi_line").parent("div").parent("div").parent("div").hide();
            $(".calculated-options").parent("div").parent("div").removeClass("hidden"); 
        } else {
            $("#multi_line").parent("div").parent("div").parent("div").show();
            $(".calculated-options").parent("div").parent("div").addClass("hidden");
        }
        
        if($(this).val() == 9){
           $("#width").parent("div").parent("div").removeClass("hidden"); 
           $("#height").parent("div").parent("div").removeClass("hidden"); 
        } else {
           $("#width").parent("div").parent("div").addClass("hidden");  
           $("#height").parent("div").parent("div").addClass("hidden");
        }
        
        recargaFieldFormatCombo($(this).val());
        
    });
    
    $("#subcombo_parent").change(function(){
        recargaSubcombovalues($("#subcombo_parent").val());
    });
});


function recargaSubcombovalues(subcombo_parent){
    $.ajax({         
            dataType: "html",
            cache:false,
            async:true,
            data:"field=" + subcombo_parent + "&format=html",
            type:"post",
            url: '/admin/field/load-combo-values', 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(data){
      
                $("#subcombo_parent_values").show();
                

                $("#subcombo_parent_values").children("div").html(data);

            }
        })
}

function recargaFieldFormatCombo(field_type){
    
    $.ajax({         
            dataType: "json",
            cache:false,
            async:true,
            data:"fieldtype=" + field_type + "&format=json",
            type:"post",
            url: '/admin/field/load-field-format-combo', 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(data){
                if(data.result){
                    $("#field_format").parent("div").parent("div").removeClass("hidden");
                    $("#field_format").html("");
                    
                    $.each(data.options, function(val, text) {
                            $('#field_format').append('<option value="' + val + '" selected="selected">' + text +  '</option>');
                    });
                    
                    $("#field_format").val(data.default);
                    $("#field_format").trigger("chosen:updated");
                } else {
                    $("#field_format").html("");
                    $('#field_format').append('<option value="" selected="selected"></option>');
                    $('#field_format').val("");
                    $("#field_format").trigger("chosen:updated");
                    $("#field_format").parent("div").parent("div").addClass("hidden");
                }
                
            }
     });
}