<div class="ui tiny modal" id="delete-process-{{ $process->id }}-modal" modal-status="uninitialized" wire:ignore.self>
	<div class="ui vertical red inverted segment huge header">Eliminar usuario</div>
	<div class="content">
		<p>¿Está seguro de que desea eliminar los datos de este proceso correspondiente a {{ strtok($process->student->first()->first_name, ' ') . ' ' . strtok($process->student->first()->last_name, ' ')}}? Esta acción no se puede deshacer.</p>
		@include('layouts.partials.messages')
	</div>
	<form class="actions" id="delete-process-{{ $process->id }}-form" wire:submit.prevent="destroyProcess" wire:reset="resetForm" wire:loading.class="loading">
		@csrf
		<button class="ui cancel grey button" form="delete-process-{{ $process->id }}-form" type="reset">Cancelar</button>
		<button class="ui red right labeled icon button" form="delete-process-{{ $process->id }}-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="destroyProcess">Sí, continuar<i class="arrow right icon"></i></button>
	</form>
</div>
