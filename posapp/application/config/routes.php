<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] 	= 'Page';
$route['404_override'] 			= '';
$route['translate_uri_dashes'] 	= FALSE;

$route['auth'] 					= 'page/auth';
$route['home'] 					= 'page/home';
$route['add'] 					= 'page/add';
$route['barang']				= 'page/barang';
$route['input'] 				= 'page/input';
$route['edit/(:num)']			= 'page/edit/$1';
$route['editcat/(:num)']		= 'page/editcat/$1';
$route['delete/(:num)']			= 'page/delete/$1';
$route['delcat/(:num)']			= 'page/delcat/$1';
$route['inputcat'] 				= 'page/inputcat';
$route['addcat'] 				= 'page/addcat';

$route['pengguna']       		= 'page/users';
$route['insertuser']       		= 'page/insertuser';
$route['edituser/(:num)']  		= 'page/edituser/$1';
$route['updateuser']       		= 'page/updateuser';
$route['deluser/(:num)']       	= 'page/deluser/$1';
$route['adduser']       		= 'page/adduser';

$route['lihat_laporan'] 		= 'page/lihat_laporan';
$route['laporan'] 				= 'page/laporan';
$route['carinota'] 				= 'page/carinota';

$route['aplikasi']				= 'page/aplikasi';
$route['updateapp']				= 'page/updateapp';

$route['bersihkan']				= 'page/bersihkan';
$route['clean']					= 'page/clean';

$route['restok']				= 'page/restok';
$route['index'] 				= 'page/index';

$route['detail_trx/(:any)']	    = 'page/detail_trx/$1';
$route['detail_brg/(:num)']	    = 'page/detail_brg/$1';

$route['editnota/(:any)']	    = 'page/editnota/$1';
$route['edit_trx']	            = 'page/edit_trx';

$route['cartdestroy']			= 'penjualan/cartdestroy';
$route['updatecart']			= 'penjualan/updatecart';
$route['removecart/(:any)']		= 'penjualan/removecart/$1';
$route['caribarang']			= 'penjualan/caribarang';
$route['transaction']			= 'penjualan/transaction';
$route['cart']					= 'penjualan/cart';

$route['satuan'] 				= 'page/satuan';
$route['addsatuan'] 			= 'page/addsatuan';
$route['editsatuan/(:num)'] 	= 'page/editsatuan/$1';
$route['updatesatuan'] 			= 'page/updatesatuan';
$route['delsatuan/(:num)'] 		= 'page/delsatuan/$1';

$route['edit'] 					= 'page/edit';
$route['update'] 				= 'page/update';
$route['updatecat'] 			= 'page/updatecat';
$route['delete'] 				= 'page/delete';
$route['reset'] 				= 'page/reset';
$route['logout'] 				= 'page/logout';
