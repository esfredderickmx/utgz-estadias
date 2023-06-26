<div class="ui tiny modal" id="edit-career-{{ $career->id }}-modal" modal-status="uninitialized" wire:ignore.self>
	<div class="ui vertical teal inverted segment huge header">Editar información del área</div>
	<div class="content">
		<form class="ui form" id="edit-career-{{ $career->id }}-form" wire:submit.prevent="updateCareer" wire:reset="resetForm" wire:loading.class="loading">
			@csrf
			<div class="field required {{ $errors->has('name') ? 'error' : '' }}">
				<label>Nombre</label>
				<div class="ui left icon input">
					<input id="name" name="name" type="text" wire:model="career.name" autocomplete="off" placeholder="Nombre de la carrera">
					<i class="quote left icon"></i>
				</div>
			</div>
			<div class="field {{ $errors->has('context') ? 'error' : '' }}">
				<label>Contexto / subárea</label>
				<div class="ui left icon input">
					<input id="context" name="context" type="text" wire:model="career.context" autocomplete="off" placeholder="Contexto / subárea de la carrera">
					<i class="quote right icon"></i>
				</div>
			</div>
			<div class="field required {{ $errors->has('area_id') ? 'error' : '' }}">
				<label>Área</label>
				<select id="area_id" name="area_id" wire:model="career.area_id" class="ui search selection dropdown">
					<option value="">Área asociada a la carrera</option>
					@foreach ($areas as $area)
						<option value="{{ $area->id }}">{{ $area->name }}</option>
					@endforeach
				</select>
			</div>
      <div class="two fields">
        <div class="field required {{ $errors->has('grade') ? 'error' : '' }}">
          <label>Grado</label>
          <select id="grade" name="grade" wire:model.debounce="career.grade" class="ui selection dropdown">
            <option value="">Grado académico</option>
            <option value="technician">Técnico Superior</option>
            <option value="higher">Continuidad</option>
          </select>
        </div>
        <div class="field required {{ $errors->has('availability') ? 'error' : '' }}">
          <label>Disponible en</label>
          <select id="availability" name="availability" wire:model="career.availability" class="ui selection dropdown">
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
		<button class="ui cancel grey button" form="edit-career-{{ $career->id }}-form" type="reset">Cancelar</button>
		<button class="ui teal right labeled icon button" form="edit-career-{{ $career->id }}-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="updateCareer">Guardar cambios<i class="save icon"></i></button>
	</div>
</div>
