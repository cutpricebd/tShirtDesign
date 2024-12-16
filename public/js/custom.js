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

function toggleSidebar(){
    let el = document.getElementById('accordionLeftMeu');
    let main_wrap = document.getElementById('main_wrap');

    // For Mobile
    if(el.classList.contains('left-0')){
        el.classList.remove('left-0');
        el.classList.add('-left-52');

        main_wrap.classList.remove('ml-52');
        main_wrap.classList.add('ml-0');
    }else{
        el.classList.remove('-left-52');
        el.classList.add('left-0');

        main_wrap.classList.add('ml-52');
        main_wrap.classList.remove('ml-0');
    }

    // For Desktop
    if(el.classList.contains('md:left-0')){
        el.classList.remove('md:left-0');
        el.classList.add('md:-left-52');

        main_wrap.classList.remove('md:ml-52');
        main_wrap.classList.add('md:ml-0');
    }else{
        el.classList.remove('md:-left-52');
        el.classList.add('md:left-0');

        main_wrap.classList.add('md:ml-52');
        main_wrap.classList.remove('md:ml-0');
    }
}

function toggleSideCart(){
    let el_sc = document.getElementById('rightCart');
    let main_wrap_sc = document.getElementById('main_wrap');

    // For Mobile
    if(el_sc.classList.contains('right-0')){
        el_sc.classList.remove('right-0');
        el_sc.classList.add('-right-full');
    }else{
        el_sc.classList.remove('-right-full');
        el_sc.classList.add('right-0');
    }

    // For Desktop
    if(el_sc.classList.contains('md:right-0')){
        el_sc.classList.remove('md:right-0');
        el_sc.classList.add('md:-right-80');

        main_wrap_sc.classList.remove('mr-80');
        main_wrap_sc.classList.add('mr-0');
    }else{
        el_sc.classList.remove('md:-right-80');
        el_sc.classList.add('md:right-0');

        main_wrap_sc.classList.add('mr-80');
        main_wrap_sc.classList.remove('mr-0');
    }
}

// $('.toggleSidebar').click(function(){
//     alert(123);
// });

$(document).on('click', '.common_add_cart', function(){
    let product_id = $(this).data('id');
    let product_data_id = $(this).data('productdata');

    $.ajax({
        url: base_url + '/cart/add',
        method: 'POST',
        dataType: "json",
        data: {product_id, product_data_id, quantity: 1, _token},
        success: function(result){
            if(result.status == true){
                cAlert('success', 'Cart Added!');
                // $('.top_cart .count').html(result.count);
                $(".side_floating_cart").effect( "shake", {direction: "up"});

                appendRightCart(result.new_item, result.product_total, result.count);
            }else{
                cAlert('error', result.text);
            }
        },
        error: function(){
            cAlert('error', 'Add to cart error!');
        }
    });

    // Shake Cart
    // $(".side_floating_cart").effect("shake", {
    //     times: 2,
    //     distance : 10
    // }, 300);
});

$(document).on('click', '.remove_cart', function(){
    let cart_id = $(this).closest('.cart_single_item').data('id');

    $.ajax({
        url: base_url + '/cart/remove',
        method: 'POST',
        dataType: "json",
        context: this,
        data: {cart_id, _token},
        success: function(result){
            if(result.status == true){
                cAlert('success', result.text);

                $(this).closest('.cart_single_item').remove();
                $('.cart_count').html(result.count);
                $('.cart_amount').html(result.product_total);
            }else{
                cAlert('error', result.text);
            }
        },
        error: function(){
            cAlert('error', 'Remove cart error!');
        }
    });
});

function appendRightCart(item, cart_total, item_count){
    $('.cart_items_sidebar').prepend(item);
    $('.cart_count').html(item_count);
    $('.cart_amount').html(cart_total);
}

// Update Cart Quantity
$(document).on('click', '.sct_qty_btn', function(){
    let btn_type = $(this).data('type');
    let cart_id = $(this).data('id');

    let current_quantity = $(this).closest('.sp_quantity').find('.cart_quantity_input').val();
    let new_quantity = 1;

    if(btn_type == 'plus'){
        new_quantity = parseInt(current_quantity) + 1;
    }else{
        new_quantity = current_quantity;
    }

    if(btn_type == 'minus' && current_quantity > 1){
        new_quantity = parseInt(current_quantity) - 1;
    }

    $(this).closest('.sp_quantity').find('.cart_quantity_input').val(new_quantity);

    // Ajax Request
    $.ajax({
        url: base_url + '/cart/update',
        method: 'POST',
        dataType: 'JSON',
        context: this,
        data: {cart_id, quantity: new_quantity, _token},
        success: function(result){
            $('.cart_count').html(result.summary.count);
            $('.cart_amount').html(result.summary.product_total);

            $(this).closest('.cart_single_item').find('.single_cart_amount').html(result.single_amount);
        },
        error: function(){
            console.log('Update cart error!');
        }
    });
});
