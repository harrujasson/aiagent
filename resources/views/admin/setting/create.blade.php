@extends('layouts.master')

@section('title') {{$title}} @endsection

@section('css')
@endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') {{$name}} @endslot
@slot('title') {{$title}} @endslot
@slot('page_title') {{$module}}  @endslot
@endcomponent


<div class="row">
    <div class="col-xl-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{$title}}</h5>
            </div>
            <form class="custom-validation" novalidate autocomplete="off" method="post"
                action="{{ route('admin.setting.common_update') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @include('widget/notifications')
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
                    <ul class="nav nav-tabs nav-tabs-custom mb-4" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#General" role="tab">
                                <span >General</span>
                            </a>
                           
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="General" role="tabpanel">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Company Name</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="isax isax-user"></i></div>
                                            <input type="text" class="form-control" name="company_name"
                                                value="{{old('company_name',$r->company_name ?? '')}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Company Address</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="isax isax-location"></i></div>
                                            <input type="text" class="form-control" name="company_address"
                                                value="{{old('company_address',$r->company_address ?? '')}}">
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Company Phone</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="isax isax-call-calling"></i></div>
                                            <input type="text" class="form-control" name="company_phone"
                                                value="{{old('company_phone',$r->company_phone ?? '')}}">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Company Email</label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="isax isax-sms-tracking"></i></div>
                                            <input type="text" class="form-control" name="company_email"
                                                value="{{old('company_email',$r->company_email ?? '')}}">
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-sm-6">
                                    <div class="mt-3">
                                        <label for="formFileFeatureSize" class="form-label">Logo Large
                                            <code></code></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="isax isax-gallery"></i></div>
                                            <input class="form-control" type="file" name="logo">
                                        </div>
                                    </div>
                                    @if(isset($r->logo) && $r->logo!="")
                                    <div class="mt-3">
                                        <img src="{{asset('uploads/settings/'.$r->logo)}}" width="200"
                                            class="img-thumbnail">
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row d-none">
                                <div class="col-sm-6">
                                    <div class="mt-3">
                                        <label for="formFileFeatureSize" class="form-label">Logo Small
                                            <code></code></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="isax isax-gallery"></i></div>
                                            <input class="form-control" type="file" name="logo_sm">
                                        </div>
                                    </div>
                                    @if(isset($r->logo_sm) && $r->logo_sm!="")
                                    <div class="mt-3">
                                        <img src="{{asset('uploads/settings/'.$r->logo_sm)}}" width="200"
                                            class="img-thumbnail">
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mt-3">
                                        <label for="formFileFeatureSize" class="form-label">Favicon
                                            <code></code></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="isax isax-gallery"></i></div>
                                            <input class="form-control" type="file" name="favicon">
                                        </div>
                                    </div>
                                    @if(isset($r->favicon) && $r->favicon!="")
                                    <div class="mt-3">
                                        <img src="{{asset('uploads/settings/'.$r->favicon)}}" width="200"
                                            class="img-thumbnail">
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row d-none">
                                <div class="col-sm-4">
                                    <div class="mt-3">
                                        <label for="formFileFeatureSize" class="form-label">Login Page Logo
                                            <code></code></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="isax isax-gallery"></i></div>
                                            <input class="form-control" type="file" name="login_logo">
                                        </div>
                                    </div>
                                    @if(isset($r->login_logo) && $r->login_logo!="")
                                    <div class="mt-3">
                                        <img src="{{asset('uploads/settings/'.$r->login_logo)}}" width="200"
                                            class="img-thumbnail">
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row d-none">
                                <div class="col-sm-4">
                                    <div class="mt-3">
                                        <label for="formFileFeatureSize" class="form-label">Email Logo
                                            <code></code></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="isax isax-gallery"></i></div>
                                            <input class="form-control" type="file" name="email_logo">
                                        </div>
                                    </div>
                                    @if(isset($r->email_logo) && $r->email_logo!="")
                                    <div class="mt-3">
                                        <img src="{{asset('uploads/settings/'.$r->email_logo)}}" width="200"
                                            class="img-thumbnail">
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex space-between align-center">
                        <a href="{{route('admin.dashboard')}}" class="btn btn-transparent btn-rounded"><i class="ti ti-arrow-left"></i> Back</a>
                        <button class="btn btn-primary btn-rounded">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ URL::asset('/assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/pages/form-validation.init.js') }}"></script>


<!-- form advanced init -->
<script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#setting").addClass("mm-active");

        $(function(){
            fileNewUpload($('.fileupload:checked'));
        })
        $(".fileupload").on('change',function(){
            fileNewUpload($(this));
        });
        function fileNewUpload($this){
            console.log($this.val())
            var obj = $this.parent().parent().parent().parent();
            if($this.val() == "1"){
                obj.find('.newFile').show();
                $(".last_file_use").hide();
                $(".tender_file_use").hide();
            }else if($this.val() == "0"){
                $(".last_file_use").hide();
                $(".tender_file_use").show();
                obj.find('.newFile').hide();
            }else{
                $(".last_file_use").show();
                $(".tender_file_use").hide();
                obj.find('.newFile').hide();
            }
        }

    });
</script>

@endsection