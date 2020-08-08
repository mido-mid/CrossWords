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

// public routes
Route::get('/',function(){

	return view('home');
})->name('welcome');


// User_Auth
Auth::routes(['verify' => true]);


//Translator_Auth

Route::get('translator/login','Translator_Auth\LoginController@ShowTranslatorLoginForm')->name('translator.loginget');
Route::get('translator/register', 'Translator_Auth\RegisterController@showTranslatorRegisterForm')->name('translator.registerget');
Route::post('translator/login','Translator_Auth\LoginController@translatorlogin')->name('translator.loginpost');
Route::post('translator/register', 'Translator_Auth\RegisterController@createTranslator')->name('translator.registerpost');
Route::post('translatorlogout', 'Translator_Auth\LoginController@logout')->name('translatorlogout');
Route::get('translator/password/reset', 'Translator_Auth\ForgotPasswordController@showLinkRequestForm')->name('translator.password.request');
Route::post('translator/password/email', 'Translator_Auth\ForgotPasswordController@sendResetLinkEmail')->name('translator.password.email');
Route::get('translator/password/reset/{token}', 'Translator_Auth\ResetPasswordController@showResetForm')->name('translator.password.reset');
Route::post('translator/password/reset', 'Translator_Auth\ResetPasswordController@reset')->name('translator.password.update');



// translator Routes

Route::group(['middleware' => 'auth:translator'], function () {

	Route::get('translator/home','Translator\DashboardController@homepage')->name('translatorhome');

});


Route::group(['middleware' => ['auth:translator','approved'] ], function () {

	Route::get('translator', function() {
		return redirect('translator/dashboard');
	});
	Route::get('translator/dashboard', 'Translator\DashboardController@index')->name('translator.dashboard');
	Route::post('translator/uploadimage', 'Translator\ProfileController@upload')->name('translatoruploadimage');
	Route::get('translator/profile', 'Translator\ProfileController@edit')->name('translatorprofile');
	Route::put('translator/profile', 'Translator\ProfileController@update')->name('translator.profileupdate');
	Route::put('translator/profile/password', 'Translator\ProfileController@password')->name('translator.profilepassword');
	Route::put('translator/dashboard/{clientfile}', 'Translator\DashboardController@assign')->name('translator.assign');
	Route::put('translator/myfiles/{clientfile}', 'Translator\DashboardController@cancelassign')->name('translator.cancelassign');
	Route::get('translator/clientfiles/download/{clientfile}', 'Translator\DashboardController@downloadclient')->name('translator.downloadclient');
    Route::get('translator/translatorfiles/download/{id}', 'Translator\DashboardController@downloadtranslator')->name('translator.downloadtranslator');
	Route::get('translator/clientfiles', 'Translator\DashboardController@clientfiles')->name('translator.clientfiles');
    Route::get('translator/translatorfiles', 'Translator\DashboardController@translatorfiles')->name('translator.translatorfiles');
    Route::get('translator/upload/{clientfile}', 'Translator\UploadController@uploadget')->name('translator.uploadget');
	Route::post('translator/upload/{clientfile}', 'Translator\UploadController@upload')->name('translator.uploadpost');
    Route::get('translator/edit/{translatorfile}', 'Translator\UploadController@uploadedit')->name('translator.uploadedit');
    Route::post('translator/edit/{translatorfile}', 'Translator\UploadController@uploadupdate')->name('translator.uploadupdate');
});


// Admin Routes

Route::group(['middleware' => ['auth', 'admin'] ], function () {

	Route::get('admin', function() {
		return redirect('admin/dashboard');
	});

	Route::get('/admin/dashboard', 'Admin\AdminController@index')->name('admin.dashboard');
	Route::resource('/admin/languages', 'Admin\LanguageController');
	Route::get('admin/profile', 'Admin\ProfileController@edit')->name('admin.profile');
	Route::put('admin/profile', 'Admin\ProfileController@update')->name('admin.profileupdate');
	Route::post('admin/profile', 'Admin\ProfileController@upload')->name('admin.uploadimage');
	Route::put('admin/profile/password', 'Admin\ProfileController@password')->name('admin.profilepassword');
	Route::get('admin/{translator}', 'Admin\AdminController@showtranslator')->name('admin.showtranslator');
	Route::post('/admin/dashboard/{translator}', 'Admin\AdminController@approve')->name('admin.approve');
});


//client Routes

Route::group(['middleware' => ['auth','verified'] ], function () {

	Route::get('profile', 'Client\ProfileController@edit')->name('profile');
	Route::put('profile', 'Client\ProfileController@update')->name('profile.update');
	Route::put('profile/password', 'Client\ProfileController@password')->name('profile.password');
	Route::post('profile', 'Client\ProfileController@upload')->name('client.uploadimage');
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('myfiles', 'Client\ClientController@myfiles')->name('myfiles');
	Route::get('uploadfile', 'Client\UploadController@index')->name('paymentget');
	Route::post('uploadfile', 'Client\UploadController@payment')->name('paymentpost');
	Route::get('/paymentstatus', 'Client\UploadController@status')->name('paymentstatus');
	Route::get('/paymentcancel/{filetostore}', 'Client\UploadController@cancel')->name('paymentcancel');
	Route::get('myfiles/download/{id}', 'Client\ClientController@download')->name('client.download');

});
