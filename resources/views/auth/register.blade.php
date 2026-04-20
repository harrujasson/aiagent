@extends('layouts.master-without-nav')

@section('title')
Register
@endsection

@section('css')

<!-- Owl Carousel -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">


<link href="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet"
    type="text/css">
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
                                            <h5 class="text-primary">Register account</h5>
                                            <p class="text-muted">Get your free {{Config::get('constants.AppnameGlobe') }}
                                                account now.</p>
                                        </div>

                                        <div class="mt-4">
                                            @include('widget/notifications')
                                            <form method="POST" class="form-horizontal" action="{{ route('register') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="useremail" class="form-label">Email*</label>
                                                    <input type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        id="useremail" value="{{ old('email') }}" name="email"
                                                        placeholder="Enter email" autofocus required>
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Name*</label>
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        value="{{ old('name') }}" id="username" name="name" autofocus
                                                        required placeholder="Enter Name">
                                                    @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Last Name*</label>
                                                    <input type="text"
                                                        class="form-control @error('last_name') is-invalid @enderror"
                                                        value="{{ old('last_name') }}" name="last_name" autofocus
                                                        placeholder="Enter last name">
                                                    @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="userpassword" class="form-label">Password*</label>
                                                    <input type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        id="userpassword" name="password" placeholder="Enter password"
                                                        autofocus required>
                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="confirmpassword" class="form-label">Confirm
                                                        Password*</label>
                                                    <input type="password"
                                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                                        id="confirmpassword" name="password_confirmation"
                                                        placeholder="Enter Confirm password" autofocus required>
                                                    @error('password_confirmation')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="avatar">Profile Picture*</label>
                                                    <div class="input-group img-upload">
                                                        <div class="image-upload-field">
                                                            <input type="file" class="form-control" id="inputGroupFile02"
                                                                name="avatar" autofocus>
                                                        </div>
                                                        <div class="img-show d-none">
                                                            <span><img
                                                                    src="{{ URL::asset('/assets/front/images/professional.svg') }}"></span>
                                                        </div>
                                                    </div>
                                                    @error('avatar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="mt-4 text-center recapcha">
                                                    <div class="g-recaptcha"
                                                        data-sitekey="6Lel4Z4UAAAAAOa8LO1Q9mqKRUiMYl_00o5mXJrR"></div>
                                                </div>

                                                <div class="mt-4 d-grid">
                                                    <button class="btn btn-primary waves-effect waves-light"
                                                        type="submit">Register</button>
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <p class="mb-0">By registering you agree to the keyperks <a
                                                            href="/term-condition" class="text-primary">Terms of Use</a></p>
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