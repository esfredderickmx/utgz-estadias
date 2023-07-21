@section('title', 'Control de empresas')

<div>
  <div class="ui vertical basic segment">
    <div class="ui container">
      <h1 class="ui huge header">Control de empresas</h1>
  
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
            <div class="ui fluid teal button" target-modal="create-company-modal"><i class="plus icon"></i>Añadir</div>
          </div>
        </div>
      </form>
  
      <div class="ui vertical basic segment">
        <table class="ui selectable single line very basic celled table">
          <thead>
            <tr class="center aligned">
              <th>Nombre</th>
              <th>Correo electrónico</th>
              <th>Teléfono</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($companies as $company)
              <tr class="center aligned">
                <td>{{ $company->name }}</td>
                <td>{{ $company->email }}</td>
                <td>{{ $company->phone }}</td>
                <td class="collapsing right aligned">
                  <div class="ui teal icon button" target-modal="edit-company-{{ $company->id }}-modal"><i class="pen icon"></i></div>
                  <div class="ui red icon button" target-modal="delete-company-{{ $company->id }}-modal"><i class="trash icon"></i></div>
                </td>
              </tr>
            @empty
              </tbody>
              </table>
              <div class="ui placeholder segment" wire:loading.class="loading">
                <div class="ui icon header">
                  <i class="{{ $search ? 'search' : 'exclamation' }} icon"></i>
                  {{ $search ? 'No hubo resultados coincidentes, inténtelo de nuevo.' : 'Aún no hay empresas registradas, intente añadir algunas.' }}
                </div>
                @if ($search)
                  <section class="ui center aligned container inline">
                    <div class="ui button" wire:click="clearSearch"><i class="times icon"></i>Limpiar búsqueda</div>
                    <div class="ui teal button" target-modal="create-company-modal">Añadir empresa</div>
                  </section>
                @else
                  <div class="ui teal button" target-modal="create-company-modal">
                    <i class="plus icon"></i>Añadir una empresa
                  </div>
                @endif
              </div>
            @endforelse
          </tbody>
        </table>
      </div>
  
      <div class="ui vertical basic segment">
        {{ $companies->links() }}
      </div>
    </div>
  </div>
  
  @foreach ($companies as $company)
    @livewire('companies.edit-company', ['company' => $company], key('edit-company-' . $company->id))
    @livewire('companies.delete-company', ['company' => $company], key('delete-company-' . $company->id))
  @endforeach
  
  @livewire('companies.create-company')
</div>