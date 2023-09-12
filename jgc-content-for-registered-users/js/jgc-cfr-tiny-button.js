(function() {
	tinymce.PluginManager.add('jgccfr_mce_button', function( editor, url ) {
		editor.addButton('jgccfr_mce_button', {
			text: '[CFR]',
			title: 'JGC Content for Registered Users Shortcode',
			icon: false,
			type: 'button',
			onclick: function(){	
					selected = editor.selection.getContent({format : "html"}) != '' ? editor.selection.getContent({format : "html"}) : 'Hidden content here' ;
					editor.insertContent( '[jgc_cfr]' + selected + '[/jgc_cfr]');
											
					} // onclick
		});
	});
})();