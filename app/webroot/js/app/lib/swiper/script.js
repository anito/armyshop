jQuery(document).ready(function($) {
    $(".category-open").on("click", function() {
        $(this).toggleClass("open");
        $(".menu-category-menu-container").toggleClass("open");
    });
    $('.scroll').on('click', function(e) {
        var href = $(this).attr('href');
        $('html, body').animate({
            scrollTop: $(href).offset().top - 140
        }, 'slow');
        e.preventDefault();
    });
    $(".scroll").on("click", function() {
        $(".scroll").removeClass("active");
        $(this).addClass("active");
    });
    $(".open-menu").on("click", function() {
        $(".outer-wrapper").toggleClass("has-push-right");
        $(".menu-push-right").toggleClass("is-active");
        $("body").toggleClass("menu-open");
    });
    $(".menu-push-to-close").on("click", function() {
        $(".outer-wrapper").removeClass("has-push-right");
        $(".menu-push-right").removeClass("is-active");
        $("body").removeClass("menu-open");
    });
    $(".menu-seitenmenue-unten-container .menu-item-has-children").append("<span class='open-sub-menu'></span>");
    $(".open-sub-menu").on("click", function() {
        $(this).prev(".sub-menu").toggleClass("open");
        $(this).parent(".menu-item-has-children").toggleClass("open");
    });
    $(".collapse.in").next(".more-link").addClass("open");
    $(".more-link").on("click", function() {
        $(this).toggleClass("open");
    });
    $("#seminar-form").nextAll("#seminar-form").css("display", "none");
});
$(window).scroll(function() {
    var scroll = $(window).scrollTop();
    if (scroll >= 1) {
        $("header").addClass("fixed");
    } else {
        $("header").removeClass("fixed");
    }
});
$(function() {
    // name your elements here
    var stickyElement = '.sticky-element'
      , // the element you want to make sticky
    bottomElement = 'footer.mobile'; // .fake-footer
    // the bottom element where you want the sticky element to stop (usually the footer) 
    // make sure the element exists on the page before trying to initalize
    if ($(stickyElement).length) {
        $(stickyElement).each(function() {
            // let's save some messy code in clean variables
            // when should we start affixing? (the amount of pixels to the top from the element)
            var fromTop = $(this).offset().top - 140
              , // where is the bottom of the element?
            fromBottom = $(document).height() - ($(this).offset().top + $(this).outerHeight())
              , // where should we stop? (the amount of pixels from the top where the bottom element is)
            // also add the outer height mismatch to the height of the element to account for padding and borders
            stopOn = $(document).height() - ($(bottomElement).offset().top) + ($(this).outerHeight() - $(this).height());
            // if the element doesn't need to get sticky, then skip it so it won't mess up your layout
            if ((fromBottom - stopOn) > 200) {
                // let's put a sticky width on the element and assign it to the top
                $(this).css('width', $(this).width()).css('top', 0).css('position', '');
                // assign the affix to the element
                $(this).affix({
                    offset: {
                        // make it stick where the top pixel of the element is
                        top: fromTop,
                        // make it stop where the top pixel of the bottom element is
                        bottom: stopOn
                    }// when the affix get's called then make sure the position is the default (fixed) and it's at the top
                }).on('affix.bs.affix', function() {
                    $(this).css('top', 140).css('position', '');
                });
            }
            // trigger the scroll event so it always activates 
            $(window).trigger('scroll');
        });
    }
});
