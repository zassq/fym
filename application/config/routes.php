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

#$route['default_controller'] = "welcome";
$route['default_controller'] = "home";
$route['404_override'] = '';

# auth pages
$route['users/(:any)'] = "users/$1";
$route['view_profile'] = "users/view_profile";
$route['user_update/(:num)'] = "users/user_update/$1";
$route['user_delete/(:num)'] = "users/user_delete/$1";
$route['user_get_client'] = "users/user_get_client";
$route['user_get_history'] = "users/user_get_history";

$route['clients/(:any)'] = "clients_controller/$1";
$route['client/(:num)'] = "clients_controller/view/$1";

$route['client_filter'] = 'clients_controller/client_filter';
$route['client_filter_upload'] = 'clients_controller/client_filter_upload';
$route['client_add_ml'] = 'clients_controller/client_add_ml';
$route['client_update/(:num)'] = 'clients_controller/client_update/$1';
$route['client_list_ajax'] = 'clients_controller/client_list_ajax';

$route['add_to_my_client'] = 'clients_controller/add_to_my_client';
$route['export_from_upload'] = 'minor/export_from_upload';

$route['ml_edit/(:num)'] = 'ml_action/ml_edit/$1';
$route['ml_delete/(:num)'] = 'ml_action/ml_delete/$1';
/* End of file routes.php */
/* Location: ./application/config/routes.php */