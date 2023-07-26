@section('title', 'Control de áreas')

<div>
  <div class="ui vertical basic segment">
    <div class="ui container">
      <h1 class="ui huge header">Control de áreas</h1>
  
      <form class="ui form" wire:submit.prevent="handleSearch">
        <div class="fields">
          <div class="six wide field">
            <div class="ui {{ $search ? 'action' : '' }} left icon input">
              <input id="search" name="search" type="text" wire:model.debounce.300ms="search" autocomplete="off" autofocus placeholder="Buscar por nombre">
              <i class="search icon"></i>
              @if ($search)
                <div class="ui red icon button" wire:click="clearSearch"><i class="times icon"></i></div>
              @endif
            </div>
          </div>
          <div class="field">
            <div class="ui fluid teal button" target-modal="create-area-modal"><i class="plus icon"></i>Añadir</div>
          </div>
        </div>
      </form>
  
      @include('layouts.partials.messages')
  
      <div class="ui vertical basic segment">
        <div class="ui three stackable doubling raised link cards">
          @forelse ($areas as $area)
            <div class="card" wire:loading.class="ui loading">
              <div class="content">
                <i class="large right floated {{ $area->icon }} icon"></i>
                <div class="header">{{ $area->name }}</div>
                <div class="meta" data-tooltip="@foreach ($area->careers as $career){{ $career->name }} {{ $career->context ?? '' }}
                   @endforeach" data-variation="tiny multiline" data-position="bottom left" data-inverted>{{ $area->careers->count() }} carreras asociadas</div>
                <div class="ui justified description container">
                  <p>{{ $area->description }}</p>
                </div>
              </div>
              <div class="ui two bottom attached buttons">
                <div class="ui teal button" target-modal="edit-area-{{ $area->id }}-modal"><i class="pen icon"></i>Editar</div>
                <div class="ui red button" target-modal="delete-area-{{ $area->id }}-modal"><i class="trash icon"></i>Eliminar</div>
              </div>
            </div>
          @empty
            </div>
            <div class="ui placeholder segment" wire:loading.class="loading">
              <div class="ui icon header">
                <i class="{{ $search ? 'search' : 'exclamation' }} icon"></i>
                {{ $search ? 'No hubo resultados coincidentes, inténtelo de nuevo.' : 'Aún no hay áreas registradas, intente añadir algunas.' }}
              </div>
              @if ($search)
                <section class="ui center aligned container inline">
                  <div class="ui button" wire:click="clearSearch"><i class="times icon"></i>Limpiar búsqueda</div>
                  <div class="ui teal button" target-modal="create-area-modal">Añadir área</div>
                </section>
              @else
                <div class="ui teal button" target-modal="create-area-modal">
                  <i class="plus icon"></i>Añadir un área
                </div>
              @endif
          @endforelse
        </div>
      </div>
  
      <div class="ui vertical basic segment">
        {{ $areas->links() }}
      </div>
    </div>
  </div>
  
  @foreach ($areas as $area)
    @livewire('areas.edit-area', ['area' => $area], key('edit-area-' . $area->id))
    @livewire('areas.delete-area', ['area' => $area], key('delete-area-' . $area->id))
  @endforeach
  
  @livewire('areas.create-area')
</div>
</div>