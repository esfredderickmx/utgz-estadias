<div>
	<div class="ui tiny modal" id="edit-area-{{ $area->id }}-modal" modal-status="uninitialized" wire:ignore.self>
		<div class="ui vertical teal inverted segment huge header">Editar información del área</div>
		<div class="scrolling content">
			<form class="ui form" id="edit-area-{{ $area->id }}-form" wire:submit.prevent="updateArea" wire:reset="resetForm" wire:loading.class="loading">
				@csrf
				<div class="field required {{ $errors->has('area.icon') ? 'error' : '' }}">
					<label>Icono</label>
					<div class="ui action left icon input">
						<input id="icon" name="icon" type="text" wire:model="area.icon" readonly autocomplete="off" placeholder="Icono">
						<i class="{{ $area->icon ?? 'icons' }} icon"></i>
						<div class="ui teal icon button" data-inverted data-tooltip="Seleccionar icono" data-variation="tiny" data-position="top right" target-modal="select-icon-{{ $area->id }}-modal"><i class="external alternate icon"></i></div>
					</div>
				</div>
				<div class="field required {{ $errors->has('area.name') ? 'error' : '' }}">
					<label>Nombre</label>
					<div class="ui left icon input">
						<input id="name" name="name" type="text" wire:model="area.name" autocomplete="off" placeholder="Nombre">
						<i class="quote left icon"></i>
					</div>
				</div>
				<div class="field required {{ $errors->has('area.description') ? 'error' : '' }}">
					<label>Descripción</label>
					<div class="ui left icon input">
						<textarea id="description" name="description" wire:model="area.description" autocomplete="off" placeholder="Descripción"></textarea>
						<i class="align left icon"></i>
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

	@livewire('components.icon-selector', ['entity_type' => 'edit', 'entity_id' => $area->id])
</div>
