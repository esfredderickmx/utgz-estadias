<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>@yield('title', isset($title) ? $title : '') | Citrogambas</title>
	<link type="text/css" href="{{ asset('css/semantic.min.css') }}" rel="stylesheet">
	<link type="text/css" href="{{ asset('css/styles.css') }}" rel="stylesheet">
	@livewireStyles
</head>

<body>
	{{-- @dd(Session::all()) --}}

	@include('layouts.partials.hidden-navbar')

	@if (Route::currentRouteName() === 'index' || Route::currentRouteName() === 'home')
		@include('layouts.partials.image-navbar')
	@else
		@include('layouts.partials.simple-navbar')
	@endif

	<main class="ui vertical segment padded" id="content">
		@yield('content', $slot ?? '')
	</main>

	@include('layouts.partials.footer')

	@guest
		@livewire('authentication.login')
		@include('auth.register')
		@livewire('authentication.password.forgot')
		@livewire('authentication.password.reset', ['token' => session('token', null), 'username' => session('username', null)])
	@endguest

	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
	{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
	<script type="text/javascript" src="{{ asset('js/semantic.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/scripts.js') }}"></script>
	@livewireScripts
</body>

</html>
