<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] = 'HomeController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['admin'] = 'Root/index';
$route['dashboard'] = 'DashboardController/index';
$route['admin-login'] = 'Root/index';
$route['logout'] = 'Root/logout';
$route['user-logout'] = 'AuthController/logout';
$route['setResultViewpermission'] = 'AdminController/setResultViewpermission';
$route['setResultViewpermission/(:any)/(:any)'] = 'AdminController/setResultViewpermission/$1/$2';
$route['setViewpermission'] = 'AdminController/controlAnswerSheetView';
// Question bank management route new
$route['question-bank'] = 'QuestionBankController/index';
$route['pre-add-question']["GET"] = 'QuestionBankController/pre_create';
$route['add-question']["POST"] = 'QuestionBankController/create';
$route['store-question']["POST"] = 'QuestionBankController/store';
$route['edit-question/(:num)']["GET"] = 'QuestionBankController/edit/$1';
$route['edit-question/(:num)']["POST"] = 'QuestionBankController/update/$1';
$route['delete-question/(:num)']["GET"] = 'QuestionBankController/delete/$1';
$route['upload-question']["POST"] = 'QuestionBankController/upload';

$route['delete-q-file']= 'QuestionBankController/delete_files';
// category
$route['categories'] = 'CategoryController/index';
$route['add-category'] = 'CategoryController/add';
$route['update-category'] = 'CategoryController/update';
$route['delete-category/(:num)'] = 'CategoryController/delete/$1';
$route['admin/login'] = 'Root/index';

// level
$route['levels'] = 'LevelController/index';
$route['add-level'] = 'LevelController/add';
$route['update-level'] = 'LevelController/update';
$route['delete-level/(:num)'] = 'LevelController/delete/$1';

// quiz management new route
$route['quiz-management'] = 'QuizController/index';
$route['add-quiz']["GET"] = 'QuizController/create';
$route['add-quiz']["POST"] = 'QuizController/store';
$route['edit-quiz/(:num)']["GET"] = 'QuizController/edit/$1';
$route['edit-quiz']["POST"] = 'QuizController/update';
$route['delete-quiz/(:num)']["GET"] = 'QuizController/delete/$1';
$route['manage-quiz/(:num)']["GET"] = 'QuizController/show/$1';
$route['quiz/add-question/(:num)']["GET"] = 'QuizController/add_question/$1';
$route['quiz/add-question']["POST"] = 'QuizController/add_question_to_quiz/';
$route['quiz/remove-quiz-question']["POST"] = 'QuizController/remove_quiz_question/';

$route['add-user']["GET"] = 'AdminController/show_add_user_form';
$route['add-user']["POST"] = 'AdminController/add_user';
$route['edit-user/(:num)']["GET"] = 'AdminController/edit_user/$1';
$route['edit-user']["POST"] = 'AdminController/update_user';





$route['user-management'] = 'Admin_home/user_list';
// pdf process
$route['umpdf']           = 'Admin_home/user_listpdf';
$route['umprint']         = 'Admin_home/user_listprint';
$route['download-user-package-mapping']           = 'Admin_home/downloadUserPackageMapping';


$route['packagedetails/(:any)'] = 'Admin_home/packagedetails/$1';

$route['status-user/(:num)'] = 'Admin_home/status_user/$1';
$route['cache-clear'] = 'Admin_home/clear_cache';
$route['change-password'] = 'Admin_home/change_admin_password';

/*******************            Admin Route End         *******************/


/*******************            Mixed Route Start (User & Admin)           *****************/
// User
$route["create-account"]["GET"] = 'UserController/create_user';
$route["create-account"]["POST"] = 'UserController/register';
$route["forgot-password"]["POST"] = 'AuthController/request_password';

// packages
$route['packages']['GET'] = 'PackageController/index';
$route['packages']['POST'] = 'PackageController/add';
$route['my-packages']["GET"] = 'PackageController/my_packages';
$route['my-quiz/(:num)'] = 'PackageController/package_quiz/$1';
$route['user-payment'] = 'UserController/payment';
$route['appreciation-list'] = 'UserController/feedback_list';
$route['get-package-details'] = 'Packages/get_package_details';
$route['update-package'] = 'Packages/add_update_package';
$route['del-package/(:num)'] = 'Packages/del_package/$1';

// report management
$route['report']['GET'] = 'ResultController/index';
// pdf process
$route['resultpdf']['GET'] = 'ResultController/resultspdf';

