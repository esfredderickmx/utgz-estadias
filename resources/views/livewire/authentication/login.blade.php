<div class="ui tiny test modal" id="login-modal" data-open-modal="{{ session('openLoginModal', false) }}" wire:ignore.self>
	<div class="ui vertical teal inverted segment huge header">Iniciar sesión</div>
	<div class="content">
		<form class="ui form" id="login-form" wire:submit.prevent="login" wire:reset="resetForm" wire:loading.class="loading">
			@csrf
			<div class="field required {{ $errors->has('username') ? 'error' : '' }}">
				<label>Matrícula / número de control</label>
				<div class="ui right labeled left icon input">
          <input id="login_username" name="login_username" type="text" wire:model="username" autocomplete="off" placeholder="Completa tu correo">
					<div class="ui basic label">@utgz.edu.mx</div>
					<i class="envelope icon outline"></i>
				</div>
				{{-- @error('username')
					<div class="ui red basic pointing label">
						{{ $message }}
					</div>
				@enderror --}}
			</div>
			<div class="field required {{ $errors->has('password') ? 'error' : '' }}">
				<label>Contraseña</label>
				<div class="ui right action left icon input">
          <input id="login_password" name="login_password" type="password" wire:model="password" autocomplete="off" placeholder="Ingresa tu contraseña de acceso">
					<i class="lock icon"></i>
					<div class="ui icon toggle button pop password" id="login-password-toggler" data-content="Alternar visibilidad" data-variation="basic inverted">
						<i class="eye slash icon"></i>
					</div>
				</div>
				<button class="ui teal tertiary button" target-modal="forgot-modal" tabindex="-1" type="reset">¿Olvidaste tu contraseña?</button>
			</div>
			<div class="field">
				<div class="ui checkbox">
					<input id="login_remember" name="login_remember" type="checkbox" wire:model="remember">
					<label>Recordar en este navegador</label>
				</div>
			</div>
		</form>
		@include('layouts.partials.messages')
	</div>
	<div class="actions">
		<button class="ui cancel grey button" form="login-form" type="reset">Cancelar</button>
		<button class="ui teal right labeled icon button" form="login-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="login">Acceder<i class="sign in icon"></i></button>
	</div>
</div>
