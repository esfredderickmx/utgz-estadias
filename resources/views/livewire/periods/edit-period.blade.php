<div class="ui tiny test modal" id="" modal-status="uninitialized" wire:ignore.self>
    <div class="ui vertical teal inverted segment huge header">Editar datos del periodo</div>
    <div class="content">
        <form class="ui form" id="" wire:submit.prevent="updatePeriod" wire:reset="resetForm"
            wire:loading.class="loading">
            @csrf
            <div class="field required">
                <label>Inicio</label>
                <div class="ui left icon input">
                    <input id="name" name="name" type="text" wire:model="name" autocomplete="off"
                        placeholder="Mes en el que inicia">
                    <i class="quote left icon"></i>
                </div>
            </div>
            <div class="field required">
                <label>Fin</label>
                <div class="ui left icon input">
                    <input id="context" name="context" type="text" wire:model="context" autocomplete="off"
                        placeholder="Mes en el que finaliza">
                    <i class="quote right icon"></i>
                </div>
            </div>
            <div class="field required">
                <label>Año</label>
                <div class="ui left icon input">
                    <input id="context" name="context" type="text" wire:model="" autocomplete="off" placeholder="Año">
                </div>
            </div>
        </form>
        @include('layouts.partials.messages')
    </div>
    <div class="actions">
        <button class="ui cancel grey button" form="" type="reset">Cancelar</button>
        <button class="ui teal right labeled icon button" form="" type="submit" wire:loading.class="loading"
            wire:loading.attr="disabled" wire:target="updatePeriod">Guardar cambios<i class="save icon"></i></button>
    </div>
</div>