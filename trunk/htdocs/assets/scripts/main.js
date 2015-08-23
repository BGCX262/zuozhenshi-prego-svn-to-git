$(function(){


	/*-- 共通メソッドの実行 ------------------------------------------*/

	accordion("#accordion"); 	// サイドメニューの設定
	setControls();				// alertが出る項目の制御
	setScroller();				// ページ先頭ボタン
	setSearchFrom();			// 検索フォームの微調整
	$(".colorbox , .popup").colorbox({width:'800px',height:'95%'});
	$('.tooltip').powerTip({placement: 'ne'});

	setRadioAndCheckbox();													// radio,checkboxの装飾
	$("select, input:file").uniform();										//selectとファイル選択の装飾
	$('td:has(.error)').parent().addClass("required");						//エラーメッセージを持つセルに着色
	$('table tbody tr:odd').addClass('odd');								//テーブルの装飾

	//$(".smartspinner").spinit({ width:54, height: 20});
	if($('#modules').size() > 0){moduleOrder(true,false,true);}			// モジュールの並び替え トップのみ強制実行
	if($('textarea:not(.mce_edit)').size() > 0)$('textarea').autogrow();	// autogrow
	if($(".sortable").size() > 0){$(".sortable").tablesorter();} 			// sortable

	/*------------------------------------------------------------*/
	//押したら.activeを付加するメニュー
	if($('.activemenu').size() > 0){
		$('.activemenu a').click(function(){
			var p = $(this).closest(".activemenu");
			$('a',p).removeClass("active");
			$(this).addClass("active");
		});
	}

	//accordionTable
	$('.accordionTable thead th').live("click",function(){
		var p = $(this).closest('table');
		$("tbody",p).toggle();
		$(this).toggleClass("active");
	});

	//search address
	$('.searchAddress').live('click',function(){
		var p = $(this).closest("td");
		var table = $(this).closest("table");
		var post1 = $('.post1',p).val();
		var post2 = $('.post2',p).val();
		if(post1 == "" || post2 == ""){return;}
		var post = post1 +""+ post2;

		zip2address(post, function(address) {
		if (address) {
			$('.resultAddress',table).val(address.all);
		}
		else {
			alert("見つかりませんでした。。\n入力した郵便番号に誤りがないか、お確かめ下さい。");
		}
	});

	});
});


/*-- 全ページ共通 --------------------------------------------------------------------*/

var moduleOrder = function(modules,aside,setup){

	var order = function(m,a){
		var max = $('#aside_inner > ul').length -1;
		var container = $("#module_container");
		for(var i = max; i >= 0; i--){
			if(m && container.size() > 0){
				var id = $.cookie('module_'+i);
				$('#'+id).prependTo('#module_container');
			}
			if(a){
				var id_side = $.cookie('side_module_'+i);
				$('#'+id_side).prependTo('#aside_inner');
			}
		}
	}

	if(setup){
		$("#module_container").sortable({
			handle : "h3,ul",
			placeholder : "module_placeholder",
			scroll:true,
			revert:200,
			tolerance:"pointer" ,
			start : function(){

				var t = $("#aside_inner > p");
				if(t.hasClass("active")){
					t.click();
				}
				$("body").append("<div id='righttopmsg'>並べたい位置に移動して、クリックを離して下さい。</div>");
				$('#righttopmsg').show(300);
			},
			deactivate : function(event, ui){
				//$('#modules div').animate({height:"180px"},200);
				//$('#modules div ul').show();
				$('#righttopmsg').fadeOut(300,function(){$(this).remove();});
				$('#module_container div').map(function(idx, obj){
					$.cookie('module_'+idx, $(this).attr('id'), {expires : 30});
					$.cookie('side_module_'+idx, "side_"+$(this).attr('id'), {expires : 30});
				});

				//この時点ではasideのsortはフラグ立てのみ
				//この状態で開いた段階でsortを実行する
				$('aside').addClass("sort_wait");
			}
		});
	}

	//init
	order(modules,aside);
}

