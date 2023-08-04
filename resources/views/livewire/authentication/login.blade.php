<div class="ui tiny test modal" id="login-modal" data-open-modal="{{ session('openLoginModal', false) }}" wire:ignore.self>
	<div class="ui vertical teal inverted segment huge header">Iniciar sesión</div>
	<div class="content">
		<form class="ui form" id="login-form" wire:submit.prevent="login" wire:reset="resetForm" wire:loading.class="loading">
			@csrf
			<div class="field required {{ $errors->has('username') ? 'error' : '' }}">
				<label>Correo {{ !$foreign ? 'institucional' : 'electrónico' }}</label>
				<div class="ui {{ !$foreign ? 'right labeled' : '' }} left icon input">
					<input id="username" name="username" type="text" wire:model="username" autocomplete="off" placeholder="Correo {{ !$foreign ? 'institucional' : 'electrónico' }}">
					@if (!$foreign)
						<div class="ui basic label">@utgz.edu.mx</div>
					@endif
					<i class="envelope icon outline"></i>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox">
					<input id="foreign" name="foreign" type="checkbox" wire:model="foreign">
					<label>Usar un correo externo a la universidad</label>
				</div>
			</div>
			<div class="field required {{ $errors->has('password') ? 'error' : '' }}">
				<label>Contraseña</label>
				<div class="ui right action left icon input">
					<input id="password" name="password" type="password" wire:model="password" autocomplete="off" placeholder="Contraseña">
					<i class="lock icon"></i>
					<div class="ui icon toggle button" data-inverted data-tooltip="Mostrar contraseña" data-variation="tiny" data-position="bottom right">
						<i class="eye slash icon"></i>
					</div>
				</div>
				<button class="ui teal tertiary button" target-modal="forgot-modal" tabindex="-1" type="reset">¿Olvidaste tu contraseña?</button>
			</div>
			<div class="field">
				<div class="ui checkbox">
					<input id="remember" name="remember" type="checkbox" wire:model="remember">
					<label>Recordar sesión en este navegador</label>
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
