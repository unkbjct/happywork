$(document).ready(() => {
    new Swiper('.swiper-promo', {
        loop: true,
        slidesPerView: 1,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
            pauseOnMouseEnter: false,
        },
    });

    const breakpoints = {
        500: {
            slidesPerView: 2,
        },
        992: {
            slidesPerView: 3,
        },
        1200: {
            slidesPerView: 4,
        },
        1400: {
            slidesPerView: 5,
        }
    }

    new Swiper('.swiper-watched', {
        slidesPerView: 1,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        navigation: {
            nextEl: '.hit-next',
            prevEl: '.hit-back',
        },
    });

})