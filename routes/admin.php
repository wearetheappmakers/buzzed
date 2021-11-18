 <?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('admin')->user();

    //dd($users);

    return view('admin.home');
})->name('home');

// Route::resource('banner','AdminSeller\BannerController');
Route::get('banner/{type}','AdminSeller\BannerController@index')->name('banner.index');
Route::post('banner/{type}','AdminSeller\BannerController@store')->name('banner.store');
Route::get('banner/create/{type}','AdminSeller\BannerController@create')->name('banner.create');
Route::get('banner/{banner}','AdminSeller\BannerController@show')->name('banner.show');
Route::delete('banner/{banner}','AdminSeller\BannerController@destroy')->name('banner.destroy');
Route::any('banner/{banner}','AdminSeller\BannerController@update')->name('banner.update');
Route::get('banner/{banner}/edit/{type}','AdminSeller\BannerController@edit')->name('banner.edit');

// Route::resource('static-page','AdminSeller\StaticPageController');
Route::get('static-page/{type}','AdminSeller\StaticPageController@index')->name('static-page.index');
Route::post('static-page/{type}','AdminSeller\StaticPageController@store')->name('static-page.store');
Route::get('static-page/create/{type}','AdminSeller\StaticPageController@create')->name('static-page.create');
// Route::get('static-page/{static-page}','AdminSeller\StaticPageController@show')->name('static-page.show');
// Route::delete('static-page/{static-page}','AdminSeller\StaticPageController@destroy')->name('static-page.destroy');
Route::any('static-page/{id}','AdminSeller\StaticPageController@update')->name('static-page.update');
Route::get('static-page/{id}/edit/{type}','AdminSeller\StaticPageController@edit')->name('static-page.edit');

Route::any('import-category', 'AdminSeller\CategoryController@importCategory')->name('category.import');
Route::any('/order/print/{order_header_id}','AdminSeller\OrderController@print')->name('order.print');

Route::post('/addorder/','AdminSeller\OrderController@addorder')->name('order.add');

Route::resource('settings','AdminSeller\SettingsController');
Route::resource('permission','AdminSeller\PermissionController');
Route::resource('currency','AdminSeller\CurrencyController');
Route::resource('option','AdminSeller\OptionController');
Route::resource('reviewrating','AdminSeller\ReviewRatingController');

Route::resource('size','AdminSeller\SizeController');
Route::resource('sizechart','AdminSeller\SizeChartController');
Route::resource('color','AdminSeller\ColorController');
Route::resource('option-value','AdminSeller\OptionValueController');
Route::resource('currency','AdminSeller\CurrencyController');
Route::resource('orderstatus','AdminSeller\OrderStatusController');
Route::resource('ticket','AdminSeller\TicketController');
Route::resource('discount','AdminSeller\DiscountController');
Route::resource('blog','AdminSeller\BlogController');
Route::resource('blogcategories','AdminSeller\BlogCategoriesController');
Route::resource('testimonial','AdminSeller\TestimonialController');
Route::resource('product','AdminSeller\ProductController');
Route::resource('category','AdminSeller\CategoryController');
Route::resource('image_optimize','AdminSeller\ImageOptimizeController');
Route::resource('topdeals','AdminSeller\TopDealsController');
Route::resource('offer','AdminSeller\OfferController');
Route::resource('emailtemplate','AdminSeller\EmailTemplateController');
Route::resource('revenue','AdminSeller\RevenueController');
Route::resource('staff','AdminSeller\StaffController');
// Route::resource('vendors','AdminSeller\VendorController');

Route::resource('captain','AdminSeller\CaptainController');
Route::resource('outlet','AdminSeller\OutletController');

Route::post('category-destory','AdminSeller\CategoryController@destory')->name('category.destory');

