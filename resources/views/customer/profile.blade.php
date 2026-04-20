
@extends('layouts.master')

@section('title'){{$module}} @endsection
@section('css')
    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

@component('components.breadcrumb')
    @slot('li_1') {{$module}} @endslot
    @slot('title') {{$title}} @endslot
    @slot('page_title') {{$title}} @endslot
@endcomponent


<div class="row">
    <div class="col-12 col-xl-6">
        <div class="card overflow-hidden profile-card">
            <div class="bg-primary bg-soft">
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                        <img src="{{ asset('build/images/profile-img.png') }}" alt="" class="img-fluid mt-4">
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="avatar-md profile-user-wid mb-3 customer-user-profile">
                            @if(!empty($r->picture))
                            <img src="{{ asset('uploads/profile/'.$r->picture) }}" alt="" class="img-thumbnail rounded-circle">
                            @else
                            <img src="{{ asset('build/images/users/blank.png') }}" alt="" class="img-thumbnail rounded-circle">
                            @endif
                        </div>
                        <h5 class="font-size-15 text-truncate">{{$r->name.' '.$r->last_name}}</h5>
                        <p class="text-muted mb-0 text-truncate">{{roleName($r->role)}}</p>
                    </div>

                    <div class="col-sm-8">
                        
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <div class="btn-set">
                            <a href="{{route('customer.profile-edit')}}" class="btn btn-primary-soft btn-rounded"><i class="ti ti-pencil-minus"></i> Edit
                                Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="col-12 col-xl-6">        
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Basic Information</h4>
            </div>
            <div class="card-body">
                
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0 mt-0">
                        <tbody>
                            <tr>
                                <th scope="row">Full Name</th>
                                <td>{{$r->name.' '.$r->last_name}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Email Address</th>
                                <td>{{$r->email}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Phone Number</th>
                                <td>{{$r->phone}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Location</th>
                                <td>{{$r->address.', '.$r->city.', '.$r->state.', '.$r->country. ' - '.$r->zipcode }}</td>
                            </tr>                  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if(!empty($r->subscripiton))
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Subcription </h4>
            </div>
            <div class="card-body">
                
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0 mt-0">
                        <tbody>

                            <tr>
                                <th scope="row">Plan</th>
                                <td>{{$r->subscripiton->package->name ?? ''}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Price</th>
                                <td>{!! currency() !!}{{$r->subscripiton->package->price ?? ''}}</td>
                            </tr> 
                             <tr>
                                <th scope="row">Status</th>
                                <td>{{$r->subscripiton->stripe_status ?? ''}}</td>
                            </tr>  
                            <tr>
                                <th scope="row">Start Date</th>
                                <td>{{$r->subscripiton->current_period_start ?? ''}}</td>
                            </tr> 
                            <tr>
                                <th scope="row">Duration</th>
                                <td>{{$r->subscripiton->current_period_end ?? ''}}</td>
                            </tr>


                            <tr>
                                <th scope="row">Duration</th>
                                <td>{{$r->subscripiton->current_period_end ?? ''}}</td>
                            </tr>
                            @if($r->subscripiton->stripe_status == 'active')
                            <tr>
                                <td><a href="{{route('customer.cancel_subscription')}}" class="btn btn-danger btn-sm">Cancel Subscription</a></td>
                            </tr>
                            @else

                            <tr>
                                <td><span class="badge badge-soft-success">{{strtoupper($r->subscripiton->stripe_status)}}</span></td>
                            </tr>

                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        @endif

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Invoice</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive single-filter-with-button">
                    <table  class="table align-middle table-nowrap dt-responsive nowrap w-100 table-striped table-bordered" id="datatable-inline">
                        <thead>
                            <tr>

                                <th>Download</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        @if(!empty($invoice))
                        @foreach($invoice as $in)
                        <tr>
                            <td><a href="{{asset('/uploads/invoice/'.$in->invoice_filename)}}" download>Download</a></td>
                            <td>{{date('m-d-Y',strtotime($in->created_at))}}</td>
                        </tr>
                        @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $("#myprofile").addClass("mm-active");
    });
</script>

@endsection