<?php
define('TITLE_GOMAPS','Plugin GoMaps');
define('DESCRIPTION_GOMAPS','This simple plugin displays a Google Maps in the administrative panel to publish / update a post and also for creating / updating a user to then capture and store latitude and longitude in a custom field to be used of the developer.');
define('TITLE_USE_GOMAPS','Use of the plugin');
define('DESCRI_USE_GOMAPS','the plugin save the latitude and longitude of Google Maps in a custom field called pto_gomaps. If you want to use it in your theme, you must use the codex <b>get_post_meta</b> or for user <b>get_the_author_meta</b>.');
define('EXAMPLE_USE_GOMAPS','Example: <b>get_post_meta($post->ID, \'pto_gomaps\', true)</b> or <b>the_author_meta(\'user_email\',$post->ID);</b>');
define('LABEL_GOMAPS','API Google Maps');
define('GET_API','Where I can get the API?');
define('WHERE_GOMAPS','Where wish you display the maps');
define('USER_GOMAPS','Users');
define('POST_GOMAPS','Posts');

define('SUBTITLE_GOMAPS','GoMaps');
define('SUBDESCRIP_GOMAPS','Click on the map');

define('BUTTOM_GOMAPS','Saved');
?>