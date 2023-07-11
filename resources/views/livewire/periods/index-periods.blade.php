@section('title', 'Control de periodos')

<div class="ui vertical basic segment">
	<div class="ui container">
		<h1 class="ui huge header">Control de periodos</h1>

		<form class="ui form" wire:submit.prevent="handleSearch">
			<div class="fields">
				<div class="six wide field">
					<select class="ui clearable selection dropdown" id="quarter_search" name="quarter_search" wire:model.lazy="quarter_search">
						<option value="">Buscar por cuatrimestre</option>
						<option value="first">Enero - Abril</option>
						<option value="second">Mayo - Agosto</option>
						<option value="third">Septiembre - Diciembre</option>
					</select>
				</div>
				<div class="four wide field">
					<div class="ui calendar"  data-type="year">
						<div class="ui {{ $year_search ? 'action' : '' }} input left icon">
							<input id="year_search" name="year_search" type="number" wire:model.lazy="year_search" autocomplete="off" placeholder="Buscar por año">
							<i class="calendar icon"></i>
							@if ($year_search)
								<div class="ui red icon button" wire:click="clearYearSearch"><i class="times icon"></i></div>
							@endif
						</div>
					</div>
				</div>
				<div class="field">
					<div class="ui fluid teal button" target-modal="create-period-modal"><i class="plus icon"></i>Añadir</div>
				</div>
			</div>
		</form>

		@include('layouts.partials.messages')

		<div class="ui vertical basic segment">
			<div class="ui four stackable doubling raised link cards">
				@forelse ($periods as $period)
					<div class="card" wire:loading.class="ui loading">
						<div class="center aligned content">
							<div class="ui large statistic">
								<div class="label">{{ $period->quarter === 'first' ? 'Enero - Abril' : ($period->quarter === 'second' ? 'Mayo - Agosto' : 'Septiembre - Diciembre') }}
								</div>
								<div class="value">{{ $period->year }}</div>
							</div>
						</div>
						<div class="ui two bottom attached buttons">
							<div class="ui teal button" target-modal="edit-period-{{ $period->id }}-modal"><i class="pen icon"></i>Ed.</div>
							<div class="ui red button" target-modal="delete-period-{{ $period->id }}-modal"><i class="trash icon"></i>Elim.</div>
						</div>
					</div>
				@empty
          </div>
          <div class="ui placeholder segment" wire:loading.class="loading">
            <div class="ui icon header">
              <i class="{{ $quarter_search || $year_search ? 'search' : 'exclamation' }} icon"></i>
              {{ $quarter_search || $year_search ? 'No hubo resultados coincidentes, inténtelo de nuevo.' : 'Aún no hay periodos registrados, intente añadir algunos.' }}
            </div>
            @if ($quarter_search || $year_search)
              <section class="ui center aligned container inline">
                <div class="ui button" wire:click="clearSearch"><i class="times icon"></i>Limpiar búsqueda</div>
                <div class="ui teal button" target-modal="create-period-modal">Añadir periodo</div>
              </section>
            @else
              <div class="ui teal button" target-modal="create-period-modal">
                <i class="plus icon"></i>Añadir un periodo
              </div>
            @endif
				@endforelse
			</div>
		</div>

		@foreach ($periods as $period)
			@livewire('periods.edit-period', ['period' => $period], key('edit-period-' . $period->id))
			@livewire('periods.delete-period', ['period' => $period], key('delete-period-' . $period->id))
		@endforeach

		@livewire('periods.create-period')

		<div class="ui vertical basic segment">
			{{ $periods->links() }}
		</div>
	</div>
</div>
