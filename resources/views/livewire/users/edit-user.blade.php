<div class="ui tiny modal" id="edit-user-{{ $user->id }}-modal" modal-status="uninitialized" wire:ignore.self>
	<div class="ui vertical teal inverted segment huge header">Editar información del usuario</div>
	<div class="scrolling content">
		<form class="ui form" id="edit-user-{{ $user->id }}-form" wire:submit.prevent="updateUser" wire:reset="resetForm" wire:loading.class="loading">
			@csrf
			<div class="two fields">
				<div class="field required {{ $errors->has('user.first_name') ? 'error' : '' }}">
					<label>Nombre(s)</label>
					<div class="ui left icon input">
						<input id="first_name" name="first_name" type="text" wire:model="user.first_name" autocomplete="off" placeholder="Nombre(s)">
						<i class="quote left icon"></i>
					</div>
				</div>
				<div class="field required {{ $errors->has('user.last_name') ? 'error' : '' }}">
					<label>Apellido(s)</label>
					<div class="ui left icon input">
						<input id="last_name" name="last_name" type="text" wire:model="user.last_name" autocomplete="off" placeholder="Apellido(s)">
						<i class="quote right icon"></i>
					</div>
				</div>
			</div>
			<div class="field required {{ $errors->has('user.role') ? 'error' : '' }}">
				<label>Rol</label>
				<select class="ui selection dropdown" id="role" name="role" wire:model="user.role">
					<option value="">Seleccionar rol</option>
					@if (Auth::user()->role === 'super')
						<option value="super">Superusuario</option>
					@endif
					<option value="admin">Administrativo</option>
					<option value="manager">Jefe de área</option>
					<option value="adviser">Asesor</option>
					<option value="student">Estudiante</option>
				</select>
			</div>
			<div class="two fields">
				<div class="field required {{ $errors->has('user.code') ? 'error' : '' }}">
					<label>Número de {{ !$user->role || $user->role === 'student' ? 'control' : 'personal' }}</label>
					<div class="ui left icon input">
						<input id="code" name="code" type="text" wire:model="user.code" autocomplete="off" placeholder="Número de {{ !$user->role || $user->role === 'student' ? 'control' : 'personal' }}">
						<i class="id card alternate icon"></i>
					</div>
				</div>
				<div class="field required {{ $errors->has('user.phone') ? 'error' : '' }}">
					<label>Teléfono personal</label>
					<div class="ui left icon input">
						<input id="phone" name="phone" type="text" maxlength="10" wire:model="user.phone" autocomplete="off" placeholder="Teléfono personal">
						<i class="phone alternate icon"></i>
					</div>
				</div>
			</div>
			@if ($user->role)
				<div class="fields">
					<div class="{{ $user->role !== 'student' ? 'sixteen' : 'ten' }} wide field required {{ $errors->has(!$user->role || $user->role === 'student' ? 'user.code' : 'user.email') ? 'error' : '' }}">
						<label>Correo institucional</label>
						<div class="ui right labeled left icon input">
							<input id="email" name="email" type="text" wire:model="{{ !$user->role || $user->role === 'student' ? 'user.code' : 'help_email' }}" autocomplete="off" {{ $user->role === 'student' ? 'readonly' : '' }} placeholder="Correo institucional">
							<div class="ui basic label">@utgz.edu.mx</div>
							<i class="envelope icon"></i>
						</div>
					</div>
					@if ($user->role === 'student')
						<div class="six wide field required {{ $errors->has('user.type') ? 'error' : '' }}">
							<label>Estado</label>
							<select class="ui selection dropdown" id="type" name="type" wire:model="user.type">
								<option value="">Seleccionar estado</option>
								<option value="ordinal">Ordinario</option>
								<option value="repeater">Repitiendo</option>
								<option value="burned">Desaprovechado</option>
							</select>
						</div>
					@endif
				</div>
			@endif
			@if ($user->role === 'adviser' || $user->role === 'manager')
				<div class="field required {{ $errors->has('user.area_id') ? 'error' : '' }}">
					<label>Área</label>
					<select class="ui search selection dropdown" id="area_id" name="area_id" wire:model="user.area_id">
						<option value="">Seleccionar área</option>
						@foreach ($areas as $area)
							<option value="{{ $area->id }}">{{ $area->name }}</option>
						@endforeach
					</select>
				</div>
			@endif
			@if ($user->role === 'student')
				<div class="field required {{ $errors->has('user.career_id') ? 'error' : '' }}">
					<label>Carrera</label>
					<select class="ui search selection dropdown" id="career_id" name="career_id" wire:model="user.career_id">
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
		<button class="ui cancel grey button" form="edit-user-{{ $user->id }}-form" type="reset">Cancelar</button>
		<button class="ui teal right labeled icon button" form="edit-user-{{ $user->id }}-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="updateUser">Guardar cambios<i class="save icon"></i></button>
	</div>
</div>
