<div class="ui tiny test modal" id="create-career-modal" modal-status="uninitialized" wire:ignore.self>
	<div class="ui vertical teal inverted segment huge header">Añadir un área nueva</div>
	<div class="content">
		<form class="ui form" id="create-career-form" wire:submit.prevent="storeCareer" wire:reset="resetForm" wire:loading.class="loading">
			@csrf
			<div class="field required {{ $errors->has('name') ? 'error' : '' }}">
				<label>Nombre</label>
				<div class="ui left icon input">
					<input id="name" name="name" type="text" wire:model="name" autocomplete="off" placeholder="Nombre de la carrera">
					<i class="quote left icon"></i>
				</div>
			</div>
			<div class="field {{ $errors->has('context') ? 'error' : '' }}">
				<label>Contexto / subárea</label>
				<div class="ui left icon input">
					<input id="context" name="context" type="text" wire:model="context" autocomplete="off" placeholder="Contexto / subárea de la carrera">
					<i class="quote right icon"></i>
				</div>
			</div>
			<div class="field required {{ $errors->has('area_id') ? 'error' : '' }}">
				<label>Área</label>
				<select id="area_id" name="area_id" wire:model="area_id" class="ui search selection dropdown">
					<option value="">Área asociada a la carrera</option>
					@foreach ($areas as $area)
						<option value="{{ $area->id }}">{{ $area->name }}</option>
					@endforeach
				</select>
			</div>
      <div class="two fields">
        <div class="field required {{ $errors->has('grade') ? 'error' : '' }}">
          <label>Grado</label>
          <select id="grade" name="grade" wire:model="grade" class="ui selection dropdown">
            <option value="">Grado académico</option>
            <option value="technician">Técnico Superior</option>
            <option value="higher">Continuidad</option>
          </select>
        </div>
        <div class="field required {{ $errors->has('availability') ? 'error' : '' }}">
          <label>Disponible en</label>
          <select id="availability" name="availability" wire:model="availability" class="ui selection dropdown">
            <option value="">Disponibilidad</option>
            <option value="week">Escolarizado</option>
            <option value="weekend">Despresurizado</option>
            <option value="both">Ambas</option>
          </select>
        </div>
      </div>
			<div class="field required {{ $errors->has('image') ? 'error' : '' }}">
				<label>Imagen de la carrera</label>
				<div class="ui file input">
					<input id="image" name="image" type="file" wire:model="image" accept=".jpg, .jpeg, .png">
				</div>
			</div>
		</form>
		@include('layouts.partials.messages')
	</div>
	<div class="actions">
		<button class="ui cancel grey button" form="create-career-form" type="reset">Cancelar</button>
		<button class="ui teal right labeled icon button" form="create-career-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="storeArea">Crear registro<i class="check icon"></i></button>
	</div>
</div>
