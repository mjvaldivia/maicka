/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {

    $(".input-image").each(function(){
                var name = $(this).attr("name");
  
                var $filename = $("#" + name + "_filename"); 
                var $fileid  = $("#" + name + "_id"); 
                
                var $progress_bar  = $("#" + name +"_progress_bar");
                var $error_message = $("#" + name +"_error");
                var $thumbnail = $("#" + name + "_thumbnail");
                var $image     = $thumbnail.parent();
                
                $error_message.hide();
                $progress_bar.hide();
                
                if($filename.val()!=""){
                    $(this).uniform({fileButtonHtml: 'Change',
                                     fileDefaultHtml: $filename.val()}); 
                } else {
                    $(this).uniform({fileButtonHtml: 'Select'});
                }

                $(this).liteUploader({
                        script: '/imagegallery/upload/image/',
                        allowedFileTypes: "image/png,image/jpg,image/jpeg,image/bmp",
                        maxSizeInBytes: 0,
                        customParams: {
                            'format': 'json',
                            'input_name': $(this).attr("name")
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
                                $error_message.html("<strong>Oh snap!</strong> The file did not pass validation");
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

                            if(response.image){
                               $thumbnail.attr("src", response.thumbnail);
                               $fileid.val(response.photo_id);
                               $image.attr("href", response.original);
                            }


                            $progress_bar.hide("slow");
                        }
                });
            });
});

function uploadImage($this){
    var name = $(this).attr("name");
  
    var $filename = $("#" + name + "_filename"); 
    var $fileurl  = $("#" + name + "_url"); 

    var $progress_bar  = $("#" + name +"_progress_bar");
    var $error_message = $("#" + name +"_error");
    var $thumbnail = $("#" + name + "_thumbnail");
    var $image     = $thumbnail.parent();

    $error_message.hide();
    $progress_bar.hide();

    if($filename.val()!=""){
        $(this).uniform({fileButtonHtml: 'Change',
                         fileDefaultHtml: $filename.val()}); 
    } else {
        $(this).uniform({fileButtonHtml: 'Select'});
    }

    $(this).liteUploader({
            script: '/imagegallery/upload/image/',
            allowedFileTypes: "image/png,image/jpg,image/jpeg,image/bmp",
            maxSizeInBytes: 0,
            customParams: {
                'format': 'json',
                'input_name': $(this).attr("name")
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

                if(response.image){
                   $thumbnail.attr("src", response.thumbnail);
                   $fileurl.val(response.photo_id);
                   $image.attr("href", response.original);
                }


                $progress_bar.hide("slow");
            }
    });
}