$route['report/generate']['POST'] = 'ResultController/generate_report';
$route['report/(:num)']['GET'] = 'UserResultController/answer_sheet/$1';
$route['report-delete/(:num)']['GET'] = 'ResultController/delete/$1';
$route['admin-report/(:num)']['GET'] = 'UserResultController/admin_answer_sheet/$1';
//----
$route['online-test/instructions/(:num)/(:num)'] = 'OnlineExamController/instructions/$1/$2';
$route['online-test'] = 'OnlineExamController/online_test';
$route['next-question']["POST"] = 'OnlineExamController/save_and_next';
$route['get-updated-question-status']["POST"] = 'OnlineExamController/get_updated_question_status';
$route['question-status']["POST"] = 'OnlineExamController/get_question_status';
$route['previous-question']['POST'] = 'OnlineExamController/previous_question';
$route['question-by-id']['POST'] = 'OnlineExamController/question_by_id';
$route['submit-test'] = 'OnlineExamController/submit_test';

$route['my-progress']['GET'] = 'UserResultController/index';
//skv
$route['practice_paper'] = 'UserResultController/practicepaper'; 
//endskv
$route['my-progress/view/(:num)']['GET'] = 'UserResultController/answer_sheet/$1';
$route['detailed-my-progress/view/(:num)']['GET'] = 'UserResultController/detailed_answer_sheet/$1';

$route['my-progress/certificate/(:num)']['GET'] = 'UserResultController/download_certificate/$1';
$route['common-merit-list/(:num)']['GET'] = 'UserResultController/common_merit_list/$1';
$route['edit-appreciation'] = 'UserController/edit_feedback';
$route['update-feedback'] = 'UserController/feedback';
$route['delete-appreciation'] = 'UserController/delete_feedback';
$route['user-login']["POST"] = 'AuthController/login';
$route['user-profile']['GET'] = 'UserController/user_profile';
$route['edit-profile']['GET'] = 'UserController/edit_profile';
$route['edit-profile']['POST'] = 'UserController/update_profile';
$route['update-password']['GET'] = 'UserController/change_password';
$route['update-password']['POST'] = 'UserController/update_password';


$route['exist-user'] = 'User_questionire/verify_username';
$route['verify-otp'] = 'User_questionire/verify_otp';
$route['my-quiz'] = 'User_questionire/show_quiz';
$route['quiz-question/(:any)'] = 'User_questionire/show_quiz_question';
$route['save-answer'] = 'User_questionire/save_user_answer';
$route['get-result/(:any)'] = 'User_questionire/get_user_result';
$route['subscribenowmypackage/(:any)'] 			= 'User_questionire/subscribenowmypackage/$1';
$route['appreciation'] = 'UserController/feedback';
$route['fb_logout'] 				= 'UserController/fb_logout';
$route['google_logout'] 	= 'UserController/google_logout';
$route['fb_register'] 				= 'UserController/registerViaFb';
$route['google_register'] 				= 'UserController/registerViaGoogle';

$route['ccAvenue/(:any)'] 				= 'User_questionire/ccAvenue/$1';
$route['resp1'] 				= 'PackageController/resp1';

$route['ccAvenueResponse'] 				= 'User_questionire/ccAvenueResponse';
//$route['fb_redirect'] 				= 'UserController/fb_redirected';
$route['terms-of-use'] 				= 'HomeController/terms';
$route['privacy-policy'] 				= 'HomeController/privacy';
$route['payments'] 				= 'Admin_home/payment_history';
// pdf
$route['paymentspdf'] 				= 'Admin_home/downloadContestPdf';


$route['admin_package'] 				= 'PackageController/admin_pack';
$route['show-bulk-payment'] 				= 'User_questionire/show_bulk_payment';
$route['bulk-payment'] 				= 'User_questionire/bulk_payment';
$route['bulk-payment-response'] 				= 'User_questionire/bulk_payment_response';
$route['download/(:any)/(:any)'] 				= 'UserResultController/pdfimage/$1/$2';

/******************admin feedback**********************/
$route['admin-appreciation']= 'Admin_home/appreciation_list';
$route['admin-edit-appreciation/(:any)']= 'Admin_home/edit_feedback/$1';
$route['admin-delete-appreciation/(:any)']= 'Admin_home/delete_feedback/$1';
$route['admin-update-appreciation']= 'Admin_home/update_feedback';