<?php
Auth::routes();

Route::get('/privacyPolicy', 'HomeController@index')->name('privacyPolicy');
// ROUTE PROTEKSI DENGAN AUTH
Route::group(['middleware' => 'auth'], function() {

  Route::get('/', 'DashboardController@index')->name('dashboard');
  Route::get('/graphicOrder','DashboardController@graphicOrder')->name('dashboard.graphicOrder');

  Route::get('/profile', 'UserController@myProfile')->name('profile');

  Route::resource('city', 'CityController')->except(['show']);
  Route::prefix('city')->group(function () {
    Route::get('/dataSelect','CityController@getDataSelect')->name('city.getDataSelect');
  });

  Route::resource('area', 'AreaController')->except(['show']);
  Route::prefix('area')->group(function () {
    Route::get('/dataSelect/{city_id}', ['uses' => 'AreaController@getDataSelectByCity', 'as' => 'area.getDataSelect']);
    Route::get('/dataSelect', ['uses' => 'AreaController@getDataSelectAll', 'as' => 'area.getDataSelectAll']);  
    Route::get('/getNumber', ['uses' => 'AreaController@getNumber', 'as' => 'area.getNumber']);  
  });

  Route::resource('space', 'SpaceController')->except(['show']);
  Route::prefix('space')->group(function () {
    Route::get('/dataSelect/{area_id}', ['uses' => 'SpaceController@getDataSelectByArea', 'as' => 'space.getDataSelectByArea']);  
    Route::get('/getNumber', ['uses' => 'SpaceController@getNumber', 'as' => 'space.getNumber']);  
  });

  Route::resource('shelves', 'ShelvesController')->except(['show']);
  Route::prefix('shelves')->group(function () {
    Route::get('/dataSelect/{space_id}', ['uses' => 'ShelvesController@getDataSelectBySpace', 'as' => 'shelves.getDataSelectBySpace']);
    Route::get('/getNumber', ['uses' => 'ShelvesController@getNumber', 'as' => 'shelves.getNumber']);  
  });

  Route::resource('box', 'BoxController')->except(['show']);
  Route::prefix('box')->group(function () {
    Route::get('/getNumber', ['uses' => 'BoxController@getNumber', 'as' => 'box.getNumber']);  
    Route::get('/barcode/{id}', ['uses' => 'BoxController@printBarcode', 'as' => 'box.barcode']);
  });

  Route::resource('category', 'CategoryController')->except(['show']);

  Route::resource('banner', 'BannerController')->except(['show']);

  Route::resource('voucher', 'VoucherController')->except(['show']);

  Route::resource('order', 'OrderController')->except(['show']);
  Route::prefix('order')->group(function () {
    Route::get('','OrderController@index')->name('order.index');
    Route::get('/order-detail/{id}','OrderController@orderDetail')->name('order.orderDetail');
    Route::get('/order-detail-box/{id}','OrderController@orderDetailBox')->name('order.orderDetailBox');
  });

  Route::resource('pickup', 'PickupController')->except(['show']);

  Route::resource('payment', 'PaymentController')->except(['show']);  
  Route::prefix('payment')->group(function () {
    Route::get('','PaymentController@index')->name('payment.index');    
  });

  Route::resource('change-box-payment', 'ChangeBoxPaymentController')->except(['show']);

  Route::resource('return-box-payment', 'ReturnBoxPaymentController')->except(['show']);
  
  Route::resource('storage', 'OrderDetailController')->except(['show']);  
  Route::prefix('storage')->group(function () {
    Route::get('/box-detail/{id}','OrderDetailController@orderDetailBox')->name('storage.orderDetailBox');
  });
  
  Route::resource('change-box', 'ChangeBoxesController')->except(['show']);
  Route::prefix('change-box')->group(function () {
    Route::get('','ChangeBoxesController@index')->name('change-box.index');    
  });

  Route::resource('return', 'ReturnBoxesController')->except(['show']);
  Route::prefix('return')->group(function () {
    Route::get('','ReturnBoxesController@index')->name('return.index');    
  });  

  Route::resource('user', 'UserController')->except(['show']);
  Route::prefix('user')->group(function () {
    Route::get('getDataSelectForAdmin', ['uses' => 'UserController@getDataSelectForAdmin', 'as' => 'user.getDataSelectForAdmin']);
    Route::get('getDataSelectForSuperadmin', ['uses' => 'UserController@getDataSelectForSuperadmin', 'as' => 'user.getDataSelectForSuperadmin']);
    Route::get('getDataSelectForFinance', ['uses' => 'UserController@getDataSelectForFinance', 'as' => 'user.getDataSelectForFinance']);
    Route::get('admin','UserController@list_admin')->name('user.admin.index');
    Route::post('admin/store','UserController@storeAdmin')->name('user.admin.store');

    Route::get('finance','UserController@list_finance')->name('user.finance.index');
    Route::post('finance/store','UserController@storeFinance')->name('user.finance.store');
    
    Route::get('superadmin','UserController@list_superadmin')->name('user.superadmin.index');  
    Route::post('superadmin/store','UserController@storeSuperadmin')->name('user.superadmin.store');
  });
  
  Route::resource('types-of-size', 'TypeSizeController')->except(['show']);
  Route::prefix('types-of-size')->group(function () {
    Route::get('createBox','TypeSizeController@createBox')->name('types-of-size.createBox');
    Route::get('createRoom','TypeSizeController@createRoom')->name('types-of-size.createRoom');
    Route::post('store','TypeSizeController@store')->name('types-of-size.store');
  });

  Route::resource('price', 'PriceController')->except(['show']);
  Route::prefix('price')->group(function () {
    Route::get('box','PriceController@priceBox')->name('price.priceBox');
    Route::get('room','PriceController@priceRoom')->name('price.priceRoom');
    Route::post('store','PriceController@store')->name('price.store');
  });

  Route::resource('delivery-fee', 'DeliveryFeeController')->except(['show']);

  Route::resource('settings', 'SettingController')->except(['show']);
  Route::prefix('settings')->group(function () {
    Route::get('','SettingController@index')->name('settings.index');
  });

});
