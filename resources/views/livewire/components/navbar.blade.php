<div class="ui large inverted pointing secondary menu">
	<div class="ui grid">
		<div class="ui mobile only row container">
			<div class="ui dropdown icon item">
				<i class="bars icon"></i>
				<div class="menu">
					<a class="item {{ Route::currentRouteName() === 'index' || Route::currentRouteName() === 'home' ? 'active' : '' }}" href="{{ route('home') }}"><i class="university icon"></i>Inicio</a>
					<div class="divider"></div>
					<div class="header">Estadías</div>
					<a class="item"><i class="calendar icon outline"></i>Periodos</a>
					<a class="item"><i class="clipboard icon outline"></i>Proceso</a>
					<a class="item"><i class="folder open icon outline"></i>Documentos</a>
				</div>
			</div>
		</div>
		<div class="tablet computer only row">
			<a class="item {{ Route::currentRouteName() === 'index' || Route::currentRouteName() === 'home' ? 'active' : '' }}" href="{{ route('home') }}">Inicio</a>
			<a class="item">Periodos</a>
			<a class="item">Proceso</a>
			<a class="item">Documentos</a>
		</div>
	</div>
	<div class="right menu">
		@auth
			<div class="ui dropdown item">
				{{ Auth::user()->first_name ? strtok(Auth::user()->first_name, ' ') . ' ' . strtok(Auth::user()->last_name, ' ') : Auth::user()->username }}
				<i class="dropdown icon"></i>
				<div class="menu">
					<div class="header">Mi cuenta</div>
					<a class="item"><i class="user icon outline"></i>Perfil de usuario</a>
					@if (Auth::user()->role === 'super' || Auth::user()->role === 'admin' || Auth::user()->role === 'manager')
						<div class="item {{ Route::currentRouteName() === 'areas' || Route::currentRouteName() === 'careers' ? 'active' : '' }}">
							<i class="dropdown icon"></i>
							<span class="text container">
								<i class="sliders horizontal icon"></i> Control admin.
							</span>
							<div class="menu">
								<a class="item {{ Route::currentRouteName() === 'areas' ? 'active' : '' }}" href="{{ route('areas') }}"><i class="grip horizontal icon"></i>Áreas</a>
								<a class="item {{ Route::currentRouteName() === 'careers' ? 'active' : '' }}" href="{{ route('careers') }}"><i class="th icon"></i>Carreras</a>
								<a class="item {{ Route::currentRouteName() === 'users' ? 'active' : '' }}" href="{{ route('users') }}"><i class="users icon"></i>Usuarios</a>
								<a class="item {{ Route::currentRouteName() === 'periods' ? 'active' : '' }}" href="{{ route('periods') }}"><i class="calendar alternate icon"></i>Periodos</a>
								<div class="item"><i class="hourglass icon"></i>Procesos</div>
							</div>
						</div>
					@endif
					<div class="divider"></div>
					<div class="header">Sesión</div>
					<a class="item" wire:click="logout"><i class="door open alternate icon"></i>Cerrar sesión</a>
				</div>
			</div>
		@endauth
		@guest
			<div class="item">
				<div class="ui animated fade inverted button" target-modal="login-modal">
					<div class="content visible">¿Ya eres estudiante?</div>
					<div class="content hidden">Iniciar sesión ahora</div>
				</div>
			</div>
		@endguest
	</div>

	<div>
		@if (Session::get('logged-out', false))
			@php
				$message = Session::get('logged-out');
			@endphp
			<input id="session-info" type="hidden" value="{{ $message }}">
		@endif
	</div>
</div>
