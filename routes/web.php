<?php

use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Auth;

// Other Pages
Route::get('/', [PageController::class, 'homepage'])->name('homepage');
Route::get('/page/{page}', [PageController::class, 'page'])->name('page');
Route::get('category/{slug}', [PageController::class, 'category'])->name('category');
Route::post('category/filter/product', [PageController::class, 'filterProduct'])->name('product.filterCategory');
Route::get('search', [PageController::class, 'search'])->name('search');
Route::get('product/{slug}', [PageController::class, 'product'])->name('product');
Route::get('all-hot-deals', [PageController::class, 'allHotDeals'])->name('allHotDeals');
Route::post('single-product/get-variation-price', [PageController::class, 'variationPrice'])->name('product.variationPrice');
Route::post('fb-track', [PageController::class, 'fbTrack'])->name('fbTrack');
Route::get('landing/{id}', [PageController::class, 'landing'])->name('landing.landing');
Route::get('front/not-found', [PageController::class, 'notFound'])->name('front.not-found');


Route::post('landing/{id}/order', [LandingController::class, 'landingBuilderOrder'])->name('landing.builderOrder');
Route::post('l-fb-track/{id}', [FrontPageController::class, 'fbTrackLanding'])->name('fbTrackLanding');
Route::post('get-cities', [LandingController::class, 'getCities'])->name('landing.getCities');
Route::post('landing-fb-track', [LandingController::class, 'fbTrack'])->name('landing.fbTrack');
Route::post('order/{product_id}', [LandingController::class, 'order'])->name('landing.order');
Route::get('thank-you/{id}', [LandingController::class, 'orderSuccess'])->name('landing.orderSuccess');
Route::get('thank-you-b/{id}/{landing}', [LandingController::class, 'orderSuccessB'])->name('landing.orderSuccessB');
Route::post('get-meta-price', [LandingController::class, 'getMetaPrice'])->name('landing.getMetaPrice');

// Cart
Route::get('cart', [CartController::class, 'cart'])->name('cart');
Route::get('cart/direct-order', [CartController::class, 'directOrder'])->name('cart.directOrder');
Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');

// Order
// Route::get('checkout', [OrderController::class, 'checkout'])->name('order.checkout');
Route::post('order', [OrderController::class, 'order'])->name('order');
Route::get('thank-you/{id}', [OrderController::class, 'orderComDetails'])->name('orderComDetails');
Route::post('order/payment/stripe/{id}', [OrderController::class, 'paymentSubmitStripe'])->name('order.payment.strip');
Route::get('order/completed/{id}', [OrderController::class, 'orderSuccess'])->name('orders.complected');


// Route::post('product/add-to-cart', [ProductController::class, 'productAddToCart'])->name('product.productAddToCart');
// Route::post('product/cart/delete', [ProductController::class, 'productCartDeleteAjax'])->name('product.productCartDeleteAjax');

// Auth
Auth::routes();
Route::get('auth/dashboard', [AuthController::class, 'dashboard'])->name('auth.dashboard');
Route::get('auth/edit-profile', [AuthController::class, 'editProfile'])->name('auth.editProfile');
Route::post('auth/update-profile', [AuthController::class, 'updateProfile'])->name('auth.updateProfile');
Route::post('auth/update-password', [AuthController::class, 'updatePassword'])->name('auth.updatePassword');
Route::get('auth/order-details/{id}', [AuthController::class, 'orderDetails'])->name('auth.orderDetails');

// Test Routes
// Route::get('test',             [TestController::class, 'test'])->name('test');
Route::get('import',             [TestController::class, 'import'])->name('import');
// Route::get('config',             [TestController::class, 'config'])->name('config');
Route::get('cache-clear', [TestController::class, 'cacheClear']);
Route::get('cache-clear-admin', [TestController::class, 'cacheClearAdmin'])->name('cacheClearAdmin');



// Home Navigation
// Route::get('/', [App\Http\Controllers\PageController::class, 'home'])->name('home');
Route::get('/blogs', [PageController::class, 'blogs'])->name('blogs');
Route::get('/about', [PageController::class, 'about'])->name('about');
// Route::get('/fourcards', [PageController::class, 'fourcards'])->name('fourcards');

Route::post('/order/get-shipping', [OrderController::class, 'getShipping'])->name('order.getShipping');
Route::post('/order/get-shipping/manual', [OrderController::class, 'getShippingManual'])->name('order.getShippingManual');
Route::post('/order/get-shipping-info', [OrderController::class, 'getShippingInfo'])->name('order.getShippingInfo');



