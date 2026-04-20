@extends('layouts.master')
@section('title') {{$title}} | {{$module}} @endsection
@section('css')
<style>
.error-message{
    color:red;
}
#back-to-details{
    margin-top: 15px;
}

input[name="cvc"]::placeholder {
    content: "CVV";
}
</style>
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') {{$module}} @endslot
@slot('title') {{$title}} @endslot
@slot('page_title') Subscription Buy@endslot
@endcomponent
        @include('widget/notifications')

        <div class="row">
            <div class="col-8 mx-auto">
                <div class="card">
                    <h5 class="card-header bg-transparent border-bottom text-uppercase">Input Credit Card Details</h5>

                    <div class="card-body">

                        <form id="payment-form" method="POST" action="{{ route('customer.subscriptions.buy_process',$package) }}" class="form-horizontal custom-validation" style="display: none;">
                            @csrf

                            <!-- Hidden fields for personal details -->
                            <input type="hidden" name="name" id="hidden-name" value="{{Auth::user()->name}}">
                            <input type="hidden" name="email" id="hidden-email" value="{{Auth::user()->email}}">
                            <input type="hidden" name="phone" id="hidden-phone" value="{{Auth::user()->phone}}">
                            <input type="hidden" name="street" id="hidden-street" value="{{Auth::user()->address}}">
                            <input type="hidden" name="city" id="hidden-city" value="{{Auth::user()->city}}">
                            <input type="hidden" name="state" id="hidden-state" value="{{Auth::user()->state}}">
                            <input type="hidden" name="zipcode" id="hidden-zipcode" value="{{Auth::user()->zipcode}}">
                            <input type="hidden" name="country" id="hidden-country">

                            <!-- Stripe Card Element -->
                            <div id="card-element" class="mb-3">
                                <!-- A Stripe Element will be inserted here. -->
                            </div>

                            <!-- Used to display form errors -->
                            <div id="card-errors" role="alert"></div>

                            <!-- Final submit button for Stripe payment -->
                            <button id="card-button" class="btn btn-primary btn-rounded waves-effect waves-light" type="submit">
                                Submit Payment
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

@endsection
@section('script')
<script src="https://js.stripe.com/v3/"></script>
<script>let stripe = Stripe('{{ config('services.stripe.STRIPE_KEY') }}');</script>
<script src="{{ asset('build/js/stripeiner.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#packages").addClass("mm-active");
    });
</script>
@endsection