<div class="ui tiny modal" id="edit-review-{{ $review->id }}-modal" modal-status="uninitialized" wire:ignore.self>
	<div class="ui vertical teal inverted segment huge header">Editar información de la revisión</div>
	<div class="content">
		<form class="ui form" id="edit-review-{{ $review->id }}-form" wire:submit.prevent="updateReview" wire:reset="resetForm" wire:loading.class="loading">
			@csrf
      <div class="field required {{ $errors->has('review.number') ? 'error' : '' }}">
        <label>Número</label>
        <div class="ui left icon input">
          <input id="number" name="number" type="number" wire:model="review.number" readonly autocomplete="off" placeholder="Número">
          <i class="list ol icon"></i>
        </div>
      </div>
      <div class="field required {{ $errors->has('review.instructions') ? 'error' : '' }}">
        <label>Instrucciones</label>
        <div class="ui left icon input">
          <textarea id="instructions" name="instructions" wire:model="review.instructions" autocomplete="off" placeholder="Instrucciones"></textarea>
          <i class="align left icon"></i>
        </div>
      </div>
      <div class="two fields">
        <div class="field required {{ $errors->has('review.status') ? 'error' : '' }}">
          <label>Estado</label>
          <select class="ui selection dropdown" id="status" name="status" wire:model="review.status">
            <option value="">Seleccionar estado</option>
            <option value="pending">Sin entregar</option>
            <option value="reviewing">En revisión</option>
            <option value="rejected">Rechazada</option>
            <option value="approved">Aprobada</option>
          </select>
        </div>
        <div class="field required {{ $errors->has('review.limit_date') ? 'error' : '' }}">
          <label>Fecha límite</label>
          <div class="ui calendar" data-type="date">
            <div class="ui input left icon">
              <input id="limit_date" name="limit_date" type="text" wire:model.lazy="review.limit_date" autocomplete="off" placeholder="Seleccionar fecha límite">
              <i class="calendar icon"></i>
            </div>
          </div>
        </div>
      </div>
		</form>
		@include('layouts.partials.messages')
	</div>
	<div class="actions">
		<button class="ui cancel grey button" form="edit-review-{{ $review->id }}-form" type="reset">Cancelar</button>
		<button class="ui teal right labeled icon button" form="edit-review-{{ $review->id }}-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="updateReview">Guardar cambios<i class="save icon"></i></button>
	</div>
</div>
