<script src="{{ asset('front-v1/js/jquery.min.js') }}"></script>
<script src="{{ asset('front-v1/js/popper.min.js') }}"></script>
<script src="{{ asset('front-v1/js/bootstrap.min.js') }}"></script>
{{--SWAL--}}
<script src="{{ asset('front-v1/sweetalert/sweetalert.min.js') }}"></script>
{{--LIVE WIRE--}}
@livewireScripts

<script>
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
</script>
