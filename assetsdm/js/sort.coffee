$ ->
	$URL=$_GET("URL")
	create_sortable($URL) if $URL

create_sortable =($URL)->
	$('#banners_sortable').sortable
		scroll: true
		helper: fixHelper
		axis: 'y'
		update: ->
			save_sortable($URL);
	$('#banners_sortable').sortable('enable');

save_sortable =($URL)->

	serial=$('#banners_sortable').sortable('serialize');
			
	$.ajax
		url:$URL
		type:'POST'
		data:serial