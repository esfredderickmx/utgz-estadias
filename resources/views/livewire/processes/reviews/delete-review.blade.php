<div class="ui tiny modal" id="delete-review-{{ $review->id }}-modal" modal-status="uninitialized" wire:ignore.self>
	<div class="ui vertical red inverted segment huge header">Eliminar revisión</div>
	<div class="content">
		<p>¿Está seguro de que desea eliminar los datos de la revisión número {{ $review->number }}? Esta acción no se puede deshacer.</p>
		@include('layouts.partials.messages')
	</div>
	<form class="actions" id="delete-review-{{ $review->id }}-form" wire:submit.prevent="destroyReview" wire:reset="resetForm" wire:loading.class="loading">
		@csrf
		<button class="ui cancel grey button" form="delete-review-{{ $review->id }}-form" type="reset">Cancelar</button>
		<button class="ui red right labeled icon button" form="delete-review-{{ $review->id }}-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="destroyReview">Sí, continuar<i class="arrow right icon"></i></button>
	</form>
</div>
