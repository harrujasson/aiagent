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
                                                <h5 class="text-primary">Forgot Password</h5>
                                                <p class="text-muted">Enter your email address to reset your password.</p>
                                            </div>

                                            <div class="mt-4">
                                                @include('widget/notifications')
                                                @if (session('status'))
                                                    <div class="alert alert-success text-center mb-4" role="alert">
                                                        {{ session('status') }}
                                                    </div>
                                                @endif
                                                <form class="form-horizontal" method="POST"  action="{{ route('password.email') }}">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="useremail" class="form-label">Email</label>
                                                        <input type="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            id="useremail" name="email" placeholder="Enter email"
                                                            value="{{ old('email') }}" id="email">
                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="mt-3 d-grid">
                                                        <button class="btn btn-dark w-md waves-effect waves-light"
                                                            type="submit">Reset</button>
                                                    </div>

                                                    <div class="mt-4 text-center">                                            
                                                        Remember It ? <a id="subscriberLoginLink" href="{{ url('login') }}" class="text-muted">Sign In</a>
                                                    </div>

                                                </form>

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