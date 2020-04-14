<?php
Auth::routes();

Route::get('/privacyPolicy', 'HomeController@index')->name('privacyPolicy');
// ROUTE PROTEKSI DENGAN AUTH
Route::group(['middleware' => 'auth'], function() {

  Route::get('/', 'DashboardController@index')->name('dashboard');
  Route::get('/dashboard/space', 'DashboardController@space')->name('dashboard.space');
  Route::post('/dashboard/ajax-space', 'DashboardController@getAjaxSpace')->name('dashboard.space.ajax');
  Route::get('/dashboard/box', 'DashboardController@box')->name('dashboard.box');
  Route::post('/dashboard/ajax-box', 'DashboardController@getAjaxBox')->name('dashboard.box.ajax');
  Route::get('/graphicOrder','DashboardController@graphicOrder')->name('dashboard.graphicOrder');

  Route::get('/profile', 'UserController@myProfile')->name('profile');

  Route::resource('city', 'CityController')->except(['show']);
  Route::prefix('city')->group(function () {
    Route::get('/dataSelect','CityController@getDataSelect')->name('city.getDataSelect');
  });
  Route::prefix('country')->group(function () {
    Route::get('/province/dataSelect/all','CountryController@getDataProvinceSelect')->name('country.province.getDataSelect');
    Route::get('/regency/dataSelect/all','CountryController@getDataRegencySelect')->name('country.regency.getDataSelect');
    Route::get('/district/dataSelect/all','CountryController@getDataDistrictSelect')->name('country.district.getDataSelect');
    Route::get('/village/dataSelect/all','CountryController@getDataVillageSelect')->name('country.village.getDataSelect');
  });

  Route::resource('area', 'AreaController')->except(['show']);
  Route::prefix('area')->group(function () {
    Route::get('/dataSelect/{city_id}', ['uses' => 'AreaController@getDataSelectByCity', 'as' => 'area.getDataSelect']);
    Route::get('/dataSelect', ['uses' => 'AreaController@getDataSelectAll', 'as' => 'area.getDataSelectAll']);
    Route::get('/getNumber', ['uses' => 'AreaController@getNumber', 'as' => 'area.getNumber']);
  });

  Route::prefix('space')->group(function () {
    Route::post('/ajax', ['uses' => 'SpaceSmallController@getAjax', 'as' => 'space.ajax']);
    Route::get('/dataSelect/{area_id}', ['uses' => 'SpaceSmallController@getDataSelectByArea', 'as' => 'space.getDataSelectByArea']);
    Route::get('/dataSelect/{shelves_id}', ['uses' => 'SpaceSmallController@getDataSelectByShelves', 'as' => 'space.getDataSelectByShelves']);
    Route::get('/getNumber', ['uses' => 'SpaceSmallController@getNumber', 'as' => 'space.getNumber']);
    Route::get('/barcode/{id}', ['uses' => 'SpaceSmallController@printBarcode', 'as' => 'space.barcode']);
    Route::get('/resetNumber', ['uses' => 'SpaceSmallController@resetNumber', 'as' => 'space.resetNumber']);
  });
  Route::resource('space', 'SpaceSmallController')->except(['show']);

  Route::prefix('shelves')->group(function () {
    Route::post('/ajax', ['uses' => 'ShelvesController@getAjax', 'as' => 'shelves.ajax']);
    Route::get('/dataSelect/{area_id}', ['uses' => 'ShelvesController@getDataSelectByArea', 'as' => 'shelves.getDataSelectByArea']);
    Route::get('/dataSelect/{space_id}', ['uses' => 'ShelvesController@getDataSelectBySpace', 'as' => 'shelves.getDataSelectBySpace']);
    Route::get('/getNumber', ['uses' => 'ShelvesController@getNumber', 'as' => 'shelves.getNumber']);
    Route::get('/getNumber', ['uses' => 'ShelvesController@getNumber', 'as' => 'shelves.getNumber']);
    Route::get('/resetNumber', ['uses' => 'ShelvesController@resetNumber', 'as' => 'shelves.resetNumber']);
  });
  Route::resource('shelves', 'ShelvesController')->except(['show']);

  Route::prefix('box')->group(function () {
    Route::post('/ajax', ['uses' => 'BoxController@getAjax', 'as' => 'box.ajax']);
    Route::get('/getNumber', ['uses' => 'BoxController@getNumber', 'as' => 'box.getNumber']);
    Route::get('/checkCode', ['uses' => 'BoxController@checkCode', 'as' => 'box.checkCode']);
    Route::get('/getCodeUsed', ['uses' => 'BoxController@getCodeUsed', 'as' => 'box.getCodeUsed']);
    Route::get('/barcode/{id}', ['uses' => 'BoxController@printBarcode', 'as' => 'box.barcode']);
    Route::get('/resetNumber', ['uses' => 'BoxController@resetNumber', 'as' => 'box.resetNumber']);
  });
  Route::resource('box', 'BoxController')->except(['show']);

  Route::resource('category', 'CategoryController')->except(['show']);

  Route::resource('banner', 'BannerController')->except(['show']);

  Route::resource('voucher', 'VoucherController')->except(['show']);

  Route::prefix('order')->group(function () {
    Route::post('/ajax', ['uses' => 'OrderController@getAjax', 'as' => 'order.ajax']);
    Route::get('','OrderController@index')->name('order.index');
    Route::get('/order-detail/{id}','OrderController@orderDetail')->name('order.orderDetail');
    Route::get('/order-detail-box/{id}','OrderController@orderDetailBox')->name('order.orderDetailBox');
    Route::get('/order-detail/{id}/edit','OrderController@orderDetailBox')->name('order.detail.edit');
    Route::put('/order-detail-box/{id}/update-place','OrderController@updatePlace')->name('order.orderDetailBox.updatePlace');
    Route::get('/boxes', ['uses' => 'OrderController@getBoxes', 'as' => 'order.boxes']);
    Route::post('/box/ajax', ['uses' => 'OrderController@getBoxAjax', 'as' => 'order.box.ajax']);
    Route::get('/spaces', ['uses' => 'OrderController@getSpaces', 'as' => 'order.spaces']);
    Route::post('/space/ajax', ['uses' => 'OrderController@getSpaceAjax', 'as' => 'order.space.ajax']);
  });
  Route::resource('order', 'OrderController')->except(['show']);
  Route::prefix('order-cancel')->group(function () {
      Route::post('/ajax', ['uses' => 'OrderCancelController@getAjax', 'as' => 'order.cancel.ajax']);
      Route::get('','OrderCancelController@index')->name('order.cancel.index');
      Route::get('/order-detail/{id}','OrderCancelController@orderDetail')->name('order.cancel.orderDetail');
      Route::get('/order-detail-box/{id}','OrderCancelController@orderDetailBox')->name('order.cancel.orderDetailBox');
  });

  Route::get('order-details/{id}','OrderDetailController@orderDetail')->name('orderDetail.detail');

  Route::post('pickup/ajax', ['uses' => 'PickupController@getAjax', 'as' => 'pickup.ajax']);
  Route::post('pickup/update-date/{id}', ['uses' => 'PickupController@updateDate', 'as' => 'pickup.updateDate']);
  Route::get('pickup/all', ['uses' => 'PickupController@getAll', 'as' => 'pickup.all']);
  Route::post('pickup/all/ajax', ['uses' => 'PickupController@getAllAjax', 'as' => 'pickup.allAjax']);
  Route::resource('pickup', 'PickupController')->except(['show']);

  Route::post('payment/order-details/ajax','PaymentController@getExtendAjax')->name('payment.extend.ajax');
  Route::get('payment/order-details','PaymentController@payment_extend')->name('payment.extend');
  Route::get('payment/order-details/{id}','PaymentController@payment_extend_edit')->name('payment.extend.edit');
  Route::put('payment/order-details/{id}','PaymentController@payment_extend_update')->name('payment.extend.update');

  Route::post('payment/ajax', ['uses' => 'PaymentController@getAjax', 'as' => 'payment.ajax']);
  Route::resource('payment', 'PaymentController')->except(['show']);
  Route::prefix('payment')->group(function () {
    Route::get('','PaymentController@index')->name('payment.index');
  });

  Route::post('change-box-payment/ajax', ['uses' => 'ChangeBoxPaymentController@getAjax', 'as' => 'change-box-payment.ajax']);
  Route::resource('change-box-payment', 'ChangeBoxPaymentController')->except(['show']);

  Route::post('add-item/ajax', ['uses' => 'AddItemBoxController@getAjax', 'as' => 'add-item.ajax']);
  Route::resource('add-item', 'AddItemBoxController')->only(['index', 'update', 'edit']); // add-item.index
  Route::post('add-item-payment/ajax', ['uses' => 'AddItemBoxPaymentController@getAjax', 'as' => 'add-item-payment.ajax']);
  Route::resource('add-item-payment', 'AddItemBoxPaymentController')->only(['index', 'update', 'edit']); // add-item-payment.index

  Route::post('return-box-payment/ajax', ['uses' => 'ReturnBoxPaymentController@getAjax', 'as' => 'return-box-payment.ajax']);
  Route::resource('return-box-payment', 'ReturnBoxPaymentController')->except(['show']);

  Route::post('storage/ajax', ['uses' => 'OrderDetailController@getAjax', 'as' => 'storage.ajax']);
  Route::resource('storage', 'OrderDetailController')->except(['show']);
  Route::prefix('storage')->group(function () {
    Route::get('/box-detail/{id}','OrderDetailController@orderDetailBox')->name('storage.orderDetailBox');
  });

  Route::post('change-box/ajax', ['uses' => 'ChangeBoxesController@getAjax', 'as' => 'change-box.ajax']);
  Route::resource('change-box', 'ChangeBoxesController')->except(['show']);
  Route::prefix('change-box')->group(function () {
    Route::get('','ChangeBoxesController@index')->name('change-box.index');
  });

  Route::post('return/ajax', ['uses' => 'OrderBackWarehouseController@getAjax', 'as' => 'return.ajax']);
  Route::post('return/update-date/{id}', ['uses' => 'OrderBackWarehouseController@updateDate', 'as' => 'return.updateDate']);
  Route::resource('return', 'OrderBackWarehouseController')->except(['show']);
  Route::prefix('return')->group(function () {
    Route::get('','OrderBackWarehouseController@index')->name('return.index');
  });

  Route::post('take/ajax', ['uses' => 'OrderTakeController@getAjax', 'as' => 'take.ajax']);
  Route::post('take/update-date/{id}', ['uses' => 'OrderTakeController@updateDate', 'as' => 'take.updateDate']);
  Route::resource('take', 'OrderTakeController')->except(['show']);
  Route::prefix('take')->group(function () {
    Route::get('','OrderTakeController@index')->name('take.index');
  });

  Route::post('terminate/ajax', ['uses' => 'TerminateBoxesController@getAjax', 'as' => 'terminate.ajax']);
  Route::post('terminate/update-date/{id}', ['uses' => 'TerminateBoxesController@updateDate', 'as' => 'terminate.updateDate']);
  Route::resource('terminate', 'TerminateBoxesController')->except(['show']);
  Route::prefix('terminate')->group(function () {
    Route::get('','TerminateBoxesController@index')->name('terminate.index');
  });

  Route::prefix('notification')->group(function () {
    Route::post('ajax', ['uses' => 'NotificationController@getAjax', 'as' => 'notification.ajax']);
    Route::get('ajax/notif', ['uses' => 'NotificationController@getAjaxNotif', 'as' => 'notification.ajax.notif']);
    Route::get('','NotificationController@index')->name('notification.index');
    Route::get('id/{id}','NotificationController@show')->name('notification.show');
  });

  Route::prefix('user')->group(function () {
    Route::post('ajax', ['uses' => 'UserController@getAjax', 'as' => 'user.ajax']);
    Route::post('store','UserController@store')->name('user.store');
    Route::put('change-profile/{id}','UserController@changeProfile')->name('user.changeProfile');
    Route::put('change-password/{id}','UserController@changePassword')->name('user.changePassword');

    Route::get('dataSelect/all','UserController@getDataSelect')->name('user.getDataSelect');
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
  Route::resource('user', 'UserController');

  Route::resource('types-of-size', 'TypeSizeController')->except(['show']);
  Route::prefix('types-of-size')->group(function () {
    Route::get('createBox','TypeSizeController@createBox')->name('types-of-size.createBox');
    Route::get('createRoom','TypeSizeController@createRoom')->name('types-of-size.createRoom');
    Route::post('store','TypeSizeController@store')->name('types-of-size.store');
  });

  Route::post('price/ajax', ['uses' => 'PriceController@getAjax', 'as' => 'price.ajax']);
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


Route::group(['namespace' => 'Api'], function () {
  Route::get('/usertoken/store', ['uses' => 'UserTokenController@userToken', 'as' => 'api.user.token']);
});
