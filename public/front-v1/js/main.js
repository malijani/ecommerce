$(document).ready(function () {
    $('#social-media-button').hide();
    $("#back-to-top").hide();
    /*************/
    /*BACK TO TOP*/
    /*************/
    // scroll body to 0px on click
    $('#back-to-top').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 400, 'linear');
        return false;
    });
    /*############*/
    /*BACK TO TOP*/
    /*############*/

    /*######################*/
    /*SCROLL THREE TOP ITEMS*/
    /*######################*/
    $(window).on('scroll', function () {
        let scrollPosition = $(window).scrollTop();
        if (scrollPosition <= 400) {
            $('#social-media-button').fadeOut(100);
            $('#back-to-top').fadeOut(100);
        } else {
            $('#social-media-button').fadeIn(100);
            $('#back-to-top').fadeIn(100);
        }
    });
    /*######################*/
    /*SCROLL THREE TOP ITEMS*/
    /*######################*/

    /*######*/
    /*HEADER*/
    /*######*/
    $('.menu__navbar_toggle').click(function () {
        $('.menu__navbar_collapse').toggle(300);
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






