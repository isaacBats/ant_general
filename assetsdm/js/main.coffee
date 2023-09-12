$ ->
	$('#form_login').submit ->
		$.post($(this).attr('action'),$(this).serialize(),(e)->
			$('#login_message').html(e)
		)
		return false


	if($('.list_buttons').size())
		$('.list_buttons').buttonset()

	if($('.button_set').size())
		$('.button_set').buttonset()

	if($('.button').size())
		$('.button').button()

	$('.del').click ->
		return false if !confirm('Seguro que quieres borrar este registro?')


	button = $('#upload_button .ui-button-text')

	$('#imagen_gal a').click ->
		if !confirm 'Desea eliminar la imagen'
			return false
		