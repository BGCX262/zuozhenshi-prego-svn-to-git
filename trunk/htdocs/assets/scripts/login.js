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
				cngText("���[���A�h���X����͂��Ă��������B");
			});
			$('.back a').click(function(){
				$('form').animate({'left':'0'},500);
				cngText("���[���A�h���X�ƃp�X���[�h����͂��Ă��������B");
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
				// ie7�͒������K�v�Ȃ��߂Ƃ肠�������O
			}else {
				//2��ڗp�Ɉ�x�C�x���g���������Ă���
				$('input[type=radio],input[type=checkbox]').unbind();
				
				//���߂ɑS�đ������āAlabel�ɑ΂��ėv�f�ɑΉ������N���X�t�^�ƃ`�F�b�N�σN���X�t�^
				$('input[type=radio],input[type=checkbox]').each(function(){
					var p = $(this).parent();
					p.removeClass($(this).attr('type')).addClass($(this).attr('type'));
					if($(this).attr('checked')){
						p.addClass('checked');
					}
				});
				
				//radio�̊Ď�
				$('input[type=radio]').change(function(){
					var name = $(this).attr('name');
					$('input[name=' + '"' + name + '"' +']').parent().removeClass('checked');
					$(this).parent().addClass('checked');
				});
				
				//checkbox�̊Ď�
				$('input[type=checkbox]').change(function(){
					if($(this).attr('checked')){
						$(this).parent().addClass('checked');
					}else {
						$(this).parent().removeClass('checked');
					}
				});
			}
			
		});