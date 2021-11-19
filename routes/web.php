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
    return view('admin.auth.login');
});
Route::get('/done', function () {
    return view('done');
});


Route::get('/membershipform','RegistrationController@register')->name('registrationform');

 Route::auth();

Route::group(['prefix' => 'admin'], function () {
  Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'AdminAuth\LoginController@login');
  Route::post('/logout', 'AdminAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'AdminAuth\RegisterController@register');

  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'customer'], function () {
  Route::get('/login', 'CustomerAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'CustomerAuth\LoginController@login');
  Route::post('/logout', 'CustomerAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'CustomerAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'CustomerAuth\RegisterController@register');

  Route::post('/password/email', 'CustomerAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'CustomerAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'CustomerAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'CustomerAuth\ResetPasswordController@showResetForm');

    Route::get('/home', function () {
    return view('customer.home');
  })->name('home');

    Route::any('/billhistory', 'AdminSeller\OrderController@billHistory')->name('bill.history');
    Route::any('/get-order-list/', 'AdminSeller\OrderController@index')->name('customer.order.index');
    Route::any('/customer/validate/', 'CustomerAuth\LoginController@customerValidate')->name('customer.validate');
    Route::get('/get-saved-balance', 'AdminSeller\OrderController@getSavedBalance')->name('get.saved.balance');
});

Route::group(['prefix' => 'manager'], function () {
  Route::get('/login', 'ManagerAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'ManagerAuth\LoginController@login');
  Route::post('/logout', 'ManagerAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'ManagerAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'ManagerAuth\RegisterController@register');

  Route::post('/password/email', 'ManagerAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'ManagerAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'ManagerAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'ManagerAuth\ResetPasswordController@showResetForm');

  Route::get('/home', function () {
    return view('manager.home');
  })->name('home');

  Route::group(['prefix' => 'captain'], function () {
    Route::get('/', 'AdminSeller\CaptainController@index')->name('manager.captain.index');
    Route::get('/create', 'AdminSeller\CaptainController@create')->name('manager.captain.create');
    Route::post('/store', 'AdminSeller\CaptainController@store')->name('manager.captain.store');
    Route::get('/{captain}/edit', 'AdminSeller\CaptainController@edit')->name('manager.captain.edit');
    Route::put('/{captain}', 'AdminSeller\CaptainController@update')->name('manager.captain.update');
  });

  Route::group(['prefix' => 'customer'], function () {
    Route::any('/{type}', 'AdminSeller\VendorController@index')->name('manager.vendors.index');
    Route::any('/create/form', 'AdminSeller\VendorController@create')->name('manager.vendors.create');
    Route::post('/store/form', 'AdminSeller\VendorController@store')->name('manager.vendors.store');
    Route::get('/edit/{id}/edit', 'AdminSeller\VendorController@edit')->name('manager.vendors.edit');
    Route::post('/update/form', 'AdminSeller\VendorController@update')->name('manager.vendors.update');
    Route::post('/destory/record', 'AdminSeller\VendorController@destory')->name('manager.vendors.destory');
    Route::any('/change/status', 'AdminSeller\VendorController@change_status')->name('manager.vendors.change_status');
  });

  Route::get('/change-multiple-status', 'AdminSeller\HomeController@changeMultipleStatus')->name('manager.change-multiple-status');

});

Route::group(['prefix' => 'waiter'], function () {
  Route::get('/login', 'WaiterAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'WaiterAuth\LoginController@login');
  Route::post('/logout', 'WaiterAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'WaiterAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'WaiterAuth\RegisterController@register');

  Route::post('/password/email', 'WaiterAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'WaiterAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'WaiterAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'WaiterAuth\ResetPasswordController@showResetForm');

  Route::get('/home', function () {
    return view('waiter.home');
  })->name('home');

  Route::any('/get-order-list/', 'AdminSeller\OrderController@index')->name('waiter.order.index');
  Route::any('/order-detail/{order_header_id}', 'AdminSeller\OrderController@detail')->name('waiter.order.detail');
  Route::post('/addorder/','AdminSeller\OrderController@addorder')->name('waiter.order.add');
  Route::get('/change-multiple-status', 'AdminSeller\HomeController@changeMultipleStatus')->name('waiter.change-multiple-status');

});

// Route::group(['prefix' => 'vendor'], function () {
//   Route::get('/login', 'VendorAuth\LoginController@showLoginForm')->name('login');
//   Route::post('/login', 'VendorAuth\LoginController@login');
//   Route::post('/logout', 'VendorAuth\LoginController@logout')->name('logout');

//   Route::get('/register', 'VendorAuth\RegisterController@showRegistrationForm')->name('register');
//   Route::post('/register', 'VendorAuth\RegisterController@register');

//   Route::get('/password/reset', 'VendorAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
//   Route::post('/password/email', 'VendorAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
//   Route::post('/password/reset', 'VendorAuth\ResetPasswordController@reset')->name('password.email');
//   Route::get('/password/reset/{token}', 'VendorAuth\ResetPasswordController@showResetForm');

//   Route::get('/home', function () {
//     return view('vendor.home');
//   })->name('home');

//   Route::any('/product', 'AdminSeller\ProductController@vendorproduct')->name('vendor.product');
//   Route::get('/product/{id}/edit', 'AdminSeller\ProductController@edit')->name('vendor.product.edit');
//   Route::any('/price-update', 'AdminSeller\ProductController@price_update')->name('vendor.product.price_update');
//   Route::any('/inventory-update', 'AdminSeller\ProductController@inventory_update')->name('vendor.product.inventory_update');
//   Route::post('/product-price-update', 'AdminSeller\ProductController@product_price_update')->name('vendor.product.product_price_update');
//   Route::post('/product-priceselling-update', 'AdminSeller\ProductController@product_priceselling_update')->name('vendor.product.product_priceselling_update');
//   Route::post('/product-inventory-update', 'AdminSeller\ProductController@product_inventory_update')->name('vendor.product.product_inventory_update');
//   Route::get('/product-price-history/{id}', 'AdminSeller\ProductController@product_price_history')->name('vendor.product.product_price_history');

//   //revenue
//   Route::post('/revenue-report','AdminSeller\RevenueController@report')->name('vendor.revenue.report');
//   Route::get('/revenue','AdminSeller\RevenueController@index')->name('vendor.revenue.index');

//   //inventory
//   Route::get('/inventory/report','AdminSeller\InventoryController@report')->name('vendor.inventory.report');
//   Route::get('/inventory/history/{id}','AdminSeller\InventoryController@history')->name('vendor.inventory.history');
//   });



