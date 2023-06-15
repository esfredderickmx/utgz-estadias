<div class="ui tiny test modal" id="forgot-modal" wire:ignore.self>
	<div class="ui vertical teal inverted segment huge header">Solictar restablecimiento</div>
	<div class="ui justified content container">
		<p>¿Olvidaste tu contraseña? No te preocupes, estamos aquí para ayudarte a recuperar el acceso a tu cuenta. Ingresa tu dirección de correo institucional asociada con tu cuenta y te enviaremos un enlace para restablecer tu contraseña.</p>
		<form class="ui form" id="forgot-form" wire:submit.prevent="sendRequest" wire:reset="resetForm" wire:loading.class="loading">
			@csrf
			<div class="field required {{ $errors->has('username') ? 'error' : '' }}">
				<label>Matrícula / número de control</label>
				<div class="ui right labeled left icon input">
          <input id="forgot_username" name="forgot_username" type="text" wire:model="username" autocomplete="off" placeholder="Completa tu correo">
					<div class="ui basic label">@utgz.edu.mx</div>
					<i class="envelope icon outline"></i>
				</div>
			</div>
		</form>
		@include('layouts.partials.messages')
	</div>
	<div class="actions">
		<button class="ui icon button left floated pop" target-modal="login-modal" data-content="Volver" data-variation="basic inverted" form="forgot-form" type="reset">
			<i class="arrow left icon"></i>
		</button>

		<button class="ui cancel grey button" form="forgot-form" type="reset">Cancelar</button>
		<button class="ui teal right labeled icon button" form="forgot-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="sendRequest">Solicitar<i class="paper plane icon"></i></button>
	</div>
</div>
