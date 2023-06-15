<div class="ui tiny test modal" id="create-area-modal" modal-status="uninitialized" wire:ignore.self>
	<div class="ui vertical teal inverted segment huge header">Añadir un área nueva</div>
	<div class="content">
		<form class="ui form" id="create-area-form" wire:submit.prevent="storeArea" wire:reset="resetForm" wire:loading.class="loading">
			@csrf
			<div class="field required {{ $errors->has('icon') ? 'error' : '' }}">
				<label>Icono representativo</label>
				<div class="ui left icon input">
					<input id="icon" name="icon" type="text" wire:model="icon" autocomplete="off" placeholder="Ingresa el id del icono">
					<i class="icons icon"></i>
				</div>
				<a class="ui teal tertiary button" href="https://fomantic-ui.com/elements/icon.html" tabindex="-1" target="_blank">¿Dónde puedo consultar los iconos?</a>
			</div>
			<div class="field required {{ $errors->has('name') ? 'error' : '' }}">
				<label>Nombre</label>
				<div class="ui left icon input">
					<input id="name" name="name" type="text" wire:model="name" autocomplete="off" placeholder="Ingresa el alias del área">
					<i class="tag icon"></i>
				</div>
			</div>
			<div class="field required {{ $errors->has('description') ? 'error' : '' }}">
				<label>Descripción</label>
				<div class="ui left icon input">
					<textarea id="description" name="description" wire:model="description" autocomplete="off" placeholder="Ingresa una descripción para el área"></textarea>
					<i class="i cursor icon"></i>
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
