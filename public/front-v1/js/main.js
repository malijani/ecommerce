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

    /*######*/
    /*HEADER*/
    /*######*/
    $('.menu__navbar_toggle').click(function () {
        $('.menu__navbar_collapse').toggle(300);
    });

    smallScreenMenu();
    let temp;

    function resizeEnd() {
        smallScreenMenu();
    }

    $(window).resize(function () {
        clearTimeout(temp);
        temp = setTimeout(resizeEnd, 100);
        resetMenu();
    });
    /*######*/
    /*HEADER*/
    /*######*/
    
});


const subMenus = $('.menu__sub_menu');
const menuLinks = $('.menu__menu_link');

function smallScreenMenu() {
    if ($(window).innerWidth() <= 992) {
        menuLinks.each(function (e) {
            $(this).click(function () {
                $(this).next().toggle();
            });
        });
    } else {
        menuLinks.each(function (e) {
            $(this).off('click');
        });
    }
}

function resetMenu() {
    if ($(window).innerWidth() > 992) {
        subMenus.each(function (e) {
            $(this).css('display', 'none');
        });
    }
}



