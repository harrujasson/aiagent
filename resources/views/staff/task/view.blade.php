@extends('layouts.master')

@section('title') {{$title}} | {{$module}} @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') {{$module}} @endslot
@slot('title') {{$title}} @endslot
@slot('page_title') {{$task->title}} @endslot
@endcomponent

<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                @include('widget/notifications')
                <h4>{{$task->title}}</h4>
                <p>{{$task->description}}</p>
                @if($task->image)
                    <img src="{{asset('uploads/tasks/'.$task->image)}}" alt="Task image" class="img-fluid rounded" style="max-height:220px;">
                @endif
                <hr>
                <p><strong>Status:</strong> {{ucwords(str_replace('_',' ',$task->status))}}</p>
                <p><strong>Assigned Staff:</strong></p>
                @foreach($task->assignments as $assignment)
                    <span class="badge bg-light text-dark">{{$assignment->user->name ?? 'N/A'}} ({{$assignment->user->email ?? ''}})</span>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <h5 class="mb-3">My Comments</h5>
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    @if(Auth::user()->picture)
                        <img src="{{asset('uploads/profile/'.Auth::user()->picture)}}" alt="{{Auth::user()->name}}" class="rounded-circle me-2" width="38" height="38">
                    @else
                        <div class="rounded-circle bg-light text-dark d-flex align-items-center justify-content-center me-2" style="width:38px;height:38px;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <h6 class="mb-0">{{Auth::user()->name}}</h6>
                        <small class="text-muted">{{Auth::user()->email}}</small>
                    </div>
                </div>

                @if($task->status === 'completed')
                    <div class="alert alert-warning">
                        This task is completed. Commenting is disabled.
                    </div>
                @else
                    <form method="post" action="{{route('staff.task.comment_save', $task->id)}}">
                        @csrf
                        <div class="mb-2">
                            <textarea class="form-control" rows="4" name="comment" required placeholder="Write your comment here..."></textarea>
                        </div>
                        <button class="btn btn-primary btn-sm">Post Comment</button>
                    </form>
                @endif

                <hr>
                @forelse($comments as $comment)
                    <div class="border rounded p-2 mb-2">
                        <small class="badge bg-light text-dark mb-1">
                            {{$comment->user_id == auth()->id() ? 'My Comment' : 'Admin Comment'}}
                        </small>
                        <small class="text-muted d-block mb-1">{{date('d M, Y h:i A', strtotime($comment->created_at))}}</small>
                        <p class="mb-0">{{$comment->comment}}</p>
                    </div>
                @empty
                    <p class="mb-0 text-muted">No comments yet.</p>
                @endforelse
            </div>
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
