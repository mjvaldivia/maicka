/*
 *  Project: 
 *  Description: 
 *  Author: 
 *  License: 
 */

// the semi-colon before function invocation is a safety net against concatenated 
// scripts and/or other plugins which may not be closed properly.
;
(function ( $, window, undefined ) {
    
    // undefined is used here as the undefined global variable in ECMAScript 3 is
    // mutable (ie. it can be changed by someone else). undefined isn't really being
    // passed in so we can ensure the value of it is truly undefined. In ES5, undefined
    // can no longer be modified.
    
    // window is passed through as local variable rather than global
    // as this (slightly) quickens the resolution process and can be more efficiently
    // minified (especially when both are regularly referenced in your plugin).

    // Create the defaults once
    var pluginName = 'confirmar',
    document = window.document,
    defaults = {
        title: 'Delete Confirmation',
        message: 'You are about to delete this item. <br />It cannot be restored at a later time! Continue?',
        init: function(obj, element, title, message){
            var miArray = [title,message];
            return miArray;
        },
        onYes: function(){},
        onNo: function(){}
    };

    // The actual plugin constructor
    function Plugin( element, options ) {
        this.element = element;

        // jQuery has an extend method which merges the contents of two or 
        // more objects, storing the result in the first object. The first object
        // is generally empty as we don't want to alter the default options for
        // future instances of the plugin
        this.options = $.extend( {}, defaults, options) ;
        
        this._defaults = defaults;
        this._name = pluginName;
        
        this.init();
    }

    Plugin.prototype.init = function () {
        // Place initialization logic here
        // You already have access to the DOM element and the options via the instance, 
        // e.g., this.element and this.options
        // alert("confirmar");
        var onYes = this.options.onYes;
        var onInit = this.options.init;
        
        var title = this.options.title;
        var message = this.options.message;
        
        /**
        * variable que contiene el objeto actual
        */
        var obj = this;
        
        $(this.element).click(function(){
            
            var opciones = onInit(obj, this, title, message);
            
            var elem = $(this).closest('.item');

            var elemento = this;

            $.confirm({
                'title'		: opciones[0],
                'message'	: opciones[1],
                'buttons'	: {
                    'Yes'	: {

                        'class'	: 'blue',
                        'action': function(){
                            onYes(elemento);
                        }
                    },
                    'No'	: {
                        'class'	: 'gray',
                        'action': function(){
  
                        }	
                    }
                }
            });


		

            
            
            
        // var result = sending_form_json('/admin/category/producttree/delete-product-listing', parameters);
        // $("#product_list_line_" + result.id).hide()
        })
    };

    // A really lightweight plugin wrapper around the constructor, 
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
            }
        });
    };

}(jQuery, window));