Route::get('/inventory','AdminSeller\InventoryController@index')->name('inventory.index');
Route::get('/inventory/offline','AdminSeller\InventoryController@indexoffline')->name('inventoryoffline.index');
Route::post('/inventory/update','AdminSeller\InventoryController@update')->name('inventory.update');
Route::post('/inventory/offline/update','AdminSeller\InventoryController@updateoffline')->name('inventoryoffline.update');
Route::get('/inventory/report','AdminSeller\InventoryController@report')->name('inventory.report');
Route::get('/inventory/history/{id}','AdminSeller\InventoryController@history')->name('inventory.history');
Route::get('/category-tree', 'AdminSeller\CategoryController@treeView')->name('category.tree-view');

Route::name('home.')->group(function () {
    Route::get('/change-multiple-status', 'AdminSeller\HomeController@changeMultipleStatus')->name('change-multiple-status');
    Route::get('/chart/get-data', 'AdminSeller\HomeController@chartgetdata')->name('getdata');
    Route::get('/delete-multiple', 'AdminSeller\HomeController@deleteMultiple')->name('delete-multiple');
    Route::get('/discount-multiple', 'AdminSeller\HomeController@discountMultiple')->name('discount-multiple');
    Route::get('/change-order', 'AdminSeller\HomeController@changeOrder')->name('change-order');
});

Route::get('pay', 'AdminSeller\RazorpayController@pay')->name('pay');
Route::post('dopayment', 'AdminSeller\RazorpayController@dopayment')->name('dopayment');

Route::any('title1-product', 'AdminSeller\ProductController@title1product')->name('product.title1');
Route::any('title2-product', 'AdminSeller\ProductController@title2product')->name('product.title2');
Route::any('title3-product', 'AdminSeller\ProductController@title3product')->name('product.title3');
Route::any('tag-product', 'AdminSeller\ProductController@tagproduct')->name('product.tag');
Route::any('import-product', 'AdminSeller\ProductController@importProduct')->name('product.import');
Route::any('category-product', 'AdminSeller\ProductController@updateCategory')->name('product.catgeory_update');
Route::any('color-product', 'AdminSeller\ProductController@updateColor')->name('product.color_update');
Route::any('size-product', 'AdminSeller\ProductController@updateSize')->name('product.size_update');
Route::any('sizechart-product', 'AdminSeller\ProductController@updateSizechart')->name('product.sizechart_update');
Route::any('discount-product', 'AdminSeller\ProductController@updateDiscount')->name('product.discount_update');
Route::any('/general-update', 'AdminSeller\ProductController@update_general')->name('product.general_update');
Route::any('/image-update', 'AdminSeller\ProductController@image_general')->name('product.image_update');
Route::any('/inventory-update', 'AdminSeller\ProductController@inventory_update')->name('product.inventory_update');
Route::any('/option-update', 'AdminSeller\ProductController@option_update')->name('product.option_update');
Route::any('/lot-inventory-update', 'AdminSeller\ProductController@lot_inventory_update')->name('product.lot_inventory_update');
Route::any('/price-update', 'AdminSeller\ProductController@price_update')->name('product.price_update');
Route::any('/get-color-popup/{id}', 'AdminSeller\ProductController@get_color_popup')->name('product.get_color_popup');
Route::any('/get-discount-popup', 'AdminSeller\ProductController@get_discount_popup')->name('product.get_discount_popup');
Route::any('/get-order-list', 'AdminSeller\OrderController@index')->name('order.index');
Route::any('/order/return/accept', 'AdminSeller\OrderController@accept')->name('order.accept');
Route::any('/order/return/reject', 'AdminSeller\OrderController@reject')->name('order.reject');
Route::any('/order-list/{status_id}', 'AdminSeller\OrderController@index')->name('order.status.index');
Route::any('/change-order-status', 'AdminSeller\OrderController@changeOrderStatus')->name('order.changeOrderStatus');
Route::any('/order-detail/{order_header_id}', 'AdminSeller\OrderController@detail')->name('order.detail');
Route::any('/user/{type}', 'AdminSeller\UserController@index')->name('user.index');
Route::any('/user/change/status', 'AdminSeller\UserController@change_status')->name('user.change_status');
Route::get('/order/export/view','AdminSeller\OrderController@exportview')->name('order.export.view');
Route::get('/order/export/update','AdminSeller\OrderController@exportupdate')->name('order.export.update');

