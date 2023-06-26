<div class="ui tiny modal" id="delete-user-{{ $user->id }}-modal" modal-status="uninitialized" wire:ignore.self>
	<div class="ui vertical red inverted segment huge header">Eliminar usuario</div>
	<div class="scrolling content">
		<p>¿Está seguro de que desea eliminar al usuario llamado {{ strtok($user->first_name, ' ') . ' ' . strtok($user->last_name, ' ') }}? Esta acción no se puede deshacer.</p>
		@include('layouts.partials.messages')
	</div>
	<form class="actions" id="delete-user-{{ $user->id }}-form" wire:submit.prevent="destroyUser" wire:reset="resetForm" wire:loading.class="loading">
		@csrf
		<button class="ui cancel grey button" form="delete-user-{{ $user->id }}-form" type="reset">Cancelar</button>
		<button class="ui red right labeled icon button" form="delete-user-{{ $user->id }}-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="destroyUser">Sí, continuar<i class="arrow right icon"></i></button>
	</form>
</div>
