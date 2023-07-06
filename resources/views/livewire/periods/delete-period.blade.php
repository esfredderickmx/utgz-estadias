<div class="ui tiny test modal" id="" modal-status="uninitialized" wire:ignore.self>
	<div class="ui vertical red inverted segment huge header">Eliminar Periodo</div>
	<div class="content">
		<p>¿Está seguro de que desea eliminar el periodo {{ $period->name }} {{$period->context ?? ''}}? Esta acción no se puede deshacer.</p>
		@include('layouts.partials.messages')
	</div>
	<form class="actions" id="" wire:submit.prevent="destroyPeriod" wire:reset="resetForm" wire:loading.class="loading">
		@csrf
		<button class="ui cancel grey button" form="" type="reset">Cancelar</button>
		<button class="ui red right labeled icon button" form="" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="updatePeriod">Sí, continuar<i class="arrow right icon"></i></button>
	</form>
</div>
