@extends('layouts.master-without-nav-sub')
@section('title')
Login Subscriber
@endsection
@section('css')
@endsection
@section('body')

<body class="auth-body-bg py-5 crmwiz-login">
    @endsection

    @section('content')


        <div class="account-pages pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-primary px-4 pt-4 pb-2">
                                        <h5 class="text-dark welcome-title pb-2" style="font-size: 20px;">Welcome to store <span class="title"></span></h5>
                                            <h5 class="text-dark pb-4">Sign in to {{ getSettingInfo('company_name') != '' ? getSettingInfo('company_name') : Config::get('constants.AppnameGlobe') }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0"> 

                                <div class="auth-logo" style="display:none;">
                                    <a href="#" class="auth-logo-light">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="" alt="" class="rounded-circle authlogo welcome-logo" height="60" width="60">
                                            </span>
                                        </div>
                                    </a>

                                    <a href="#" class="auth-logo-dark">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light ">
                                                <img src="" alt="" class="rounded-circle light authlogo welcome-logo" height="60" width="60">
                                            </span>
                                        </div>
                                    </a>
                                </div>

                                <div class="p-2">
                                    @php
                                    if(isset($_GET['auth']) && $_GET['auth'] == true) { @endphp
                                        <div class="alert alert-danger alert-dismissable fade show">
                                            <strong>Error: </strong> Your User Name/password combination was incorrect.!
                                        </div>
                                    @php } @endphp

                                    <form class="form-horizontal" method="POST" action="{{ route('loginsubprocess') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username" class="form-label">User Name</label>
                                            <input name="username" type="text" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', '') }}" id="username" placeholder="Enter Username" autocomplete="username" autofocus>
                                            @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">                                            
                                            <label class="form-label">Password</label>
                                            <div class="input-group auth-pass-inputgroup @error('password') is-invalid @enderror">
                                                <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror" id="userpassword"  placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                                                <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="login-btn-grp">
                                        <div class="mt-3 d-grid">
                                            <input type="hidden" value="{{$store}}" name="storenumber">
                                            <button class="btn btn-primary btn-rounded waves-effect waves-light" type="submit">Log In</button>
                                        </div>
                                        <div class="mt-3 d-grid">
                                            <a href="{{route('home')}}" class="btn btn-primary btn-rounded waves-effect waves-light">Back</a>
                                        </div>
                                        </div>
                                        @if (Route::has('password.request'))
                                        <div class="mt-4 text-center">
                                            <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                                        </div>
                                        @endif
                                    
                                    </form>
                                </div>            
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            
                            <div>
                                <p>© <script>document.write(new Date().getFullYear())</script> {{(getSettingInfo('company_name') != "" ? getSettingInfo('company_name') : Config::get('constants.AppnameGlobe') ) }} </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
    <script src="{{asset('assets/front/js/process.js')}}"></script>
    @endsection