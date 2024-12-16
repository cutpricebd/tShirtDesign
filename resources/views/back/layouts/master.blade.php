<!doctype html>
<html class="no-js" lang="en">

@php
    $pending_orders = App\Models\Order\Order::where('status', 'Processing');
    if(auth()->user()->type == 'order_employee'){
        $pending_orders->where('admin_id', auth()->user()->id);
    }
    $pending_orders = $pending_orders->count();
    $delivered_orders = App\Models\Order\Order::where('status', 'Delivered');
    if(auth()->user()->type == 'order_employee'){
        $delivered_orders->where('admin_id', auth()->user()->id);
    }
    $delivered_orders = $delivered_orders->count();
    $completed_orders = App\Models\Order\Order::where('status', 'Completed');
    if(auth()->user()->type == 'order_employee'){
        $completed_orders->where('admin_id', auth()->user()->id);
    }
    $completed_orders = $completed_orders->count();
    $in_courier_orders = App\Models\Order\Order::where('status', 'In Courier');
    if(auth()->user()->type == 'order_employee'){
        $in_courier_orders->where('admin_id', auth()->user()->id);
    }
    $in_courier_orders = $in_courier_orders->count();
    $confirmed_orders = App\Models\Order\Order::where('status', 'Confirmed');
    if(auth()->user()->type == 'order_employee'){
        $confirmed_orders->where('admin_id', auth()->user()->id);
    }
    $confirmed_orders = $confirmed_orders->count();
    $returned_orders = App\Models\Order\Order::where('status', 'Returned');
    if(auth()->user()->type == 'order_employee'){
        $returned_orders->where('admin_id', auth()->user()->id);
    }
    $returned_orders = $returned_orders->count();
    $canceled_orders = App\Models\Order\Order::where('status', 'Canceled');
    if(auth()->user()->type == 'order_employee'){
        $canceled_orders->where('admin_id', auth()->user()->id);
    }
    $canceled_orders = $canceled_orders->count();

    $pending_customers = App\Models\PreUser::where('email_verified_at', null)->count();
    $reviews = App\Models\Product\Review::where('status', 2)->count();
    // $quotes = App\Models\Product\ProductQuotes::where('admin_read', 2)->count();
    $carts = App\Models\Product\Cart::where('admin_read', 2)->count();
    $favorites = App\Models\Favorite::where('admin_read', 2)->count();
    $customers = App\Models\User::where('admin_read', 2)->where('type', 'customer')->active()->count();
    $orders = App\Models\Order\Order::where('admin_read', 2)->count();

    $stock_pre_alert_quantity_products=0;
    $stock_alert_quantity_products=0;
    $stock_out_products=0;
@endphp

