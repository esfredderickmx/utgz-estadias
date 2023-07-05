@section('title', 'Periodos')

<div class="ui vertical basic segment">
    <div class="ui container">
        <h1 class="ui huge header">Control de Periodos</h1>
        <form class="ui form" wire:submit.prevent="handleSearch">
            <div class="fields">
                <div class="six wide field">
                    <div class="ui left icon input">
                        <input id="search" name="search" type="text" wire:model.debounce.300ms="search"
                            autocomplete="off" autofocus placeholder="Realizar búsqueda...">
                    </div>
                </div>
                <div class="field">
                    <div class="ui fluid teal button" target-modal="create-period-modal"><i class="plus icon"></i>Añadir
                    </div>
                </div>
            </div>
        </form>
        @include('layouts.partials.messages')
        <div class="ui vertical basic segment">
            <div class="ui three stackable doubling raised link cards">
                <div class="card" wire:loading.class="ui loading">
                    <div class="content">
                        <img class="right floated tiny ui image" src="">
                        <div class="header"></div>
                        <div class="meta">
                            <a class="ui label"></a>
                        </div>
                        <div class="description">
                            <b></b>
                        </div>
                    </div>
                    <div class="extra content">
                        <div class="right floated" data-tooltip="" data-variation="mini" data-position="left center"
                            data-inverted>
                            <i class="large icon"></i>
                        </div>
                    </div>
                    <div class="ui two bottom attached buttons">
                        <div class="ui teal button" target-modal=""><i class="pen icon"></i>Editar</div>
                        <div class="ui red button" target-modal=""><i class="trash icon"></i>Eliminar</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
