$(document).ready(function () {
    $('ul li').on('click', function (e) {
        e.stopPropagation();
        $(this).find('.faq-content').stop(true, true).slideToggle(200);
    });
});
