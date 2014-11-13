<?php
/*Event::Listen('illuminate.query', function($query)
{
    var_dump($query);
});*/

#binding
App::bind('Suenos\Users\UserRepository', 'Suenos\Users\DbUserRepository');
App::bind('Suenos\Payments\PaymentRepository', 'Suenos\Payments\DbPaymentRepository');
App::bind('Suenos\Categories\CategoryRepository', 'Suenos\Categories\DbCategoryRepository');
App::bind('Suenos\Products\ProductRepository', 'Suenos\Products\DbProductRepository');
App::bind('Suenos\Photos\PhotoRepository', 'Suenos\Photos\DbPhotoRepository');
App::bind('Suenos\Orders\OrderRepository', 'Suenos\Orders\DbOrderRepository');
/*App::after(function($request, $response)
{
    $response->headers->set('Cache-Control','nocache, no-store, max-age=0, must-revalidate');
    $response->headers->set('Pragma','no-cache');
    $response->headers->set('Expires','Fri, 01 Jan 1990 00:00:00 GMT');
});*/
/**
 * Pages
 */
Route::get('/', [
    'as'   => 'home',
    'uses' => 'PagesController@index'
]);
Route::get('about', [
    'as'   => 'about',
    'uses' => 'PagesController@about'
]);
Route::get('opportunity', [
    'as'   => 'opportunity',
    'uses' => 'PagesController@opportunity'
]);
Route::get('aid-plan', [
    'as'   => 'aid',
    'uses' => 'PagesController@aid'
]);
Route::get('contact', [
    'as'   => 'contact',
    'uses' => 'PagesController@contact'
]);
Route::post('contact', [
    'as'   => 'contact.store',
    'uses' => 'PagesController@postContact'
]);
Route::get('terms', [
    'as'   => 'terms',
    'uses' => 'PagesController@terms'
]);
Route::get('descargas', [
    'as'   => 'downloads_path',
    'uses' => 'DownloadsController@index'
]);

/**
 * Registration
 */
Route::get('register', [
    'as'   => 'registration.create',
    'uses' => 'RegistrationController@create'
])->before('guest');

Route::post('register', [
    'as'   => 'registration.store',
    'uses' => 'RegistrationController@store'
])->before('guest');

/**
 * Authentication
 */
Route::get('login', [
    'as'   => 'login',
    'uses' => 'SessionsController@create'
]);
Route::get('logout', [
    'as'   => 'logout',
    'uses' => 'SessionsController@destroy'
]);
Route::resource('sessions', 'SessionsController', [
    'only' => ['create', 'store', 'destroy']
]);

/**
 * Payments user
 */
Route::resource('payments', 'PaymentsController');

/**
 * orders user
 */

Route::resource('orders', 'OrdersController');

/**
 * Cart
 */
Route::get('cart', [
    'as'   => 'cart_path',
    'uses' => 'OrdersController@cart'
]);

Route::get('cart/checkout', [
    'as'   => 'cart_checkout',
    'uses' => 'OrdersController@formCheckout'
])->before('auth');

Route::post('cart/checkoutConfirm', [
    'as'   => 'cart_checkout.confirm',
    'uses' => 'OrdersController@formPostCheckout'
])->before('auth');


Route::post('cart/checkout', [
    'as'   => 'cart_checkout.store',
    'uses' => 'OrdersController@store'
])->before('auth');


/**
 * Members Red
 */
Route::get('red', [
    'as'   => 'red.show',
    'uses' => 'PaymentsController@red'
])->before('auth');
/**
 * Profile
 */
Route::resource('profile', 'ProfilesController', [
    'only' => ['show', 'edit', 'update']
]);

Route::get('/{profile}', [
    'as'   => 'profile.register',
    'uses' => 'RegistrationController@create'
])->before('guest');

/**
 * Administration Store
 */
