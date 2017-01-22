$(function(){
'use strict';
// Trigger The Selectboxit

	$("select").selectBoxIt({

		autoWidth: false

	});
$('[placeholder]').focus(function(){
   $(this).attr('data-text', $(this).attr('placeholder'));
   $(this).attr('placeholder','');
   }).blur(function(){
$(this).attr('placeholder', $(this).attr('data-text'));
});

// Add Asterisk In Every Required Field
$('input').each(function(){
	if($(this).attr('required')==='required') {
		$(this).after('<span class="asterisk">*</span>');
	}
})

//Convert Password Field To Text Field On Hover
var passField=$('.password');
$('.show-pass').hover(function(){
	passField.attr('type','text');
}, function(){
passField.attr('type','password');	
});
// Confirmation Message On Button

	$('.confirm').click(function () {

		return confirm('Are You Sure?');

});
	$('.cat h3').click(function(){
    $(this).next('.full-view').fadeToggle(200);
	});

	
	$('.option span').click(function () {

		$(this).addClass('active').siblings('span').removeClass('active');

		if ($(this).data('view') === 'full') {

			$('.cat .full-view').fadeIn(200);

		} else {

			$('.cat .full-view').fadeOut(200);

		}

});
});



