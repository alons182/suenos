<?php

App::bind('Suenos\Users\UserRepository', 'Suenos\Users\DbUserRepository');
App::bind('Suenos\Payments\PaymentRepository', 'Suenos\Payments\DbPaymentRepository');
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
 * Password Reset
 */
Route::controller('password', 'RemindersController');

/*Route::get('secret', function()
{
    return 'private page';
})->before('role:administrator');*/

