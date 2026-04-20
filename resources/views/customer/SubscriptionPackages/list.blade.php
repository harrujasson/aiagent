@extends('layouts.master')
@section('title') {{$title}} | {{$module}} @endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') {{$module}} @endslot
@slot('title') {{$title}} @endslot
@slot('page_title') 
<span>Packages</span>

 @endslot
@endcomponent

        @include('widget/notifications')

            <div class="row customer-package-list mb-4">
            @if(!empty($package))
            @foreach($package as $p)
                <div class="col-md-4 col-12 mb-4">
                    <div class="card h-100">
                        <div class="card-body p-4">

                            <div class="pricing-plan">
                            <div class="pricing-plan-inner">
                            <div class="plan-head-bx">
                                <h2 class="Core-title">{{$p->name}} @if($active_package == $p->id) <span class="badge badge-soft-success">Active</span> @endif</h2>
                                <h4 class="Core-title">Plan includes :</h4>
                                <h3 class="price"><strong>{!! currency() !!}{{$p->price}}</strong></h3>

                            </div>
                                <div class="list-feature">
                                    <ul>
                                    <li class="features_added">Number of giveaway {{$p->ticket_allow}}</li>
                                        @php
                                            $addedFeatures = [];
                                            $notAddedFeatures = [];
                                        @endphp

                                        @foreach($package_features as $feature)
                                            @php
                                                if (in_array($feature->name, $p->features)) {
                                                    $addedFeatures[] = $feature->name;  // Store added features
                                                } else {
                                                    $notAddedFeatures[] = $feature->name;  // Store not added features
                                                }
                                            @endphp
                                        @endforeach

                                        <!-- Loop through and display features that are added -->
                                        @foreach($addedFeatures as $feature)
                                            <li class="features_added">{{ $feature }}</li>
                                        @endforeach

                                        <!-- Loop through and display features that are not added -->
                                        @foreach($notAddedFeatures as $feature)
                                            <li class="features_not_added">{{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                </div>

                                @if($active_subscription=="")
                                <a href="{{route('customer.subscriptions.buy',encode($p->id))}}" class="btn btn-primary"> Buy Now</a>
                                @else
                                    @if($active_package !=$p->id)
                                    <a  class=" btn  choose-plan-btn upgrade-subscription btn-primary" data-id="{{$p->id}}"  data-upgrade-price-id="{{$p->stripe_id}}">
                                    Update
                                    </a>
                                    @else
                                    @endif
                                @endif

                               
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @endif
            </div>

<!-- Modal -->
<div id="cancelSubscriptionModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Subscription Cancel Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('customer.subscriptions.request_cancel') }}">
                    @csrf
                    <div class="mb-3" bis_skin_checked="1">
                        <label for="recipient-name" class="col-form-label">Reason for Cancellation</label>
                        <textarea name="reason" class="form-control"></textarea>
                    </div>
                    <input type="hidden" name="subscription_id" id="subscription_id">
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
 <!-- Required datatable js -->

 <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweet-alert2/jquery.sweet-alert2.init.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.cancel-subscription').on('click', function(){
            var sub_id = $(this).data('cancel-price-id');
            $('#subscription_id').val(sub_id);
            $('#cancelSubscriptionModal').modal('show');
        });
    });


    $(document).ready(function() {
        $(".choose-plan-btn").on("click", function(event) {
            event.preventDefault();
            const $button = $(this);


            // Check if the button has the correct class for API action
            if ($button.hasClass("upgrade-subscription") || $button.hasClass("downgrade-subscription")) {
                $(this).html('Updating package <i class="bx bx-hourglass bx-spin font-size-16 align-middle me-2 loader" ></i>');
                // Gather data from data attributes
                const id = $button.data("id");
                const upgradePriceId = $button.data("upgrade-price-id");
                // Define the data to send to the API
                const requestData = {
                    productId: upgradePriceId
                };

                // Send the data using jQuery AJAX
                $.ajax({
                    url:'{!! route('customer.subscriptions.update_subscription') !!}',
                    type: 'POST',
                    data: JSON.stringify(requestData),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            alert("Subscription updated successfully!");
                            setTimeout(() => {
                                window.location.reload(true);
                            }, 500);
                        } else {
                            alert("Failed to update subscription.");
                            setTimeout(() => {
                                window.location.reload(true);
                            }, 500);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                        alert("An error occurred while updating the subscription.");
                        setTimeout(() => {
                            window.location.reload(true);
                        }, 500);
                    }
                });
            }
        });
    });

</script>
@endsection