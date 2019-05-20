(function(jQuery) {

    jQuery.organicTabs = function(el, options) {
    
        var base = this;
        base.jQueryel = jQuery(el);
        base.jQuerynav = base.jQueryel.find(".tabs-nav, .tabs-nav2");
                
        base.init = function() {
        
            base.options = jQuery.extend({},jQuery.organicTabs.defaultOptions, options);
            
            // Accessible hiding fix
            jQuery(".hidden-tab").css({
                "position": "relative",
                "top": 0,
                "left": 0,
                "display": "none"
            }); 
            
            base.jQuerynav.delegate("li > a", "click", function() {
            
                // Figure out current list via CSS class
                var curList = base.jQueryel.find("a.current").attr("href").substring(1),
                
                // List moving to
                    jQuerynewList = jQuery(this),
                    
                // Figure out ID of new list
                    listID = jQuerynewList.attr("href").substring(1),
                
                // Set outer wrapper height to (static) height of current inner list
                    jQueryallListWrap = base.jQueryel.find(".list-wrap"),
                    curListHeight = jQueryallListWrap.height();
                jQueryallListWrap.height(curListHeight);
                                        
                if ((listID != curList) && ( base.jQueryel.find(":animated").length == 0)) {
                                            
                    // Fade out current list
                    base.jQueryel.find("#"+curList).fadeOut(base.options.speed, function() {
                        
                        // Fade in new list on callback
                        base.jQueryel.find("#"+listID).fadeIn(base.options.speed);
                        
                        // Adjust outer wrapper to fit new list snuggly
                        var newHeight = base.jQueryel.find("#"+listID).height();
                        jQueryallListWrap.animate({
                            height: newHeight
                        });
                        
                        // Remove highlighting - Add to just-clicked tab
                        base.jQueryel.find(".tabs-nav li a, .tabs-nav2 li a").removeClass("current");
                        jQuerynewList.addClass("current");
                            
                    });
                    
                }   
                
                // Don't behave like a regular link
                // Stop propegation and bubbling
                return false;
            });
            
        };
        base.init();
    };
    
    jQuery.organicTabs.defaultOptions = {
        "speed": 700
    };
    
    jQuery.fn.organicTabs = function(options) {
        return this.each(function() {
            (new jQuery.organicTabs(this, options));
        });
    };
    
})(jQuery);



jQuery(function() {
          jQuery("#tabs-container").organicTabs({
              "speed": 500
          });
});


jQuery(function() {
          jQuery("#tabs-container2").organicTabs({
              "speed": 500
          });
});
        


jQuery(function(){
var $container = jQuery('.recent-comment-container');
// initialize
$container.masonry({
  itemSelector: '.shordcode-recent-comment'
});
});