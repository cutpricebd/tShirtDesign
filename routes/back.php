<?php

use App\Http\Controllers\Back\AdminController;
use App\Http\Controllers\Back\BlogController;
use App\Http\Controllers\Back\CouponController;
use App\Http\Controllers\Back\CourierController;
use App\Http\Controllers\Back\CustomerController;
use App\Http\Controllers\Back\FeatureAdsController;
use App\Http\Controllers\Back\FooterWidgetController;
use App\Http\Controllers\Back\FrontendController;
use App\Http\Controllers\Back\MenuController;
use App\Http\Controllers\Back\NotificationController;
use App\Http\Controllers\Back\OrderController;
use App\Http\Controllers\Back\OtherPageController;
use App\Http\Controllers\Back\PageController;
use App\Http\Controllers\Back\Product\AttributeController;
use App\Http\Controllers\Back\Product\BrandController;
use App\Http\Controllers\Back\Product\CategoryController;
use App\Http\Controllers\Back\Product\ProductController;
use App\Http\Controllers\Back\Product\StockAdjustmentController;
use App\Http\Controllers\Back\Product\StockController;
use App\Http\Controllers\back\Product\SupplerController;
use App\Http\Controllers\Back\Product\TaxController;
use App\Http\Controllers\Back\ReportController;
use App\Http\Controllers\Back\ShippingController;
use App\Http\Controllers\Back\SliderController;
use App\Http\Controllers\Back\TestimonialController;
use App\Http\Controllers\Back\TextSliderController;
use App\Http\Controllers\Back\LandingBuilderController;
use App\Http\Controllers\Back\GoogleMerchantController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\SpecialOfferController;
use Illuminate\Support\Facades\Route;

// Auth
// Route::get('login',             [AuthController::class, 'login'])->name('back.login');

