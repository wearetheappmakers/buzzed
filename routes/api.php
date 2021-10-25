<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) { 
    $api->group(['namespace' => 'App\Http\Controllers\Api\V1', 'prefix' => 'v1'], function ($api) {
        $api->post('login', 'AuthController@login');
        $api->post('register', 'AuthController@register');
        // $api->post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
        // $api->post('password/reset', 'ResetPasswordController@reset');
        $api->post('password/forgot', 'ForgotPasswordController@autoGeneratePassword');

        
        $api->get('get-category', 'CatrgoryController@index');
        $api->post('contact-us', 'HomeController@get');
        $api->post('search', 'ProductController@search');
        $api->post('sendmail', 'OrderController@sendmail');

        // Product 
        
        $api->post('product-filter/{cat_slug}', 'ProductController@getFilter');
        

        $api->post('new/product/{cat_slug}', 'NewProductController@index');
        $api->post('new/product-filter/{cat_slug}', 'NewProductController@getFilter');
        $api->get('new/{product_slug}/{id}', 'NewProductController@detail');
        // Review
        $api->post('reviewrating', 'ReviewRatingController@index');
        
        $api->post('delete-reviewrating', 'ReviewRatingController@delete');

        $api->get('pay', 'RazorpayController@pay');
        $api->post('dopayment', 'RazorpayController@dopayment');
        $api->post('get_payment_id','RazorpayController@get');
        $api->post('usercartdelete','RazorpayController@delete');

        $api->post('state', 'LocationController@state');
        $api->post('cities', 'LocationController@cities');
        $api->group(['middleware' => 'jwt.verify'], function ($api_child) {

            $api_child->get('get-home', 'HomeController@index');

            $api_child->post('product/{cat_slug}', 'ProductController@index');
            $api_child->post('product-filter-apply/{cat_slug}', 'ProductController@applyfilter');

            $api_child->post('add-reviewrating', 'ReviewRatingController@add');
            $api_child->post('edit-reviewrating', 'ReviewRatingController@edit');

            $api_child->post('get-brand-category', 'CatrgoryController@getCategoryWithBrand');

            $api_child->get('get-banner', 'BannerController@index');
            
            $api_child->post('category/product', 'CatrgoryController@category');
            $api_child->get('currencies', 'CurrencyController@index');
            $api_child->any('get-order-list', 'OrderController@getOrderList');
            $api_child->get('get-order-detail/{id}', 'OrderController@getOrderDetail');
            $api_child->post('return-request', 'OrderController@returnrequest');
            $api_child->post('get-order-history-status/{id}', 'OrderController@getOrder');

            $api_child->post('update-product-qty', 'OrderController@updateProductQty');
            $api_child->post('removecartitem', 'OrderController@removeItemCart');

            // Product
            $api_child->post('product', 'ProductController@allproduct');
            $api_child->get('/{product_slug}/{id}', 'ProductController@detail');

            $api_child->any('get-cart-list/', 'UserCartController@getCartList');
            $api_child->post('delete-cart/', 'UserCartController@deleteCart');
            $api_child->post('update-cart', 'UserCartController@updateCart');
            $api_child->post('place-order', 'OrderController@placeOrder');
            $api_child->post('new-place-order', 'OrderController@newplaceOrder');
            $api_child->post('confirm-order', 'OrderController@confirmOrder');

            $api_child->post('add-wishlist', 'UserWishlistController@index');
            $api_child->post('wishlist/details', 'UserWishlistController@details');
            $api_child->post('remove-wishlist', 'UserWishlistController@destory');

            
            $api_child->post('add-usercart', 'UserCartController@add');
            $api_child->post('apply-discount', 'UserCartController@applyDiscount');
            $api_child->any('remove-discount', 'UserCartController@removeDiscount');
            
            //Ticket
            $api_child->post('ticket', 'TicketController@add');
            

            $api_child->get('get-address', 'AddressController@index');
            $api_child->post('add-address', 'AddressController@add');
            $api_child->post('edit-address', 'AddressController@edit');
            $api_child->post('view-address', 'AddressController@view');
            $api_child->post('delete-address', 'AddressController@delete');

            $api_child->post('change-password', 'AuthController@changepassword');
            $api_child->post('update-user-details', 'AuthController@update_user');
            $api_child->get('get-user-details', 'AuthController@getUser');

            //offers
            $api_child->get('offres', 'HomeController@offres');

        });
    });
});
