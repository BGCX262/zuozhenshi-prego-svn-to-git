$(function(){
	
	var duration = 200;		// animation spped
		
	/*-- plugin --------------------------------------------------------------------*/
	
	var container = $('#module_container');
	
	var set_compact_event = function(b){
		if(b){
			$('.compact div').unbind();
			//hoverイベント
			$('.compact div').hover(
				function(){
					var top = ($('ul',this).height()+136);
					$('ul',this)
						.slideDown(200);
				},
				function(){
					$('ul',this).slideUp(200);
				}
			);
			$('div ul',container).hide();
		}else {
			$('.open div').unbind();
			$('div ul',container).show();
		}
	}
	
	$('#modules .btns_mini .left a').click(function(){
		if(!container.hasClass('open')){
			container.fadeOut(duration,function(){
				container
					.removeClass("compact")
					.addClass("open")
					.fadeIn(duration);
					set_compact_event(false);
			});
			
			$.cookie('plugin_mode', 'open', {expires : 30});
		}
	});
	
	$('#modules .btns_mini .right a').click(function(){
		if(!container.hasClass('compact')){
			container.fadeOut(duration,function(){
				container
					.removeClass("open")
					.addClass("compact")
					.fadeIn(duration);
					set_compact_event(true);
			});
			
			$.cookie('plugin_mode', 'compact', {expires : 30});
		}
	});
	
	
	/*-- set plugin order --------------------------------------------------------------------*/

	if($.cookie('plugin_mode') == 'compact'){
		container.addClass('compact');
		$('#modules .btns_mini .right a').addClass('active');
		set_compact_event(true);
	}else {
		container.addClass('open');
		$('#modules .btns_mini .left a').addClass('active');
	}

	$('#sections').css("visibility","visible")
	$('#article').removeClass("load");
	
});