const aside = document.querySelector('.text__sub_content_section');

if (
    !aside.querySelector('.text__tag') &&
    !aside.querySelector('.text__outline')
) {
    aside.remove();
}
