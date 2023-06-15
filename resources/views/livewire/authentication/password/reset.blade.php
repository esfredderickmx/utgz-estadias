<div class="ui tiny test modal" id="reset-modal" data-open-modal="{{ session('openResetModal', false) }}" wire:ignore.self>
	<div class="ui vertical teal inverted segment huge header">Restablecer contraseña</div>
	<div class="ui justified content container">
		<p>¡Genial, has llegado al paso final para restablecer tu contraseña! Ingresa una nueva contraseña segura y confírmala para completar el proceso y recuperar el acceso a tu cuenta.</p>
		<form class="ui form" id="reset-form" wire:submit.prevent="resetPassword" wire:reset="resetForm" wire:loading.class="loading">
			@csrf
			<input class="hide" name="token" type="hidden" wire:model="token">
			<div class="field required {{ $errors->has('username') ? 'error' : '' }}">
				<label>Matrícula / número de control</label>
				<div class="ui left icon input">
          <input id="reset_username" name="reset_username" type="text" wire:model="username" readonly autocomplete="off">
					<i class="envelope icon outline"></i>
				</div>
			</div>
			<div class="field required {{ $errors->has('password') ? 'error' : '' }}">
				<label>Contraseña nueva</label>
				<div class="ui right action left icon input">
          <input id="reset_password" name="reset_password" type="password" wire:model="password" autofocus autocomplete="off" placeholder="Ingresa una contraseña">
          <i class="lock icon"></i>
					<div class="ui icon toggle button pop password state" data-content="Alternar visibilidad" data-variation="basic inverted">
						<i class="eye slash icon"></i>
					</div>
				</div>
			</div>
			<div class="field required {{ $errors->has('password_confirmation') ? 'error' : '' }}">
				<label>Confirmar contraseña</label>
				<div class="ui right action left icon input">
          <input id="reset_password_confirmation" name="reset_password_confirmation" type="password" wire:model="password_confirmation" autocomplete="off" placeholder="Confirma tu contraseña">
          <i class="unlock icon"></i>
					<div class="ui icon toggle button pop password state" data-content="Alternar visibilidad" data-variation="basic inverted">
						<i class="eye slash icon"></i>
					</div>
				</div>
			</div>
		</form>
		@include('layouts.partials.messages')
	</div>
	<div class="actions">
		<button class="ui cancel grey button" form="reset-form" type="reset">Cancelar</button>
		<button class="ui teal right labeled icon button" form="reset-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="resetPassword">Restablecer<i class="undo icon"></i></button>
	</div>
</div>
