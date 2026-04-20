@extends('layouts.master')

@section('title') {{$title}} | {{$module}} @endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') {{$module}} @endslot
@slot('title') {{$title}} @endslot
@slot('page_title') Notifications @endslot
@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">                
                @include('widget/notifications')
                <table  class="table align-middle table-nowrap dt-responsive nowrap w-100 table-striped table-bordered" id="datatable-inline">
                    <thead class="hide">
                        <th>Description</th>
                        <th>status</th>
                        <th>action</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div>
                                        <img class="rounded-circle avatar-sm" src="{{ asset('assets/images/users/avatar-2.jpg') }}">
                                    </div>
                                    <div>
                                        <h5 class="font-size-14 mb-1">You have new message from Lukie <i class="mdi mdi-circle text-violet align-middle me-1"></i></h5>
                                        <p class="text-muted mb-0">You have a new message in the conversation from Lukie Willium</p>
                                    </div>
                                </div>
                            </td>
                            <td><p class="text-violet mb-0">New</p></td>
                            <td>
                                <a href="#" class="on-default"><i class="ti ti-eye"></i></a>
                                <a href="javascript:void(0);" data-url="" class="on-default sa-warning"><i class="ti ti-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div>
                                        <img class="rounded-circle avatar-sm" src="{{ asset('assets/images/users/avatar-2.jpg') }}">
                                    </div>
                                    <div>
                                        <h5 class="font-size-14 mb-1">You have new message from Lukie </h5>
                                        <p class="text-muted mb-0">You have a new message in the conversation from Lukie Willium</p>
                                    </div>
                                </div>
                            </td>
                            <td><p class="text-muted mb-0">3 Days ago</p></td>
                            <td>
                                <a href="#" class="on-default"><i class="ti ti-eye"></i></a>
                                <a href="javascript:void(0);" data-url="" class="on-default sa-warning"><i class="ti ti-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div>
                                        <img class="rounded-circle avatar-sm" src="{{ asset('assets/images/users/avatar-2.jpg') }}">
                                    </div>
                                    <div>
                                        <h5 class="font-size-14 mb-1">You have new message from Lukie </h5>
                                        <p class="text-muted mb-0">You have a new message in the conversation from Lukie Willium</p>
                                    </div>
                                </div>
                            </td>
                            <td><p class="text-muted mb-0">3 Days ago</p></td>
                            <td>
                                <a href="#" class="on-default"><i class="ti ti-eye"></i></a>
                                <a href="javascript:void(0);" data-url="" class="on-default sa-warning"><i class="ti ti-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div>
                                        <img class="rounded-circle avatar-sm" src="{{ asset('assets/images/users/avatar-2.jpg') }}">
                                    </div>
                                    <div>
                                        <h5 class="font-size-14 mb-1">You have new message from Lukie</h5>
                                        <p class="text-muted mb-0">You have a new message in the conversation from Lukie Willium</p>
                                    </div>
                                </div>
                            </td>
                            <td><p class="text-muted mb-0">3 Days ago</p></td>
                            <td>
                                <a href="#" class="on-default"><i class="ti ti-eye"></i></a>
                                <a href="javascript:void(0);" data-url="" class="on-default sa-warning"><i class="ti ti-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="table_heading">
    <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
        <li class="nav-item">
            <a class="nav-link active font-size-16" data-bs-toggle="tab" href="#basic" role="tab">
                <span class="d-sm-block">All</span> 
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link font-size-16" data-bs-toggle="tab" href="#biography" role="tab">
                <span class="d-sm-block">New</span> 
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link font-size-16" data-bs-toggle="tab" href="#activities" role="tab">
                <span class="d-sm-block">Unread</span> 
            </a>
        </li>
    </ul>
</div>
<div class="table_add_btn">
    <a href="#" class="table_head_btn">Mark all as read</a>
</div>

@endsection

@section('script')
 <!-- Required datatable js -->
<script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweet-alert2/jquery.sweet-alert2.init.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
       var table = $('#datatable-inline').DataTable({
            lengthChange: false,
            pageLength: 25,
            responsive: true,
            language: {
                search : '<i class="ti ti-search"></i>',
                searchPlaceholder: "Search by name, email..."
            }
        });
        $("#staff").addClass("mm-active");
        $(".table_heading").appendTo("#datatable-inline_wrapper .row:first-child > .col-md-6:first-child"); 
        $(".table_add_btn").appendTo("#datatable-inline_wrapper .row:first-child > .col-md-6:last-child .dataTables_filter"); 
    });
</script>

@endsection
