<div>
	<div class="ui tiny modal" id="create-area-modal" modal-status="uninitialized" wire:ignore.self>
		<div class="ui vertical teal inverted segment huge header">Añadir un área nueva</div>
		<div class="scrolling content">
			<form class="ui form" id="create-area-form" wire:submit.prevent="storeArea" wire:reset="resetForm" wire:loading.class="loading">
				@csrf
				<div class="field required {{ $errors->has('icon') ? 'error' : '' }}">
					<label>Icono</label>
					<div class="ui action left icon input">
						<input id="icon" name="icon" type="text" wire:model="icon" autocomplete="off" readonly placeholder="Icono">
						<i class="{{ $icon ?? 'icons' }} icon"></i>
						<div class="ui teal icon button" data-inverted data-tooltip="Seleccionar icono" data-variation="tiny" data-position="top right" target-modal="select-icon-create-modal"><i class="external alternate icon"></i></div>
					</div>
				</div>
				<div class="field required {{ $errors->has('name') ? 'error' : '' }}">
					<label>Nombre</label>
					<div class="ui left icon input">
						<input id="name" name="name" type="text" wire:model="name" autocomplete="off" placeholder="Nombre">
						<i class="quote left icon"></i>
					</div>
				</div>
				<div class="field required {{ $errors->has('description') ? 'error' : '' }}">
					<label>Descripción</label>
					<div class="ui left icon input">
						<textarea id="description" name="description" wire:model="description" autocomplete="off" placeholder="Descripción"></textarea>
						<i class="align left icon"></i>
					</div>
				</div>
			</form>
			@include('layouts.partials.messages')
		</div>
		<div class="actions">
			<button class="ui cancel grey button" form="create-area-form" type="reset">Cancelar</button>
			<button class="ui teal right labeled icon button" form="create-area-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="storeArea">Crear registro<i class="check icon"></i></button>
		</div>
	</div>

	@livewire('components.icon-selector', ['entity_type' => 'create'])
</div>
