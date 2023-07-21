@section('title', 'Control de carreras')

<div>
  <div class="ui vertical basic segment">
    <div class="ui container">
      <h1 class="ui huge header">Control de carreras</h1>
  
      <form class="ui form" wire:submit.prevent="handleSearch">
        <div class="fields">
          <div class="six wide field">
            <div class="ui {{ $search ? 'action' : '' }} left icon input">
              <input id="search" name="search" type="text" wire:model.debounce.300ms="search" autocomplete="off" autofocus placeholder="Buscar por nombre o contexto">
              <i class="search icon"></i>
              @if ($search)
                <div class="ui red icon button" wire:click="clearSearch"><i class="times icon"></i></div>
              @endif
            </div>
          </div>
          <div class="field">
            <div class="ui fluid teal button" target-modal="create-career-modal"><i class="plus icon"></i>Añadir</div>
          </div>
        </div>
      </form>
  
      @include('layouts.partials.messages')
  
      <div class="ui vertical basic segment">
        <div class="ui three stackable doubling raised link cards">
          @forelse ($careers as $career)
            <div class="card" wire:loading.class="ui loading">
              <div class="content">
                <img class="ui right floated circular tiny image" src="{{ asset('storage/images/careers/' . $career->image) }}">
                <div class="header">{{ $career->name }} {{ $career->context ?? '' }}</div>
                <div class="meta">
                  <div class="ui {{ $career->grade === 'higher' ? 'black' : 'teal' }} horizontal label">{{ $career->grade === 'higher' ? 'ING. / LIC.' : 'T.S.U.' }}</div>
                  <div class="ui horizontal label">
                    <i class="user graduate icon"></i>{{ $career->users->count() }}
                    <div class="detail">Alumnos</div>
                  </div>
                </div>
                <div class="description">
                  <b>Disponible en:</b> {{ $career->availability === 'week' ? 'Escolarizado' : ($career->availability === 'weekend' ? 'Despresurizado' : 'Escolarizado y despresurizado') }}.
                </div>
              </div>
              <div class="extra content">
                Del área de: {{ $career->area->name }}
                <i class="large right floated {{ $career->area->icon }} icon"></i>
              </div>
              <div class="ui two bottom attached buttons">
                <div class="ui teal button" target-modal="edit-career-{{ $career->id }}-modal"><i class="pen icon"></i>Editar</div>
                <div class="ui red button" target-modal="delete-career-{{ $career->id }}-modal"><i class="trash icon"></i>Eliminar</div>
              </div>
            </div>
          @empty
            </div>
            <div class="ui placeholder segment" wire:loading.class="loading">
              <div class="ui icon header">
                <i class="{{ $search ? 'search' : 'exclamation' }} icon"></i>
                {{ $search ? 'No hubo resultados coincidentes, inténtelo de nuevo.' : 'Aún no hay carreras registradas, intente añadir algunas.' }}
              </div>
              @if ($search)
                <section class="ui center aligned container inline">
                  <div class="ui button" wire:click="clearSearch"><i class="times icon"></i>Limpiar búsqueda</div>
                  <div class="ui teal button" target-modal="create-career-modal">Añadir carrera</div>
                </section>
              @else
                <div class="ui teal button" target-modal="create-career-modal">
                  <i class="plus icon"></i>Añadir una carrera
                </div>
              @endif
          @endforelse
        </div>
      </div>
  
      <div class="ui vertical basic segment">
        {{ $careers->links() }}
      </div>
    </div>
  </div>
  
  @foreach ($careers as $career)
    @livewire('careers.edit-career', ['career' => $career], key('edit-career-' . $career->id))
    @livewire('careers.delete-career', ['career' => $career], key('delete-career-' . $career->id))
  @endforeach
  
  @livewire('careers.create-career')
</div>