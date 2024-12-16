<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.5/owl.carousel.min.js"></script>
<script src="{{asset('landing/scrollIt.js/scrollIt.min.js')}}"></script>
<script src="{{asset('landing/FitVids.js/jquery.fitvids.js')}}"></script>
<!-- Sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.0/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(".responsive_video").fitVids();

    $('.owl-carousel_normal').owlCarousel({
        items: 1.3,
        loop: true,
        video: true,
        center: true,
        autoplay: true,
        // margin: '10px',
        autoplayTimeout: 3000,
        margin:10,
        nav: true,
        navText: [
            '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 inline-block"><path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" /></svg>',
            '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 inline-block"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" /></svg>'
        ],
        lazyLoad: false
    });

    $.scrollIt();

    $('.select_state').select2();
    $('.select_city').select2();

    // Alert Script
    const Toast = Swal.mixin({
        toast: true,
        position: 'center-center',
        showConfirmButton: false,
        background: '#E5F3FE',
        timer: 4000
    });
    function cAlert(type, text){
        Toast.fire({
            icon: type,
            title: text
        });
    }

    $(document).on('click', '.kinun_btn', function(){
        let html_data = `<img class="check_image inline-block mr-2 float-left" style="width: 30px !important;height:30px !important" src="{{asset('landing/2705.svg')}}" alt="check">`;

        let id = $(this).data('id');
        let image = $(this).data('image');
        let variation = $(this).data('variation');
        let price = $(this).data('price');
        let oldprice = $(this).data('oldprice');
        let product_title = $(this).closest('tr').find('.product_title').html();
        let product_id = $(this).data('product_id');
        let old_item = '';
        if(oldprice){
            old_item = '<small class="text-gray-400"><del>'+ oldprice +' টাকা</del></small>';
        }

        let listes_item = '<li class="flex py-6">' +
                             '<div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">' +
                                '<img src="'+ image +'" alt="{{$product->name}}" class="h-full w-full object-cover object-center"><input type="hidden" name="meta[]" value="'+ id +'"><input type="hidden" name="product_id[]" value="'+ product_id +'">' +
                             '</div>' +
                             '<div class="ml-4 flex flex-1 flex-col">' +
                                '<div>' +
                                    '<div class="flex justify-between text-base font-medium">' +
                                        '<h3>'+(product_title ? product_title : '{{$product->name}}')+'</h3>' +
                                        '<p class="ml-4"><span class="product_price">'+ price +'</span> টাকা '+ old_item +'</p>' +
                                   '</div>' +
                                   '<input type="hidden" name="variation[]" value="">' +
                                '</div>' +
                                '<div class="flex flex-1 items-end justify-between text-sm">' +
                                    '<p>Qty: 1</p>' +
                                    '</div>' +
                             '</div>' +
                          '</li>';
        $('.default_item').remove();
        $('.listed_items').append(listes_item);

        $(this).closest('td').html(html_data);
        summaryCalculation();

        // Add To Cart Track
        fbq('track', 'AddToCart', {
            value: price,
            currency: 'BDT',
            contents: [
                {
                    quantity: 1,
                    id: product_id ?? '{{$product->id}}'
                }
            ],
            content_ids: product_id ?? '{{$product->id}}',
        });
        if(fb_track_enable){
            $.ajax({
                type: "POST",
                url: "{{ route('landing.fbTrack') }}",
                data: {_token: '{{csrf_token()}}', event_type: 'AddToCart', pixel_id: fb_pixel_id, access_token: fb_access_token, value: price, currency: 'BDT', quantity: 1, id: product_id, content_ids: (product_id ?? '{{$product->id}}')},
                success: function (data) {
                    console.log('FB Tracked "AddToCart"!');
                },
                error: function(){
                    console.log('Something wrong to facebook track!');
                }
            });
        }

        // gtag('event', 'begin_checkout', {
        //     "currency": "BDT",
        //     "items": [
        //         {
        //             "id": product_id ?? '{{$product->id}}',
        //             "name": product_title ? product_title : '{{$product->name}}',
        //             "brand": 'Cut Price BD',
        //             "category": 'Cut Price BD',
        //             "list_position": 1,
        //             "price": price
        //         }
        //     ]
        // });
    });

    function summaryCalculation(){
        let priceses = $('.product_price').map(function () {
            return $(this).html();
        });
        let product_total = 0;

        $.each(priceses, function (index, item) {
            product_total = Number(product_total) + Number(item);
        });
        $('.product_total').html(product_total);

        let shipping_charge = $('.shipping_charge:checked').val();

        $('.grand_total').html(Number(product_total) + Number(shipping_charge));
    }

    $(document).on('change', '.shipping_charge', function(){
        summaryCalculation();
    });

    $(document).on('change', '.select_state', function(){
        let state = $(this).val();
        if(state == 'Dhaka'){
            $('#idhd').prop("checked", true);

            $('#idhd').removeAttr("disabled", true);
            $('#odhd').attr("disabled", true);
            // $('#odcd').attr("disabled", true);
        }else{
            $('#odhd').prop("checked", true);

            $('#idhd').attr("disabled", true);
            $('#odhd').removeAttr("disabled", true);
            // $('#odcd').removeAttr("disabled", true);
        }
        summaryCalculation();

        // Grt Cities
        $.ajax({
            url: '{{route("landing.getCities")}}',
            method: 'POST',
            data: {_token: "{{csrf_token()}}", state},
            success: function (result){
                $('.select_city').html(result);
                $('.select_city').select2();
            },
            error: function (){
                console.log('Something wrong to get city!');
            }
        });
    });

    $(document).on('submit', '.checkoutForm', function(){
        let mobile_number = $('.mobile_number').val();

        if(mobile_number.length != 11){
            Toast.fire({
                icon: 'error',
                title: 'মোবাইল নম্বর অবসসই ১১ সংখ্যার হতে হবে'
            });

            return false;
        }else{
            return true;
        }
    });

    // gtag('event', 'checkout_progress', {
    //     "currency": "BDT",
    //     "items": [
    //         {
    //             "id": "{{$product->id}}",
    //             "name": "{{$product->name}}",
    //             "brand": "Cut Price BD",
    //             "category": "{{isset($product->categories[0]) ? $product->categories[0]->name : 'Cut Price BD'}}",
    //             "list_position": 1,
    //             "price": '{{$product->first_price}}'
    //         }
    //     ]
    // });

    $(document).on('click', '.kinun_btn2', function(){
        let id = $(this).data('id');
        let image = $(this).data('image');
        let product_title = $(this).data('title');
        let oldprice = $(this).data('oldprice');
        let price = $(this).data('price');
        let attr_string = $(this).data('attr');

        let variation_ids = $('.product_variations:checked').map(function () {
            return $(this).val();
        });
        let values = variation_ids.get();
        values = values.sort();
        values = values.join('.') + '.';

        // let old_item = '';
        // if(oldprice){
        //     old_item = '<small class="text-gray-400"><del>'+ oldprice +' টাকা</del></small>';
        // }

        let listes_item = '<li class="flex py-6">' +
                             '<div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">' +
                                '<img src="'+ image +'" alt="{{$product->name}}" class="h-full w-full object-cover object-center"><input type="hidden" name="meta[]" value=""> <input type="hidden" name="product_id[]" value="'+ id +'"> <input type="hidden" class="selected_price" value="'+ price +'">' +
                             '</div>' +
                             '<div class="ml-4 flex flex-1 flex-col">' +
                                '<div>' +
                                    '<div class="flex justify-between text-base font-medium">' +
                                        '<h3>'+(product_title ? product_title : '{{$product->name}}')+'</h3>' +
                                        '<p class="ml-4"><span class="product_price">'+ price +'</span> টাকা</p>' +
                                   '</div>' +
                                   '<input type="hidden" name="variation[]" value="'+ values +'">' +
                                '</div>' +

                                '<p><small>'+ attr_string +'</small></p>'+
                                // '<div class="flex flex-1 items-end justify-between text-sm">' +
                                //     '<p>Qty: 1</p>' +
                                //     '</div>' +

                                '<div class="flex flex-1 items-end justify-between text-sm">' +
                                    '<div class="flex">' +
                                        '<button class="w-6 h-6 text-center border-2 border-red-500 cursor-pointer font-bold border-l-0 bg-red-500 text-white qty_btn" data-type="minus" type="button">-</button>' +
                                        '<input type="number" class="h-6 border-2 border-red-500 px-1 w-10 focus:outline-none text-center selected_qty" name="quantity[]" value="1" readonly>' +
                                        '<button class="w-6 h-6 text-center border-2 border-red-500 cursor-pointer font-bold border-r-0 bg-red-500 text-white qty_btn" data-type="plus" type="button">+</button>' +
                                    '</div>' +

                                    '<div class="flex">' +
                                        '<button type="button" class="font-medium text-red-400 hover:text-red-500 removeItem" onclick="return confirm(`Are you sure to remove?`);">' +
                                            '<svg data-v-1caa4ad4="" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">' +
                                                '<path data-v-1caa4ad4="" stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>' +
                                            '</svg>' +
                                        '</button>' +
                                    '</div>' +
                                '</div>' +
                             '</div>' +
                          '</li>';
        $('.default_item').remove();
        $('.listed_items').append(listes_item);

        summaryCalculation();
    });

    $(document).on('click', '.changeImage', function(){
        let type = $(this).data('type');
        if(type == 'image'){
            $(this).closest('.single_product_wrap').find('.product_preview .image').show();
            $(this).closest('.single_product_wrap').find('.product_preview .video').hide();

            let image = $(this).data('image');
            $(this).closest('.single_product_wrap').find('.product_preview .image').attr('src', image);
        }else{
            $(this).closest('.single_product_wrap').find('.product_preview .image').hide();
            $(this).closest('.single_product_wrap').find('.product_preview .video').show();
        }
    });

    $(document).on('change', '.product_variations', function(){
        let attributes = $(this).closest('.single_product_wrap').find(".product_variations:checked").map(function () {
            return $(this).val();
        });

        let values = attributes.get();
        values = values.sort();
        let product = $(this).closest('.single_product_wrap').find('.kinun_btn2').data('id');
        let price = $(this).closest('.single_product_wrap').find('.kinun_btn2').data('price');
        let oldprice = $(this).closest('.single_product_wrap').find('.kinun_btn2').data('oldprice');

        // Get Meta Price
        $.ajax({
            url: "{{ route('landing.getMetaPrice') }}",
            method: "post",
            data: {values, product, _token: "{{csrf_token()}}"},
            dataType: "JSON",
            context: this,
            success: function (result) {
                if (result.success == true) {
                    $(this).closest('.single_product_wrap').find('.single_price').html(result.price);
                    $(this).closest('.single_product_wrap').find('.single_old_price').html(result.old_price);
                    $(this).closest('.single_product_wrap').find('.kinun_btn2').attr('data-attr', result.attribute_string);
                    $(this).closest('.single_product_wrap').find('.product_attr_string_title').html('(' + result.attribute_string + ')');
                }else{
                    $(this).closest('.single_product_wrap').find('.single_price').html(price);
                    $(this).closest('.single_product_wrap').find('.single_old_price').html(oldprice);
                    $(this).closest('.single_product_wrap').find('.kinun_btn2').attr('data-attr', '');
                    $(this).closest('.single_product_wrap').find('.product_attr_string_title').html('');
                }
            },
            error: function(){
                cAlert('error', 'Something went wrong!');
            }
        });
    });

    $(document).on('click', '.qty_btn', function(){
        let type = $(this).data('type');
        let current_qty = $(this).closest('li').find('.selected_qty').val();
        let new_qty = current_qty;
        let selected_price = $(this).closest('li').find('.selected_price').val();

        if(type == 'minus' && current_qty > 1){
            new_qty = current_qty - 1;
        }

        if(type == 'plus'){
            new_qty = Number(current_qty) + 1;
        }
        $(this).closest('li').find('.selected_qty').val(new_qty);
        $(this).closest('li').find('.product_price').html(selected_price * new_qty);
        summaryCalculation();
    });

    $(document).on('click', '.removeItem', function(){
        let selected_prices = $('.selected_price').map(function () {
            return $(this).val();
        });

        if(selected_prices.length > 1){
            $(this).closest('li').remove();
        }else{
            cAlert('error', 'Minimum 1 product is required for order!');
        }

        summaryCalculation();
    });

    $(document).on('focusout', '.information_field', function(){
        activityTrack('Information Inserted');
    });

    function activityTrack(event){
        let shipping_name = $('.shipping_name').val();
        let shipping_mobile_number = $('.shipping_mobile_number').val();
        let shipping_address = $('.shipping_address').val();
        let shipping_state = $('.shipping_state').val();
        let shipping_city = $('.shipping_city').val();
        let product_variation = $('.product_variation:checked').val();
        let shipping_charge = 0;
        let price = $('.product_variation:checked').data('price');
        let uu_id = $('.uu_id').val();
        // let product_datas = [
        //     {
        //         product_data_id: product_variation,
        //         quantity: 1,
        //         selling_price: price,
        //     }
        // ];

        $.ajax({
            url: "{{route('api.orders.failedTrack')}}",
            method: "POST",
            data: {
                _token: "{{csrf_token()}}",
                uid: uu_id,
                name: shipping_name,
                event,
                mobile_number: shipping_mobile_number,
                page: "{{request()->getHost()}}",
                address: shipping_address,
                state: shipping_state,
                city: shipping_city,
            },
            success: function(){},
            error: function(){}
        });
    }
