<?php
Auth::routes();

Route::get('/privacyPolicy', 'HomeController@index')->name('privacyPolicy');
// ROUTE PROTEKSI DENGAN AUTH
Route::group(['middleware' => 'auth'], function() {
  // Route::get('/home', function(){ return redirect()->route('home'); });
  Route::get('/', 'DashboardController@index')->name('dashboard');

  Route::resource('warehouses', 'WarehousesController');
  Route::resource('warehouses-city', 'CityController');
  Route::resource('warehouses-area', 'AreaController');
  Route::resource('space', 'SpaceController')->except(['show']);
  Route::resource('room', 'RoomController')->except(['show']);
  Route::resource('box', 'BoxController')->except(['show']);

  
  Route::get('/city/dataSelect', ['uses' => 'CityController@getDataSelect', 'as' => 'city.getDataSelect']);
  Route::get('/area/dataSelect/{city_id}', ['uses' => 'AreaController@getDataSelectByCity', 'as' => 'area.getDataSelect']);
  Route::get('/area/dataSelect', ['uses' => 'AreaController@getDataSelectAll', 'as' => 'area.getDataSelectAll']);  
  Route::get('/warehouse/dataSelect/{area_id}', ['uses' => 'WarehousesController@getDataSelectByArea', 'as' => 'warehouses.getDataSelectByArea']);
  // Route::get('/warehouse/dataSelect', ['uses' => 'WarehousesController@getDataSelectAll', 'as' => 'warehouses.getDataSelectAll']);
  Route::get('/space/dataSelect/{warehouse_id}', ['uses' => 'SpaceController@getDataSelectByWarehouse', 'as' => 'space.getDataSelectByWarehouse']);
  // Route::get('/space/dataSelect', ['uses' => 'SpaceController@getDataSelectAll', 'as' => 'space.getDataSelectAll']);
  
  Route::resource('order', 'OrderController')->except(['show']);
  Route::prefix('order')->group(function () {
    Route::get('','OrderController@index')->name('order.index');
    Route::get('/order-detail/{id}','OrderController@orderDetail')->name('order.orderDetail');
    Route::get('/order-detail-box/{id}','OrderController@orderDetailBox')->name('order.orderDetailBox');
  });

  Route::resource('pickup', 'PickupController')->except(['show']);

  Route::resource('user', 'UserController')->except(['show']);

  Route::resource('types-of-size', 'TypeSizeController')->except(['show']);

  Route::resource('price', 'PriceController')->except(['show']);

  Route::resource('setting', 'SettingController')->except(['show']);

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
