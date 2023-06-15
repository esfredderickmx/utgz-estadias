@if (Session::get('info', false))
	@php
		$infos = Session::get('info');
	@endphp
	<div class="ui info message">
		@if (is_array($infos))
			<ul class="list">
				@foreach ($infos as $info)
					<li>{{ $info }}</li>
				@endforeach
			</ul>
		@else
			{{ $infos }}
		@endif
	</div>
@endif

@if (Session::get('warning', false))
	@php
		$warnings = Session::get('warning');
	@endphp
	<div class="ui warning message">
		@if (is_array($warnings))
			<ul class="list">
				@foreach ($warnings as $warning)
					<li>{{ $warning }}</li>
				@endforeach
			</ul>
		@else
			{{ $warnings }}
		@endif
	</div>
@endif

@if (Session::get('success', false))
	@php
		$successes = Session::get('success');
	@endphp
	<div class="ui success message">
		@if (is_array($successes))
			<ul class="list">
				@foreach ($successes as $success)
					<li>{{ $success }}</li>
				@endforeach
			</ul>
		@else
			{{ $successes }}
		@endif
	</div>
@endif

@if (isset($errors) && count($errors) > 0)
	<div class="ui error message">
		<ul class="list">
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif
