$.fn.extend({

        counter: function(id) {        	
            return this.each(function() {            	
            	var $this = $(this);
				var html = '<div class="countbox" id="countbox'+id+'"></div>';	
                $this.html(html);  
            });
        }
});