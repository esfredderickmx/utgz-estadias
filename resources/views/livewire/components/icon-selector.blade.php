<div class="ui small modal" id="select-icon-{{ $entity_type === 'create' ? 'create' : $entity_id }}-modal" modal-status="uninitialized" wire:ignore.self>
	<div class="ui vertical teal inverted segment huge header">Seleccionar icono</div>
	<div class="scrolling content">
		<form class="ui form" id="select-icon-{{ $entity_type === 'create' ? 'create' : $entity_id }}-form" wire:submit.prevent="selectIcon" wire:reset="resetForm">
			<div class="two fields">
				<div class="field">
					<div class="ui {{ $icon_search ? 'action' : '' }} left icon input">
						<input id="icon_search" name="icon_search" type="text" wire:model.debounce.300ms="icon_search" autocomplete="off" placeholder="Buscar...">
						<i class="search icon"></i>
						@if ($icon_search)
							<div class="ui red icon button" wire:click="clearSearch"><i class="times icon"></i></div>
						@endif
					</div>
				</div>
				<div class="field">
					<select class="ui two column clearable search selection dropdown" id="category_search" name="category_search" wire:model.lazy="category_search">
						<option value="">Todos los iconos</option>
						@foreach ($categories as $category)
							<option class="item" value="{{ $category->value }}">{{ $category->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</form>

		@include('layouts.partials.messages')

		<div class="ui segment basic vertical">
			<div class="ui six doubling raised link cards">
				@forelse ($icons as $icon)
					<label class="card" for="{{ $entity_type === 'create' ? 'create' : $entity_id }} {{ $icon->name }}" wire:loading.class="ui loading">
						<div class="content">
							<div class="center aligned header" data-inverted data-tooltip="{{ $icon->name }}" data-variation="tiny">
								<i class="big black {{ $icon->name }} icon"></i>
							</div>
							<div class="center aligned description">
								<div class="ui fitted checkbox">
									<input id="{{ $entity_type === 'create' ? 'create' : $entity_id }} {{ $icon->name }}" name="icon-{{ $entity_type === 'create' ? 'create' : $entity_id }}" form="select-icon-{{ $entity_type === 'create' ? 'create' : $entity_id }}-form" type="radio" value="{{ $icon->name }}" wire:model.defer="selection">
								</div>
							</div>
						</div>
					</label>
				@empty
			</div>
			<div class="ui placeholder segment" wire:loading.class="loading">
				<div class="ui icon header">
					<i class="search icon"></i>No hubo resultados coincidentes, inténtelo de nuevo.
				</div>
				<section class="ui center aligned container inline">
					<div class="ui button" wire:click="clearSearch"><i class="times icon"></i>Limpiar búsqueda</div>
					<div class="ui teal button" wire:click="resetForm">Limpiar filtros</div>
				</section>
				@endforelse
			</div>
		</div>

		<div class="ui vertical basic segment">
			{{ $icons->links() }}
		</div>
	</div>
	<div class="actions">
		<button class="ui grey button" form="select-icon-{{ $entity_type === 'create' ? 'create' : $entity_id }}-form" type="reset" target-modal="{{ $entity_type === 'create' ? 'create-area-modal' : 'edit-area-' . $entity_id . '-modal' }}">Cancelar</button>
		<button class="ui teal right labeled icon button" form="select-icon-{{ $entity_type === 'create' ? 'create' : $entity_id }}-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="selectIcon">Insertar selección<i class="reply icon"></i></i></button>
	</div>
</div>
