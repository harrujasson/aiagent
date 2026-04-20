@extends('layouts.master')
@section('title')
{{$title}}
@endsection
@section('css')
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1')
Admin
@endslot
@slot('title')
Dashboard
@endslot
@slot('page_title')
<span class="dashboard-title">Dashboard</span>
@endslot
@endcomponent

<div class="row mt-5">
   <div class="col-3">
   <a href="{{route('admin.profile')}}" class="btn btn-primary">My profile</a>
   </div>

</div>
@endsection
@section('script')


<script type="text/javascript">
   $(document).ready(function() {
   });
   
</script>
@endsection

