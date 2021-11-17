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
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['contact'] = 'home/contact';
$route['docs'] = 'home/page/docs';
$route['faqs'] = 'home/page/faqs';
$route['states'] = 'home/ajax_page/states';
$route['districts/(:any)'] = 'home/ajax_page/districts/$1';
$route['db_check'] = 'home/db_check';
$route['about-us'] = 'home/page/about-us';
$route['privacy-policy'] = 'home/page/privacy-policy';
$route['blog'] = 'home/page/blog';
$route['help'] = 'home/page/help';

$route['dataview'] = 'home/index/dataview';
$route['dataeditor'] = 'home/index/dataeditor';
$route['dataanalyzer'] = 'home/index/dataanalyzer';

$route['login'] = 'login';
$route['login/success'] = 'login/success';
$route['login/logout'] = 'login/logout';
$route['login/myaccount'] = 'login/myaccount';
$route['login/edit_name'] = 'login/edit_name';
$route['login/edit_password'] = 'login/edit_password';
$route['login/savepassword'] = 'login/savepassword';
$route['login/setpassword/(:any)'] = 'login/setpassword/$1';
$route['login/check_username/(:any)'] = 'login/check_username/$1';
$route['login/profile/save/(:any)'] = 'login/profile_save/$1';
$route['login/forgot'] = 'login/forgot';
$route['login/savelocal'] = 'login/savelocal';
$route['login/syncfirstdata/(:any)'] = 'login/syncfirstdata/$1';
$route['login/syncfirstdataupdate/(:any)'] = 'login/syncfirstdataupdate/$1';
$route['login/theme/save'] = 'login/theme_save';

$route['dashboard/save'] = 'dashboard/save';
$route['dashboard/email'] = 'dashboard/email';
$route['dashboard/update/(:any)/(:any)/(:any)'] = 'dashboard/update/$1/$2/$3';
$route['dashboard/(:any)'] = 'dashboard/index/$1';
$route['dashboard/(:any)/(:any)'] = 'dashboard/panel/$1/$2';
$route['dashboard/(:any)/(:any)/(:any)'] = 'dashboard/panel/$1/$2/$3';

$route['template'] = 'template/index';									//all
$route['template/(:any)'] = 'template/index/$1';						//sector
$route['template/(:any)/(:any)'] = 'template/index/$1/$2';				//country
$route['template/(:any)/(:any)/(:any)/(:any)'] = 'template/view/$1/$2/$3/$4';	//view sector country title title_url 

$route['survey/save']='survey/survey_save';
$route['survey/duplicate']='survey/survey_duplicate_save';
/*$route['survey/duplicate/(:any)']='survey/survey_duplicate/$1';*/
$route['survey/ajxsort1/(:any)/(:any)']='survey/ajxsort1/$1/$2';
$route['survey/ajxsort2/(:any)/(:any)']='survey/ajxsort2/$1/$2';
$route['survey/edit/(:any)']='survey/survey_edit/$1';
$route['survey/editsave/(:any)']='survey/survey_editsave/$1';
$route['survey/compile/(:any)']='survey/survey_compile/$1';
$route['survey/lengths/(:any)']='survey/lengths/$1';
$route['survey/savelengths/(:any)']='survey/savelengths/$1';
$route['survey/conrol/(:any)']='survey/conrol/$1';
$route['survey/savecontrol/(:any)']='survey/savecontrol/$1';
$route['survey/newcase']='survey/newcase';


$route['survey/section/save/(:any)']='survey/section_save/$1';
$route['survey/section/edit/(:any)']='survey/section_edit/$1';
$route['survey/section/duplicate/(:any)']='survey/section_duplicate/$1';
$route['survey/section/delete/(:any)']='survey/section_delete/$1';
$route['survey/section/editsave/(:any)']='survey/section_editsave/$1';

