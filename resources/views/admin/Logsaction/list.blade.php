@extends('layouts.master')
@section('title') {{$title}} | {{$module}} @endsection
@section('css')
<!-- DataTables -->
<link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('build/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('build/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') {{$module}} @endslot
@slot('title') {{$title}} @endslot
@slot('page_title') <span>{{$title}}</span>
<span class="top-filter-wrapper">
   <span class="filter-col filter-date">
      <!-- <label>Date</label> -->
      <div class="input-group">
         <div id="datepicker3">
            <input type="text" value="{{date('Y-m-01')}}" id="from" class="form-control" placeholder="YYYY-MM-DD" data-provide="datepicker" data-date-container='#datepicker3' data-date-format="yyyy-mm-dd" data-date-multidate="false" data-date-autoclose="true" data-orientation="auto">
         </div>
         <div class="saprator">-</div>
         <div id="datepicker4">
            <input type="text" value="{{date('Y-m-t')}}" id="to" class="form-control" placeholder="YYYY-MM-DD" data-provide="datepicker" data-date-container='#datepicker4' data-date-format="yyyy-mm-dd" data-date-multidate="false" data-date-autoclose="true" data-orientation="auto">
         </div>
      </div>
   </span>
   <span class="filter-col filter-buttons top-flter-btn">
      <div class="input-group">            
         <button type="button" class="btn btn-info" id="searchfilter">Go</button>
      </div>
   </span>
</span>
@endslot
@endcomponent
<div class="row">
   <div class="col-12">
   <div class="card">
         <div class="card-body commission-card-body">
            @include('widget/notifications')
            <form method="post" action="javascript:void(0);" id="list_form">
               @csrf
               <div class="table-responsive">
                  <table  class="table align-middle table-nowrap dt-responsive nowrap w-100 table-striped table-bordered" id="datatable-inline">
                     <thead>
                        <tr>
                           <th class="select_record"> 
                              <input  type="checkbox" id="select_all" name="select_all">
                              <label  for="select_all">
                              All
                              </label>
                           </th>
                           <th>#</th>
                           <th>Action By</th>
                           <th>Module</th>
                           <th>Action</th>
                           <th>Message</th>
                           <th>Created Date</th>
                        </tr>
                     </thead>
                  </table>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<!--Filters-->
<div class="table_heading">
   <div class="top-filter">
      <div class="filter-col search-filter"></div>
      <div class="filter-col">
         <label>Upload By</label>
         <div class="input-group" >
            <select class="form-control" id="userby">
               <option value="">All</option>
               @if(!empty($users))
               @foreach($users as $user)
               <option value="{{$user->id}}">
                  {{(Auth::id() == $user->id ? "Self":$user->name.' '.$user->last_name)}}
               </option>
               @endforeach
               @endif
            </select>
         </div>
      </div>
      <div class="filter-col filter-buttons">
         <label>&nbsp;</label>
         <div class="input-group">            
            <button type="button" class="btn btn-info" id="searchfilter">Search</button>
            <button type="button" class="btn btn-warning" id="searchclear">Clear</button>
            <button type="button" class="delete_record btn btn-danger"> Delete </button>
         </div>
      </div>
   </div>
</div>


@endsection
@section('script')
<!-- Required datatable js -->
<script src="{{ URL::asset('build/libs/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('build/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('build/plugins/sweet-alert2/jquery.sweet-alert2.init.js') }}"></script>
<script src="{{ asset('build/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::asset('/build/libs/parsleyjs/parsleyjs.min.js') }}"></script>
<script src="{{ URL::asset('/build/js/pages/form-validation.init.js') }}"></script>
<script type="text/javascript">
   $(document).ready(function() {  
       $(function(){
       });  
       var table = $('#datatable-inline').DataTable({
           processing: true,
           serverSide: true,
           pageLength: 50,
           responsive: false,
           language: {
               search : '<i class="ti ti-search"></i>',
               searchPlaceholder: "Search"
           },
           ajax: {
               url:'{!! route('admin.log.showAjaxList') !!}',
               data:function(d){
                   d.invfrom = $('#from').val(),
                   d.invto = $('#to').val(),
                   d.userby = $('#userby').val(),
                   d.reference = $('#reference_filter').val()
               }
           },
           columns: [
               { data: 'select_all', name: 'select_all',orderable: false, searchable: false},
               { data: 'id', name: 'id'},
               { data: 'uploaded_by', name: 'uploaded_by',orderable: false, searchable: false},
               { data: 'module_name', name: 'module_name' },
               { data: 'action', name: 'action' },
               { data: 'message', name: 'message' },
               { data: 'created_at', name: 'created_at'}

           ],
           initComplete: function (settings) {
           },
           "order": [[1, 'desc']]
       });
       $("#log").addClass("mm-active");
       $(".table_heading").appendTo("#datatable-inline_wrapper .row:first-child > .col-md-6:first-child") ;
       $("#datatable-inline_filter").appendTo("#datatable-inline_wrapper .row:first-child > .col-md-6:first-child .filter-col:first-child");
       $(".table_add_btn").appendTo("#datatable-inline_wrapper .row:first-child > .col-md-6:last-child .dataTables_filter"); 
       $("body").on("click","#searchfilter",function(){
           $('#datatable-inline').DataTable().draw();

       });
       $("body").on("click","#searchclear",function(){
           $("#reference_filter").val('');
           $("#from").val('');
           $("#to").val('');
           $('#userby').val('');
           $('#datatable-inline').DataTable().draw();

       });
       /***Delete Records */
       $("#select_all").click(function(){
           if($(this).is(':checked')){
               $(".select_field").prop('checked',true);
           }else{
               $(".select_field").prop('checked',false);
           }
       });
       $(".delete_record").click(function(){
           var x = confirm('Are you sure you want to delete?');
           if(x){
               $.ajax({
                   type:'POST',
                   data:$("#list_form").serialize(),
                   url:'{!! route('admin.log.deletall') !!}',
                   success:function(res){
                       if(res == 2){
                           alert("Please select atleast one record");
                       }
                       else if(res == 1){
                           $("#select_all").prop("checked",false);
                           $('#datatable-inline').DataTable().draw();
                       }
                   },
                   error:function(){
                       alert('Something went wrong, Please try after some time');
                   }
               })
           }else{
               $(".select_field").prop('checked',false);
               $("#select_all").prop('checked',false);
               return false;
           }
       });
       /***End Delete Records */
   });
</script>
@endsection