{{--JQUERY--}}
<script src="{{ asset('front-v1/js/jquery.min.js') }}"></script>

{{--POPPER--}}
<script src="{{ asset('front-v1/js/popper.min.js') }}"></script>

{{--BOOTSTRAP 4--}}
<script src="{{ asset('front-v1/js/bootstrap.min.js') }}"></script>

{{--SWAL--}}
{{--<script src="{{ asset('front-v1/sweetalert/sweetalert.min.js') }}"></script>--}}
<script src="{{ asset('front-v1/sweetalert/sweetalert2.min.js') }}"></script>

{{--OWL CAROUSEL--}}
<script src="{{asset('front-v1/owl-carousel/owl.carousel.min.js')}}"></script>

{{--CUSTOM JS--}}
<script src="{{ asset('front-v1/js/main.js') }}"></script>

{{--LIVE WIRE--}}
@livewireScripts


{{--<script src="{{ asset('front-v1/mega-menu/script.js') }}"></script>--}}

<script>
    $(document).ready(function () {
        /*SET LOGO AS PARALLAX_HEADER*/
        /*let parallax_header = $("#parallax_header");
        parallax_header.css("background-image", "url({{asset($logo->pic??'images/fallback/logo.png')}})")*/

        /*DISABLE LINK HREF EVENT ON NAV HEADINGS*/
        /*let menu_headers = $(".submenu").siblings();
        menu_headers.on('click touch', function(e){
            e.preventDefault();
        });*/

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>

