		$(function(){
			$('#text_id').focus();
			
			var txt = $('h2 span');
			var cngText = function(t){
				txt.fadeOut(300,function(){
					txt.removeClass("error").text(t).fadeIn(300)
				})
			}
			
			$('.forget a').click(function(){
				$('form').animate({'left':'-400px'},500);
				cngText("メールアドレスを入力してください。");
			});
			$('.back a').click(function(){
				$('form').animate({'left':'0'},500);
				cngText("メールアドレスとパスワードを入力してください。");
			});
			
			$('#first_image').load(function(){
				$('#images').fadeIn(300);
			});
			
			if($('.error').length){
				$('#window')
					.css({"opacity":"1","left":"0px"})
					.animate({"left":"-10px"},100)
					.animate({"left":"10px"},100)
					.animate({"left":"-10px"},100)
					.animate({"left":"10px"},100)
					.animate({"left":"0px"},100);				
			}else {
				$('#window').animate({
					"opacity":1,
					"left":"0px"
				},300);
			}
			
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
			
		});