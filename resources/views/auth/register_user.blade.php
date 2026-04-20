@extends('layouts.master-without-nav')

@section('title')
    Register
@endsection

@section('css')
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link href="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('body')

    <body class="auth-body-bg">
    @endsection

    @section('content')

        <div>
            <div class="container-fluid p-0">
                <div class="row g-0">

                    <div class="col-xl-9">
                        <div class="auth-full-bg pt-lg-5 p-4" style="background: url('{{ URL::asset('/build/images/slider-new-3.webp') }}') no-repeat center center; background-size: cover;">
                            <div class="w-100">
                                <div class="bg-overlay"></div>
                                <div class="d-flex h-100 flex-column">

                                    <!-- <div class="p-4 mt-auto">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-7">
                                                <div class="text-center">

                                                    <h4 class="mb-3"><i
                                                            class="bx bxs-quote-alt-left text-primary h1 align-middle me-3"></i><span
                                                            class="text-primary">5k</span>+ Satisfied clients</h4>

                                                    <div dir="ltr">
                                                        <div class="owl-carousel owl-theme auth-review-carousel"
                                                            id="auth-review-carousel">
                                                            <div class="item">
                                                                <div class="py-3">
                                                                    <p class="font-size-16 mb-4">" Fantastic theme with a
                                                                        ton of options. If you just want the HTML to
                                                                        integrate with your project, then this is the
                                                                        package. You can find the files in the 'dist'
                                                                        folder...no need to install git and all the other
                                                                        stuff the documentation talks about. "</p>

                                                                    <div>
                                                                        <h4 class="font-size-16 text-primary">Abs1981</h4>
                                                                        <p class="font-size-14 mb-0">- {{Config::get('constants.AppnameGlobe') }} User</p>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="item">
                                                                <div class="py-3">
                                                                    <p class="font-size-16 mb-4">" If Every Vendor on Envato
                                                                        are as supportive as Themesbrand, Development with
                                                                        be a nice experience. You guys are Wonderful. Keep
                                                                        us the good work. "</p>

                                                                    <div>
                                                                        <h4 class="font-size-16 text-primary">nezerious</h4>
                                                                        <p class="font-size-14 mb-0">- {{Config::get('constants.AppnameGlobe') }} User</p>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-3">
                        <div class="auth-full-page-content p-md-5 p-4">
                            <div class="w-100">

                                <div class="d-flex flex-column h-100 space-between">
                                    <div class="my-auto-top">
                                        <div class="mb-3 mb-md-3">
                                            <a href="index" class="d-block auth-logo">
                                                @if(getSettingInfo('logo')!="")
                                                    <img src="{{ URL::asset('uploads/settings/'.getSettingInfo('logo')) }}" alt="Logo" height="70" class="auth-logo-dark">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="my-auto">

                                            <div>
                                                <h5 class="text-primary">Register account</h5>
                                                <p class="text-muted">Get your free {{Config::get('constants.AppnameGlobe') }} account now.</p>
                                            </div>

                                            <div class="mt-4">
                                                @include('widget/notifications')
                                            

                                                <form class="custom-validation form-horizontal" novalidate method="POST" action="{{ route('user_register_process') }}">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label  class="form-label">First Name</label>
                                                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                                        @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label  class="form-label">Last Name</label>
                                                        <input name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" >
                                                        @error('last_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input name="email" type="text" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', '') }}"   autocomplete="email" autofocus required>
                                                        @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label  class="form-label">Phone Number</label>
                                                        <input name="phone" type="text" class="form-control" value="{{ old('phone') }}" >
                                                        @error('phone')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">                                            
                                                        <label class="form-label">Password</label>
                                                        <div class="input-group auth-pass-inputgroup @error('password') is-invalid @enderror" required>
                                                            <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror" id="userpassword"  placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                                                            <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                                            @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="mt-3 d-grid">
                                                        <button class="btn btn-primary btn-rounded waves-effect waves-light" type="submit">Register Now</button>
                                                    </div>
                                                    

                                                </form>

                                                <div class="mt-3 text-center">
                                                    <p>Already have an account ? <a href="{{ url('login') }}"
                                                            class="fw-medium text-primary"> Login</a> </p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 mt-md-3 text-center">
                                        <p class="mb-0">© <script>
                                            document.write(new Date().getFullYear())
                                            </script> {{Config::get('constants.AppnameGlobe') }}. Crafted with <i
                                                class="mdi mdi-heart text-danger"></i> by
                                            Cybernauticstech</p>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container-fluid -->
        </div>

    @endsection
    @section('script')
    <script src="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <!-- owl.carousel js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- auth-2-carousel init -->
   
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
            jQuery(document).ready(function($){
                $('.owl-carousel').owlCarousel({
                    loop:true,
                    margin:20,
                    nav:false,
                    dots:false,
                    autoplay:true,
                    autoplayTimeout:5000,
                    responsive:{
                        0:{ items:1 },
                        768:{ items:1 },
                        1024:{ items:1 }
                    }
                });
            });
        </script>

    @endsection