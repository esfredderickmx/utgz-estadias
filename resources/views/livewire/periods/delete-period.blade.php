<div class="ui tiny modal" id="delete-period-{{ $period->id }}-modal" modal-status="uninitialized" wire:ignore.self>
	<div class="ui vertical red inverted segment huge header">Eliminar periodo</div>
	<div class="content">
		<p>¿Está seguro de que desea eliminar los datos del periodo {{ $period->quarter === 'first' ? 'Enero - Abril' : ($period->quarter === 'second' ? 'Mayo - Agosto' : 'Septiembre - Diciembre') }} {{ $period->year }}? Esta acción no se puede deshacer.</p>
		@include('layouts.partials.messages')
	</div>
	<form class="actions" id="delete-period-{{ $period->id }}-form" wire:submit.prevent="destroyPeriod" wire:reset="resetForm" wire:loading.class="loading">
		@csrf
		<button class="ui cancel grey button" form="delete-period-{{ $period->id }}-form" type="reset">Cancelar</button>
		<button class="ui red right labeled icon button" form="delete-period-{{ $period->id }}-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="destroyPeriod">Sí, continuar<i class="arrow right icon"></i></button>
	</form>
</div>
