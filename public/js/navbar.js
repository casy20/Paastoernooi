let lastScrollY = window.scrollY;

window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar');

    if (window.scrollY > lastScrollY) {
        navbar.style.top = '-90px';
    } else {
        navbar.style.top = '0';
    }

    lastScrollY = window.scrollY;
});
