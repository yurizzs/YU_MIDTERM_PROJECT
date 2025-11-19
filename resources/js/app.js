import Swiper from 'swiper';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';

document.addEventListener("DOMContentLoaded", () => {
    new Swiper(".mySwiper", {
        modules: [Autoplay, Pagination, Navigation], // REQUIRED

        loop: true,

        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },

        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },

        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
});
