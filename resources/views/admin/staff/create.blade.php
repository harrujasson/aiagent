@extends('layouts.master')

@section('title') {{$title}} | {{$module}} @endsection

@section('css')
@endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') {{$module}} @endslot
@slot('title') {{$title}} @endslot
@slot('page_title') User Management @endslot
@endcomponent


<div class="row">
    <div class="col-xl-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{$title}}</h5>
            </div>
            @include('widget/notifications')
            <form class="custom-validation" novalidate autocomplete="off" method="post" action="{{ route('admin.staff.new_save') }}"  enctype="multipart/form-data">
            @csrf                
                <div class="card-body">
                
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Nav tabs -->

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label>First Name <code>*</code></label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="isax isax-user"></i></div>
                                    <input type="text" class="form-control" name="name" required value="{{ old('name') }}">
                                </div>
                                <span class="text-danger">{{ $errors->first('name', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formrow-password-input" class="form-label">Last Name</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="isax isax-user"></i></div>
                                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}"  >
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Email ID <code>*</code></label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="isax isax-sms-tracking"></i></div>
                                    <input type="email" class="form-control" name="email" required value="{{ old('email') }}">
                                </div> 
                                <span class="text-danger">{{ $errors->first('email', ':message') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label  class="form-label">Telephone <code>*</code></label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="isax isax-call-calling"></i></div>
                                    <input type="text" class="form-control" name="phone" required value="{{ old('phone') }}" maxlength="10">
                                </div> 
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label>Address  <code>*</code></label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="isax isax-location"></i></div>
                                    <input type="text" class="form-control" id="autocomplete" name="address" required value="{{ old('address') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label  class="form-label">City</label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="isax isax-map"></i></div>
                                        <input type="text" class="form-control" name="city" value="{{ old('city') }}"  >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label  class="form-label">State</label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="isax isax-map"></i></div>
                                        <input type="text" class="form-control" name="state" value="{{ old('state') }}"  >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label  class="form-label">Country</label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="isax isax-map"></i></div>
                                        <input type="text" class="form-control" name="country" value="{{ old('country') }}"  >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label  class="form-label">Zipcode</label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="isax isax-map"></i></div>
                                        <input type="text" class="form-control" name="zipcode" value="{{ old('zipcode') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Role Type <code>*</code></label>
                                <div class="input-group status-field">
                                    <div class="input-group-text"><i class="isax isax-user"></i></div>
                                    <select class="form-control" name="role_type" required>
                                        <option value="Admin">Admin</option>
                                        <option value="Accountant">Accountant</option>
                                        <option value="Manager">Manager</option>
                                        <option value="Staff">Staff</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Status </label>
                                <div class="input-group status-field">
                                    <div class="input-group-text"><i class="isax isax-receipt-edit"></i></div>
                                    <select class="form-control" name="status">
                                        <option value="1">Active</option>
                                        <option value="0">De-Active</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>

                
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>New Password </label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="isax isax-lock-1"></i></div>
                                    <input type="password" class="form-control" name="password" required >
                                </div>                                    
                                <span class="text-danger">{{ $errors->first('password', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Confirm New Password </label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="isax isax-lock-1"></i></div>
                                    <input type="password" class="form-control" name="confirm_password" required >
                                </div>
                                <span class="text-danger">{{ $errors->first('confirm_password', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Profile Picture</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="isax isax-gallery"></i></div>
                                    <input class="form-control" name="picture" type="file" id="formFile">
                                </div>                                    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex space-between align-center">
                        <a href="{{route('admin.staff.manage')}}" class="btn btn-transparent btn-rounded"><i class="ti ti-arrow-left"></i> Back</a>
                        <button class="btn btn-primary btn-rounded">Save Changes</button>
                    </div>
                    
                </div>
            </form>
        </div>
        <!-- end card -->
    </div> <!-- end col -->
</div>

@endsection

@section('script')
<script src="{{ URL::asset('build/libs/parsleyjs/parsleyjs.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#staff").addClass("mm-active");
    });
    let autocomplete;
    function initAutocomplete() {
        // Initialize Google Autocomplete
        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById('autocomplete'),
            { types: ['address'],componentRestrictions: { country: ["us"] }, }
        );

        // Add listener to populate address fields on selection
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        const place = autocomplete.getPlace();
        const addressComponents = place.address_components;

        

        // Loop through address components and assign values to fields
        addressComponents.forEach(component => {
            const types = component.types;
            const value = component.long_name;
            if (types.includes("postal_code")) {
                document.getElementById('zipcode').value = value;
            }
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.address_key') }}&libraries=places&callback=initAutocomplete" async defer></script>


@endsection
