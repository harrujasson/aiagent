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
            <form method="post" action="{{ route('admin.task.new_save') }}" enctype="multipart/form-data">
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
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="4">{{ old('description') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Status <code>*</code></label>
                                <select class="form-control" name="status" required>
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="review">Review</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Task Image</label>
                                <input type="file" class="form-control" name="image" accept=".jpg,.jpeg,.png,.webp">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Assign Staff <code>*</code></label>
                        <select class="form-control" name="assigned_staff[]" multiple required>
                            @foreach($staffUsers as $staff)
                                <option value="{{$staff->id}}">{{$staff->name}} {{$staff->last_name}} ({{$staff->email}})</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Use Ctrl (or Command) to select multiple staff.</small>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{route('admin.task.manage')}}" class="btn btn-secondary">Back</a>
                    <button class="btn btn-primary">Save Task</button>
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
