@extends('layouts.master')

@section('title') {{$title}} | {{$module}} @endsection
@section('css')
<link href="{{ asset('build/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
<style>
.ctext-wrap {
    background: #ffffff;
    border-radius: 18px;
    padding: 24px;
    max-width: 100%;
    line-height: 1.6;
    color: #334155;
    box-shadow: 0 4px 18px rgba(15, 23, 42, 0.06);
    border: 1px solid #e2e8f0;
    font-family: "Inter", sans-serif;
}

/* Top Label */
.ctext-wrap .conversation-name {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 10px;
    font-weight: 600;
    color: #4f46e5;
    background: #e3e7f3;
    padding: 4px 10px;
    border-radius: 30px;
    margin-bottom: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Main Title */
.ctext-wrap h2 {
    font-size: 24px;
    line-height: 1.3;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 20px;
    border-bottom: 1px solid #e5e8fb;
    padding-bottom: 14px;
}

/* Section Titles */
.ctext-wrap h3 {
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
    margin-top: 22px;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Sub Titles */
.ctext-wrap h4 {
    font-size: 16px;
    font-weight: 600;
    color: #334155;
    margin-top: 20px;
    margin-bottom: 10px;
    padding-left: 10px;
    border-left: 3px solid #6366f1;
}

/* Lists */
.ctext-wrap ul {
    margin: 0;
    padding-left: 18px;
}

.ctext-wrap ul li {
    margin-bottom: 6px;
    font-size: 13px;
    color: #475569;
}

.ctext-wrap ul li:last-child {
    margin-bottom: 0;
}

/* Nested List */
.ctext-wrap ul ul {
    margin-top: 8px;
    padding-left: 18px;
}

.ctext-wrap ul ul li {
    margin-bottom: 6px;
    font-size: 13px;
}

/* Strong Text */
.ctext-wrap strong {
    color: #0f172a;
    font-weight: 600;
}

/* Card Feel for Sections */
.ctext-wrap h3 + ul, .ctext-wrap h4 + ul {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px 18px 16px 35px;
}

/* Responsive */
@media (max-width: 768px) {
    .ctext-wrap {
        padding: 18px;
    }

    .ctext-wrap h2 {
        font-size: 20px;
    }

    .ctext-wrap h3 {
        font-size: 16px;
    }

    .ctext-wrap h4 {
        font-size: 15px;
    }

    .ctext-wrap ul li {
        font-size: 13px;
    }
}
</style>
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
                        <ul class="list-unstyled mb-0" data-simplebar style="min-height: 410px;">

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


@endsection
