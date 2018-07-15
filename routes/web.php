<?php
Auth::routes();

// ROUTE PROTEKSI DENGAN AUTH
Route::group(['middleware' => 'auth'], function() {
  // Route::get('/home', function(){ return redirect()->route('home'); });
  Route::get('/', 'DashboardController@index')->name('dashboard');

  //Warehouse
  Route::resource('warehouses', 'WarehousesController');
  Route::resource('warehouses-city', 'CityWarehouseController');
  Route::resource('warehouses-area', 'AreaWarehouseController');

  //Spaces
  Route::resource('space', 'SpaceController')->except(['show']);

  //Rooms
  Route::resource('room', 'RoomController')->except(['show']);

  //Boxes
  Route::resource('box', 'BoxController')->except(['show']);

  //User
  Route::resource('user', 'UserController')->except(['show']);

  // Route::prefix('new-user')->group(function () {
  //   Route::get('','NewuserController@index')->name('new-user.index');
  //   Route::post('','NewuserController@setStatus');
  //   Route::get('/create-user','NewuserController@create_user')->name('new-user.createuser');
  //   Route::post('/create-user','NewuserController@save_user');
  //   Route::get('/create-user/{id}/edit','NewuserController@edit_user')->name('new-user.edituser');
  //   Route::post('/create-user/{id}/edit','NewuserController@update_user');
  
  //   Route::get('/role','NewuserController@newrole')->name('new-user.newrole');
  //   Route::post('/role','NewuserController@saverole');
  //   Route::get('/list-role','NewuserController@listrole')->name('new-user.listrole');
  //   Route::get('/list-role/{name}/attach','NewuserController@viewPermission')->name('new-user.attachrole');
  //   Route::post('/list-role/{name}/attach','NewuserController@setPermission');
  // });

});
