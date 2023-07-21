@section('title', 'Control de procesos')

<div>
	<div class="ui vertical basic segment">
		<div class="ui container">
			<h1 class="ui huge header">Control de procesos</h1>

			<form class="ui form" wire:submit.prevent="handleSearch">
				<div class="fields">
					<div class="five wide field">
						<div class="ui {{ $users_search ? 'action' : '' }} left icon input">
							<input id="users_search" name="users_search" type="text" wire:model.debounce.300ms="users_search" autocomplete="off" autofocus placeholder="Buscar por estudiante o asesor">
							<i class="search icon"></i>
							@if ($users_search)
								<div class="ui red icon button" wire:click="clearUsersSearch"><i class="times icon"></i></div>
							@endif
						</div>
					</div>
          <div class="four wide field">
            <select class="ui clearable selection dropdown" id="type_search" name="type_search" wire:model.lazy="type_search">
              <option value="">Buscar por tipo</option>
              <option value="technician">T.S.U.</option>
              <option value="higher">Ing. / Lic.</option>
            </select>
          </div>
          <div class="four wide field">
            <select class="ui clearable selection dropdown" id="status_search" name="status_search" wire:model.lazy="status_search">
              <option value="">Buscar por estado</option>
              <option value="pending">Pendientes</option>
              <option value="developing">En proceso</option>
              <option value="approved">Aprobados</option>
              <option value="unapproved">Reprobados</option>
              <option value="finished">Finalizados</option>
            </select>
          </div>
					<div class="field">
						<div class="ui fluid teal button" target-modal="create-process-modal"><i class="plus icon"></i>Añadir</div>
					</div>
				</div>
			</form>

			@include('layouts.partials.messages')

			<div class="ui vertical basic segment">
				<div class="ui three stackable doubling raised link cards">
					@forelse ($processes as $process)
						<div class="card" wire:loading.class="ui loading">
							<div class="content">
								<div class="right floated">
									<img class="ui circular mini image" src="{{ asset('storage/images/careers/' . $process->student->first()->career->image) }}">
								</div>
								<div class="header"><i class="{{ $process->status === 'unapproved' ? 'times circle' : ($process->status === 'approved' ? 'check circle' : ($process->status === 'developing' ? 'dot circle' : 'circle outline')) }} icon"></i>{{ strtok($process->student->first()->first_name, ' ') . ' ' . strtok($process->student->first()->last_name, ' ') }}</div>
								<div class="meta" data-tooltip="{{ $process->student->first()->career->name }} {{ $process->student->first()->career->context ?? '' }}" data-variation="tiny multiline" data-position="bottom right" data-inverted>{{ $process->period->quarter === 'first' ? 'Enero - Abril' : ($process->period->quarter === 'second' ? 'Mayo - Agosto' : 'Septiembre - Diciembre') }} {{ $process->period->year }}</div>
								<div class="description">
									<div class="ui list">
										<div class="item">
											<i class="chalkboard teacher icon"></i>
											<div class="content">Asesor/a: {{ strtok($process->adviser->first()->first_name, ' ') . ' ' . strtok($process->adviser->first()->last_name, ' ') }}</div>
										</div>
										<div class="item">
											<i class="building icon"></i>
											<div class="content">{{ $process->company->name }}</div>
										</div>
										<div class="item">
											<i class="calendar check icon"></i>
											<div class="content">Revisiones realizadas: {{ $process->reviews->count() }}</div>
										</div>
										<div class="item">
											<i class="certificate icon"></i>
											<div class="content">Calificación final: {{ $process->grade ?? 'Sin asignar' }}</div>
										</div>
										<div class="item">
											<i class="{{ $process->student->first()->career->area->icon }} icon"></i>
											<div class="content">{{ $process->student->first()->career->area->name }}</div>
										</div>
									</div>
								</div>
							</div>
							<div class="extra content">
								<div class="ui {{ $process->attempt === 'one' ? 'olive' : ($process->attempt === 'two' ? 'yellow' : 'orange') }} horizontal label">{{ $process->attempt === 'one' ? '1er' : ($process->attempt === 'two' ? '2do' : '3er') }} intento</div>
								<div class="ui {{ $process->type === 'technician' ? 'teal' : 'black' }} horizontal label">{{ $process->type === 'technician' ? 'T.S.U.' : 'ING. / LIC.' }}</div>
								<div class="ui {{ $process->status === 'unapproved' ? 'red' : ($process->status === 'approved' ? 'green' : ($process->status === 'developing' ? 'blue' : 'grey')) }} horizontal label">{{ $process->status === 'unapproved' ? 'Reprobado' : ($process->status === 'approved' ? 'Aprobado' : ($process->status === 'developing' ? 'En proceso' : 'Pendiente')) }}</div>
							</div>
							<div class="ui two bottom attached buttons">
								<div class="ui teal button" target-modal="edit-process-{{ $process->id }}-modal"><i class="pen icon"></i>Editar</div>
								<div class="ui red button" target-modal="delete-process-{{ $process->id }}-modal"><i class="trash icon"></i>Eliminar</div>
							</div>
						</div>
					@empty
            </div>
            <div class="ui placeholder segment" wire:loading.class="loading">
              <div class="ui icon header">
                <i class="{{ $users_search || $type_search || $status_search ? 'search' : 'exclamation' }} icon"></i>
                {{ $users_search || $type_search || $status_search ? 'No hubo resultados coincidentes, inténtelo de nuevo.' : 'Aún no hay procesos registrados, intente añadir algunos.' }}
              </div>
              @if ($users_search || $type_search || $status_search)
                <section class="ui center aligned container inline">
                  <div class="ui button" wire:click="clearSearch"><i class="times icon"></i>Limpiar búsqueda</div>
                  <div class="ui teal button" target-modal="create-process-modal">Añadir periodo</div>
                </section>
              @else
                <div class="ui teal button" target-modal="create-process-modal">
                  <i class="plus icon"></i>Añadir un periodo
                </div>
              @endif
					@endforelse
				</div>
			</div>

			<div class="ui vertical basic segment">
				{{ $processes->links() }}
			</div>
		</div>
	</div>

	@foreach ($processes as $process)
		@livewire('processes.edit-process', ['process' => $process], key('edit-process-' . $process->id))
		@livewire('processes.delete-process', ['process' => $process], key('delete-process-' . $process->id))
	@endforeach

	@livewire('processes.create-process')
</div>
