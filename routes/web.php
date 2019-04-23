<?php

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

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes(['verify' => true]);
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// User contacts route start here
Route::get('contact/index', 'ContactController@index')->name('contact.index');
Route::get('contact/list', 'ContactController@getAjaxContacts')->name('contact.list');
Route::get('contact/add', 'ContactController@createNewContact')->name('contact.add');
Route::post('contact/insert', 'ContactController@saveNewContact')->name('contact.insert');
Route::get('contact/edit/{id}', 'ContactController@editContact')->name('contact.edit');
Route::post('contact/update/{id}', 'ContactController@updateContact');
Route::get('contact/details/{id}', 'ContactController@details');
Route::get('contact/delete', 'ContactController@delete')->name('contact.delete');

Route::get('contact/share', 'ContactController@userList')->name('contact.user.list');
Route::post('contact/share-update', 'ContactController@contactShareUpdate')->name('contact.share.update');

Route::get('contact/shared', 'ContactController@sharedContact')->name('contact.shared');
Route::get('contact/shared-list', 'ContactController@getAjaxSharedContacts')->name('contact.shared.list');
Route::get('contact/shared-details/{id}', 'ContactController@sharedDetails');

// User contacts route end here

Route::get('vcard', 'ContactController@vCard')->name('vcard');
Route::post('/download-vcard', 'ContactController@downloadVCard')->name("download.vcard");