<?php

Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function () {

    Route::get('/', 'WelcomeController@index')->name('welcome');

    // Users Routes

    Route::resource('users', 'UserController')->except(['show']);

    Route::resource('categories', 'CategoryController')->except(['show']);

    Route::resource('products', 'ProductController')->except(['show']);

    Route::resource('clients', 'ClientController')->except(['show']);

    Route::resource('clients.orders', 'Client\OrderController')->except(['show']);

    Route::resource('orders', 'OrderController')->except(['show']);

    Route::get('/orders/{order}/products', 'OrderController@products')->name('orders.products');
});


