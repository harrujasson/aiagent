@extends('layouts.master')
@section('title')
{{$title}}
@endsection
@section('css')
<style>
   .pricing-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    text-align: center;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.pricing-header {
    padding: 25px 20px;
    color: #fff;
    position: relative;
}

.price-tag {
    position: absolute;
    top: 0;
    background: #000;
    color: #fff;
    font-size: 13px;
    padding: 3px 12px;
    border-radius: 0 0 6px 6px;
    left: 50%;
    transform: translateX(-50%);
}

.plan-title {
    margin-top: 30px;
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 15px;
    color: #fff;
}

.entry-count {
    font-size: 72px;
    font-weight: 800;
    line-height: 1;
}

.entry-subtitle {
    margin-top: 5px;
    font-weight: 600;
    color: #ffffffc4;
}

.pricing-features {
    list-style: none;
    padding: 20px 30px;
}

.pricing-features li {
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.pricing-footer {
    padding: 20px;
}

.price-box {
    font-size: 38px;
    font-weight: 800;
}

.join-btn {
    background: #005689;
    display: inline-block;
    margin-top: 10px;
    padding: 8px 30px;
    border: 1px solid #005689;
    border-radius: 30px;
    font-weight: 600;
    text-decoration: none;
    color: #ffffff;
    font-family: sans-serif;
    transition: 0.3s;
}

.join-btn:hover {
    border: 1px solid #005689;
    color: #005689;
    background: #fff;
}

img.payments-logos {
    max-width: 340px;
}

ul.feature-list li {
    font-size: 14px;
    font-weight: 500;
    line-height: 1;
    position: relative;
    display: inline-block;
    padding: 5px 0 5px 25px;
    margin: 5px .5em;
}

ul.feature-list li:before {
    content: "";
    display: block;
    width: 20px;
    height: 20px;
    background: url(../images/check-primary.svg) no-repeat center center;
    background-size: 16px;
    position: absolute;
    left: 0;
    top: 0;
}

.subscribe-area-sec {
    background: #00b5ef2e;
}

.download-sec {
    background: #005689;
    padding: 60px 0;
}

h3.MullerNext {
    color: #fff;
    margin-bottom: 7px;
}

.next-draw {
    position: relative;
    z-index: 1;
    margin-top: -70px;
}

.next-draw.next-draw-hero {
    margin-top: -110px;
}

.feature-list-box {
    display: flex;
    justify-content: space-between;
    gap: 15px;
}

</style>
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1')
Admin
@endslot
@slot('title')
Dashboard
@endslot
@slot('page_title')
<span class="dashboard-title">Dashboard</span>
@endslot
@endcomponent

<div class="row mt-5">
   <div class="col-md-4">
         <div class="card mini-stats-wid">
            <div class="card-body">
               <div class="d-flex">
                     <div class="flex-grow-1">
                        <p class="text-muted fw-medium">Total Redeem Discounts</p>
                        <h4 class="mb-0">{{$total_redeem}}</h4>
                     </div>

                     <div class="flex-shrink-0 align-self-center">
                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                           <span class="avatar-title">
                                 <i class="fas fa-ticket-alt font-size-24"></i>
                           </span>
                        </div>
                     </div>
               </div>
            </div>
         </div>
   </div>

</div>


@endsection
@section('script')


<script type="text/javascript">
   $(document).ready(function() {
   });
   
</script>
@endsection

