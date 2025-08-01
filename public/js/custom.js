$(document).ready(function () {
    $("#sidebarToggle").on("click", function () {
        $("#sidebar").toggleClass("active");
        $("#content").toggleClass("active");
    });

    $(window).on("resize", function () {
        if ($(window).width() > 768) {
            $("#sidebar").removeClass("active");
            $("#content").removeClass("active");
        }
    });

    $("#mobile-menu-button").on("click", function () {
        $("#offcanvas-menu").removeClass("translate-x-full");
        $("#offcanvas-overlay").removeClass("opacity-0 pointer-events-none");
    });

    $("#close-offcanvas, #offcanvas-overlay").on("click", function () {
        $("#offcanvas-menu").addClass("translate-x-full");
        $("#offcanvas-overlay").addClass("opacity-0 pointer-events-none");
    });

    $(window).on("scroll", function () {
        if ($(this).scrollTop() > 200) {
            $("#scrollToTop").removeClass("opacity-0 pointer-events-none");
        } else {
            $("#scrollToTop").addClass("opacity-0 pointer-events-none");
        }
    });

    $("#scrollToTop").on("click", function () {
        $("html, body").animate({ scrollTop: 0 }, 500);
    });

    $("#avatarInput").on("change", function () {
        if (this.files && this.files[0]) {
            $("#avatarForm").submit();
        }
    });

    const firstInvalid = $(".is-valid").first();
    if (firstInvalid.length) {
        $("html, body").animate(
            {
                scrollTop: firstInvalid.offset().top - 100,
            },
            1000,
            "linear"
        );
    }

    setTimeout(function () {
        const banner = document.getElementById("guide-banner");
        if (banner) {
            banner.classList.add("opacity-0", "scale-95");
            setTimeout(() => banner.remove(), 500);
        }
    }, 5000);
});
