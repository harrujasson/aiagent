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

                <hr>
                <h6>Update Status</h6>
                <form method="post" action="{{route('admin.task.status_update', $task->id)}}">
                    @csrf
                    <div class="mb-2">
                        <select class="form-control" name="status">
                            <option value="pending" {{$task->status == 'pending' ? 'selected' : ''}}>Pending</option>
                            <option value="in_progress" {{$task->status == 'in_progress' ? 'selected' : ''}}>In Progress</option>
                            <option value="review" {{$task->status == 'review' ? 'selected' : ''}}>Review</option>
                            <option value="completed" {{$task->status == 'completed' ? 'selected' : ''}}>Completed</option>
                        </select>
                    </div>
                    <button class="btn btn-primary btn-sm">Update</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <h5 class="mb-3">Staff Comments</h5>
        @forelse($task->assignments as $assignment)
            @php
                $staff = $assignment->user;
                $staffComments = $comments->filter(function ($comment) use ($assignment) {
                    return $comment->user_id == $assignment->user_id || $comment->comment_for_user_id == $assignment->user_id;
                });
            @endphp
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        @if($staff && $staff->picture)
                            <img src="{{asset('uploads/profile/'.$staff->picture)}}" alt="{{$staff->name}}" class="rounded-circle me-2" width="38" height="38">
                        @else
                            <div class="rounded-circle bg-light text-dark d-flex align-items-center justify-content-center me-2" style="width:38px;height:38px;">
                                {{ $staff && $staff->name ? strtoupper(substr($staff->name, 0, 1)) : '?' }}
                            </div>
                        @endif
                        <div>
                            <h6 class="mb-0">{{$staff->name ?? 'N/A'}}</h6>
                            <small class="text-muted">{{$staff->email ?? ''}}</small>
                        </div>
                    </div>

                    @forelse($staffComments as $comment)
                        <div class="border rounded p-2 mb-2">
                            <small class="badge bg-light text-dark mb-1">
                                {{$comment->user_id == $assignment->user_id ? 'Staff Comment' : 'Admin Comment'}}
                            </small>
                            <small class="text-muted d-block mb-1">{{date('d M, Y h:i A', strtotime($comment->created_at))}}</small>
                            <p class="mb-0">{{$comment->comment}}</p>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No comments from this staff yet.</p>
                    @endforelse

                    <hr>
                    <h6 class="mb-2">Comment to {{$staff->name ?? 'Staff'}}</h6>
                    <form method="post" action="{{route('admin.task.comment_staff_save', ['id' => $task->id, 'staffId' => $assignment->user_id])}}">
                        @csrf
                        <div class="mb-2">
                            <textarea class="form-control" name="comment" rows="3" required placeholder="Write comment for this staff..."></textarea>
                        </div>
                        <button class="btn btn-primary btn-sm">Post Comment</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="card">
                <div class="card-body">
                    <p class="mb-0 text-muted">No staff assigned.</p>
                </div>
            </div>
        @endforelse
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
