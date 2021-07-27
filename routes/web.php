<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','loginController@index');
Route::get('/login','loginController@index');
Route::post('/checkLogin','loginController@checkLogin');
Route::get('/forgot-password', 'loginController@forgotPassword');
Route::post('/set-password', 'loginController@setPassword');

Route::get('/admin/login','loginController@adminindex');
Route::get('/admin','loginController@adminindex');
Route::post('/admin','loginController@admincheckLogin');
Route::post('/ajax/getSubFolder','ajaxController@getSubFolder');
Route::post('/ajax/getCopySubFolder','ajaxController@getCopySubFolder');
Route::post('/ajax/getuserdetails','ajaxController@getuserdetails');
Route::post('/ajax/getUpdatedUsersList','ajaxController@getUpdatedUsersList');
Route::post('/ajax/getUpdatedUsersListForUsers','ajaxController@getUpdatedUsersListForUsers');
Route::post('/ajax/readMessages','ajaxController@readMessages');
Route::post('/ajax/readUserMessages','ajaxController@readUserMessages');
Route::post('/ajax/getSharedUserDetails','ajaxController@getSharedUserDetails');
Route::post('/ajax/getLink','ajaxController@getSharableLink');
Route::post('/ajax/getNewLink','ajaxController@generateNewLink');
Route::get('/user/hr/form/{token}', 'admin\hrFolderController@getForm')->name('getForm');
Route::post('/admin/addDetails','admin\hrFolderController@addDetails');
        
