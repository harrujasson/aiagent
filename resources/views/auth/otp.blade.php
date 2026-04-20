@extends('layouts.master-without-nav')

@section('title')
Login
@endsection

@section('css')

@endsection

@section('body')

<body class="auth-body-bg">
    @endsection

    @section('content')


        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-primary p-4">
                                            <h5 class="text-dark">Two way authorization !</h5>
                                            <p>Please check your mobile otp {{$phone}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0"> 
                            @if(getSettingInfo('login_logo')!="")                            
                                <div class="auth-logo">
                                    <a href="#" class="auth-logo-light">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{ URL::asset('uploads/settings/'.getSettingInfo('login_logo')) }}" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>

                                    <a href="#" class="auth-logo-dark">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{ URL::asset('uploads/settings/'.getSettingInfo('login_logo')) }}" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                @endif
                                <div class="p-2">
                                    @include('widget/notifications')
                                    <form class="form-horizontal" method="POST" action="{{ route('login_process') }}">
                                        @csrf
                                        <div class="mb-3">                                            
                                            <label class="form-label">OTP</label>
                                            <div class="input-group auth-pass-inputgroup @error('otp') is-invalid @enderror">
                                                <input type="password" name="otp" class="form-control  @error('otp') is-invalid @enderror" id="userpassword"  placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                                                <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                                @error('otp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mt-3 d-grid">
                                            <button class="btn btn-dark waves-effect waves-light" type="submit">Verify</button>
                                        </div>
                                        
                                        <div class="mt-4 text-center">                                            
                                            <a href="{{ route('resend_top') }}" class="text-muted"><i class="mdi mdi-lock me-1"></i> Resend OTP?</a>
                                        </div>
                                        
                                    </form>
                                </div>            
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            
                            <div>
                                <!-- <p>Don't have an account ? <a href="register.html" class="fw-medium text-primary"> Signup now </a> </p> -->
                                <p>© <script>document.write(new Date().getFullYear())</script> {{Config::get('constants.AppnameGlobe') }}.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
    
    @endsection