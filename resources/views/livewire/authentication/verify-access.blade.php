<div class="ui tiny test modal" id="verify-access-modal" wire:ignore.self>
	<div class="ui vertical teal inverted segment huge header">Confirmar acceso como estudiante</div>
	<div class="content">
		<p>Para asegurarnos de que tienes acceso autorizado, por favor, ingresa tu dirección de correo institucional en el campo de abajo y haz clic en "Verificar". No te preocupes, solo usaremos tu email para comprobar que eres un usuario válido.</p>
		<form class="ui form" id="verify-access-form" wire:submit.prevent="verifyAccess" wire:reset="resetForm" wire:loading.class="loading">
			@csrf
			<div class="field required {{ $errors->has('username') ? 'error' : '' }}">
				<label>Correo institucional</label>
				<div class="ui right labeled left icon input">
					<input id="username" name="username" type="text" wire:model="username" autocomplete="off" placeholder="Correo institucional">
          <div class="ui basic label">@utgz.edu.mx</div>
					<i class="envelope icon outline"></i>
				</div>
			</div>
		</form>
		@include('layouts.partials.messages')
	</div>
	<div class="actions">
		<button class="ui cancel grey button" form="verify-access-form" type="reset">Cancelar</button>
		<button class="ui teal right labeled icon button" form="verify-access-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="verifyAccess">Verificar<i class="question icon"></i></button>
	</div>
</div>
