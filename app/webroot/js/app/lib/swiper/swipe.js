function pricingSlider_() {
    var e = new Swiper(".swiper-container-pricing",{
        pagination: ".swiper-pagination",
        paginationClickable: !0,
        nextButton: ".swiper-button-next",
        prevButton: ".swiper-button-prev",
        loop: true,
        autoplay: 6e3,
        effect: "fade",
        speed: 800,
        fade: {
            crossFade: !1
        }
    })
}
function pricingSlider(id) {
    var query = $('#'+id + " .swiper-container-pricing");
    query.addClass('swiper')
    var e = new Swiper(query[0], {
        pagination: ".swiper-pagination",
        paginationClickable: true,
        nextButton: ".swiper-button-next",
        prevButton: ".swiper-button-prev",
        effect: "fade",
        fade: {
          crossFade: false
        },
        loop: true,
        autoplay: 6e3
    })
    return e;
}
function detailsSlider() {
    var query = $(".swiper-container-details");
    query.addClass('swiper')
    var e = new Swiper(query[0], {
        pagination: ".swiper-pagination",
        paginationClickable: true,
        nextButton: ".swiper-button-next",
        prevButton: ".swiper-button-prev",
        effect: "fade",
        fade: {
          crossFade: false
        },
        loop: true,
        autoplay: 6e3
    })
    return e;
}
function testimonialSlider2() {
    var e = new Swiper(".swiper-container-testimonial-2",{
        pagination: ".swiper-pagination-testimonial-2",
        paginationClickable: !0,
        nextButton: ".swiper-button-next",
        prevButton: ".swiper-button-prev"
    })
}
function teamSliderGross() {
    var e = new Swiper(".swiper-container-team-gross",{
        pagination: ".swiper-pagination-team-gross",
        paginationClickable: !0,
        nextButton: ".swiper-button-next",
        prevButton: ".swiper-button-prev"
    })
}
function teamSlider() {
    var e = new Swiper(".swiper-container-team",{
        slidesPerView: 8,
        spaceBetween: 0,
        breakpoints: {
            1200: {
                slidesPerView: 5,
                spaceBetween: 0
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 0
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 0
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 0
            }
        }
    })
}
