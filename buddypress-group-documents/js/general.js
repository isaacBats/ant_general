jQuery(document).ready( function($) {

	//Hide the sort form submit, we're gonna submit on change
	$('#bp-group-documents-sort-form input[type=submit]').hide();
	$('#bp-group-documents-sort-form select[name=order]').change(function(){
		$('form#bp-group-documents-sort-form').submit();
	});

	//Hide the upload form by default, expand as needed
	$('#bp-group-documents-upload-new').hide();
	$('#bp-group-documents-upload-button').show();
	$('#bp-group-documents-upload-button').click(function(){
		$('#bp-group-documents-upload-button').slideUp();
		$('#bp-group-documents-upload-new').slideDown();
		return false;
	});
		
	//check for presence of a file before submitting form
	$('form#bp-group-documents-form').submit(function(){
		if( $('input[name=bp_group_documents_operation]').val() == 'add' ) {
			if($('input#bp-group-documents-file').val()) {
				return true;
			}
			alert('You must select a file to upload!');
			return false;
		}
	});	

	//Make the user confirm when deleting a document
	$('a#bp-group-documents-delete').click(function(){
		return confirm('Are you sure you wish to permanently delete this document?');
	});

	//Track when a user clicks a document via Ajax
	$('a.group-documents-title').add($('a.group-documents-icon')).click(function(){
		dash_position = $(this).attr('id').lastIndexOf('-');
		document_num = $(this).attr('id').substring(dash_position+1);

		$.post( ajaxurl ,{
			action:'bp_group_documents_increment_downloads',
			document_id:document_num
		},function(response){
			alert(reposnse);
		});

	});

});
