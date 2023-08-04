<div class="ui tiny modal" id="edit-period-{{ $period->id }}-modal" modal-status="uninitialized" wire:ignore.self>
	<div class="ui vertical teal inverted segment huge header">Editar información del periodo</div>
	<div class="content">
		<form class="ui form" id="edit-period-{{ $period->id }}-form" wire:submit.prevent="updatePeriod" wire:reset="resetForm" wire:loading.class="loading">
			@csrf
			<div class="field required {{ $errors->has('period.quarter') ? 'error' : '' }}">
				<label>Cuatrimestre</label>
				<select class="ui selection dropdown" id="quarter" name="quarter" wire:model="period.quarter">
					<option value="">Seleccionar cuatrimestre</option>
					<option value="first">Enero - Abril</option>
					<option value="second">Mayo - Agosto</option>
					<option value="third">Septiembre - Diciembre</option>
				</select>
			</div>
			<div class="field required {{ $errors->has('period.year') ? 'error' : '' }}">
				<label>Año</label>
				<div class="ui calendar" data-type="year">
					<div class="ui input left icon">
            <input id="year" name="year" type="number" wire:model.lazy="period.year" autocomplete="off" placeholder="Seleccionar año">
						<i class="calendar icon"></i>
					</div>
				</div>
			</div>
		</form>
		@include('layouts.partials.messages')
	</div>
	<div class="actions">
		<button class="ui cancel grey button" form="edit-period-{{ $period->id }}-form" type="reset">Cancelar</button>
		<button class="ui teal right labeled icon button" form="edit-period-{{ $period->id }}-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="updatePeriod">Guardar cambios<i class="save icon"></i></button>
	</div>
</div>
