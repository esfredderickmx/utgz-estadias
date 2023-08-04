<div class="ui tiny modal" id="edit-process-{{ $process->id }}-modal" modal-status="uninitialized" wire:ignore.self>
	<div class="ui vertical teal inverted segment huge header">Editar información del proceso</div>
	<div class="content">
		<form class="ui form" id="edit-process-{{ $process->id }}-form" wire:submit.prevent="updateProcess" wire:reset="resetForm" wire:loading.class="loading">
			@csrf
			<div class="field required {{ $errors->has('process.period_id') ? 'error' : '' }}">
				<label>Periodo</label>
				<select class="ui search selection dropdown" id="period_id" name="period_id" wire:model="process.period_id">
					<option value="">Seleccionar periodo</option>
					@foreach ($periods as $period)
						<option value="{{ $period->id }}">{{ $period->year }}. {{ $period->quarter === 'first' ? 'Enero - Abril' : ($period->quarter === 'second' ? 'Mayo - Agosto' : 'Septiembre - Diciembre') }}</option>
					@endforeach
				</select>
			</div>
			<div class="field required {{ $errors->has('process.company_id') ? 'error' : '' }}">
				<label>Empresa</label>
				<select class="ui search selection dropdown" id="company_id" name="company_id" wire:model="process.company_id">
					<option value="">Seleccionar empresa</option>
					@foreach ($companies as $company)
						<option value="{{ $company->id }}">{{ $company->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="two fields">
				<div class="field required {{ $errors->has('student_id') ? 'error' : '' }}">
					<label>Estudiante</label>
					<select class="ui search selection dropdown" id="student_id" name="student_id" {{ $process->status === 'approved' || $process->status === 'unapproved' ? 'disabled' : '' }} wire:model="student_id">
						<option value="">Seleccionar estudiante</option>
						@foreach ($students as $student)
							<option value="{{ $student->id }}">{{ $student->code }} - {{ strtok($student->first_name, ' ') . ' ' . strtok($student->last_name, ' ') }}</option>
						@endforeach
					</select>
				</div>
				<div class="field required {{ $errors->has('adviser_id') ? 'error' : '' }}">
					<label>Asesor</label>
					<select class="ui search selection dropdown" id="adviser_id" name="adviser_id" {{ $process->status === 'approved' || $process->status === 'unapproved' ? 'disabled' : '' }} wire:model="adviser_id">
						<option value="">Seleccionar asesor</option>
						@foreach ($advisers as $adviser)
							<option value="{{ $adviser->id }}">{{ strtok($adviser->first_name, ' ') . ' ' . strtok($adviser->last_name, ' ') }} del área de {{ $adviser->area->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			@if ($student_id)
				<div class="two fields">
					<div class="field required {{ $errors->has('process.attempt') ? 'error' : '' }}">
						<label>Intento</label>
						<select class="ui search selection dropdown" id="attempt" name="attempt" disabled wire:model="process.attempt">
							<option value="">Seleccionar intento</option>
							<option value="one">Primer intento</option>
							<option value="two">Segundo intento</option>
							<option value="three">Tercer intento</option>
							<option value="no_more">Sin más intentos</option>
						</select>
					</div>
					<div class="field required {{ $errors->has('process.type') ? 'error' : '' }}">
						<label>Tipo</label>
						<select class="ui search selection dropdown" id="type" name="type" disabled wire:model="process.type">
							<option value="">Seleccionar tipo</option>
							<option value="technician">Técnico Superior</option>
							<option value="higher">Ingeniería / Licenciatura</option>
						</select>
					</div>
				</div>
			@endif
		</form>
		@include('layouts.partials.messages')
	</div>
	<div class="actions">
		<button class="ui cancel grey button" form="edit-process-{{ $process->id }}-form" type="reset">Cancelar</button>
		<button class="ui teal right labeled icon button" form="edit-process-{{ $process->id }}-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="updateProcess">Guardar cambios<i class="save icon"></i></button>
	</div>
</div>
