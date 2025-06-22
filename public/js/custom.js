$(document).ready(function () {
    $('#sidebarToggle').on('click', function () {
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('active');
    });

    $(window).on('resize', function () {
        if ($(window).width() > 768) {
            $('#sidebar').removeClass('active');
            $('#content').removeClass('active');
        }
    });


    $('#mobile-menu-button').on('click', function() {
        $('#offcanvas-menu').removeClass('translate-x-full');
        $('#offcanvas-overlay').removeClass('opacity-0 pointer-events-none');
    });

    $('#close-offcanvas, #offcanvas-overlay').on('click', function() {
        $('#offcanvas-menu').addClass('translate-x-full');
        $('#offcanvas-overlay').addClass('opacity-0 pointer-events-none');
    });
});