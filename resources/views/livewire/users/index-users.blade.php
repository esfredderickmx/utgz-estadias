@section('title', 'Control de usuarios')

<div>
  <div class="ui vertical basic segment">
    <div class="ui container">
      <h1 class="ui huge header">Control de usuarios</h1>
  
      <form class="ui form" wire:submit.prevent="handleSearch">
        <div class="fields">
          <div class="six wide field">
            <div class="ui {{ $search ? 'action' : '' }} left icon input">
              <input id="search" name="search" type="text" wire:model.debounce.300ms="search" autocomplete="off" autofocus placeholder="Buscar por nombre o apellido">
              <i class="search icon"></i>
              @if ($search)
                <div class="ui red icon button" wire:click="clearSearch"><i class="times icon"></i></div>
              @endif
            </div>
          </div>
          <div class="field">
            <div class="ui fluid teal button" target-modal="create-user-modal"><i class="plus icon"></i>Añadir</div>
          </div>
        </div>
      </form>
  
      @include('layouts.partials.messages')
  
      <div class="ui vertical basic segment">
        <table class="ui selectable single line very basic celled table">
          <thead>
            <tr class="center aligned">
              <th>Rol</th>
              <th>Nombre</th>
              <th>Correo electrónico</th>
              <th>Teléfono</th>
              <th>Oportunidades</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $user)
              <tr class="center aligned">
                <td data-tooltip="{{ $user->role === 'super' ? 'Superusuario' : ($user->role === 'admin' ? 'Administrativo' : ($user->role === 'manager' ? 'Jefe de área' : ($user->role === 'adviser' ? 'Asesor' : 'Estudiante'))) }}" data-variation="tiny" data-position="bottom center" data-inverted>
                  <div wire:loading.remove>
                    <i class="{{ $user->role === 'super' ? 'user astronaut' : ($user->role === 'admin' ? 'user cog' : ($user->role === 'manager' ? 'user tie' : ($user->role === 'adviser' ? 'chalkboard teacher' : 'user graduate'))) }} icon"></i>
                  </div>
                  <div wire:loading.class="active" class="ui inline small loader"></div>
                </td>
                <td>{{ strtok($user->first_name, ' ') . ' ' . strtok($user->last_name, ' ') }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td class="{{ !$user->type ? '' : ($user->type === 'ordinal' ? 'positive' : ($user->type === 'repeater' ? 'warning' : 'negative')) }}"><i class="{{ !$user->type ? 'ban' : ($user->type === 'ordinal' ? 'check' : ($user->type === 'repeater' ? 'exclamation' : 'times')) }} icon"></i> {{ !$user->type ? 'No aplica' : ($user->type === 'ordinal' ? 'Ordinario' : ($user->type === 'repeater' ? 'Repetidor' : 'Desaprovechado')) }}</i></td>
                <td class="collapsing right aligned">
                  <div class="ui teal icon button" target-modal="edit-user-{{ $user->id }}-modal"><i class="pen icon"></i></div>
                  <div class="ui red icon button" target-modal="delete-user-{{ $user->id }}-modal"><i class="trash icon"></i></div>
                </td>
              </tr>
            @empty
              </tbody>
              </table>
              <div class="ui placeholder segment" wire:loading.class="loading">
                <div class="ui icon header">
                  <i class="{{ $search ? 'search' : 'exclamation' }} icon"></i>
                  {{ $search ? 'No hubo resultados coincidentes, inténtelo de nuevo.' : 'Aún no hay usuarios registrados, intente añadir algunos.' }}
                </div>
                @if ($search)
                  <section class="ui center aligned container inline">
                    <div class="ui button" wire:click="clearSearch"><i class="times icon"></i>Limpiar búsqueda</div>
                    <div class="ui teal button" target-modal="create-user-modal">Añadir usuario</div>
                  </section>
                @else
                  <div class="ui teal button" target-modal="create-user-modal">
                    <i class="plus icon"></i>Añadir un usuario
                  </div>
                @endif
              </div>
            @endforelse
          </tbody>
        </table>
      </div>
  
      <div class="ui vertical basic segment">
        {{ $users->links() }}
      </div>
    </div>
  </div>
  
  @foreach ($users as $user)
    @livewire('users.edit-user', ['user' => $user], key('edit-user-' . $user->id))
    @livewire('users.delete-user', ['user' => $user], key('delete-user-' . $user->id))
  @endforeach
  
  @livewire('users.create-user')
</div>
