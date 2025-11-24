import Swiper from 'swiper';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';

document.addEventListener("DOMContentLoaded", () => {
    const slides = document.querySelectorAll('.swiper-slide');
    slides.forEach((slides, index) => {
        if (index >= 5) {
            slides.remove();
        }
    });
    
    new Swiper(".mySwiper", {
        modules: [Autoplay, Pagination, Navigation], // REQUIRED

        slidesPerView: 1,
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
