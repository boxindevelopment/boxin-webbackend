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
  Route::get('barcode/{id}', ['uses' => 'BoxController@printBarcode', 'as' => 'box.barcode']);

  
  Route::get('/city/dataSelect', ['uses' => 'CityController@getDataSelect', 'as' => 'city.getDataSelect']);
  Route::get('/area/dataSelect/{city_id}', ['uses' => 'AreaController@getDataSelectByCity', 'as' => 'area.getDataSelect']);
  Route::get('/area/dataSelect', ['uses' => 'AreaController@getDataSelectAll', 'as' => 'area.getDataSelectAll']);  
  Route::get('/warehouse/dataSelect/{area_id}', ['uses' => 'WarehousesController@getDataSelectByArea', 'as' => 'warehouses.getDataSelectByArea']);
  Route::get('/space/dataSelect/{warehouse_id}', ['uses' => 'SpaceController@getDataSelectByWarehouse', 'as' => 'space.getDataSelectByWarehouse']);
  
  Route::resource('order', 'OrderController')->except(['show']);
  Route::prefix('order')->group(function () {
    Route::get('','OrderController@index')->name('order.index');
    Route::get('/order-detail/{id}','OrderController@orderDetail')->name('order.orderDetail');
    Route::get('/order-detail-box/{id}','OrderController@orderDetailBox')->name('order.orderDetailBox');
  });

  Route::resource('pickup', 'PickupController')->except(['show']);

  Route::resource('storage', 'OrderDetailController')->except(['show']);

  Route::resource('return', 'ReturnBoxesController')->except(['show']);

  Route::resource('user', 'UserController')->except(['show']);
  Route::prefix('user')->group(function () {
    Route::get('getDataSelectNotAdmin', ['uses' => 'UserController@getDataSelectNotAdmin', 'as' => 'user.getDataSelectNotAdmin']);
    Route::get('getDataSelectNotSuperadmin', ['uses' => 'UserController@getDataSelectNotSuperadmin', 'as' => 'user.getDataSelectNotSuperadmin']);
    Route::get('admin-city','UserController@list_admincity')->name('user.list_admincity');
    Route::get('superadmin','UserController@list_superadmin')->name('user.list_superadmin');
  });
  
  Route::resource('types-of-size', 'TypeSizeController')->except(['show']);

  Route::resource('price', 'PriceController')->except(['show']);

  Route::resource('setting', 'SettingController')->except(['show']);

});