//product-index
Route::post('product-price-update', 'AdminSeller\ProductController@product_price_update')->name('product.product_price_update');
Route::post('product-priceselling-update', 'AdminSeller\ProductController@product_priceselling_update')->name('product.product_priceselling_update');
Route::post('product-inventory-update', 'AdminSeller\ProductController@product_inventory_update')->name('product.product_inventory_update');
Route::get('product-price-history/{id}', 'AdminSeller\ProductController@product_price_history')->name('product.product_price_history');

//Vendor
Route::any('/customer/{type}', 'AdminSeller\VendorController@index')->name('vendors.index');
Route::any('/customer/create/form', 'AdminSeller\VendorController@create')->name('vendors.create');
Route::post('/customer/store/form', 'AdminSeller\VendorController@store')->name('vendors.store');
Route::get('/customer/edit/{id}/edit', 'AdminSeller\VendorController@edit')->name('vendors.edit');
Route::post('/customer/update/form', 'AdminSeller\VendorController@update')->name('vendors.update');
Route::post('/customer/destory/record', 'AdminSeller\VendorController@destory')->name('vendors.destory');
Route::any('/customer/change/status', 'AdminSeller\VendorController@change_status')->name('vendors.change_status');


//location management
Route::resource('country','AdminSeller\CountryLocationManagementController');
Route::resource('state','AdminSeller\StateLocationManagementController');
Route::resource('city','AdminSeller\CityLocationManagementController');
Route::post('country-destory','AdminSeller\CountryLocationManagementController@destory')->name('country.destory');
Route::post('state-destory','AdminSeller\StateLocationManagementController@destory')->name('state.destory');
Route::post('city-destory','AdminSeller\CityLocationManagementController@destory')->name('city.destory');

//Brand 
Route::resource('brand','AdminSeller\BrandController');
Route::post('brand-destory','AdminSeller\BrandController@destory')->name('brand.destory');

//General Settings
Route::get('general-setting','AdminSeller\GeneralSettingController@index')->name('general.setting');
Route::post('/general/setting/update', 'AdminSeller\GeneralSettingController@update')->name('general.update');
Route::get('/general/setting/cacheclear', 'AdminSeller\GeneralSettingController@CacheClear')->name('general.cacheclear');

Route::post('revenue-report','AdminSeller\RevenueController@report')->name('revenue.report');

//destory routes
Route::post('color-destory','AdminSeller\ColorController@destory')->name('color.destory');
Route::post('size-destory','AdminSeller\SizeController@destory')->name('size.destory');
Route::post('option-destory','AdminSeller\OptionController@destory')->name('option.destory');
Route::post('option-value-destory','AdminSeller\OptionValueController@destory')->name('option-value.destory');
Route::post('product-destory','AdminSeller\ProductController@destory')->name('product.destory');
Route::post('orderstatus-destory','AdminSeller\OrderStatusController@destory')->name('orderstatus.destory');
Route::post('reviewrating-destory','AdminSeller\ReviewRatingController@destory')->name('reviewrating.destory');
Route::post('banner-destory','AdminSeller\BannerController@destory')->name('banner.destory');
Route::post('topdeals-destory','AdminSeller\TopDealsController@destory')->name('topdeals.destory');
Route::post('offer-destory','AdminSeller\OfferController@destory')->name('offer.destory');
Route::post('emailtemplate-destory','AdminSeller\EmailTemplateController@destory')->name('emailtemplate.destory');
Route::post('revenue-destory','AdminSeller\RevenueController@destory')->name('revenue.destory');
Route::post('revenue-destory','AdminSeller\RevenueController@destory')->name('revenue.destory');
Route::post('discount-destory','AdminSeller\DiscountController@destory')->name('discount.destory');
Route::post('captain-destory','AdminSeller\CaptainController@destory')->name('captain.destory');
Route::post('outlet-destory','AdminSeller\OutletController@destory')->name('outlet.destory');
Route::post('staff-destory','AdminSeller\StaffController@destory')->name('staff.destory');

