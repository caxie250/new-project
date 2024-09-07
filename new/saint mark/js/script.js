document.addEventListener('DOMContentLoaded', function() {
    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');
    const slides = document.querySelectorAll('.carousel-slide');
    const stars = document.querySelectorAll('.star');
    let currentIndex = 0;

    function showSlide(index) {
        const carousel = document.querySelector('.carousel');
        const offset = index * -100;
        carousel.style.transform = `translateX(${offset}%)`;
    }

    prevButton.addEventListener('click', () => {
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : slides.length - 1;
        showSlide(currentIndex);
    });

    nextButton.addEventListener('click', () => {
        currentIndex = (currentIndex < slides.length - 1) ? currentIndex + 1 : 0;
        showSlide(currentIndex);
    });

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const selectedValue = this.getAttribute('data-value');
            const allStars = this.parentNode.querySelectorAll('.star');
            
            allStars.forEach(s => {
                if (s.getAttribute('data-value') <= selectedValue) {
                    s.classList.add('selected');
                } else {
                    s.classList.remove('selected');
                }
            });
        });
    });
});
