function heroSlider() {
    var e = new Swiper(".swiper-container-hero",{
        pagination: ".swiper-pagination-hero",
        paginationClickable: !0,
        nextButton: ".swiper-button-next",
        prevButton: ".swiper-button-prev",
        loop: !0,
        autoplay: 6e3,
        speed: 800,
        effect: "fade",
        fade: {
            crossFade: !1
        }
    })
}
function testimonialSlider() {
    var e = new Swiper(".swiper-container-testimonial",{
        pagination: ".swiper-pagination-testimonial",
        paginationClickable: !0,
        nextButton: ".swiper-button-next",
        prevButton: ".swiper-button-prev"
    })
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
