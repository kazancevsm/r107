<?php
/*
+ ------------------------------------------------------------------------------+
|	© е107 Клуб 2010-2011. Все права защищены.									|
|	Сайт: http://www.e107club.ru												|
|	Почта: plugin@e107club.ru													|
|	Плагин: Прокрутка страницы													|
|	Версия: 1.2																	|
|	Дата: 07.07.2011 05:05:05													|
|	Автор: © Кадников Александр	[Predator]										|
+-------------------------------------------------------------------------------+
*/

	header('Content-type: text/javascript');
	@require_once("../../class2.php");
	
	global $pref;
	
	echo "(function(jq) {
			jq.autoScroll = function(ops) {
			ops = ops || {};
			ops.styleClass = ops.styleClass || 'top-button';
			var t = jq('<div class=\"'+ops.styleClass+'\"></div>'),
            d = jq(ops.target || document);
			jq(ops.container || 'body').append(t);

			t.css({
				opacity: 0,
				position: 'absolute',
				top: 0,
				right: 0,
				'margin-top': ($(window).height() - (75 - ".ceil(32 - $pref['tb_size']).")) + 'px'
			}).click(function() {
				jq('html,body').animate({
					scrollTop: 0
				}, ops.scrollDuration || 1000);
			});

			d.scroll(function() {
				var sv = d.scrollTop();
				if (sv < 10) {
					t.clearQueue().fadeOut(ops.hideDuration || 200);
					return;
				}

				t.css('display', '').clearQueue().animate({
					top: sv,
					opacity: 0.8
				}, ops.showDuration || 500);
			});
		};
	})(jQuery);
	
	$(document).ready(function(){
		$.autoScroll({
			scrollDuration: 800, 
			showDuration: 600, 
			hideDuration: 300
		});
	});	
";	
	
	
?>