var accordion = function(p){

	var aside = $("aside");

	if(aside.size() == 0){return;}

	var that = {};

	$('#aside_inner > ul > li > a > span').each(function(){
		$(this).html($(this).html().replace("<br />",'').replace("<br>",''));
	});

	that.checkSortFlag = function(){
		//sortのフラグチェック
		if(aside.hasClass("sort_wait")){
			moduleOrder(false,true);
			aside.removeClass("sort_wait");
		}
	};

	that.toggleAnimation = function(){

		var maxtop = 0;
		var maxbottom = 0;
		var defaultLeft = aside.offset().left+$('p',aside).width();
		var defaultX = $('p',aside).css("left");
		var defaultTop = aside.offset().top;
		var arrowWidth = $('p',aside).width();
		aside.animate({'left':defaultLeft+'px'},600).addClass("first-state");
		$('p a',aside).click(function(){

			that.checkSortFlag();

			var l = 0;
			if(aside.css('left') == "0px"){ //:open
				l = defaultLeft;
				$('p',aside).removeClass("active");
				aside.animate({left:(l-arrowWidth)+"px"},300,function(){
					aside.css({position:"fixed",top:defaultTop+"px"}).animate({left:defaultLeft+'px'},300);
				});
				$('p',aside).css({position:"absolute",top:"0px"});
				maxtop = 0;
			}else{ //閉じてる
				var stateScroll = $(document).scrollTop();
				$('p',aside).addClass("active");
				aside.css({position:"absolute",top:(stateScroll+defaultTop)+"px"});
				$('p',aside).css({position:"fixed",left:"0px",top:defaultTop+"px"}).animate({left:defaultX},300);
				maxtop = aside.offset().top-defaultTop;
				maxbottom = aside.height()+aside.offset().top-100;
				if(aside.hasClass('first-state')){
					moduleOrder(false,true);
					aside.removeClass('first-state');
				}
			}
			aside.animate({'left':l + 'px'},300);
		});

		$(window).scroll(function() {
			if(maxtop > 0){
				if($(document).scrollTop() < maxtop){
					$('p',aside).css({position:"absolute",top:"0px"});
				}
				else if($(document).scrollTop() > maxbottom){
					$('p',aside).css({position:"absolute",top:(aside.height()-defaultTop)+"px"});
				}else {
					$('p',aside).css({position:"fixed",top:defaultTop+"px"});
				}
			}
		});
	};

	//init
	that.toggleAnimation();

	that.hide = function(target,h){
		target.animate({height:"0px"},300,
			function(){
				$(this).hide().css({height:h+'px'})
			});
	};

	that.start = function(obj){
		//クリックしたノード周辺
		var parent = $(obj).parent().parent();
		var inner = $('ol',parent);
		var h = inner.height();
		//展開済のノード
		var before = ($('ul.active',p).size() > 0) ? $('ul.active ol',p) : "";

		$('ul',p).removeClass("active");
		parent.addClass("active");

		if(inner.is(':hidden')){
			if(before != ""){
				that.hide(before,before.height());
			}
			inner.show().css({height:"0px"}).animate({height:h+"px"},300);
		}else {
			if(before != ""){
				that.hide(inner,h);
			}
			$('ul',p).removeClass("active");
		}
	};

	//クリックイベントを付与
	$('ul > li a',p).click(function(){
		that.start($(this));
	});

	return that;
}

//add new input field
var setAppendCtrl = function(id,html){
	$('.del_item').live("click",function(){
		var deleteItem = function(){
			that.closest("table").remove();
		}
		var that = $(this);
		var v = $('input[type=text]',$(this).closest('tr')).val();
		if(v != ""){
			customConfirm('削除しますか？',"",$(this),function(){
				deleteItem();
			});
		}else {
			deleteItem();
		}
	});

	//add new item
	$('.btns .left').click(function(){
		var addArea = $(id);
		addArea.append(html);
		setRadioAndCheckbox();
		$("td > select, input:file").uniform();
	});

	//delete all item with blank field
	$('.btns .right a').click(function(){
		$('tbody input[type=text]',$(id)).each(function(){
			if(!$(this).val()){
				$(".del_item",$(this).closest('tr')).click();
			}
		});
	});
}

