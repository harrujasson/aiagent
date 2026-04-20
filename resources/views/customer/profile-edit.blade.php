@extends('layouts.master')

@section('title') {{$title}} @endsection
@section('css')
    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('li_1') {{$name}} @endslot
        @slot('title') {{$title}} @endslot
        @slot('page_title') {{$module}} @endslot
    @endcomponent



<div class="row">
    <div class="col-lg-12 col-md-12 mx-auto">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$title}}</h4>
            </div>            
            <form class="needs-validation" novalidate method="post" action="{{ route('customer.my_profile_save',$r->id) }}"  enctype="multipart/form-data">
            @csrf
                <div class="card-body">
                    @include('widget/notifications')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>First Name <code>*</code></label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="isax isax-user"></i></div>
                                    <input type="text" class="form-control" name="name" required value="{{ old('name', $r->name) }}">
                                </div>
                                <span class="text-danger">{{ $errors->first('name', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Last Name <code>*</code></label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="isax isax-user"></i></div>
                                    <input type="text" class="form-control" name="last_name" required value="{{ old('last_name', $r->last_name) }}">
                                </div>
                                <span class="text-danger">{{ $errors->first('last_name', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>E-Mail <code>*</code></label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="isax isax-sms-tracking"></i></div>
                                    <input type="email" class="form-control" name="email" required value="{{ old('email', $r->email) }}">
                                </div>
                                <span class="text-danger">{{ $errors->first('email', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label  class="form-label">Telephone</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="isax isax-call-calling"></i></div>
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone', $r->phone) }}"  >
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label>Address</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="isax isax-location"></i></div>
                                    <input type="text" class="form-control" id="autocomplete" name="address" required value="{{ old('address', $r->address) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label  class="form-label">City</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="isax isax-map"></i></div>
                                    <input type="text" class="form-control" name="city" value="{{ old('city', $r->city) }}"  >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label  class="form-label">State</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="isax isax-map"></i></div>
                                    <input type="text" class="form-control" name="state" value="{{ old('state', $r->state) }}"  >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label  class="form-label">Country</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="isax isax-map"></i></div>
                                    <input type="text" class="form-control" name="country" value="{{ old('country', $r->country) }}"  >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label  class="form-label">Zipcode</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="isax isax-map"></i></div>
                                    <input type="text" class="form-control" name="zipcode" value="{{ old('zipcode', $r->zipcode) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Profile Picture</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="isax isax-gallery"></i></div>
                                    <input class="form-control" name="picture" type="file" id="formFile">
                                </div>
                            </div>
                            @if($r->picture!="")
                                <div class="mb-3">
                                    <img class="rounded-circle avatar-xl" src="{{ asset('uploads/profile/'.$r->picture) }}">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>New Password </label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="isax isax-lock-1"></i></div>
                                    <input type="password" class="form-control" name="new_password"  >
                                </div>                                
                                <span class="text-danger">{{ $errors->first('new_password', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Confirm New Password </label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="isax isax-lock-1"></i></div>
                                    <input type="password" class="form-control" name="confirm_password"  >
                                </div>                                
                                <span class="text-danger">{{ $errors->first('confirm_password', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                </div>            
                <div class="card-footer">
                    <div class="d-flex space-between align-center">
                        <a href="{{route('customer.profile')}}" class="btn btn-transparent btn-rounded"><i class="ti ti-arrow-left"></i> Back</a>
                        <button class="btn btn-primary btn-rounded">Update Profile</button>
                    </div>                
                </div>
            </form>
        </div>
    </div>
</div>




@endsection

@section('script')
<!-- form advanced init -->
<script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
@endsection
