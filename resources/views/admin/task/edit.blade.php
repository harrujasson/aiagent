@extends('layouts.master')

@section('title') {{$title}} | {{$module}} @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') {{$module}} @endslot
@slot('title') {{$title}} @endslot
@slot('page_title') Task Management @endslot
@endcomponent

<div class="row">
    <div class="col-xl-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{$title}}</h5>
            </div>
            @include('widget/notifications')
            <form method="post" action="{{ route('admin.task.edit_save', $task->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label>Task Title <code>*</code></label>
                        <input type="text" class="form-control" name="title" value="{{ old('title', $task->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="4">{{ old('description', $task->description) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Status <code>*</code></label>
                                <select class="form-control" name="status" required>
                                    <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="review" {{ old('status', $task->status) == 'review' ? 'selected' : '' }}>Review</option>
                                    <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Task Image</label>
                                <input type="file" class="form-control" name="image" accept=".jpg,.jpeg,.png,.webp">
                            </div>
                            @if($task->image)
                                <div class="mb-3">
                                    <img src="{{asset('uploads/tasks/'.$task->image)}}" alt="Task image" class="img-fluid rounded" style="max-height:120px;">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Assign Staff <code>*</code></label>
                        <select class="form-control" name="assigned_staff[]" multiple required>
                            @foreach($staffUsers as $staff)
                                <option value="{{$staff->id}}" {{ in_array($staff->id, old('assigned_staff', $assignedStaffIds)) ? 'selected' : '' }}>
                                    {{$staff->name}} {{$staff->last_name}} ({{$staff->email}})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Use Ctrl (or Command) to select multiple staff.</small>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{route('admin.task.manage')}}" class="btn btn-secondary">Back</a>
                    <button class="btn btn-primary">Update Task</button>
                </div>
            </form>
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
