$(document).ready(() => {
    new Swiper('.swiper-hits', {
        loop: true,
        slidesPerView: 1,
        navigation: {
            nextEl: '.hit-next',
            prevEl: '.hit-back',
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

    new Swiper('.swiper-news', {
        loop: true,
        slidesPerView: 1,
        navigation: {
            nextEl: '.news-next',
            prevEl: '.news-back',
        },
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        breakpoints: breakpoints
    });

    new Swiper('.swiper-tops', {
        loop: true,
        slidesPerView: 1,
        // grabCursor: true,
        navigation: {
            nextEl: '.tops-next',
            prevEl: '.tops-back',
        },
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        breakpoints: breakpoints
    });
})