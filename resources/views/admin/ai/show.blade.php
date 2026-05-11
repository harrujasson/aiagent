@extends('layouts.master')

@section('title') {{$title}} | {{$module}} @endsection
@section('css')
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
        <div class="w-100 user-chat">
            <div class="card">
                <div class="p-4 border-bottom ">
                    <div class="row">
                        <div class="col-md-4 col-9">
                            <h5 class="font-size-15 mb-1">AI Agent</h5>
                            <p class="text-muted mb-0"><i class="mdi mdi-circle text-success align-middle me-1"></i> Active</p>
                        </div>
                    </div>
                </div>


                <div>
                    <div class="chat-conversation p-3">
                        <ul class="list-unstyled mb-0 airesponse" data-simplebar style="min-height: 410px;">

                        </ul>
                    </div>
                    <div class="p-3 chat-input-section">
                        <div class="row">
                            <div class="col">
                                <div class="position-relative">
                                    <input type="text" class="form-control chat-input" id="query_input" placeholder="Enter Query...">
                                    <div class="chat-input-links" id="tooltip-container">
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item"><a href="javascript: void(0);" title="MIC"><i class="mdi mdi-microphone-settings"></i></a></li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="send_query btn btn-primary btn-rounded chat-send w-md waves-effect waves-light">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
 <!-- Required datatable js -->
<script src="{{ asset('build/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('build/plugins/sweet-alert2/jquery.sweet-alert2.init.js') }}"></script>
<script src="{{ asset('build/libs/simplebar/simplebar.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#ai").addClass("mm-active");

        $(".send_query").click(function(){
            var $this = $(this);
            $this.text('Sending..')
            let queryinput = $("#query_input");
            if(queryinput.val() == ""){
                alert('Error!', 'Please enter your query.', 'error');
            }



            let querySend=`<li class="right">
                                <div class="conversation-list">
                                    <div class="ctext-wrap">
                                        <div class="conversation-name">Your Request</div>
                                        <p>
                                            <strong>${queryinput.val()}</strong>
                                        </p>
                                    </div>
                                </div>
                            </li>`;
            $(".airesponse").append(querySend)

            $.ajax({
                method: 'POST',
                data: {
                    _token:$('meta[name="csrf-token"]').attr('content'),
                    query:queryinput.val()
                },
                url:'/admin/report/query',
                success:function(res){
                    $this.text('Send')
                    if(res.success){
                        let html = `
                        <li>
                            <div class="conversation-list">
                                <div class="ctext-wrap">
                                    <div class="conversation-name">AI Agent Response</div>
                                    ${res.data}
                                </div>
                            </div>
                        </li>
                        `;
                        queryinput.val('');
                        $(".airesponse").append(html);

                    }else{
                        queryinput.val('');
                        alert('Error!', res.message, 'error');
                    }
                },
                error: function () {
                    $this.text('Send')
                    queryinput.val('');
                    alert('Error!', 'Something went wrong.', 'error');
                }
            })

        });
    });

</script>

@endsection
