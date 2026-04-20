@extends('layouts.master')

@section('title') {{$title}} | {{$module}} @endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('build/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') {{$module}} @endslot
@slot('title') Package @endslot
@slot('page_title')Package @endslot
@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">           
            <div class="card-body">
                @include('widget/notifications')
                <div class="table-responsive single-filter-with-button">
                    <table  class="table align-middle table-nowrap dt-responsive nowrap w-100 table-striped table-bordered" id="datatable-inline">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 70px;">#</th>
                                <th>Discount Name</th>
                                <th>Platform</th>
                                <th>Discount Code</th>
                                <th>Discount</th>
                                <th>Date Redeem</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="table_heading">
    <h2>{{$title}}</h2>
</div>
<div class="table_add_btn">
</div>

@endsection

@section('script')
 <!-- Required datatable js -->
<script src="{{ URL::asset('build/libs/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('build/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('build/plugins/sweet-alert2/jquery.sweet-alert2.init.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
       var table = $('#datatable-inline').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            pageLength: 25,
            language: {
                search : '<i class="ti ti-search"></i>',
                searchPlaceholder: "Search by name, price..."
            },
            ajax: '{!! route('customer.coupon_redeem_ajax') !!}',
            columns: [
                { data: 'id', name: 'id'},
                { data: 'name', name: 'name'},
                { data: 'platform', name: 'platform' },
                { data: 'coupon_code', name: 'coupon_code' },
                { data: 'discount', name: 'discount' },
                { data: 'created_at', name: 'created_at' }
            ],
            "order": [[0, 'desc'],]
        });
        $("#coupons").addClass("mm-active");
        $(".table_heading").appendTo("#datatable-inline_wrapper .row:first-child > .col-md-6:first-child"); 
        $(".table_add_btn").appendTo("#datatable-inline_wrapper .row:first-child > .col-md-6:last-child .dataTables_filter"); 
    });
</script>

@endsection
