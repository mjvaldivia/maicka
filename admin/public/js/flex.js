// Flex Admin Custom JavaScript Document

//Sidebar Toggle
$("#sidebar-toggle").click(function(e) {
    e.preventDefault();
    $(".navbar-side").toggleClass("collapsed");
    $("#page-wrapper").toggleClass("collapsed");
});

//Portlet Icon Toggle
$(".portlet-widgets .fa-chevron-down, .portlet-widgets .fa-chevron-up").click(function() {
    $(this).toggleClass("fa-chevron-down fa-chevron-up");
});

//Portlet Refresh Icon
(function($) {

    $.fn.extend({

        addTemporaryClass: function(className, duration) {
            var elements = this;
            setTimeout(function() {
                elements.removeClass(className);
            }, duration);

            return this.each(function() {
                $(this).addClass(className);
            });
        }
    });

})(jQuery);

$("a i.fa-refresh").click(function() {
    $(this).addTemporaryClass("fa-spin fa-spinner", 2000);
});

//Slim Scroll
$(function() {
    $('#messageScroll, #alertScroll, #taskScroll').slimScroll({
        height: '200px',
        alwaysVisible: true,
        disableFadeOut: true,
        touchScrollStep: 50
    });
});

//Easing Script for Smooth Page Transitions
$(function() {
    $('.page-content').addClass('page-content-ease-in');
});

//Tooltips
$(function() {

    // Tooltips for sidebar toggle and sidebar logout button
    $('.tooltip-sidebar-toggle, .tooltip-sidebar-logout').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })

})

//HISRC Responsive Images
$(document).ready(function() {
    $(".hisrc").hisrc();
    
    //para clase grilla
    $(".grid_delete").livequery(function(){
        $(this).confirmar({
            onYes:function(element){
                $.ajax({         
                    dataType: "json",
                    cache:false,
                    async: true,
                    data: "format=json",
                    type:"post",
                    url: $(element).attr("url"), 
                    error: function(xhr, textStatus, errorThrown){
                       
                    },
                    success:function(data){
                        $("#" + $(element).attr("table")).dataTable().api().draw(false)();

                    }
                });                
            }
        });
    });
    
    //formulario search
    $(".element-search").keypress(function (evt) {
        var charCode = evt.charCode || evt.keyCode;
        if (charCode  == 13) {
            $(this).parent().parent().children(".search-button").trigger("click");
            return false;
        }
    });
    
    $(".chosen").chosen({width: "100%",allow_single_deselect: true});
    
    $('[data-toggle=tooltip]').tooltip({
        container: "body"
    });
});