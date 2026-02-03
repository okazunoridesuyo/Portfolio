const nav_menu = document.querySelector('.nav__menu');
const hum_menu = document.querySelector('.nav__hum_icon');

hum_menu.addEventListener('click', () => {
    nav_menu.classList.toggle('on');
    hum_menu.classList.toggle('on');
});

nav_menu.addEventListener('click', () => {
    nav_menu.classList.remove('on');
    hum_menu.classList.remove('on');
});
