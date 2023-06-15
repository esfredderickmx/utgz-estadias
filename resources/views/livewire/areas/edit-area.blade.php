<div class="ui tiny test modal" id="edit-area-{{ $area->id }}-modal" modal-status="uninitialized" wire:ignore.self>
	<div class="ui vertical teal inverted segment huge header">Editar datos del área</div>
	<div class="content">
		<form class="ui form" id="edit-area-{{ $area->id }}-form" wire:submit.prevent="updateArea" wire:reset="resetForm" wire:loading.class="loading">
			@csrf
			<div class="field required {{ $errors->has('area.icon') ? 'error' : '' }}">
				<label>Icono representativo</label>
				<div class="ui left icon input">
					<input id="icon" name="icon" type="text" wire:model="area.icon" autocomplete="off" placeholder="Ingresa el id del icono">
					<i class="icons icon"></i>
				</div>
				<a class="ui teal tertiary button" href="https://fomantic-ui.com/elements/icon.html" tabindex="-1" target="_blank">¿Dónde puedo consultar los iconos?</a>
			</div>
			<div class="field required {{ $errors->has('area.name') ? 'error' : '' }}">
				<label>Nombre</label>
				<div class="ui left icon input">
					<input id="name" name="name" type="text" wire:model="area.name" autocomplete="off" placeholder="Ingresa el alias del área">
					<i class="tag icon"></i>
				</div>
			</div>
			<div class="field required {{ $errors->has('area.description') ? 'error' : '' }}">
				<label>Descripción</label>
				<div class="ui left icon input">
					<textarea id="description" name="description" wire:model="area.description" autocomplete="off" placeholder="Ingresa una descripción para el área"></textarea>
					<i class="i cursor icon"></i>
				</div>
			</div>
		</form>
		@include('layouts.partials.messages')
	</div>
	<div class="actions">
		<button class="ui cancel grey button" form="edit-area-{{ $area->id }}-form" type="reset">Cancelar</button>
		<button class="ui teal right labeled icon button" form="edit-area-{{ $area->id }}-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="updateArea">Guardar cambios<i class="save icon"></i></button>
	</div>
</div>
