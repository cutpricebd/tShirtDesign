function toggleSearch(){
let search_modal = document.getElementById("search_modal");
search_modal.classList.toggle('top_search_hidden');
}
// Alert Script
const Toast = Swal.mixin({
    toast: true,
    position: 'center-center',
    showConfirmButton: false,
    background: '#E5F3FE',
    timer: 2000
});
function cAlert(type, text){
    Toast.fire({
        icon: type,
        title: text
    });
}

function changeProductImage(path){
    document.getElementById('product_preview').src = path;
}
function updateProQuantity(type){
    // console.log(type);
    let calculated_quantity = 0;
    let quantity = $('#single_cart_quantity').val();
    if(type == 'plus'){
        calculated_quantity = Number(quantity) + 1;
    }else{
        calculated_quantity = Number(quantity) - 1;
    }
    // // console.log(document.getElementById('single_cart_quantity').val);

    if(calculated_quantity > 0){
        $('#single_cart_quantity').val(calculated_quantity);
        // document.getElementById('single_cart_quantity').val = calculated_quantity;
        // this.cart_quantity = calculated_quantity;
    }
}

var swiper = new Swiper(".mySwiper", {
    spaceBetween: 30,
    loop: true,
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    }
});

var swiper = new Swiper(".mySwiperNewArrivalProducts", {
    spaceBetween: 30,
    breakpoints: {
        480: {
          slidesPerView: 1,
        },
        767: {
          slidesPerView: 2,
        },
        1200: {
          slidesPerView: 3,
        },
        1600: {
          slidesPerView: 4,
        },
    },
    loop: true,
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    }
});