/*-- UIの装飾 --------------------------------------------------------------------*/

var setSearchFrom = function(){
	if($('#search_form').not('.nofix').size() == 0){return;}
	var dtw = 0;
	var ddw = 0;
	$('#search_form dt').each(function(){
		if($(this).outerWidth() > dtw){dtw = $(this).outerWidth();}
	});
	$('#search_form dl:not(.noCmp) dd').each(function(){
		if($(this).outerWidth() > ddw){ddw = $(this).outerWidth();}
	});
	$('#search_form dt').width(dtw);
	$('#search_form dl:not(.noCmp) dd').width(ddw);
}

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

var sortableTable = function(c){
	/*--- テーブルセルのドラッグ ---*/
	var op = ($('.draggable').hasClass('noTip')) ? "on" : "";
	$('.draggable input').click(function(){$(this).focus();});

	$(".draggable tbody").sortable({
		start: function(event, ui) {
			$("body").append("<div id='righttopmsg'>並べたい位置に移動して、クリックを離して下さい。</div>");
			$('#righttopmsg').show(300);
		},
		stop: function(event, ui) {
			$('#righttopmsg').fadeOut(300,function(){$(this).remove();});
		}
	});
	$(".draggable tbody").disableSelection();
	//$(".draggable tbody td").width($(this).width()); //ドラッグ中サイズが不安定なため固定しておく
	if(op == ""){
		$(".draggable tr td:last-child").append("<span class='ddmsg'>ドラッグ&ドロップで並び替え</span>");
	}
}

/*-- フォーム関係 --------------------------------------------------------------*/

//呼び出し元でpreventDefaultで制御し、
//表示メッセージと実行したい関数を渡してこちらで処理する
var customConfirm = function(msg,mode,obj,callback,direction){

	var m = (mode != "") ? mode : 'default';
	var c = (direction) ? "directon_e" : "";

	var closeConfirm = function(){
		if($('#modal_background').size() > 0){
			$('#modal_background').fadeOut(300,function(){$(this).remove();});
			var t = $('#confirm_container').offset().top;
			$('#confirm_container').css({"position":"absolute"}).animate({"opacity":0,"top":(t-20)+"px"},300,function(){$(this).remove();});
		}
	}

	$('body').append('<div id="modal_background" class="white">modal is active</div>');
	$('#modal_background').fadeIn(300).height($(document).height());
	$('body').append('<div id="confirm_container" class="' + c + '"><p>' + msg + '</p><ul><li class="yes"><a href="javascript:;">YES</a></li><li class="no"><a href="javascript:;">NO</a></li></ul></div>');

	var x,y;
	if(direction == "e"){
		x = obj.offset().left-$('#confirm_container').width()-5;
		y = obj.offset().top-(($('#confirm_container').height()-obj.height())/2);
	}else {
		x = obj.offset().left-(($('#confirm_container').width()-obj.width())/2);
		y = obj.offset().top-$('#confirm_container').height();
	}
	if(y-18 > 0 ){
		$('#confirm_container').addClass(m).show().css({"position":"absolute","opacity":0,'left':x+"px",'top':y+"px"}).animate({"opacity":1,"top":y-18+"px"},300);
	}else{
		$('#confirm_container').addClass(m).show().css({"position":"absolute","opacity":0,'left':x+"px",'top':y+"px"}).animate({"opacity":1,"top":y+100+"px"},300);
	}
	$('#modal_background').click(function(){
		closeConfirm();
	});

	$('#confirm_container li a').click(function(){
		var i = $('#confirm_container a').index($(this));
		if(i == 0){ //yes
			closeConfirm();
			callback();
		}else { //no
			closeConfirm();
			return false;
		}
	});
}