$route['survey/question/add/(:any)/(:any)']='survey/question_add/$1/$2';
$route['survey/question/save/(:any)']='survey/question_save/$1';
$route['survey/question/edit/(:any)']='survey/question_edit/$1';
$route['survey/question/duplicate/(:any)']='survey/question_duplicate/$1';
$route['survey/question/editsave/(:any)']='survey/question_editsave/$1';
$route['survey/question/delete/(:any)/(:any)']='survey/question_delete/$1/$2';
$route['survey/question/collectcode/(:any)']='survey/question_collectcode/$1';
$route['survey/question/collectname/(:any)']='survey/question_collectname/$1';
$route['survey/question/savecodename/(:any)']='survey/question_savecodename/$1';
$route['survey/question/lengths/(:any)']='survey/question_lengths/$1';
$route['survey/question/savelengths/(:any)']='survey/question_savelengths/$1';
$route['survey/question/completequestion/(:any)']='survey/question_complete/$1';
$route['survey/question/default_name/(:any)']='survey/question_default_name/$1';

$route['survey/question/generatecode']='survey/question_generatecode';
$route['survey/question/generatecode/(:any)']='survey/question_generatecode/$1';
$route['survey/question/codesave/(:any)']='survey/question_codesave/$1';
$route['survey/question/search']='survey/question_search';
$route['survey/question/copy/(:any)/(:any)']='survey/question_copy/$1/$2';
$route['survey/elements/(:any)']='survey/survey_elements/$1';
$route['survey/style/(:any)']='survey/survey_style/$1';
$route['survey/style/save/(:any)']='survey/survey_style_save/$1';
$route['survey/section/style/(:any)']='survey/survey_section_style/$1';
$route['survey/section/style/save/(:any)']='survey/survey_section_style_save/$1';
$route['survey/question/style/(:any)']='survey/survey_question_style/$1';
$route['survey/question/style/save/(:any)']='survey/survey_question_style_save/$1';

$route['survey/partial/save/(:any)']='survey/partial_save/$1';
$route['survey/partial/load/(:any)']='survey/partial_load/$1';
$route['survey/final/save/(:any)']='survey/final_save/$1';
$route['survey/analytics/graph/(:any)/(:any)/(:any)']='survey/analytics_graph/$1/$2/$3';
$route['survey/list/indicators/(:any)']='survey/survey_indicators/$1';
$route['survey/indicators/save']='survey/indicators_save';
$route['survey/indicators/(:any)']='survey/indicators/$1';
$route['survey/export/(:any)/(:any)']='survey/survey_export/$1/$2';
$route['login/users/search/(:any)']='login/users_search/$1';
$route['survey/search/(:any)']='survey/survey_search/$1';
$route['survey/permission/update/(:any)/(:any)/(:any)']='survey/permission_update/$1/$2/$3';
$route['survey/permission/check/(:any)/(:any)']='survey/permission_check/$1/$2';
$route['survey/permission/save']='survey/permission_save';
$route['survey/cases/(:any)']='survey/cases/$1';

$route['survey/analytics/savejson/(:any)/(:any)']='survey/savejson/$1/$2';
$route['survey/analytics/loadjson/(:any)/(:any)']='survey/loadjson/$1/$2';
$route['survey/analytics/removejson/(:any)/(:any)']='survey/removejson/$1/$2';
$route['survey/analytics/updateentry/(:any)/(:any)/(:any)/(:any)']='survey/updateentry/$1/$2/$3/$4';
$route['survey/analytics/frequency/(:any)']='survey/frequency/$1';
$route['survey/analytics/table/(:any)']='survey/table/$1';
$route['survey/analytics/table_layer/(:any)']='survey/table_layer/$1';
$route['survey/analytics/table2x2/(:any)']='survey/table2x2/$1';
$route['survey/analytics/recordchart/(:any)']='survey/recordchart/$1';
$route['survey/analytics/chart/(:any)']='survey/chart/$1';
$route['survey/analytics/calculateregression/(:any)']='survey/calculateregression/$1';
$route['survey/analytics/regressionchart/(:any)']='survey/regressionchart/$1';
$route['survey/analytics/map/(:any)']='survey/map/$1';
$route['survey/analytics/save/(:any)']='survey/analytics_save/$1';
$route['survey/analytics/png']='survey/analytics_png';
$route['survey/analytics/png2/(:any)']='survey/analytics_png2/$1';
$route['survey/fill/entry/(:any)']='survey/fill_entry/$1';
$route['survey/email']='survey/survey_email';
$route['survey/questionbank']='survey/question_bank';
$route['survey/templates']='survey/templates';
$route['survey/fill/status/(:any)']='survey/fill_status/$1';
$route['survey/fill_vals_save']='survey/fill_vals_save';
$route['survey/compute/(:any)']='survey/compute/$1';
$route['survey/table_columns/(:any)']='survey/table_columns/$1';
$route['survey/excel/upload']='survey/excel_upload';
$route['survey/attach/(:any)/(:any)']='survey/survey_attach/$1/$2';
$route['survey/attach_save']='survey/attach_save';