Route::middleware('auth', 'isAdmin')->group(function () {
    // Other pages
    Route::get('/', [OtherPageController::class, 'dashboard'])->name('dashboard2');
    Route::get('dashboard', [OtherPageController::class, 'dashboard'])->name('dashboard');
    Route::post('top-products', [OtherPageController::class, 'topProducts'])->name('topProducts');
    // Route::get('carts', [OtherPageController::class, 'carts'])->name('back.carts');
    // Route::get('carts/delete/{cart}', [OtherPageController::class, 'cartDelete'])->name('back.cartDelete');
    // Route::get('wishlists', [OtherPageController::class, 'wishlists'])->name('back.wishlists');
    // Route::get('wishlists/delete/{favorite}', [OtherPageController::class, 'wishlistDelete'])->name('back.wishlistDelete');
    Route::get('product-quotes', [OtherPageController::class, 'productQuotes'])->name('back.productQuotes');
    Route::post('show', [OtherPageController::class, 'show'])->name('back.show');


    // -------------- SYSTEM BACKUP ---------------//
    Route::get('system/backup', [\App\Http\Controllers\Back\BackupController::class,'systemBackup'])->name('back.system.backup');
    Route::get('database/backup', [\App\Http\Controllers\Back\BackupController::class,'databaseBackup'])->name('back.database.backup');


    // --------- Genarate Sitemap _______
    Route::get('/sitemap', [\App\Http\Controllers\Back\SitemapController::class,'index'])->name('admin.sitemap.index');
    Route::get('/sitemap/add', [\App\Http\Controllers\Back\SitemapController::class,'add'])->name('admin.sitemap.add');
    Route::post('/sitemap/store',[\App\Http\Controllers\Back\SitemapController::class,'store'])->name('admin.sitemap.store');
    Route::delete('/sitemap/delete/{id}/', [\App\Http\Controllers\Back\SitemapController::class,'delete'])->name('admin.sitemap.delete');
    Route::post('/sitemap/download', [\App\Http\Controllers\Back\SitemapController::class,'download'])->name('admin.sitemap.download');


    // Admin CRUD
    //update admin profile
    Route::get('profile/update-profile', [AdminController::class, 'update_profile_page'])->name('admin.update-profile');
    Route::post('profile/update-profile/action', [AdminController::class, 'update_profile'])->name('back.admins.update.action');
    Route::post('profile/update-password', [AdminController::class, 'update_password'])->name('admin.password-update');
    Route::get('admins/delete/{user}', [AdminController::class, 'removeImage'])->name('back.admins.removeImage');
    Route::resource('admins', AdminController::class, ['as' => 'back']);

    // Customer CRUD
    Route::get('customers/select-list', [CustomerController::class, 'selectList'])->name('back.customers.selectList');
    Route::get('customers/pre-destroy/{id}', [CustomerController::class, 'preDestroy'])->name('back.customers.preDestroy');
    Route::get('customers/action/{user}/{action}', [CustomerController::class, 'action'])->name('back.customers.action');
    Route::get('customers/remove-image/{user}', [CustomerController::class, 'removeImage'])->name('back.customers.removeImage');
    Route::resource('customers', CustomerController::class, ['as' => 'back']);

    // Supplier CRUD
    Route::resource('suppliers', SupplerController::class, ['as' => 'back']);

    // Page CRUD
    Route::get('pages/remove-image/{page}', [PageController::class, 'removeImage'])->name('back.pages.removeImage');
    Route::resource('pages', PageController::class, ['as' => 'back']);

    // Media
    Route::get('media/settings', [MediaController::class, 'settings'])->name('back.media.settings');
    Route::post('media/settings', [MediaController::class, 'settingsUpdate']);
    Route::post('media/upload', [MediaController::class, 'upload'])->name('back.media.upload');
    // Image Upload
    Route::post('media/image-upload',  [MediaController::class, 'imageUpload'])->name('imageUpload');
    Route::post('media/get-gallery', [MediaController::class, 'getGallery'])->name('back.media.getGallery');

    // Coupon CRUD
    Route::resource('coupons', CouponController::class, ['as' => 'back']);

    // Footer Widgets CRUD
    Route::resource('footer-widgets', FooterWidgetController::class, ['as' => 'back']);

    // Notification
     Route::get('notification/email', [NotificationController::class, 'email'])->name('back.notification.email');
     Route::get('notification/email/send', [NotificationController::class, 'emailSend'])->name('back.notification.emailSend');
     Route::post('notification/email/send', [NotificationController::class, 'emailSendSubmit']);
     Route::get('notification/email/show/{email}', [NotificationController::class, 'emailShow'])->name('back.notification.emailShow');
     Route::get('notification/newsletter-subscribers', [NotificationController::class, 'newslatterSubscribers'])->name('back.notification.newslatterSubscribers');
     Route::get('notification/delete-newsletter/{id}', [NotificationController::class, 'deleteNewslatter'])->name('back.notification.deleteNewslatter');

     Route::get('notification/push', [NotificationController::class, 'push'])->name('back.notification.push');
     Route::post('notification/push', [NotificationController::class, 'pushSend']);

    // Reports
    Route::get('report/overview', [ReportController::class, 'overview'])->name('back.report.overview');
    Route::get('report/taxes', [ReportController::class, 'taxes'])->name('back.report.taxes');
    Route::get('report/revenue', [ReportController::class, 'revenue'])->name('back.report.revenue');
    Route::post('report/revenue', [ReportController::class, 'revenueTable']);
    Route::get('report/coupon', [ReportController::class, 'coupon'])->name('back.report.coupon');
    Route::get('report/coupon/{coupon}', [ReportController::class, 'couponDetails'])->name('back.report.couponDetails');
    Route::get('report/product', [ReportController::class, 'product'])->name('back.report.product');
    Route::post('report/product', [ReportController::class, 'productTable']);
    Route::get('report/product/{product}', [ReportController::class, 'productDetails'])->name('back.report.productDetails');
    Route::get('report/orders', [ReportController::class, 'orders'])->name('back.report.orders');

    // Frontend
    Route::get('frontend/general', [FrontendController::class, 'general'])->name('back.frontend.general');
    Route::post('frontend/general', [FrontendController::class, 'generalStore']);
    // Slider
    Route::post('sliders/position', [SliderController::class, 'position'])->name('back.sliders.position');
    Route::get('sliders/delete/{slider}', [SliderController::class, 'destroy'])->name('back.sliders.delete');
    Route::resource('sliders', SliderController::class, ['as' => 'back']);
    // Top Text Slider
    Route::post('text-sliders/edit-ajax', [TextSliderController::class, 'editAjax'])->name('back.text-sliders.editAjax');
    Route::post('text-sliders/update-ajax', [TextSliderController::class, 'updateAjax'])->name('back.text-sliders.updateAjax');
    Route::post('text-sliders/position', [TextSliderController::class, 'position'])->name('back.text-sliders.position');
    Route::resource('text-sliders', TextSliderController::class, ['as' => 'back']);

    // Courier
    Route::get('courier/config', [CourierController::class, 'config'])->name('back.courier.config');
    Route::post('courier/config', [CourierController::class, 'update'])->name('back.courier.update');

    // Feature Ads
    Route::post('feature-ads/position', [FeatureAdsController::class, 'position'])->name('back.feature-ads.position');
    Route::get('feature-ads/delete/{feature_ad}', [FeatureAdsController::class, 'delete'])->name('back.feature-ads.delete');
    Route::resource('feature-ads', FeatureAdsController::class, ['as' => 'back']);

    // Blog CRUD
    Route::get('blogs/categories', [BlogController::class, 'categories'])->name('back.blogs.categories');
    Route::get('blogs/categories/create', [BlogController::class, 'categoriesCreate'])->name('back.blogs.categories.create');
    Route::get('blogs/remove-image/{blog}', [BlogController::class, 'removeImage'])->name('back.blogs.removeImage');
    Route::resource('blogs', BlogController::class, ['as' => 'back']);

    // Menus
    Route::get('menus', [MenuController::class, 'index'])->name('back.menus.index');
    Route::post('menus/store', [MenuController::class, 'store'])->name('back.menus.store');
    Route::post('menus/store/menu-item', [MenuController::class, 'storeMenuItem'])->name('back.menus.storeMenuItem');
    Route::post('menus/menu-item/position', [MenuController::class, 'menuItemPosition'])->name('back.menus.menuItemPosition');
    Route::get('menus/destroy/{menu}', [MenuController::class, 'destroy'])->name('back.menus.destroy');
    Route::get('menus/item/destroy/{menu_item}', [MenuController::class, 'destroyItem'])->name('back.menus.destroyItem');
    Route::post('menus/item/edit-ajax', [MenuController::class, 'editItemAjax'])->name('back.menus.editItemAjax');
    Route::post('menus/item/update', [MenuController::class, 'updateItem'])->name('back.menus.updateItem');
    Route::get('menus/category', [MenuController::class, 'category'])->name('back.menus.category');

    // Products
    Route::prefix('product')->group(function () {
        // Category CRUD
        Route::get('categories/delete/{category}', [CategoryController::class, 'delete'])->name('back.categories.delete');
        Route::get('categories/get-sub-options', [CategoryController::class, 'getSubOptions'])->name('back.categories.getSubOptions');
        Route::post('categories/change-parent-category', [CategoryController::class, 'changeParentCategory'])->name('back.categories.changeParentCategory');
        Route::post('categories/change-product-category', [CategoryController::class, 'changeProductCategory'])->name('back.categories.changeProductCategory');
        Route::get('categories/remove-product/{product}/{category}', [CategoryController::class, 'removeProduct'])->name('back.categories.removeProduct');
        Route::get('categories/remove-image/{category}', [CategoryController::class, 'removeImage'])->name('back.categories.removeImage');
        Route::get('categories/remove-banner-image/{category}', [CategoryController::class, 'removeBannerImage'])->name('back.categories.removeBannerImage');
        Route::get('categories/remove-feature-image/{category}', [CategoryController::class, 'removeFeatureImage'])->name('back.categories.removeFeatureImage');
        Route::get('categories/remove-collection-image/{category}', [CategoryController::class, 'removeCollectionImage'])->name('back.categories.removeCollectionImage');
        Route::resource('categories', CategoryController::class, ['as' => 'back']);

        // Brand CRUD
        Route::get('brands/remove-image/{brand}', [BrandController::class, 'removeImage'])->name('back.brands.removeImage');
        Route::resource('brands', BrandController::class, ['as' => 'back']);

        // Product CRUD
        Route::post('products/attribute/apply', [ProductController::class, 'attributeApply'])->name('back.products.attributeApply');
        Route::post('products/table', [ProductController::class, 'table'])->name('back.products.table');
        Route::get('products/select-list', [ProductController::class, 'selectList'])->name('back.products.selectList');
        Route::post('products/product-data-json', [ProductController::class, 'productDataJson'])->name('back.products.productDataJson');
        Route::get('products/reviews', [ProductController::class, 'reviews'])->name('back.products.reviews');
        Route::get('products/reviews-action/{review}/{action}', [ProductController::class, 'reviewAction'])->name('back.products.reviewAction');
        Route::get('products/reviews-action/{review}', [ProductController::class, 'reviewDelete'])->name('back.products.reviewDelete');
        Route::post('products/change-featured', [ProductController::class, 'changeFeatured'])->name('back.products.changeFeatured');
        Route::resource('products', ProductController::class, ['as' => 'back']);

        // Attribute CRUD
        Route::post('attributes/items/store', [AttributeController::class, 'itemStore'])->name('back.attributes.itemStore');
        Route::get('attributes/items/destroy/{id}', [AttributeController::class, 'itemDestroy'])->name('back.attributes.itemDestroy');
        // Route::get('attributes/items/edit/{id}', [AttributeController::class, 'itemEdit'])->name('back.attributes.itemEdit');
        Route::post('attributes/items/update', [AttributeController::class, 'itemUpdate'])->name('back.attributes.itemUpdate');
        Route::post('attributes/update', [AttributeController::class, 'updateModal'])->name('back.attributes.updateModal');
        Route::resource('attributes', AttributeController::class, ['as' => 'back']);

        // Stocks
         Route::post('stocks/product-table', [StockController::class, 'productTable'])->name('back.stocks.productTable');
         Route::post('stocks/add-item', [StockController::class, 'addItem'])->name('back.stocks.addItem');
         Route::get('stocks/pre-alert', [StockController::class, 'preAlert'])->name('back.stocks.preAlert');
         Route::get('stocks/out', [StockController::class, 'out'])->name('back.stocks.out');
         Route::get('stocks/alert', [StockController::class, 'alert'])->name('back.stocks.alert');
         Route::get('stocks/history', [StockController::class, 'history'])->name('back.stoct.history');
         Route::post('stocks/history', [StockController::class, 'historyTable']);
         Route::resource('stocks', StockController::class, ['as' => 'back']);

        // Adjustment
        Route::get('adjustments', [StockAdjustmentController::class, 'index'])->name('back.adjustments.index');
        Route::get('adjustments/create', [StockAdjustmentController::class, 'create'])->name('back.adjustments.create');
        Route::post('adjustments/store', [StockAdjustmentController::class, 'store'])->name('back.adjustments.store');
        Route::post('adjustments/add-item', [StockAdjustmentController::class, 'addItem'])->name('back.adjustments.addItem');
        Route::post('adjustments/get-cost', [StockAdjustmentController::class, 'getCost'])->name('back.adjustments.getCost');
        Route::delete('adjustments/delete', [StockAdjustmentController::class, 'delete'])->name('back.adjustments.delete');

        // Tax
        Route::resource('taxes', TaxController::class, ['as' => 'back']);

        // Shipping Charges
        Route::resource('shippings', ShippingController::class, ['as' => 'back']);
    });

    // Brand CRUD
    Route::resource('testimonials', TestimonialController::class, ['as' => 'back']);

    // Spacial Offers CRUD
    Route::resource('special-offer', SpecialOfferController::class, ['as' => 'back']);

    // Orders
    Route::post('orders/add-item', [OrderController::class, 'addItem'])->name('back.orders.addItem');
    Route::post('orders/table', [OrderController::class, 'table'])->name('back.orders.table');
    Route::get('orders/refund/{id}', [OrderController::class, 'refund'])->name('back.orders.refund');
    Route::get('orders/return-refund/{order}', [OrderController::class, 'returnRefund'])->name('back.orders.returnRefund');
    Route::post('orders/return-refund/{order}', [OrderController::class, 'returnRefundSubmit']);
    Route::get('orders/e-shipper-label/{order}', [OrderController::class, 'eShipperLabel'])->name('back.orders.eShipperLabel');
    Route::get('orders/select-courier/{order}', [OrderController::class, 'selectCourier'])->name('back.orders.selectCourier');
    Route::post('orders/select-courier/{order}', [OrderController::class, 'selectCourierSubmit']);
    Route::post('orders/add-product/{order}', [OrderController::class, 'addProduct'])->name('back.orders.addProduct');
    Route::get('orders/export-csv', [OrderController::class, 'exportCsv'])->name('back.orders.exportCsv');
    Route::post('orders/print-list', [OrderController::class, 'printList'])->name('back.orders.printList');
    Route::resource('orders', OrderController::class, ['as' => 'back']);

    Route::post('orders/get-courier-success-rate', [OrderController::class, 'getSuccessRate'])->name('orders.getSuccessRate');

    Route::get('orders/update-courier-status/{id}', [CourierController::class, 'updateCourierStatus'])->name('orders.updateCourierStatus');

    // Landing Builder
    Route::get('landing-builders', [LandingBuilderController::class, 'index'])->name('back.landingBuilders.index');
    Route::get('landing-builders/create', [LandingBuilderController::class, 'create'])->name('back.landingBuilders.create');
    Route::get('landing-builders/add-stock-product', [LandingBuilderController::class, 'addProduct'])->name('back.landingBuilders.addProduct');
    Route::post('landing-builders/store', [LandingBuilderController::class, 'store'])->name('back.landingBuilders.store');
    Route::get('landing-builders/edit/{id}', [LandingBuilderController::class, 'edit'])->name('back.landingBuilders.edit');
    Route::post('landing-builders/update/{id}', [LandingBuilderController::class, 'update'])->name('back.landingBuilders.update');
    Route::get('landing-builders/build/{id}', [LandingBuilderController::class, 'build'])->name('back.landingBuilders.build');
    Route::post('landing-builders/build/{id}/save', [LandingBuilderController::class, 'buildSave'])->name('back.landingBuilders.buildSave');

    // Google Merchant
    Route::get('upload-to-google-b', [GoogleMerchantController::class, 'uploadB'])->name('gm.uploadB');
    Route::post('upload-to-google-b', [GoogleMerchantController::class, 'uploadBSubmit'])->name('gm.uploadBSubmit');
    Route::post('upload-to-google-by-product', [GoogleMerchantController::class, 'uploadSubmitByProduct'])->name('gm.uploadSubmitByProduct');

    // Pathao
    Route::post('orders/get-pathao-info', [CourierController::class, 'getPathaoInfo'])->name('orders.getPathaoInfo');
    Route::post('orders/send-pathao-order/{id}', [CourierController::class, 'sendPathaoOrder'])->name('orders.sendPathaoOrder');
    Route::post('orders/get-zones', [CourierController::class, 'getPathaoZone'])->name('orders.getPathaoZone');
    Route::post('orders/get-areas', [CourierController::class, 'getPathaoAreas'])->name('orders.getPathaoAreas');

    // REDX
    Route::post('orders/get-redx-info', [CourierController::class, 'getRedexInfo'])->name('orders.getRedexInfo');
    Route::post('orders/send-redx-order/{id}', [CourierController::class, 'sendRedexOrder'])->name('orders.sendRedexOrder');

    // Steadfast
    Route::post('orders/send-steadfast-order/{id}', [CourierController::class, 'sendSteadfastOrder'])->name('orders.sendSteadfastOrder');
    Route::post('orders/get-for-steadfast', [CourierController::class, 'getFotSteadFast'])->name('orders.getForSteadFast');
    Route::post('orders/steadfast-create-ajax', [CourierController::class, 'steadFastCreateAjax'])->name('orders.steadFastCreateAjax');






});
