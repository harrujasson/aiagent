@extends('layouts.master')

@section('title') {{$title}} | {{$module}} @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') {{$module}} @endslot
@slot('title') {{$title}} @endslot
@slot('page_title') {{$title}} @endslot
@endcomponent

<div class="card">
    <div class="card-body">
        @include('widget/notifications')
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr>
                            <td>{{$task->id}}</td>
                            <td>{{$task->title}}</td>
                            <td>{{ucwords(str_replace('_',' ',$task->status))}}</td>
                            <td>{{date('Y-m-d', strtotime($task->created_at))}}</td>
                            <td><a href="{{route('staff.task.view', $task->id)}}" class="btn btn-sm btn-info">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No assigned tasks found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $("#task").addClass("mm-active");
    });
</script>
@endsection
