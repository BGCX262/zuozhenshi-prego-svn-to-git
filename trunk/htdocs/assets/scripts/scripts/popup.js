$(function(){
	
	//sortable table
	if($(".sortable").size() > 0){
		$(".sortable").tablesorter();
	}

	//accordionTable
	$('#service_master #content > div > h2').live("click",function(){
		var p = $(this).closest('div');
		$("table",p).toggle();
		$(this).toggleClass("active");
	});
	
});

var setRadioAndCheckbox = function(){
	
	if(jQuery.browser.msie && parseInt(jQuery.browser.version) == 7){
		// ie7は調整が必要なためとりあえず除外
	}else {
		//2回目用に一度イベントを解除しておく
		$('input[type=radio],input[type=checkbox]').unbind();
		
		//初めに全て走査して、labelに対して要素に対応したクラス付与とチェック済クラス付与
		$('input[type=radio],input[type=checkbox]').each(function(){
			var p = $(this).parent();
			p.removeClass($(this).attr('type')).addClass($(this).attr('type'));
			if($(this).attr('checked')){
				p.addClass('checked');
			}
		});
		
		//radioの監視
		$('input[type=radio]').change(function(){
			var name = $(this).attr('name');
			$('input[name=' + '"' + name + '"' +']').parent().removeClass('checked');
			$(this).parent().addClass('checked');
		});
		
		//checkboxの監視
		$('input[type=checkbox]').change(function(){
			if($(this).attr('checked')){
				$(this).parent().addClass('checked');
			}else {
				$(this).parent().removeClass('checked');
			}
		});
	}
}