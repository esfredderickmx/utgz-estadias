<div class="ui tiny modal" id="delete-career-{{ $career->id }}-modal" modal-status="uninitialized" wire:ignore.self>
	<div class="ui vertical red inverted segment huge header">Eliminar área</div>
	<div class="content">
		<p>¿Está seguro de que desea eliminar la carrera de {{ $career->name }} {{$career->context ?? ''}}? Esta acción no se puede deshacer.</p>
		@include('layouts.partials.messages')
	</div>
	<form class="actions" id="delete-career-{{ $career->id }}-form" wire:submit.prevent="destroyCareer" wire:reset="resetForm" wire:loading.class="loading">
		@csrf
		<button class="ui cancel grey button" form="delete-career-{{ $career->id }}-form" type="reset">Cancelar</button>
		<button class="ui red right labeled icon button" form="delete-career-{{ $career->id }}-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="destroyCareer">Sí, continuar<i class="arrow right icon"></i></button>
	</form>
</div>
