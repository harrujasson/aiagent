
@extends('layouts.master')

@section('title'){{$module}} @endsection
@section('css')
    <link href="{{ asset('build/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- DataTables -->
    <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('build/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('content')

@component('components.breadcrumb')
    @slot('li_1') {{$module}} @endslot
    @slot('title') {{$title}} @endslot
    @slot('page_title') {{$title}} @endslot
@endcomponent


<div class="row">
    <div class="col-xl-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Information</h4>
            </div>
            <div class="card-body">
                
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0 mt-0">
                        <tbody>
                            <tr>
                                <th scope="row">Name</th>
                                <td>{{$r->name}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Description</th>
                                <td>{!! $r->description !!}</td>
                            </tr>
                            <tr>
                                <th scope="row">Number of entry</th>
                                <td>{{$r->number_of_entry}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Winner Allowed</th>
                                <td>{{$r->winner_allow}}</td>
                            </tr>

                            <tr>
                                <th scope="row">Start Date</th>
                                <td>{{$r->start_date}}</td>
                            </tr>
                            <tr>
                                <th scope="row">End Date</th>
                                <td>{{$r->end_date}}</td>
                            </tr>

                            @if($r->picture!="")
                            <tr>

                                <td colspan="2"><img src="{{asset('uploads/giveaway/'.$r->picture)}}" width="200"></td>
                            </tr>
                            @endif

                            <tr>
                                <td colsapan="2" scope="row"><h3>Prize Includes</h3></td>

                            </tr>
                            @if(!$r->prizeinclude->isEmpty())
                            @foreach($r->prizeinclude as $prize)
                            <tr>
                                <th scope="row">Icon</th>
                                <td>{{$prize->icon ?? ''}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Title</th>
                                <td>{{$prize->title ?? ''}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Description</th>
                                <td>{{$prize->description ?? ''}}</td>
                            </tr>
                            @endforeach
                            @endif


                            <tr>
                                <td colsapan="2" scope="row"><h3>How it works</h3></td>

                            </tr>
                            @if(!$r->howitwork->isEmpty())
                            @foreach($r->howitwork as $work)

                            <tr>
                                <td colspan="2">{{$work->title ?? ''}}</td>
                            </tr>
                            @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex space-between align-center">
                    <a href="{{route('admin.giveaway.manage')}}" class="btn btn-transparent btn-rounded"><i class="ti ti-arrow-left"></i> Back</a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Enrolled Customers</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive single-filter-with-button">
                    <table  class="table align-middle table-nowrap dt-responsive nowrap w-100 table-striped table-bordered" id="datatable-inline">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 70px;">#</th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Enrolled Winner Customers</h4>
            </div>

            @if(!$r->is_winner_publish)
            <form id="winnerform" class="custom-validation" novalidate autocomplete="off" method="post" action="{{ route('admin.giveaway.publishwinner',$r->id) }}"  enctype="multipart/form-data">
            @csrf
            <div class="card-body">

            @include('widget/notifications')

                <div class="table-responsive single-filter-with-button">
                    <table id="winners" class="table align-middle table-nowrap dt-responsive nowrap w-100 table-striped table-bordered">
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex space-between align-center">
                    <button class="btn btn-primary btn-rounded publishWinner" type="button">Publish Winner</button>
                </div>

            </div>
            </form>
            @else
                <div class="card-body">
                    <div class="table-responsive single-filter-with-button">
                        <table  class="table align-middle table-nowrap dt-responsive nowrap w-100 table-striped table-bordered">

                            <tr>
                                <th>Date</th>
                                <th>Winner</th>
                            </tr>

                            @if(!$r->winners->isEmpty())
                            @foreach($r->winners as $winner)
                            <tr>
                                <td>{{date('m-d-Y h:i a',strtotime($winner->created_at))}}</td>
                                <td><a target="_blank" href="{{route('admin.customer.view',$winner->winner_id)}}">{{userInfo($winner->winner_id)}} {{userInfo($winner->winner_id,'last_name')}}</a></td>
                            </tr>
                            @endforeach
                            @endif
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('script')
<!-- Required datatable js -->
<script src="{{ URL::asset('build/libs/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('build/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('build/plugins/sweet-alert2/jquery.sweet-alert2.init.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#giveaway").addClass("mm-active");
        var limitwinner = '{{$r->winner_allow}}';

        var table = $('#datatable-inline').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            pageLength: 25,
            language: {
                search : '<i class="ti ti-search"></i>',
                searchPlaceholder: "Search by keyword..."
            },
            ajax: '{!! route('admin.giveaway.showAjaxListEnrolled',$r->id) !!}',
            columns: [
                { data: 'id', name: 'id'},
                { data: 'name', name: 'name'},
                { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }

            ],
            "order": [[0, 'desc'],]
        });




        $('body').on('click', '.addwinner', function () {
            var $this = $(this);
            var id = $this.data('id'); // from data-id
            var name = $this.data('name') || $this.text().trim();
            // Prevent duplicate row
            if ($('#winner_row_' + id).length) return;

            var existWinnr =parseInt($(".winnerinput").length);
            var totalAllowWinner =parseInt(limitwinner);
            if(existWinnr < totalAllowWinner){
            }else{
                alert("Only Allowed Winners: "+totalAllowWinner)
                return false;
            }
            var html = '';
            html += '<tr id="winner_row_' + id + '">';
            html += '  <td><strong>' + name + '</strong><input type="hidden" class="winnerinput" name="winners[]" value="' + id + '"></td>';
            html += '  <td><button type="button" class="remove_winner btn btn-default btn-sm" data-id="' + id + '">Remove Winner</button></td>';
            html += '</tr>';

            $('#winners').append(html);
        });

        $('body').on('click','.remove_winner',function(){
            var $this = $(this);
            var x = confirm('Are you sure you want to delete ?');
            if(x){
                $("#winner_row_"+$this.data('id')).remove();
            }
        });

        $(".publishWinner").click(function(){

            var x = confirm('Are you sure you want to publish winner ?, Once winner published, you can not chagne.')

            if(x == true){
                var existWinnr = $(".winnerinput").length;
                var existWinnr =parseInt($(".winnerinput").length);
                var totalAllowWinner =parseInt(limitwinner);
                if(existWinnr){
                    $("#winnerform").submit();
                }else{
                    alert('Please first choose winner')
                }
            }

        });
    });
</script>

@endsection