@extends('layouts.master')

@section('title') {{$title}} | {{$module}} @endsection
@section('css')
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
                        <a href="{{route('admin.task.new')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap dt-responsive nowrap w-100 table-striped table-bordered" id="datatable-inline">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Assigned Staff</th>
                                <th>Created</th>
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
    <h2>{{$title}}</h2>
    <div class="row">
        <div class="top-filter mt-1 col-3">
            <label>Status Wise</label>
            <div class="input-group">
                <select class="form-control" id="statusinfo">
                    <option value="">All</option>
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="review">Review</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
        </div>
        <div class="top-filter mt-1 col-3">
            <label>Assigned Staff</label>
            <div class="input-group">
                <select class="form-control" id="staffinfo">
                    <option value="">All</option>
                    @foreach($staffUsers as $staff)
                        <option value="{{$staff->id}}">{{$staff->name}} {{$staff->last_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="table_add_btn"></div>
@endsection

@section('script')
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
            responsive: false,
            language: {
                search : '<i class="ti ti-search"></i>',
                searchPlaceholder: "Search by title..."
            },
            ajax: {
                url: '{!! route('admin.task.showAjaxList') !!}',
                data: function(d){
                    d.status = $('#statusinfo').val(),
                    d.assigned_staff = $('#staffinfo').val()
                }
            },
            columns: [
                { data: 'id', name: 'id'},
                { data: 'title', name: 'title'},
                { data: 'status', name: 'status', orderable: false },
                { data: 'assigned_staff', name: 'assigned_staff', orderable: false, searchable: false },
                { data: 'created_at', name: 'created_at'},
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });

        $("#task").addClass("mm-active");
        $(".table_heading").appendTo("#datatable-inline_wrapper .row:first-child > .col-md-6:first-child");
        $(".table_add_btn").appendTo("#datatable-inline_wrapper .row:first-child > .col-md-6:last-child .dataTables_filter");
        $("body").on("change","#statusinfo, #staffinfo",function(){
            $('#datatable-inline').DataTable().draw();
        });
    });
</script>
@endsection