Route::middleware('authadmin')->group(function(){
	
	Route::get('/admin/dashboard','admin\dashboardController@index');
	Route::post('/admin/updateprofile','admin\dashboardController@updateprofile');
	Route::post('/admin/updatepassword','admin\dashboardController@updatepassword');
	Route::get('/admin/notifications','admin\notificationController@index');
	Route::get('/admin/logout','admin\dashboardController@logout');

	Route::get('/admin/folder','admin\folderController@index');
	Route::get('/admin/folder/deletefile/{id}','admin\folderController@deletefile');
	Route::get('/admin/folder/deletefolder/{id}','admin\folderController@deletefolder');
	Route::post('/admin/movefolder','admin\folderController@movefolder');
	Route::post('/admin/copyfolder','admin\folderController@copyfolder');
	Route::get('/admin/folder/{folder1}','admin\folderController@folderindex');
	Route::post('/admin/addupdatefolder','admin\folderController@addupdatefolder');
	Route::post('/admin/addupdatefile','admin\folderController@addupdatefile');
	//Fix Folder
	Route::get('/admin/fixfolder/{folder1}','admin\folderController@fixfolderindex');
	Route::post('/admin/addupdatefixfile','admin\folderController@addupdatefixfile');
	Route::get('/admin/downloadfixfile/{path}','admin\folderController@downloadfixfile');
	Route::get('/admin/folder/deletefixfile/{id}','admin\folderController@deletefixfile');
	Route::post('/admin/movefixfile','admin\folderController@movefixfile');
	Route::post('/admin/copyfixfile','admin\folderController@copyfixfile');
	Route::get('/admin/folderdownload/{id}','admin\folderController@downloadFolder');
	
        //Hr Folder
        Route::get('/admin/hrfolder','admin\hrFolderController@index');
        Route::post('/admin/addfolder','admin\hrFolderController@addFolder');
        Route::get('/admin/hrfolder/{id}','admin\hrFolderController@getFolder');
        Route::get('/admin/hrfolder/details/{id}','admin\hrFolderController@getFolderDetails');
        
	//Report
	Route::get('/admin/report','admin\reportController@index');
	Route::post('/admin/addupdatereport','admin\reportController@addupdatereport');
	
	Route::get('/admin/setting','admin\settingController@index');
	Route::get('/admin/addteamuser/{id}','admin\settingController@addteamuser');
	Route::get('/admin/removefromteam/{id}','admin\settingController@removefromteam');
	Route::get('/admin/removeuser/{id}','admin\settingController@removeuser');
	Route::post('/admin/addteammember','admin\settingController@addteammember');
	Route::post('/admin/addUsersToTeams','admin\settingController@addUsersToTeams');

	Route::get('/admin/removeUserFromSharing/{userId}/{folderId}/{folderType}/{type}','admin\shareController@removeUserFromSharing');

	Route::post('/admin/changeUserFromSharing/{userId}/{folderId}/{folderType}/{type}','admin\shareController@changeUserFromSharing');

	Route::get('/admin/removeUserFromSharingProfile/{id}','admin\shareController@removeUserFromSharingProfile');

	Route::post('/admin/changeUserFromSharingProfile/{id}','admin\shareController@changeUserFromSharingProfile');

	Route::post('/admin/addteamwithuser','admin\settingController@addteamwithuser');
	
	Route::post('/admin/addteamuser','admin\settingController@submitteamuser');

	Route::post('/admin/addupdateteam','admin\settingController@addupdateteam');
	Route::post('/admin/addupdateuser','admin\settingController@addupdateuser');
	
	Route::get('/admin/chats','admin\chatController@index');
	Route::post('/admin/sendMessage','admin\chatController@sendMessage');
	//Download
	Route::get('/admin/download/{path}','admin\folderController@download');
	Route::get('/admin/hr/file/download/{id}/{key}','admin\hrFolderController@download');
	//share module
	Route::get('/admin/recentshare','admin\shareController@index');
	Route::post('/admin/sharewithuser','admin\shareController@sharewithuser');
	Route::post('/admin/sharewithteam','admin\shareController@sharewithteam');
	//Trash Module
	Route::get('/admin/trash','admin\trashController@index');
	Route::get('/admin/trash/restorefile/{id}','admin\trashController@restorefile');
	Route::get('/admin/trash/restorefolder/{id}','admin\trashController@restorefolder');
	Route::get('/admin/trash/deletefile/{id}','admin\trashController@deletefile');
	Route::get('/admin/trash/deletefolder/{id}','admin\trashController@deletefolder');
	Route::get('/admin/trash/restorefixfile/{id}','admin\trashController@restorefixfile');
	Route::get('/admin/trash/deletefixfile/{id}','admin\trashController@deletefixfile');

	//Questionnaire Modules
	Route::get('/admin/questionnaire/{id?}','admin\questionnaireController@index')->name('questionnaire.index');
	Route::post('/admin/add-questionnaire-file', 'admin\questionnaireController@addQuestionnaireFile');
	Route::get('/admin/questionnaire/folder/download/{id}', 'admin\questionnaireController@downloadFolder');
	Route::get('/admin/questionnaire/file/download/{id}', 'admin\questionnaireController@downloadFile');
	Route::get('/admin/questionnaire/file/delete/{id}', 'admin\questionnaireController@deleteFile');
	
});
Route::middleware('authuser')->group(function(){
	Route::get('/dashboard','user\dashboardController@index')->name('dashboard');
	Route::get('/logout','user\dashboardController@logout');
	Route::post('/user/updateprofile','user\dashboardController@updateprofile');
	Route::post('/user/updatepassword','user\dashboardController@updatepassword');
	Route::get('/user/notifications','user\notificationController@index');

	Route::get('/user/fixfolders','user\whatsNewController@index');
	Route::get('/user/fixfolder/{folder1}','user\folderController@fixfolderindex');
	Route::get('/user/downloadfixfile/{path}','user\folderController@downloadfixfile');

	Route::get('/user/reports','user\reportController@index');
	Route::get('/user/download/{path}','user\folderController@download');

	Route::get('/user/folder','user\folderController@index');
	Route::get('/user/folder/{folder1}','user\folderController@folderindex');

	Route::get('/user/questionnaires','user\questionController@index');
	Route::get('/user/folderdownload/{id}','user\folderController@downloadFolder');
	Route::get('/user/download/{path}','user\folderController@download');

	//Questionnaire Modules
	Route::get('/user/questionnaire/{id}','user\questionnaireController@index')->name('questionnaire.index');
	Route::post('/user/add-questionnaire-file', 'user\questionnaireController@addQuestionnaireFile');
	Route::get('/user/questionnaire/folder/download/{id}', 'user\questionnaireController@downloadFolder');
	Route::get('/user/questionnaire/file/download/{id}', 'user\questionnaireController@downloadFile');
	Route::get('/user/questionnaire/file/delete/{id}', 'user\questionnaireController@deleteFile');

	//Chats module
	Route::get('/user/chats','user\chatController@index');
	Route::post('/user/sendMessage','user\chatController@sendMessage');
});