var form_validation = function(){
	var flag = 0;
	$('.must').each(function(){
		var p = $(this).parent();
		var t = "input:not([type=file])";
		if(($('.mce_edit',p).size() > 0)){t = "iframe";return;}
		else if(($('textarea',p).size() > 0)){t = "textarea";}

		if(
			(t.indexOf("iframe") == -1 && $(t,p).val() == "") ||
			((t == "iframe" && $(t,p).contents().find('body').html() == "<p>&nbsp;</p>")) ||  // for ie 9
			((t == "iframe" && $(t,p).contents().find('body').html() == "<P>&nbsp;</P>")) ||  // for ie 7,8
			((!jQuery.browser.mozilla && t == "iframe" && $(t,p).contents().find('body').html().indexOf("data-mce-bogus") != -1)) || // for chrome
			(jQuery.browser.mozilla && t == "iframe" && $(t,p).contents().find('body').html() == '<p><br data-mce-bogus="1"></p>') // for mozilla
			){
				//flag++;
				//p.addClass("required");
				//if($('td .error',p).size() == 0){
				//	$(' > td',p).append('<p class="error">必須項目です</p>');
				//	$('td .error',p).fadeIn("slow");
				//}
		}else {
			p.removeClass("required");
			$('td .error',p).remove();
		}
	});
	return (flag > 0) ? false : true;
	//return true;
}
/*
var validateError = function(){
	$("body").append("<div id='righttopmsg' class='error'>入力漏れが御座います。赤枠の項目を入力して下さい。</div>");
	//最初のrequiredの場所までスクロールする
	if($(document).scrollTop() >  $('.required').offset().top-100){
		$('html,body').animate({scrollTop : $('.required').offset().top-100 + "px"}, '100','swing');
	}
	$('#righttopmsg').show(300,function(){
		$(this).delay(3000).fadeOut(300,function(){
			$(this).remove();
		});
	});
}
*/

var remove_img = function(index){
	loading();
	var form = $('form[name=fm]',form);
	pushID();
	$('input[name=del_num]',form).val(index);
	$('input[name=mode]',form).val('remove_img');
	form.action = '#pic';
	form.submit();
}

var pushID = function(){
	var form = $('form[name=fm]',form);
	var arrCategory = new Array();
	$('#selected_category li').each( function(){
		arrCategory.push( $(this).attr('id'));
	});
	$('input[name=category]',form).val(arrCategory.toString());
}

var delete_img  = function(index){
	loading();
	pushID();
	var form = $('form[name=fm]',form);
	$('input[name=del_num]',form).val(index);
	$('input[name=mode]',form).val('delete_img');
	form.submit();
}

var setControls = function(){
	var that = {};

	if($('.text_date').size() > 0){
		$('.text_date').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'
		});
	}

	var form = $('form[name=fm]',form);
	var logout_form = $('form[name=logout_form]',logout_form);

//	$('.btn_back,.chk_back').click(function(){
//		var ref = document.referrer;
//		location.href = ref;
//	});

	$('.btn_regist , .chk_add').unbind().click(function(e){

		var dir = ($(this).hasClass('chk_regist') || $(this).hasClass('chk_add')) ? "e" : "";

		e.preventDefault();
		if(form_validation() == true){
			customConfirm("登録してよろしいですか？","",$(this),function(){
				if(window.service_spec_fee){
					if(!service_update())
						return;
				}
				loading();
				pushID();
				$('input[name=mode]',form).val('input');
				form.submit();
			},dir);
		}
//			else {
//			validateError();
//		}
	});
	$('.btn_update').unbind().click(function(e){
		var dir = ($(this).hasClass('chk_update')) ? "e" : "";
		e.preventDefault();
		if ($(this).hasClass('disp')){
			loading();
			pushID();
			$('input[name=mode]',form).val('input');
			form.submit();
			return;
		}
		if(form_validation() == true){
			customConfirm('更新してよろしいですか？',"",$(this),function(){
				if(window.service_spec_fee){
					if(!service_update())
						return;
				}
				loading();
				pushID();
				$('input[name=mode]',form).val('input');
				form.submit();
			},dir);
		}
//		else {
//			validateError();
//		}
	});

	// add by zhangxin
	$('#button_logout').unbind().click(function(e){

		var dir = ($(this).hasClass('logout')) ? "e" : "";
		e.preventDefault();

		customConfirm('ログアウトしてもよろしいですか？',"",$(this),function(){
			loading();
			logout_form.submit();
		},dir);
	});

