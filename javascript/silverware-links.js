/* SilverWare Links Module :: Link Page Script:
===================================================================================================================== */

$(function(){
    
    // Handle Link Page:
    
    $('#LinkPage').entwine({
        
        onmatch: function() {
            
            var iconOpen  = "fa-plus-circle";
            var iconClose = "fa-minus-circle";
            
            var categories = this.find('div.categories');
            
            if (categories.data('toggle')) {
                
                categories.addClass('toggle');
                
                if (categories.data('start') == 'closed') {
                    categories.find('div.links').hide();
                    categories.find('i.icon').addClass(iconOpen);
                } else {
                    categories.find('article.category').addClass('open');
                    categories.find('i.icon').addClass(iconClose);
                }
                
                this.find('article.category > header').on('click', function() {
                    
                    var self = $(this);
                    var icon = self.find('i.icon');
                    var category = self.parent();
                    
                    var links = category.find('div.links');
                    
                    if (!category.hasClass('open')) {
                        icon.removeClass(iconOpen);
                        icon.addClass(iconClose);
                        links.slideDown();
                        category.addClass('open');
                    } else {
                        icon.removeClass(iconClose);
                        icon.addClass(iconOpen);
                        category.removeClass('open');
                        links.slideUp();
                    }
                });
                
            }
            
        }
        
    });
    
});
