<!-- JAVASCRIPT -->
<!-- JS here -->
<script src="{{ URL::asset('/assets/front/js/vendor/jquery-3.5.0.min.js') }}"></script>
<script src="{{ URL::asset('/assets/front/js/popper.min.js') }}"></script>
<script src="{{ URL::asset('/assets/front/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('/assets/front/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ URL::asset('/assets/front/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ URL::asset('/assets/front/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ URL::asset('/assets/front/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ URL::asset('/assets/front/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::asset('/assets/front/js/jquery.nice-select.min.js') }}"></script>

<script src="{{ URL::asset('/assets/front/js/swiper-bundle.min.js') }}"></script>
<script src="{{ URL::asset('/assets/front/js/jarallax.min.js') }}"></script>
<script src="{{ URL::asset('/assets/front/js/slick.min.js') }}"></script>
<script src="{{ URL::asset('/assets/front/js/wow.min.js') }}"></script>
<script src="{{ URL::asset('/assets/front/js/nav-tool.js') }}"></script>
<script src="{{ URL::asset('/assets/front/js/plugins.js') }}"></script>
<script src="{{ URL::asset('/assets/front/js/main.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
<script src="{{ URL::asset('/assets/front/js/init.js') }}"></script>
<script src='{{asset("assets/front/js/jquery.star-rating-svg.js")}}'></script>
<script>
    $(".rating").starRating({
        activeColor: '#FF7F50',          
        strokeColor:'#FF7F50',
        readOnly: true
    });
    
    $(document).ready(function(){
        $('.featured_slider').slick({
            dots:true,
            arrows:true
            // setting-name: setting-value
        });
   
        $("#password-addon").click(function(){
            $("i.fas.fa-eye-slash").toggleClass("eye-visible");
        });
    });
    </script>

@yield('script')
