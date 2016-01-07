
    $(document).ready(function() 
    {
        $('.tabs').tabs(
		{
			activate	:	function(event,ui)
			{
				document.location=ui.newTab.children('a').attr('href');
				$(window).scrollTop(0);
			}
		});
		
		$(window).bind('hashchange',function() 
		{
			var id=window.location.hash.substring(1);
			var object=$('#'+id);
			
			if(object.length!=1) return;
			
			var position=$('.tabs>div').index(object);
			$('.tabs').tabs('option','active',position-1);
		});
		
        jQuery.getScript('http://quanticalabs.com/.tools/EnvatoItems/js/getItems.js',function() { });
    });

