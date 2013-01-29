// JavaScript Document

jQuery(function($){
		
	//FOCUS/BLUR
	$('.clp-name').live('focus', function(){
		var value = $(this).val();
		if(value === 'Your First Name...')
		{
			$(this).val('');	
		}
	});
	$('.clp-name').live('blur', function(){
		var value = $(this).val();
		if(value === '')
		{
			$(this).val('Your First Name...');	
		}
	});
	$('.clp-email').live('focus', function(){
		var value = $(this).val();
		if(value === 'Your Email Address...')
		{
			$(this).val('');	
		}
	});
	$('.clp-email').live('blur', function(){
		var value = $(this).val();
		if(value === '')
		{
			$(this).val('Your Email Address...');	
		}
	});
	
	$('.clp-close').live('click', function(){
		$.colorbox.close()
		return false;
	});
});