</script>

@if(env('APP_ENV') == 'production')
<script>
    fbq('track', 'ViewContent', {
        value: '{{$product->first_price}}',
        currency: 'BDT',
        content_ids: '{{$product->id}}',
        content_type: 'product',
    });

    if(fb_track_enable){
        $.ajax({
            type: "POST",
            url: "{{ route('landing.fbTrack') }}",
            data: {_token: '{{csrf_token()}}', event_type: 'ViewContent', pixel_id: fb_pixel_id, access_token: fb_access_token, value: "{{$product->first_price}}", currency: 'BDT', quantity: 1, content_ids: (product_id ?? '{{$product->id}}'), content_type: 'product'},
            success: function (data) {
                console.log('FB Tracked "ViewContent"!');
            },
            error: function(){
                console.log('Something wrong to facebook track!');
            }
        });
    }

    gtag('event', 'view_item', {
        "currency": "BDT",
        "items": [
            {
                "id": "{{$product->id}}",
                "name": "{{$product->name}}",
                "brand": "Cut Price BD",
                "category": "{{isset($product->categories[0]) ? $product->categories[0]->name : 'Cut Price BD'}}",
                "list_position": 1,
                "price": '{{$product->first_price}}'
            }
        ]
    });
</script>

@if($product_2)
<script>
    fbq('track', 'ViewContent', {
        value: {{$product_2->first_price}},
        currency: 'BDT',
        content_ids: '{{$product_2->id}}',
        content_type: 'product',
    });

    if(fb_track_enable){
        $.ajax({
            type: "POST",
            url: "{{ route('landing.fbTrack') }}",
            data: {_token: '{{csrf_token()}}', event_type: 'ViewContent', pixel_id: fb_pixel_id, access_token: fb_access_token, value: "{{$product_2->first_price}}", currency: 'BDT', quantity: 1, content_ids: (product_id ?? '{{$product_2->id}}'), content_type: 'product'},
            success: function (data) {
                console.log('FB Tracked "ViewContent"!');
            },
            error: function(){
                console.log('Something wrong to facebook track!');
            }
        });
    }

    gtag('event', 'view_item', {
        "currency": "BDT",
        "items": [
            {
                "id": "{{$product_2->id}}",
                "name": "{{$product_2->name}}",
                "brand": "Cut Price BD",
                "category": "{{isset($product_2->categories[0]) ? $product_2->categories[0]->name : 'Cut Price BD',}}",
                "list_position": 1,
                "price": '{{$product_2->first_price}}'
            }
        ]
    });

    // gtag('event', 'checkout_progress', {
    //     "currency": "BDT",
    //     "items": [
    //         {
    //             "id": "{{$product_2->id}}",
    //             "name": "{{$product_2->name}}",
    //             "brand": "Cut Price BD",
    //             "category": "{{isset($product_2->categories[0]) ? $product_2->categories[0]->name : 'Cut Price BD'}}",
    //             "list_position": 1,
    //             "price": '{{$product_2->first_price}}'
    //         }
    //     ]
    // });
</script>
@endif
@endif
