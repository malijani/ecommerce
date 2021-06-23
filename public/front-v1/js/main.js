/*$$$$$$$$$$$$$$$*/
/*HEADER NAVBAR*/
/*$$$$$$$$$$$$$$$*/
!function (e) {
    "use strict";

    e(function () {
        let s="desktop";
        e(window).on("load resize", function () {
            let t = "desktop";
            if (matchMedia("only screen and (max-width: 991px)").matches && (t = "mobile"), t !== s)
                if (s = t, "mobile" === t) {
                    let a = e("#main_nav").attr("id", "main_nav_mobi").hide(),
                        i = e("#main_nav_mobi").find("li:has(ul)");
                    e("#header #site-header-inner").after(a);
                    i.children("ul").hide();
                    i.children("a").after('<span class="btn-submenu"></span>');
                    e(".btn-menu").removeClass("active")
                } else {
                    let o = e("#main_nav_mobi").attr("id", "main_nav").removeAttr("style");
                    o.find(".submenu").removeAttr("style");
                    e("#header").find(".nav-wrap").append(o);
                    e(".btn-submenu").remove()
                }
        });
        e(".mobile-button").on("click", function () {
            e("#main_nav_mobi").slideToggle(300);
            e(this).toggleClass("active");
        });
            e(document).on("click", "#main_nav_mobi li .btn-submenu", function (t) {
            e(this).toggleClass("active").next("ul").slideToggle(300);
                t.stopImmediatePropagation()
        })

    })
}(jQuery);

/*$$$$$$$$$$$$$$$*/
/*HEADER NAVBAR*/
/*$$$$$$$$$$$$$$$*/

$(document).ready(function () {
    /*************/
    /*BACK TO TOP*/
    /*************/
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });
    // scroll body to 0px on click
    $('#back-to-top').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 400);
        return false;
    });
    /*############*/
    /*BACK TO TOP*/
    /*############*/

    /********************/
    /*HIDE MOBILE FOOTER*/
    /********************/
    $('#phone-nav').hide();
    $(window).scroll(function () {
        if ($(this).scrollTop() < 10) {
            $('#phone-nav').fadeOut();
        } else {
            $('#phone-nav').fadeIn();
        }
    });
    /*##################*/
    /*HIDE MOBILE FOOTER*/
    /*##################*/


});

