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

// Authentication

Auth::routes();

Route::get('/admin', 'AdminController@admin')    
    ->middleware('is_admin')    
    ->name('admin');


// Home

Route::get('/', function () {
    return redirect('/home');
})->name('home');

Route::get('/home', 'HomeController@show');

// Auctions

//Route::get('/auction, AuctionController@index');
Route::put('/auction/{auction}', 'AuctionController@update')->name('auction.update');
Route::get('/auction/create', 'AuctionController@create')->name('auction.create');
Route::post('/auction/{auction}', 'AuctionController@makeBid')->name('auction.makeBid');
Route::post('/auction', 'AuctionController@store')->name('auction.store');
Route::get('/auction/{auction}', 'AuctionController@show');
Route::delete('/auction/{auction}', 'AuctionController@softDelete');
Route::get('/auction/{auction}', 'AuctionController@show');
Route::get('/auction/{auction}/edit', 'AuctionController@edit')->name('auction.edit')->middleware('auth');


// Profile Page
Route::get('/profile/{user}', 'UserController@show')->name('profile.show');
Route::get('/profile/{user}/edit', 'UserController@edit')->name('profile.edit')->middleware('auth');
Route::put('/profile/{user}', 'UserController@update')->name('profile.update');
Route::get('/profile/{user}/delete', 'UserController@softDelete')->name('profile.delete');
Route::post('/profile/{user}/addReview', 'UserController@addReview')->name('review.add');
Route::post('/profile/{user}/addReport', 'UserController@addReport')->name('report.add');

// Wishlist
Route::get('/wishlist', 'WishlistController@index')->name('wishlist.index');
Route::post('auction/{auction}/addToWishlist', 'AuctionController@addToWishlist')->name('auctions.addToWishlist');
Route::post('auction/{auction}/removeFromWishlist', 'AuctionController@removeFromWishlist')->name('auctions.removeFromWishlist');

// Notification
Route::get('/notifications','NotificationsController@index')->name('notifications.index');
Route::get('/notifications/{notifications}', 'NotificationsController@show')->name('notifications.show');
Route::put('/notifications/{notification}', 'NotificationsController@update')->name('notifications.update');

//Messages
Route::get('/messages', 'MessagesController@index')->name('messages.index');
Route::get('/messages/{message}', 'MessagesController@show')->name('messages.show');
Route::post('/messages', 'MessagesController@create')->name('messages.create');



//Auction Search
Route::get('/search', 'SearchController@search')->name('search');


//MODAL PAGE
Route::get('/modal', 'AuctionController@showModal');

Route::post('/admin', 'AdminController@createCategory')->name('category.create');
Route::put('/admin/{user}', 'AdminController@userBan')->name('user.updateBan');

// ----- Static Pages ---- //

// FAQ
Route::get('/faq', 'StaticPagesController@showFaq')->name('faq');
Route::post('/faq', 'StaticPagesController@addFaq')->name('faq.create');
Route::put('/faq/{faq}', 'StaticPagesController@update')->name('faq.update');

// About
Route::get('/about', 'StaticPagesController@showAbout')->name('about');

// Contact
Route::get('/contact', 'StaticPagesController@showContact')->name('contact');