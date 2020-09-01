$(window).scroll(function() {
    if ($(this).scrollTop() > 200) {
        $('.navbar-expand-lg').addClass('header-fixed');
    } else {
        $('.navbar-expand-lg').removeClass('header-fixed');
    }
});
$('.owl-travel').owlCarousel({
    loop: true,
    margin: 30,
    responsiveClass: true,
    dots: true,
    responsive: {
        0: {
            items: 1,
            nav: true
        },
        600: {
            items: 3,
            nav: false
        },
        1000: {
            items: 3,
            nav: false,
            dots: true,
            loop: true
        }
    }
});