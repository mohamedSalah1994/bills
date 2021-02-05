$(function() {
	'use strict'
	new PerfectScrollbar('#mainbillList', {
		suppressScrollX: true
	});
	new PerfectScrollbar('.main-content-body-bill', {
		suppressScrollX: true
	});
	$('#mainbillList .media').on('click', function(e) {
		$(this).addClass('selected');
		$(this).siblings().removeClass('selected');
		$('body').addClass('main-content-body-show');
	});
});
