<div class="ui tiny modal" id="create-period-modal" modal-status="uninitialized" wire:ignore.self>
	<div class="ui vertical teal inverted segment huge header">Añadir un periodo nuevo</div>
	<div class="content">
		<form class="ui form" id="create-period-form" wire:submit.prevent="storePeriod" wire:reset="resetForm" wire:loading.class="loading">
			@csrf
			<div class="field required {{ $errors->has('quarter') ? 'error' : '' }}">
				<label>Cuatrimestre</label>
				<select class="ui selection dropdown" id="quarter" name="quarter" wire:model="quarter">
					<option value="">Seleccionar cuatrimestre</option>
					<option value="first">Enero - Abril</option>
					<option value="second">Mayo - Agosto</option>
					<option value="third">Septiembre - Diciembre</option>
				</select>
			</div>
			<div class="field required {{ $errors->has('year') ? 'error' : '' }}">
				<label>Año</label>
				<div class="ui calendar" data-type="year">
					<div class="ui input left icon">
						<i class="calendar icon"></i>
						<input id="year" name="year" type="number" wire:model.lazy="year" autocomplete="off" placeholder="Seleccionar año">
					</div>
				</div>
			</div>
		</form>
		@include('layouts.partials.messages')
	</div>
	<div class="actions">
		<button class="ui cancel grey button" form="create-period-form" type="reset">Cancelar</button>
		<button class="ui teal right labeled icon button" form="create-period-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="storePeriod">Crear registro<i class="check icon"></i></button>
	</div>
</div>
