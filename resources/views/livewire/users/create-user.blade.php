<div class="ui tiny test modal" id="create-user-modal" modal-status="uninitialized" wire:ignore.self>
	<div class="ui vertical teal inverted segment huge header">Añadir un usuario nuevo</div>
	<div class="content">
		<form class="ui form" id="create-user-form" wire:submit.prevent="storeUser" wire:reset="resetForm" wire:loading.class="loading">
			@csrf
			<div class="two fields">
				<div class="field required {{ $errors->has('first_name') ? 'error' : '' }}">
					<label>Nombre(s)</label>
					<div class="ui left icon input">
						<input id="first_name" name="first_name" type="text" wire:model.lazy="first_name" autocomplete="off" placeholder="Nombre(s)">
						<i class="quote left icon"></i>
					</div>
				</div>
				<div class="field required {{ $errors->has('last_name') ? 'error' : '' }}">
					<label>Apellido(s)</label>
					<div class="ui left icon input">
						<input id="last_name" name="last_name" type="text" wire:model.lazy="last_name" autocomplete="off" placeholder="Apellido(s)">
						<i class="quote right icon"></i>
					</div>
				</div>
			</div>
			<div class="field required {{ $errors->has('role') ? 'error' : '' }}">
				<label>Rol</label>
				<select class="ui selection dropdown" id="role" name="role" wire:model.lazy="role">
					<option value="">Seleccionar rol</option>
					<option value="admin">Administrativo</option>
					<option value="manager">Jefe de área</option>
					<option value="adviser">Asesor</option>
					<option value="student">Estudiante</option>
				</select>
			</div>
			<div class="two fields">
				<div class="field required {{ $errors->has('control_number') ? 'error' : '' }}">
					<label>Número de {{ !$role || $role === 'student' ? 'control' : 'personal' }}</label>
					<div class="ui left icon input">
						<input id="control_number" name="control_number" type="text" wire:model.lazy="control_number" autocomplete="off" placeholder="Número de {{ !$role || $role === 'student' ? 'control' : 'personal' }}">
						<i class="id card alternate icon"></i>
					</div>
				</div>
				<div class="field required {{ $errors->has('phone') ? 'error' : '' }}">
					<label>Teléfono personal</label>
					<div class="ui left icon input">
						<input id="phone" name="phone" type="text" maxlength="10" wire:model.lazy="phone" autocomplete="off" placeholder="Teléfono personal">
						<i class="phone alternate icon"></i>
					</div>
				</div>
			</div>
			@if ($role)
				<div class="fields">
					<div class="{{ $role !== 'student' ? 'sixteen' : 'ten' }} wide field required {{ $errors->has(!$role || $role === 'student' ? 'control_number' : 'valid_email') ? 'error' : '' }}">
						<label>Correo institucional</label>
						<div class="ui right labeled left icon input">
							<input id="email" name="email" type="text" wire:model.lazy="{{ !$role || $role === 'student' ? 'control_number' : 'email' }}" autocomplete="off" {{$role === 'student' ? 'readonly' : ''}} placeholder="Correo institucional">
							<div class="ui basic label">@utgz.edu.mx</div>
							<i class="envelope icon"></i>
						</div>
					</div>
					@if ($role === 'student')
						<div class="six wide field required {{ $errors->has('type') ? 'error' : '' }}">
							<label>Estado</label>
							<select class="ui selection dropdown" id="type" name="type" wire:model.lazy="type">
								<option value="">Seleccionar estado</option>
								<option value="ordinal">Ordinario</option>
								<option value="repeater">Repitiendo</option>
								<option value="burned">Desaprovechado</option>
							</select>
						</div>
					@endif
				</div>
			@endif
			@if ($role === 'adviser' || $role === 'manager')
				<div class="field required {{ $errors->has('area_id') ? 'error' : '' }}">
					<label>Área</label>
					<select class="ui search selection dropdown" id="area_id" name="area_id" wire:model.lazy="area_id">
						<option value="">Seleccionar área</option>
						@foreach ($areas as $area)
							<option value="{{ $area->id }}">{{ $area->name }}</option>
						@endforeach
					</select>
				</div>
			@endif
			@if ($role === 'student')
				<div class="field required {{ $errors->has('career_id') ? 'error' : '' }}">
					<label>Carrera</label>
					<select class="ui search selection dropdown" id="career_id" name="career_id" wire:model.lazy="career_id">
						<option value="">Seleccionar carrera</option>
						@foreach ($careers as $career)
							<option value="{{ $career->id }}">{{ $career->name }} {{ $career->context ?? '' }}</option>
						@endforeach
					</select>
				</div>
			@endif
		</form>
		@include('layouts.partials.messages')
	</div>
	<div class="actions">
		<button class="ui cancel grey button" form="create-user-form" type="reset">Cancelar</button>
		<button class="ui teal right labeled icon button" form="create-user-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="storeUser">Crear registro<i class="check icon"></i></button>
	</div>
</div>
