// JavaScript Document

jQuery(function($){

	/*MEDIA*/
	$('.clp-media').click(function(){
		var media = $(this).val();
		$('#lightbox_'+media).removeAttr('disabled').focus();
		if(media === 'video')
		{
			$('#lightbox_image').attr('disabled', 'disabled').val('');
			$('#lightbox_talkfusion').attr('disabled', 'disabled').val('');
		
		}
		else if(media === 'talkfusion')
		{
			$('#lightbox_video').attr('disabled', 'disabled').val('');
			$('#lightbox_image').attr('disabled', 'disabled').val('');
		}
		else if(media === 'image')
		{
			$('#lightbox_video').attr('disabled', 'disabled').val('');
			$('#lightbox_talkfusion').attr('disabled', 'disabled').val('');
		}
	});
	
	/*ON PASTE, GET FORM*/
	$('#autoresponder').bind('paste', function(){
		var field = $(this);
		setTimeout(function(){
			var html = escape($(field).val());
		
			$.post(ajaxurl, 'action=clp_process_autoresponder&html='+html, function(response){
				var data = $.parseJSON(response);
				$(field).val(data.html);
			});
		}, 150);
	});
	
	/*ON PASTE, GET FORM FIELDS*/
	$('#autoresponder').bind('paste', function(){
		var response = '';
		var field = $(this);									   
		setTimeout(function(){
			var html = escape($(field).val());
			var sel = $('.clp-select');
			$(sel).html('');
			$.ajax({
			   type: 'POST',
			   url: ajaxurl,
			   data: 'action=clp_process_fields&html='+html,
			   success: function(response){
				   $(sel).append(response);
			   }
			});
		}, 150);
	});

	/*DELETE COOKIE*/
	$('#clp-delete-cookie').click(function(){
		$.post(ajaxurl, 'action=clp_delete_cookie', function(response){
			alert(response);
		});
		return false;
	});
});