//	$('.btn_copy').unbind().click(function(e){
//
//		var dir = ($(this).hasClass('chk_copy')) ? "e" : "";
//
//		e.preventDefault();
//		customConfirm('コピーしてよろしいですか？',"",$(this),function(){
//			loading();
//			pushID();
//			$('input[name=mode]',form).val('copy');
//			form.submit();
//		},dir);
//	});
	$('.btn_del').unbind().click(function(e){

		var dir = ($(this).hasClass('chk_delete')) ? "e" : "";

		e.preventDefault();
		customConfirm('削除してよろしいですか？',"alert",$(this),function(){
			loading();
			$('input[name=mode]',form).val('delete');
			form.submit();
		},dir);
	});
	$('.uploadPic').unbind().change(function(e){
		loading();
		$('input[name=mode]',form).val('upload');
		form.action = '#pic';
		form.submit();
	});
	$('.btn_upload').unbind().click(function(e){
		loading();
		pushID();
		$('input[name=mode]',form).val('upload');
		form.submit();
	});

	$('#btn_new').unbind().click(function(e){
		loading();
		$('input[name=mode]',form).val('new');
		form.submit();
	});


	$('#optYear').unbind().change(function(e){
		loading();
		$('input[name=mode]',form).val('change');
		form.submit();
	});

	$('#addPic').unbind().click(function(e){
		var max_uploads = 20;

		if( $(this).attr('rel') >= max_uploads ){
			alert('これ以上追加できません');
		}else{
			loading();
			$('input[name=mode]',form).val('add_img');
			form.action = '#pic';
			form.submit();
		}
	});
}

/*-- ナビゲーション・その他 --------------------------------------------------------------*/

var back_to_search = function(){
	var ref = document.referrer;
	var now = location.href;
	if(ref != now && typeof ref != "undefined" && typeof now != "undefined" && now.indexOf("?") != -1){
		$("body").append('<p id="back_to_result"><a href="' + ref + '">検索結果に戻る</a></p>');
		$('#back_to_result').delay(500).animate({left:"0px"},500);
	}
}

var setScroller = function(){
	var flag = 0;
	var scrollToTop = function(){
		flag = 1;
		$('html,body').animate({ scrollTop: 0 }, 'slow','swing',function(){flag = 0;$('#totop').fadeOut(300);});
		return false;
	}

	//TOPに行くボタンを拵える
	$('body').append("<div id='totop'><p><a href='javascript:;'>TO PAGE TOP</a></p></div>");
	$('#totop').click(function(){scrollToTop();});
	$(window).scroll(function() {
		if(flag == 0){
			if($(document).scrollTop() > 100){
				if($('#totop').is(':hidden')){
					$('#totop').fadeIn(300);
				}
			}else {
				$('#totop').fadeOut(300);
			}
		}
	});
}

var loading = function(t){
	if(t){
		$('#loading').fadeOut(500,function(){$(this).remove()});
	}else {
		var l = '<div id="loading"><p>読み込み中...</p></div><div id="loadingBg">&nbsp;</div>';
		$('body').append(l);
		$('#loading').fadeIn(300);
	}
}