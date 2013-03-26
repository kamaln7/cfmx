$(function(){
	function creds_message(message){
		if(message == ''){
			$('#creds_message').parent().parent().slideUp();
		}else{
			$('#creds_message').html(message).parent().parent().slideDown();
		}
	}
	var email, token;

	$('#creds').click(function(){
		creds_message('');
		var $email = $('#inputEmail'),
			$key = $('#inputKey'),
			lemail = $email.val(),
			lkey = $key.val(),
			$button = $(this);

		email = lemail;
		token = lkey;

		$(this).prop('disabled', 'disabled');

		$.post('api/domains.php', {'email': email, 'key': token}, function(resp){
			if(resp.status == 'false'){
				creds_message(resp.message);
				$button.prop('disabled', '');
			}else{
				$.each(resp.zones, function(){
					$('#zones_list').append('<tr><td>' + this.zone_name + '</td><td class="' + (this.has_mx ? 'success' : 'error') + '">' + (this.has_mx ? 'Yes' : 'No') + '</td><td><button class="btn btn-info addmx" data-zone="' + this.zone_name + '">Add MX Records</button></td></tr>');
				});
				$('#zones_list').parent().parent().slideDown();
			}
		}, 'json');

		return false;
	});

	$('.addmx').live('click', function(){
		$button = $(this);
		$button.prop('disabled', 'disabled');

		$.post('api/add.php', {'email': email, 'key': token, 'domain': $button.data('zone')}, function(resp){
			if(resp.status == false){
				$button.removeClass('btn-info').addClass('btn-danger').html(resp.message).prop('disabled', '');
			}else{
				$button.removeClass('btn-info').removeClass('btn-danger').addClass('btn-success').html('Added MX Records.');
				$button.parent().prev().removeClass('error').addClass('success').html('Yes');
			}
		}, 'json');

		return false;
	});
});