Route::group(['prefix' => 'store/admin', 'before' => 'authByRole'], function ()
{

    # Dashboard
    Route::get('/', [
        'as'   => 'dashboard',
        'uses' => 'app\controllers\Admin\DashboardController@index'

    ]);

    # Users
    Route::get('users', [
        'as'   => 'users',
        'uses' => 'app\controllers\Admin\UsersController@index'

    ]);
    Route::get('users/register', [
        'as'   => 'user_register',
        'uses' => 'app\controllers\Admin\UsersController@create'
    ]);
    Route::post('users/register', [
        'as'   => 'user_register.store',
        'uses' => 'app\controllers\Admin\UsersController@store'
    ]);
    foreach (['active', 'inactive'] as $key)
    {
        Route::post('users/{user}/' . $key, array(
            'as'   => 'users.' . $key,
            'uses' => 'app\controllers\Admin\UsersController@' . $key,
        ));
    }
    Route::get('users/gainsExcel', [
        'as'   => 'users_gains_excel',
        'uses' => 'app\controllers\Admin\UsersController@exportGainsList'
    ]);
    Route::get('users/paymentsDayExcel', [
        'as'   => 'users_payments_excel',
        'uses' => 'app\controllers\Admin\UsersController@exportPaymentsList'
    ]);
    Route::get('users/list', [
        'as' => 'patners_list',
        'uses' => 'app\controllers\Admin\UsersController@list_patners'
    ]);
    Route::resource('users', 'app\controllers\Admin\UsersController');

    # categories
    foreach (['up', 'down', 'pub', 'unpub', 'feat', 'unfeat'] as $key)
    {
        Route::post('categories/{category}/' . $key, [
            'as'   => 'categories.' . $key,
            'uses' => 'app\controllers\Admin\CategoriesController@' . $key,
        ]);
    }
    Route::get('categories', [
        'as'   => 'categories',
        'uses' => 'app\controllers\Admin\ProductsController@index'
    ]);
    Route::resource('categories', 'app\controllers\Admin\CategoriesController');

    # products

    foreach (['pub', 'unpub', 'feat', 'unfeat'] as $key)
    {
        Route::post('products/{product}/' . $key, array(
            'as'   => 'products.' . $key,
            'uses' => 'app\controllers\Admin\ProductsController@' . $key,
        ));
    }
    Route::post('products/delete', [
        'as'   => 'destroy_multiple',
        'uses' => 'app\controllers\Admin\ProductsController@destroy_multiple'
    ]);
    Route::get('products/list', [
        'as'   => 'products_list',
        'uses' => 'app\controllers\Admin\ProductsController@list_products'
    ]);
    Route::get('products', [
        'as'   => 'products',
        'uses' => 'app\controllers\Admin\ProductsController@index'
    ]);

    Route::resource('products', 'app\controllers\Admin\ProductsController');

    #photos
    Route::post('photos', [
        'as'   => 'save_photo',
        'uses' => 'app\controllers\Admin\PhotosController@store'
    ]);
    Route::post('photos/{photo}', [
        'as'   => 'delete_photo',
        'uses' => 'app\controllers\Admin\PhotosController@destroy'
    ]);

    #orders
    Route::post('orders/delete', [
        'as'   => 'destroy_multiple_orders',
        'uses' => 'app\controllers\Admin\OrdersController@destroy_multiple'
    ]);
    Route::get('orders/list', [
        'as'   => 'orders_list',
        'uses' => 'app\controllers\Admin\OrdersController@list_orders'
    ]);
    Route::get('orders', [
        'as'   => 'orders',
        'uses' => 'app\controllers\Admin\OrdersController@index'
    ]);

    Route::resource('orders', 'app\controllers\Admin\OrdersController');

    Route::post('downloads/store', [
        'as'   => 'downloads_store_path',
        'uses' => 'app\controllers\Admin\DownloadsController@store'
    ]);

    Route::resource('downloads', 'app\controllers\Admin\DownloadsController');

});
Route::group(['prefix' => 'store'], function ()
{
    # products
    Route::get('categories/{category}/products', [
            'as'   => 'products_path',
            'uses' => 'ProductsController@index']
    );
    Route::get('categories/{category}/products/{product}', [
        'as'   => 'product_path',
        'uses' => 'ProductsController@show'
    ]);
    Route::get('search', [
        'as' => 'products_search',
        'uses' => 'ProductsController@search'
    ]);

    # categories
    Route::get('categories', [
            'as'   => 'categories_path',
            'uses' => 'ProductsController@categories']
    );


});
/**
 * Password Reset
 */
Route::controller('password', 'RemindersController');


