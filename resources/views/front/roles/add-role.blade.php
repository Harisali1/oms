@extends('front.layouts.Dispatch-layout')

@section('page-title',"Role Create")

@section('css')
	<style>
		.select2-search__field{
			padding:17px!important;
		}
	</style>
@stop

@section('content')
<main id="main" class="page-summary" data-page="summary">
<div class="pg-container container-fluid">
{{--@include('front.partials.errors')--}}
<!-- Content Area - [Start] -->
<div id="main_content_area">
<div class="row no-gutters">
<!-- Sidebar -->
@include('front.roles.role-sidebar')
<!-- Sidebar -->
<aside id="right_content" class="col-12 col-lg-9">
	<div class="inner">
		<div class="content_header_wrap">
			<div class="hgroup divider-after left">
				<h1 class="lh-10">Add Role</h1>
			</div>
		</div>

		<form method="POST" action="{{ route('role.store') }}" id="account-form"  class="needs-validation" role="form" enctype="multipart/form-data" novalidate>
			@csrf
			@method('POST')
			<section class="form-section pb-0">
				<div class="section-inner">
					<div class="form-row">
						<div class="form-group col-12 col-md-6 no-min-h">
							<label for="name">Name *</label>
							<input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
								   placeholder="Role Name" value="{{ old('name') }}" id="name" name="name" required>
							<div class="invalid-feedback">
								@if ($errors->has('name'))
									{{ $errors->first('name') }}
								@else
									Please provide a role name.
								@endif
							</div>
						</div>
						<div class="form-group col-12 col-md-6 no-min-h">
							<label for="dashboard_card_permission">Dashboard Components Permission</label>
							<select class="form-control select2 select-test" name="dashboard_card_permission[]" data-placeholder="Please Select Option" multiple="multiple">
								@foreach($dashboard_card_permissions as $value => $name)
									<option value="{{$value}}">{{$name}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</section>
			<div class="content_footer_wrap">
				<button type="submit" class="btn btn-primary submitButton">Save</button>
				<a href="{{route('role.index')}}"><button type="button" class="btn btn-primary" style="background-color: #bad709!important;">Cancel</button></a>
			</div>
		</form>
	</div>
</aside>
</div>
</div>
<!-- Content Area - [/end] -->
</div>
</main>
@stop

@section('js')
	<script>
        $(document).ready(function() {
            $('.select2').select2();

        });
	</script>
@stop
