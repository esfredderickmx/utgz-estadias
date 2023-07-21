<div class="ui tiny modal" id="edit-career-{{ $career->id }}-modal" modal-status="uninitialized" wire:ignore.self>
	<div class="ui vertical teal inverted segment huge header">Editar información del área</div>
	<div class="scrolling content">
		<form class="ui form" id="edit-career-{{ $career->id }}-form" wire:submit.prevent="updateCareer" wire:reset="resetForm" wire:loading.class="loading">
			@csrf
			<div class="field required {{ $errors->has('career.career.name') ? 'error' : '' }}">
				<label>Nombre</label>
				<div class="ui left icon input">
					<input id="name" name="name" type="text" wire:model="career.name" autocomplete="off" placeholder="Nombre">
					<i class="quote left icon"></i>
				</div>
			</div>
			@if ($has_context)
				<div class="field {{ $errors->has('career.context') ? 'error' : '' }}">
					<label>Contexto</label>
					<div class="ui left icon input">
						<input id="context" name="context" type="text" wire:model="career.context" autocomplete="off" placeholder="Contexto">
						<i class="quote right icon"></i>
					</div>
				</div>
			@endif
			<div class="field">
				<div class="ui checkbox">
					<input id="has_context" name="has_context" type="checkbox" wire:model="has_context">
					<label>Incluir contexto de la carrera</label>
				</div>
			</div>
			<div class="field required {{ $errors->has('career.area_id') ? 'error' : '' }}">
				<label>Área</label>
				<select class="ui search selection dropdown" id="area_id" name="area_id" wire:model="career.area_id">
					<option value="">Seleccionar área</option>
					@foreach ($areas as $area)
						<option value="{{ $area->id }}">{{ $area->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="two fields">
				<div class="field required {{ $errors->has('career.grade') ? 'error' : '' }}">
					<label>Grado</label>
					<select class="ui selection dropdown" id="grade" name="grade" wire:model.debounce="career.grade">
						<option value="">Seleccionar grado</option>
						<option value="technician">Técnico Superior</option>
						<option value="higher">Ingeniería / Licenciatura</option>
					</select>
				</div>
				<div class="field required {{ $errors->has('career.availability') ? 'error' : '' }}">
					<label>Disponibilidad</label>
					<select class="ui selection dropdown" id="availability" name="availability" wire:model="career.availability">
						<option value="">Seleccionar disponibilidad</option>
						<option value="week">Escolarizado</option>
						<option value="weekend">Despresurizado</option>
						<option value="both">Ambas</option>
					</select>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox">
					<input id="has_image" name="has_image" type="checkbox" wire:model="has_image">
					<label>Actualizar imagen de la carrera</label>
				</div>
			</div>
			@if ($has_image)
			<div class="field required {{ $errors->has('image_valid') ? 'error' : '' }}">
				<label>Imagen de la carrera</label>
				<div class="ui file input">
					<input id="image" name="image" type="file" wire:model="image_valid" accept=".jpg, .jpeg, .png">
				</div>
			</div>
			<div class="ui teal indeterminate" wire:loading.class="progress" wire:target="image_valid">
				<div class="bar" wire:loading wire:target="image_valid">
					<div class="progress">Cargando imagen...</div>
				</div>
			</div>
			@endif
		</form>
		@include('layouts.partials.messages')
	</div>
	<div class="actions">
		<button class="ui cancel grey button" form="edit-career-{{ $career->id }}-form" type="reset">Cancelar</button>
		<button class="ui teal right labeled icon button" form="edit-career-{{ $career->id }}-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="updateCareer, image_valid">Guardar cambios<i class="save icon"></i></button>
	</div>
</div>
