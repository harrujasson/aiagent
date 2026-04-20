@extends('layouts.master')

@section('title') {{$title}} | {{$module}} @endsection

@section('css')

@endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') {{$module}} @endslot
@slot('title') {{$title}} @endslot
@slot('page_title') {{$title}} @endslot
@endcomponent


<div class="row">
    <div class="col-xl-12 mx-auto">
        <div class="card">
            @include('widget/notifications')
            <form class="custom-validation" novalidate autocomplete="off" method="post" action="{{ route('admin.staff.edit_save',$r->id) }}"  enctype="multipart/form-data">
            @csrf
                <div class="card-header">
                    <h5 class="card-title mb-0">{{$title}}</h5>
                </div>
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
                    <ul class="nav nav-tabs nav-tabs-custom mb-4 mt-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#basic" role="tab">
                                <span class="d-sm-block">Basic Information</span> 
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="basic" role="tabpanel">

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
                                        <label for="formrow-password-input" class="form-label">Last Name</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="isax isax-user"></i></div>
                                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name', $r->last_name) }}"  >
                                        </div> 
                                        
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
                                        <label  class="form-label">Telephone <code>*</code></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="isax isax-call-calling"></i></div>
                                            <input type="text" class="form-control" name="phone" required value="{{ old('phone', $r->phone) }}" maxlength="10">
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
                                        <label>Role Type <code>*</code></label>
                                        <div class="input-group status-field">
                                            <div class="input-group-text"><i class="isax isax-user"></i></div>
                                            <select class="form-control" name="role_type" required>
                                                <option value="Admin" {{($r->role_type == "Admin" ? "selected":"")}}>Admin</option>
                                                <option value="Accountant" {{($r->role_type == "Accountant" ? "selected":"")}}>Accountant</option>
                                                <option value="Manager" {{($r->role_type == "Manager" ? "selected":"")}}>Manager</option>
                                                <option value="Staff" {{($r->role_type == "Staff" ? "selected":"")}}>Staff</option>
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
                                                <option value="1" {{ ($r->status == "1"? "selected":"") }}>Active</option>
                                                <option value="0" {{ ($r->status == "0"? "selected":"") }}>De-Active</option>
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
                                            <input type="password" class="form-control" name="new_password" >
                                        </div>                                    
                                        <span class="text-danger">{{ $errors->first('new_password', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Confirm New Password </label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="isax isax-lock-1"></i></div>
                                            <input type="password" class="form-control" name="confirm_password" >
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
                                    @if($r->picture!="")                                        
                                        <div class="mb-3">
                                            <img class="rounded-circle avatar-xl" src="{{ asset('uploads/profile/'.$r->picture) }}">
                                        </div>                                       
                                    @endif
                                </div>
                            </div> 
                        </div>
                        
                    </div>

               
                </div>
                <div class="card-footer">
                    <div class="d-flex space-between align-center">
                        <a href="{{route('admin.staff.manage')}}" class="btn btn-transparent btn-rounded"><i class="ti ti-arrow-left"></i> Back</a>
                        <button class="btn btn-primary btn-rounded">Update Changes</button>
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
<!-- form advanced init -->
<script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#staff").addClass("mm-active");
    });
</script>
@endsection



