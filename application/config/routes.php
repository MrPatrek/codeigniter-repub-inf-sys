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



$route['register'] = 'users/register';
$route['login'] = 'users/login';
$route['logout'] = 'users/logout';

$route['profile/(:any)'] = 'users/profile/$1';



$route['edit-report-requests/(:any)'] = 'reports/edit_report_request_view/$1';
$route['edit-appeal-requests/(:any)'] = 'reports/edit_appeal_request_view/$1';
$route['edit-report-requests'] = 'reports/edit_report_requests_index';
$route['edit-appeal-requests'] = 'reports/edit_appeal_requests_index';


$route['approve-report-edit/(:any)'] = 'reports/approve_report_edit/$1';
$route['disapprove-report-edit/(:any)'] = 'reports/disapprove_report_edit/$1';
$route['approve-appeal-edit/(:any)'] = 'reports/approve_appeal_edit/$1';
$route['disapprove-appeal-edit/(:any)'] = 'reports/disapprove_appeal_edit/$1';



$route['edit-report/(:any)'] = 'reports/edit_report_request/$1';
$route['edit-appeal/(:any)'] = 'reports/edit_appeal_request/$1';


$route['delete-report/(:any)'] = 'reports/delete_request/$1';

$route['delete-requests'] = 'reports/delete_requests_index';
$route['delete-requests/(:any)'] = 'reports/delete_request_view/$1';

$route['approve-delete/(:any)'] = 'reports/delete_approve/$1';
$route['disapprove-delete/(:any)'] = 'reports/delete_disapprove/$1';





$route['answer/(:any)'] = 'reports/answer/$1';
$route['appeal/(:any)'] = 'reports/appeal/$1';



$route['reports/citizen/(:any)'] = 'reports/index_for_citizen/$1';
$route['reports/authorities/(:any)'] = 'reports/index_for_authorities/$1';
$route['reports/(:any)'] = 'reports/view/$1';
$route['reports'] = 'reports/index';
// $route['reports'] = 'reports';		// Причем этот тоже работает. Наверное потому, что index - это типа главная функция. Или может потому, что она - единственная. Хз почему.
$route['create'] = 'reports/create';



$route['default_controller'] = 'pages/view';
$route['(:any)'] = 'pages/view/$1';



$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;



// А вообще, шаблон иерархии выглядит примерно так:
// $route['news/create'] = 'news/create';
// $route['news/(:any)'] = 'news/view/$1';
// $route['news'] = 'news';
// $route['(:any)'] = 'pages/view/$1';
// $route['default_controller'] = 'pages/view';
