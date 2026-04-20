@extends('layouts.master')

@section('title') {{$title}} | {{$module}} @endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('build/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') {{$module}} @endslot
@slot('title') {{$title}} @endslot
@slot('page_title') {{$title}} @endslot
@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card manage-user-card">
            <div class="card-body">
                @include('widget/notifications')
                <div class="row mb-2">
                    <div class="col-4 mx-auto">
                        <a href="{{route('admin.staff.new_user')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>

                    </div>
                </div>
                <div class="table-responsive">
                <table  class="table align-middle table-nowrap dt-responsive nowrap w-100 table-striped table-bordered" id="datatable-inline">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Role</th>
                            <th>E-mail</th>
                            <th>Telephone</th>
                            <th>Register Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
                </div>  
            </div>
        </div>
    </div>
</div>

<div class="table_heading">
    <h2 >{{$title}}</h2>

    <div class="row">
        <div class="top-filter mt-1 col-3">
            <label>Status Wise</label>
            <div class="input-group" >
                <select class="form-control" id="statusinfo">
                    <option value="">All</option>
                    <option value="1">Active</option>
                    <option value="0">In-Active</option>
                </select>
            </div>
        </div>
        <div class="top-filter mt-1 col-3">
            <label>Role Wise</label>
            <div class="input-group" >
                <select class="form-control" id="roleinfo">
                    <option value="">All</option>
                    <option value="Admin">Admin</option>
                    <option value="Accountant">Accountant</option>
                    <option value="Manager">Manager</option>
                    <option value="Staff">Staff</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="table_add_btn">
</div>

@endsection

@section('script')
 <!-- Required datatable js -->
<script src="{{ asset('build/libs/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('build/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('build/plugins/sweet-alert2/jquery.sweet-alert2.init.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
       var table = $('#datatable-inline').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            pageLength: 25,
            responsive:false,
            language: {
                search : '<i class="ti ti-search"></i>',
                searchPlaceholder: "Search by name, email..."
            },
            ajax: {
                url:'{!! route('admin.staff.showAjaxList') !!}',
                data:function(d){
                    d.status = $('#statusinfo').val(),
                    d.role_type = $('#roleinfo').val()
                }
            },
            columns: [
                { data: 'id', name: 'id'},
                { data: 'picture', name: 'picture', orderable: false, searchable: false },
                { data: 'name', name: 'name'},
                { data: 'last_name', name: 'last_name'},
                { data: 'role_type', name: 'role_type'},
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'created_at', name: 'created_at' },
                { data: 'status', name: 'status',orderable: false },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
        $("#staff").addClass("mm-active");
        $(".table_heading").appendTo("#datatable-inline_wrapper .row:first-child > .col-md-6:first-child");
        $(".table_add_btn").appendTo("#datatable-inline_wrapper .row:first-child > .col-md-6:last-child .dataTables_filter");
        $("body").on("change","#statusinfo, #roleinfo ",function(){
            $('#datatable-inline').DataTable().draw();
        });

    });
</script>

@endsection