$route['survey/r_software']='survey/r_software';



$route['report/(:any)']='report/index/$1';

$route['android_api/(:any)/(:any)']='android/func/$1/$2';
$route['android_api/(:any)']='android/func/$1';
$route['android_api']='android/index';

$route['desktop_api/(:any)/(:any)']='desktop/func/$1/$2';
$route['desktop_api/(:any)']='desktop/func/$1';
$route['desktop_api']='desktop/index';

/* admin routes*/
$route['admin'] = 'admin/dashboard';
$route['admin/dashboard'] = 'admin/dashboard';
$route['admin/login'] = 'admin/login';
$route['admin/login/login'] = 'admin/login/login';
$route['admin/logout'] = 'admin/logout';
$route['admin/users/checkuser/(:any)'] = 'admin/users/checkuser/$1';

$route['admin/survey'] = 'admin/survey';
$route['admin/survey/delete/(:any)'] = 'admin/survey/delete/$1';

/*
$route['admin/category/display'] = 'admin/category/display';
$route['admin/listing/display'] = 'admin/listing/display';
$route['admin/ajaxclass/youtube/(:any)'] = 'admin/ajaxclass/youtube/$1';
$route['admin/ajaxclass/video'] = 'admin/ajaxclass/video';

$route['admin/ajaxclass/home_setting/(:any)/(:any)/(:any)'] = 'admin/ajaxclass/home_setting/$1/$2/$3';
$route['admin/ajaxclass/display/(:any)/(:any)/(:any)'] = 'admin/ajaxclass/display/$1/$2/$3';

$route['admin/ajaxclass/loadHome/(:any)'] = 'admin/ajaxclass/loadHome/$1';
$route['admin/ajaxclass/previewPost/(:any)'] = 'admin/ajaxclass/previewPost/$1';

$route['admin/dashboard/category_setting/(:any)'] = 'admin/dashboard/category_setting/$1';
$route['admin/dashboard/category_setting'] = 'admin/dashboard/category_setting';
$route['admin/dashboard/listing_setting/(:any)'] = 'admin/dashboard/listing_setting/$1';
$route['admin/dashboard/listing_setting'] = 'admin/dashboard/listing_setting';



$route['admin/category'] = 'admin/category/index';
$route['admin/category/add'] = 'admin/category/add';
$route['admin/category/edit/(:any)'] = 'admin/category/edit/$1';
$route['admin/category/inverse/(:any)'] = 'admin/category/inverse/$1';
$route['admin/category/delete/(:any)'] = 'admin/category/delete/$1';
$route['admin/category/save'] = 'admin/category/save';

$route['admin/users'] = 'admin/users/index';
$route['admin/users/index/(:any)'] = 'admin/users/index/$1';
$route['admin/users/add'] = 'admin/users/add';
$route['admin/users/edit/(:any)'] = 'admin/users/edit/$1';
$route['admin/users/delete/(:any)'] = 'admin/users/delete/$1';
$route['admin/users/save'] = 'admin/users/save';

$route['admin/listing'] = 'admin/listing/index';
$route['admin/listing/add'] = 'admin/listing/add';
$route['admin/listing/edit/(:any)'] = 'admin/listing/edit/$1';
$route['admin/listing/delete/(:any)'] = 'admin/listing/delete/$1';
$route['admin/listing/save'] = 'admin/listing/save';

$route['admin/video'] = 'admin/video/index';
$route['admin/video/add'] = 'admin/video/add';
$route['admin/video/edit/(:num)'] = 'admin/video/edit/$1';
$route['admin/video/delete/(:any)'] = 'admin/video/delete/$1';
$route['admin/video/save'] = 'admin/video/save';
$route['admin/video/saveagain'] = 'admin/video/saveagain';
$route['admin/video/postAcceptor'] = 'admin/video/postAcceptor';
$route['admin/video/status/(:num)/(:num)'] = 'admin/video/status/$1/$2';
$route['admin/video/index/(:num)'] = 'admin/video/index/$1';*/