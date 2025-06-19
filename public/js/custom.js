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
});