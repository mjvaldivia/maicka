function loadprovinceCombo(country, idstate, code){
    
    var parametros = "id=" + country.val();
    var state = "#" + idstate;
    
    
    $(state).attr("disabled", true);
    
    var ok = false;
    
    $(state).html("");
    $(state).append("<option value=\"\"></option>");
    if(country.val!=""){

      /*  if (country.val() == 3)
            $('#entity_address_postal_'+code).setMask({mask : 'a9a 9a9'});
	else if (country.val() == 2)
            $('#entity_address_postal_'+code).setMask({mask : '99999-9999'});*/

        var data = sending_form_json("/entitymanager/province/combo-load", parametros);
        $.each(data.province, function(index, value) { 
            $(state).append("<option value=\"" + index + "\">" + value + "</option>");
            ok = true;
        });
        
        if(ok) $(state).removeAttr("disabled");    
        else $(state).attr("disabled", true);
        
        
	
    } else {
        $(state).attr("disabled", true);
    }
    $(state).trigger("chosen:updated"); 
}



