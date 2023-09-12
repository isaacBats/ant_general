<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "inicio/inicio2019";
//$route['(:any)'] = "home/$1";
$route['404_override'] = 'inicio/pagina/error404';

$route['GeneralAdm'] 				= "admin/home";
$route['GeneralAdm/home/(:any)'] 	= "admin/home/$1";
$route['GeneralAdm/menu'] 			= "admin/crud";
$route['GeneralAdm/menu/(:any)'] 	= "admin/crud/$1";
$route['GeneralAdm/crud/(:any)'] 	= "admin/crud/$1";

/*$route['inicio2019'] 	= "inicio/inicio2019";*/
$route['general_es/contacto.html'] 	= "inicio/pagina/contacto2019";
$route['general_es/cotizador.html'] 	= "inicio/pagina/cotiza2019";
$route['guardaForm'] 	= "inicio/guardaForm";
$route['guardaFormCoti'] 	= "inicio/guardaFormCoti";
$route['landing/(:any)'] 		= "landing/page/$1";
$route['general_es/(:any)'] 	= "inicio/pagina/$1";
$route['general_is/(:any)'] 	= "home/page/$1";
$route['inicio'] 	= "inicio/inicio2019";



/* End of file routes.php */
/* Location: ./application/config/routes.php */