<head>
  <meta charset="utf-8">
  <title>@yield('title') - {{$settings_g['title'] ?? env('APP_NAME')}}</title>
  {{-- <meta name="description" content=""> --}}
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Icons -->
  <link rel="shortcut icon" href="{{$settings_g['favicon'] ?? ''}}">

  <link rel="stylesheet" href="{{asset('back/css/normalize.css')}}">
  <link rel="stylesheet" href="{{asset('back/css/main.css')}}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" href="{{asset('back/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('back/css/responsive.css')}}">

  {{-- <link href="{{asset('back/css/app.css')}}" rel="stylesheet"> --}}

  <!-- fontawesome -->
  {{-- <link href="https://cutpricebd.com/oms/public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> --}}
  {{--<script src="https://kit.fontawesome.com/9c65216417.js" crossorigin="anonymous"></script>--}}
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>

    <meta name="theme-color" content="#fafafa">

  @yield('head')

  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

  @include('switcher::code')

  <script>
    window.application_root = '{{url("/")}}';
    window.application_root_api = '{{url("/api")}}';
    window._token = '{{csrf_token()}}';
    window.upload_required = false;
  </script>

  <link href="{{asset('back/css/print.css')}}" media="print" rel="stylesheet">
</head>

<body>
    <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
        @csrf
    </form>
    <input type="hidden" class="gallery_skip" value="0">

    <!-- Custom Loader -->
    <div class="loader noPrint" style="display: none">
        <i class="fas fa-spinner fa-spin"></i>
    </div>

  <div class="main" id="app">
    <header class="noPrint">
      <div class="container-fluid">
        <div class="header_wrap">
          <div class="row">
            <div class="col-md-6">
              <ul class="npnls left_menu d-none d-md-block">
                <li>
                    <a href="{{route('homepage')}}" target="_blank" class="app_name">
                        @if(isset($settings_g['logo']) && $settings_g['logo'])
                        <img src="{{$settings_g['logo'] ?? ''}}" alt="{{$settings_g['title'] ?? ''}}" class="whp" style="background: #fff;padding: 5px;height: 50px;object-fit: contain;">
                        @else
                        {{$settings_g['title'] ?? ''}}
                        @endif
                    </a>
                </li>
              </ul>
            </div>

            <div class="col-md-6">
              <div class="row">
                <div class="col-6 d-block d-md-none">
                  <ul class="npnls header_right_items hli">
                    <li><a href="#" onclick="menuTrigger()"><i class="fas fa-bars"></i></a></li>
                  </ul>
                </div>
                <div class="col-6 col-md-12">
                  <ul class="npnls text-right header_right_items d-none d-md-block">
                    {{-- <li><a href="{{route('back.customers.index')}}">Pending Registration <span class="badge badge-primary" style="background: yellow;color: red;">{{$pending_customers}}</span></a></li>
                    <li><a href="{{route('back.stocks.out')}}">Out of Stock <span class="badge badge-primary" style="background: yellow;color: red;">{{$stock_out_products}}</span></a></li>
                    <li><a href="{{route('back.orders.index')}}?ref=Processing">Not Delivered <span class="badge badge-primary" style="background: yellow;color: red;">{{$pending_orders}}</span></a></li> --}}

                    <li>
                      <a href="#"><i class="fa fa-user"></i> {{auth()->user()->full_name}}</a>

                      <ul class="npnls header_right_dropdown">
                        <li><a href="{{route('admin.update-profile')}}"><i class="fas fa-user mr-2"></i>Profile</a></li>
                        <li><a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-lock mr-2"></i>Logout</a></li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <aside class="main-sidebar noPrint" id="sidebar_accordion">
      <ul class="npnls">
        <li class="{{(Route::is('dashboard2') || Route::is('dashboard')) ? 'active' : ''}}"><a href="{{route('dashboard')}}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="{{(Route::is('back.products.index') || Route::is('back.products.create') || Route::is('back.products.edit')) ? 'active' : ''}}"><a href="{{route('back.products.index')}}"><i class="fas fa-edit"></i> Product</a></li>
         <li class="{{(request()->route()->getName() == 'back.adjustments.index') ? 'active' : ''}}"><a href="{{route('back.adjustments.index')}}"><i class="fas fa-layer-group"></i>Srock Adjustments</a></li>

         <li>
            <a href="{{route('back.adjustments.index')}}" class="{{(Route::is('back.adjustments.index') || Route::is('back.stocks.preAlert') || Route::is('back.stocks.alert') || Route::is('back.stocks.out')) ? 'active' : 'collapsed'}}" type="button" data-toggle="collapse" data-target="#collapse_stock" aria-expanded="false"><i class="fas fa-chart-pie"></i> Stock <i class="fas fa-chevron-right float-right text-right sub_menu_arrow"></i></a>

            <ul class="sub_ms collapse {{(Route::is('back.adjustments.index') || Route::is('back.stocks.preAlert') || Route::is('back.stocks.alert') || Route::is('back.stocks.out') || Route::is('back.stoct.history')) ? 'show' : ''}}" id="collapse_stock" data-parent="#sidebar_accordion">
              <li class="{{(request()->route()->getName() == 'back.stoct.history') ? 'active_sub_menu' : ''}}"><a href="{{route('back.stoct.history')}}"><i class="fas fa-circle"></i> History</a></li>
              <li class="{{(request()->route()->getName() == 'back.stocks.preAlert') ? 'active_sub_menu' : ''}}"><a href="{{route('back.stocks.preAlert')}}"><i class="fas fa-circle"></i> Pre Alert <span class="badge badge-primary" style="background: red;color: yellow;">{{$stock_pre_alert_quantity_products}}</span></a></li>
              <li class="{{(request()->route()->getName() == 'back.stocks.alert') ? 'active_sub_menu' : ''}}"><a href="{{route('back.stocks.alert')}}"><i class="fas fa-circle"></i> Alert <span class="badge badge-primary" style="background: red;color: yellow;">{{$stock_alert_quantity_products}}</span></a></li>
              <li class="{{(request()->route()->getName() == 'back.stocks.out') ? 'active_sub_menu' : ''}}"><a href="{{route('back.stocks.out')}}"><i class="fas fa-circle"></i> Stock Out <span class="badge badge-primary" style="background: red;color: yellow;">{{$stock_out_products}}</span></a></li>
            </ul>
        </li>

         {{--<li class="{{(request()->route()->getName() == 'back.stocks.index') ? 'active' : ''}}"><a href="{{route('back.stocks.index')}}"><i class="fas fa-layer-group"></i> Product Stock</a></li>
--}}
          <li class="{{(Route::is('back.categories.index') || Route::is('back.categories.create') || Route::is('back.categories.edit')) ? 'active' : ''}}"><a href="{{route('back.categories.index')}}"><i class="fas fa-list"></i> Categories</a></li>
        <li class="{{(Route::is('back.brands.index') || Route::is('back.brands.create') || Route::is('back.brands.edit')) ? 'active' : ''}}"><a href="{{route('back.brands.index')}}"><i class="fas fa-tag"></i> Brand</a></li>

        {{-- <li class="{{(Route::is('back.testimonials.index') || Route::is('back.testimonials.create') || Route::is('back.testimonials.edit')) ? 'active' : ''}}"><a href="{{route('back.testimonials.index')}}"><i class="fas fa-check"></i> Testimonial</a></li> --}}

        {{-- <li class="{{(Route::is('back.special-offer.index') || Route::is('back.special-offer.create') || Route::is('back.special-offer.edit')) ? 'active' : ''}}"><a href="{{route('back.special-offer.index')}}"><i class="fas fa-tags"></i> Special Offers</a></li> --}}

         <li class="{{(request()->route()->getName() == 'back.taxes.index') ? 'active' : ''}}"><a href="{{route('back.taxes.index')}}"><i class="fas fa-money-bill-alt"></i> TAX</a></li>
        <li class="{{(request()->route()->getName() == 'back.shippings.index') ? 'active' : ''}}"><a href="{{route('back.shippings.index')}}"><i class="fas fa-dollar-sign"></i> Shipping Charges</a></li>

        <li>
            <a href="{{route('back.orders.index')}}?ref=All" class="{{(Route::is('back.orders.create') || Route::is('back.orders.index') || Route::is('back.orders.show')) ? 'active' : 'collapsed'}}" type="button" data-toggle="collapse" data-target="#collapse_order" aria-expanded="false"><i class="fas fa-truck-loading"></i> Orders @if($orders)<span class="badge badge-primary" style="background: red;color: yellow;">{{$orders}}</span>@endif <i class="fas fa-chevron-right float-right text-right sub_menu_arrow"></i></a>

            <ul class="sub_ms collapse {{(Route::is('back.orders.create') || Route::is('back.orders.index') || Route::is('back.orders.show')) ? 'show' : ''}}" id="collapse_order" data-parent="#sidebar_accordion">
                {{-- <li class="{{(request()->route()->getName() == 'back.orders.create') ? 'active_sub_menu' : ''}}"><a href="{{route('back.orders.create')}}">Create new</a></li> --}}
                <li class="{{(Route::is('back.orders.index') && request('ref') == 'All') ? 'active_sub_menu' : ''}}"><a href="{{route('back.orders.index')}}?ref=All"><i class="fas fa-circle"></i> All Orders <span class="badge badge-primary" style="background: red;color: yellow;">{{$pending_orders + $delivered_orders + $completed_orders + $returned_orders}}</span></a></li>
                <li class="{{(Route::is('back.orders.index') && request('ref') == 'Processing') ? 'active_sub_menu' : ''}}"><a href="{{route('back.orders.index')}}?ref=Processing"><i class="fas fa-circle"></i> Processing @if($pending_orders)<span class="badge badge-primary" style="background: red;color: yellow;">{{$pending_orders}}</span>@endif</a></li>
                <li class="{{(Route::is('back.orders.index') && request('ref') == 'Confirmed') ? 'active_sub_menu' : ''}}"><a href="{{route('back.orders.index')}}?ref=Confirmed"><i class="fas fa-circle"></i> Confirmed @if($confirmed_orders)<span class="badge badge-primary" style="background: red;color: yellow;">{{$confirmed_orders}}</span>@endif</a></li>
                <li class="{{(Route::is('back.orders.index') && request('ref') == 'In Courier') ? 'active_sub_menu' : ''}}"><a href="{{route('back.orders.index')}}?ref=In Courier"><i class="fas fa-circle"></i> In Courier @if($in_courier_orders)<span class="badge badge-primary" style="background: red;color: yellow;">{{$in_courier_orders}}</span>@endif</a></li>
                <li class="{{(Route::is('back.orders.index') && request('ref') == 'Delivered') ? 'active_sub_menu' : ''}}"><a href="{{route('back.orders.index')}}?ref=Delivered"><i class="fas fa-circle"></i> Delivered @if($delivered_orders)<span class="badge badge-primary" style="background: red;color: yellow;">{{$delivered_orders}}</span>@endif</a></li>
                <li class="{{(Route::is('back.orders.index') && request('ref') == 'Completed') ? 'active_sub_menu' : ''}}"><a href="{{route('back.orders.index')}}?ref=Completed"><i class="fas fa-circle"></i> Completed @if($completed_orders)<span class="badge badge-primary" style="background: red;color: yellow;">{{$completed_orders}}</span>@endif</a></li>
                <li class="{{(Route::is('back.orders.index') && request('ref') == 'Canceled') ? 'active_sub_menu' : ''}}"><a href="{{route('back.orders.index')}}?ref=Canceled"><i class="fas fa-circle"></i> Canceled @if($canceled_orders)<span class="badge badge-primary" style="background: red;color: yellow;">{{$canceled_orders}}</span>@endif</a></li>

                <li class="{{(Route::is('back.orders.index') && request('ref') == 'Returned') ? 'active_sub_menu' : ''}}"><a href="{{route('back.orders.index')}}?ref=Returned"><i class="fas fa-circle"></i> Returned @if($returned_orders)<span class="badge badge-primary" style="background: red;color: yellow;">{{$returned_orders}}</span>@endif</a></li>
            </ul>
        </li>

        <li class="{{(Route::is('back.customers.index') || Route::is('back.customers.create') || Route::is('back.customers.edit')) ? 'active' : ''}}"><a href="{{route('back.customers.index')}}"><i class="fas fa-users"></i> Customers @if($customers)<span class="badge badge-primary" style="background: red;color: yellow;">{{$customers}}</span>@endif</a></li>
        <li class="{{(Route::is('back.coupons.index') || Route::is('back.coupons.create') || Route::is('back.coupons.edit') || Route::is('back.coupons.show')) ? 'active' : ''}}"><a href="{{route('back.coupons.index')}}"><i class="fas fa-tag"></i> Coupon</a></li>
          @php
              $notification_routes = Route::is('back.notification.email') || Route::is('back.notification.emailSend') || Route::is('back.notification.emailShow') || Route::is('back.notification.push') || Route::is('back.notification.newslatterSubscribers');
          @endphp
          <li>
              <a href="" class="{{$notification_routes ? 'active' : 'collapsed'}}" type="button" data-toggle="collapse" data-target="#collapse_notification" aria-expanded="false"><i class="fas fa-bell"></i> Notification <i class="fas fa-chevron-right float-right text-right sub_menu_arrow"></i></a>

              <ul class="sub_ms collapse {{$notification_routes ? 'show' : ''}}" id="collapse_notification" data-parent="#sidebar_accordion">
                <li class="{{(Route::is('back.notification.email') || Route::is('back.notification.emailSend') || Route::is('back.notification.emailShow')) ? 'active_sub_menu' : ''}}"><a href="{{route('back.notification.email')}}"><i class="fas fa-circle"></i> Email</a></li>
                <li class="{{Route::is('back.notification.newslatterSubscribers') ? 'active_sub_menu' : ''}}"><a href="{{route('back.notification.newslatterSubscribers')}}"><i class="fas fa-circle"></i> Newsletter Subscribers</a></li>
              </ul>
          </li>
        <li>
            <a href="{{route('back.report.overview')}}" class="{{(Route::is('back.report.overview') || Route::is('back.report.product') || Route::is('back.report.orders') || Route::is('back.report.coupon') || Route::is('back.report.revenue') || Route::is('back.report.taxes') || Route::is('back.report.couponDetails')) ? 'active' : 'collapsed'}}" type="button" data-toggle="collapse" data-target="#collapse_report" aria-expanded="false"><i class="fas fa-chart-bar"></i> Report <i class="fas fa-chevron-right float-right text-right sub_menu_arrow"></i></a>

            <ul class="sub_ms collapse {{(Route::is('back.report.overview') || Route::is('back.report.product') || Route::is('back.report.orders') || Route::is('back.report.coupon') || Route::is('back.report.revenue') || Route::is('back.report.taxes') || Route::is('back.report.couponDetails')) ? 'show' : ''}}" id="collapse_report" data-parent="#sidebar_accordion">
              <li class="{{Route::is('back.report.overview') ? 'active_sub_menu' : ''}}"><a href="{{route('back.report.overview')}}"><i class="fas fa-circle"></i> Overview</a></li>
              <li class="{{Route::is('back.report.product') ? 'active_sub_menu' : ''}}"><a href="{{route('back.report.product')}}"><i class="fas fa-circle"></i> Product</a></li>
              <li class="{{Route::is('back.report.orders') ? 'active_sub_menu' : ''}}"><a href="{{route('back.report.orders')}}"><i class="fas fa-circle"></i> Orders</a></li>
               <li class="{{(Route::is('back.report.coupon') || Route::is('back.report.couponDetails')) ? 'active_sub_menu' : ''}}"><a href="{{route('back.report.coupon')}}"><i class="fas fa-circle"></i> Coupons</a></li>
              <li class="{{Route::is('back.report.taxes') ? 'active_sub_menu' : ''}}"><a href="{{route('back.report.taxes')}}"><i class="fas fa-circle"></i> Taxes</a></li>

            </ul>
        </li>
        <li class="{{(request()->route()->getName() == 'back.attributes.index') ? 'active' : ''}}"><a href="{{route('back.attributes.index')}}"><i class="fas fa-bars"></i> Attributes</a></li>
        {{-- <li><a href="{{route('back.products.reviews')}}" class="{{(request()->route()->getName() == 'back.products.reviews') ? 'active' : ''}}"><i class="fas fa-star-half-alt"></i> Product Reviews @if($reviews)<span class="badge badge-primary" style="background: red;color: yellow;">{{$reviews}}</span>@endif</a></li> --}}

        @php
            $settings_route = Route::is('back.frontend.general') || Route::is('back.pages.index') || Route::is('back.pages.create') || Route::is('back.pages.edit') || Route::is('back.menus.index') || Route::is('back.sliders.index') || Route::is('back.sliders.edit') || Route::is('back.media.settings') || Route::is('back.feature-ads.index') || Route::is('back.feature-ads.edit') || Route::is('back.footerwidgets.index') || Route::is('back.footer-widgets.create') || Route::is('back.menus.category') || Route::is('back.text-sliders.index') || Route::is('back.footer-widgets.index');
        @endphp
        <li>
          <a href="" class="{{$settings_route ? 'active' : 'collapsed'}}" type="button" data-toggle="collapse" data-target="#collapse_frontend" aria-expanded="false"><i class="fas fa-cog"></i> Settings <i class="fas fa-chevron-right float-right text-right sub_menu_arrow"></i></a>

          <ul class="sub_ms collapse {{$settings_route ? 'show' : ''}}" id="collapse_frontend" data-parent="#sidebar_accordion">
            <li class="{{(request()->route()->getName() == 'back.frontend.general') ? 'active_sub_menu' : ''}}"><a href="{{route('back.frontend.general')}}"><i class="fas fa-circle"></i> General Settings</a></li>

            <li class="{{(Route::is('back.pages.index') || Route::is('back.pages.create') || Route::is('back.pages.edit')) ? 'active_sub_menu' : ''}}"><a href="{{route('back.pages.index')}}"><i class="fas fa-circle"></i> Pages</a></li>

            <li class="{{(request()->route()->getName() == 'back.menus.index') ? 'active_sub_menu' : ''}}"><a href="{{route('back.menus.index')}}"><i class="fas fa-circle"></i> Menu</a></li>

            {{-- <li class="{{(request()->route()->getName() == 'back.menus.category') ? 'active_sub_menu' : ''}}"><a href="{{route('back.menus.category')}}"><i class="fas fa-circle"></i> Nav Menu</a></li> --}}

            <li class="{{(Route::is('back.sliders.index') || Route::is('back.sliders.edit')) ? 'active_sub_menu' : ''}}"><a href="{{route('back.sliders.index')}}"><i class="fas fa-circle"></i> Slider</a></li>

            <li class="{{(request()->route()->getName() == 'back.media.settings') ? 'active_sub_menu' : ''}}"><a href="{{route('back.media.settings')}}"><i class="fas fa-circle"></i> Media</a></li>

            <li class="{{(request()->route()->getName() == 'back.courier.config') ? 'active_sub_menu' : ''}}"><a href="{{route('back.courier.config')}}"><i class="fas fa-circle"></i> Courier</a></li>

            {{-- <li class="{{(Route::is('back.feature-ads.index') || Route::is('back.feature-ads.edit')) ? 'active_sub_menu' : ''}}"><a href="{{route('back.feature-ads.index')}}"><i class="fas fa-circle"></i> Feature Ads</a></li>
             --}}
            <li class="{{(Route::is('back.footer-widgets.index')) ? 'active_sub_menu' : ''}}"><a href="{{route('back.footer-widgets.index')}}"><i class="fas fa-circle"></i> Footer Widgets</a></li>
          </ul>
        </li>
        {{-- <li>
          <a href="{{route('back.blogs.index')}}" class="{{(Route::is('back.blogs.index') || Route::is('back.blogs.create') || Route::is('back.blogs.edit') || Route::is('back.blogs.categories') || Route::is('back.blogs.categories.create')) ? 'active' : 'collapsed'}}" type="button" data-toggle="collapse" data-target="#collapse_blog" aria-expanded="false"><i class="fas fa-edit"></i> Blog <i class="fas fa-chevron-right float-right text-right sub_menu_arrow"></i></a>

          <ul class="sub_ms collapse {{(Route::is('back.blogs.index') || Route::is('back.blogs.create') || Route::is('back.blogs.edit') || Route::is('back.blogs.categories') || Route::is('back.blogs.categories.create')) ? 'show' : ''}}" id="collapse_blog" data-parent="#sidebar_accordion">
            <li class="{{(Route::is('back.blogs.index') || Route::is('back.blogs.create') || Route::is('back.blogs.edit')) ? 'active_sub_menu' : ''}}"><a href="{{route('back.blogs.index')}}"><i class="fas fa-circle"></i> List</a></li>
            <li class="{{(Route::is('back.blogs.categories') || Route::is('back.blogs.categories.create')) ? 'active_sub_menu' : ''}}"><a href="{{route('back.blogs.categories')}}"><i class="fas fa-circle"></i> Categories</a></li>
          </ul>
        </li> --}}

        {{-- <li class="{{Route::is('back.carts') ? 'active' : ''}}"><a href="{{route('back.carts')}}"><i class="fas fa-shopping-cart"></i> Customer Carts @if($carts)<span class="badge badge-primary" style="background: red;color: yellow;">{{$carts}}</span>@endif</a></li>

        <li class="{{Route::is('back.wishlists') ? 'active' : ''}}"><a href="{{route('back.wishlists')}}"><i class="fas fa-heart"></i> Customer Wishlist @if($favorites)<span class="badge badge-primary" style="background: red;color: yellow;">{{$favorites}}</span>@endif</a></li> --}}

        @if(auth()->user()->type == 'admin')
        <li class="{{(Route::is('back.admins.index') || Route::is('back.admins.create') || Route::is('back.admins.edit')) ? 'active' : ''}}"><a href="{{route('back.admins.index')}}"><i class="fas fa-user"></i> Admins</a></li>
        @endif

        @if(env('LANDING_BUILDER'))
        <li class="{{(Route::is('back.landingBuilders.index') || Route::is('back.landingBuilders.create') || Route::is('back.landingBuilders.edit')) ? 'active' : ''}}"><a href="{{route('back.landingBuilders.index')}}"><i class="fas fa-cogs"></i> Landing Builder</a></li>
        @endif

        @if(env('GOOGLE_MERCHENT_ENABLED'))
        <li class="{{(Route::is('gm.uploadB')) ? 'active' : ''}}"><a href="{{route('gm.uploadB')}}"><i class="fab fa-google"></i> Upload to Google Merchant</a></li>
        @endif

      <li>
          <a href="#" class="" type="button" data-toggle="collapse" data-target="#collapse_manageSite" aria-expanded="false">
              <i class="fas fa-hdd"></i> Manage Sites <i class="fas fa-chevron-right float-right text-right sub_menu_arrow"></i>
          </a>

          <ul class="sub_ms collapse" id="collapse_manageSite" data-parent="#sidebar_accordion">
              <li class="{{Route::is('admin.sitemap.index') ? 'active_sub_menu' : ''}}">
                  <a href="{{ route('admin.sitemap.index') }}"><i class="fas fa-circle"></i>Sitemap</a>
              </li>
          </ul>
      </li>
      <li>
          <a href="#" class="" type="button" data-toggle="collapse" data-target="#collapse_backup" aria-expanded="false">
              <i class="fas fa-hdd"></i> Backups <i class="fas fa-chevron-right float-right text-right sub_menu_arrow"></i>
          </a>

          <ul class="sub_ms collapse" id="collapse_backup" data-parent="#sidebar_accordion">
              <li class="{{Route::is('back.system.backup') ? 'active_sub_menu' : ''}}">
                  <a href="{{route('back.system.backup')}}"><i class="fas fa-circle"></i> System Backup</a>
              </li>
              <li class="{{Route::is('back.database.backup') ? 'active_sub_menu' : ''}}">
                  <a href="{{route('back.database.backup')}}"><i class="fas fa-circle"></i> Database Backup</a>
              </li>
          </ul>
      </li>

        <li><a href="{{route('cacheClearAdmin')}}"><i class="fas fa-times"></i> Cache Clear</a></li>
      </ul>
    </aside>

    <div class="content-wrapper">
      <div class="content">
        <section class="content-header noPrint">
          <div class="row">
            <div class="col-md-6">
              <h1>
                @yield('title')
                <small>{{env('APP_NAME')}}</small>
              </h1>
            </div>

            <div class="col-md-6">
              <ul class="npnls text-left text-md-right ch_breadcrumb">
                <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard > </a></li>
                <li class="active">@yield('title')</li>
              </ul>
            </div>
          </div>
        </section>

        <div class="content_body">
            @if(isset($errors))
                @include('extra.error-validation')
            @endif
            @if(session('success'))
                @include('extra.success')
            @endif
            @if(session('error'))
                @include('extra.error')
            @endif

            @yield('master')

            <div class="modal fade detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="detailsModalLabel">Details Item</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="detailsModalContent">

                    </div>
                  </div>
                </div>
            </div>
        </div>
      </div>

      <footer class="p-3 noPrint">
        @if(request()->getHost() == 'digital-bazar.com')
        <p class="mb-0">&copy; {{ ($settings_g['title'] ?? env('APP_NAME')) . ' ' . date('Y')}} | Developed by XOTECHZ</p>
        @else
        <p class="mb-0">&copy; {{ ($settings_g['title'] ?? env('APP_NAME')) . ' ' . date('Y')}} | Developed by <a class="text-success" href="https://eomsbd.com" target="_blank">EOMSBD</a></p>
        @endif
      </footer>
    </div>
  </div>

<!-- Media Modal -->
<div class="modal fade" id="mediaModal" tabindex="-1" aria-labelledby="mediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="mediaModalLabel">Choice Image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
          <div class="row gallery_items">
          </div>

          <div class="text-center">
              <button class="btn btn-success btn-sm mt-4 gallery_load_more_btn show_gallery_btn" data-type="more">Load More</button>
          </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

  <script src="{{asset('back/js/vendor/modernizr-3.11.2.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script src="{{asset('back/js/plugins.js')}}"></script>
  <!-- Sweetalert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.0/dist/sweetalert2.all.min.js"></script>

  <script src="{{asset('back/js/main.js')}}"></script>

  {{-- <script src="{{asset('back/js/app.js')}}"></script> --}}

    @if(session('success-alert'))
        <script>
            cAlert('success', "{{session('success-alert')}}");
        </script>
    @endif

    @if(session('error-alert'))
        <script>
            cAlert('error', "{{session('error-alert')}}");
        </script>
    @endif

    @if(session('error-alert2'))
        <script>
            Swal.fire(
                'Failed!',
                '{{session("error-alert2")}}',
                'error'
            )
        </script>
    @endif

    @if(session('success-alert2'))
        <script>
            Swal.fire(
                'Success!',
                '{{session("success-alert2")}}',
                'success'
            )
        </script>
    @endif

    @if(session('error-transaction'))
        <script>
            Swal.fire(
                'Transaction Failed!',
                '{{session("error-transaction")}}',
                'error'
            )
        </script>
    @endif

    <script>
        function detailItem(type, item_id){
            cLoader();

            $.ajax({
                url: '{{route("back.show")}}',
                method: 'POST',
                data: {type, item_id, _token: '{{csrf_token()}}'},
                success: function(result){
                    cLoader('h');
                    $('.detailsModalContent').html(result);
                    $('.detailsModal').modal('show');
                },
                error: function(){
                    cLoader('h');
                    cAlert('error', 'Something wring!');
                }
            });
        }
    </script>

    @yield('footer')
</body>

</html>
