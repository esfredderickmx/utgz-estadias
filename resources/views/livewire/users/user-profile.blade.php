<div class="ui modal tiny" id="user-profile-modal" wire:ignore.self>
    <div class="ui vertical teal inverted segment huge header">Perfil de Usuario</div>
    <div class="content">
        <form class="ui form" id="user-profile-form" wire:submit.prevent="editProfile" wire:reset="resetForm"
            wire:loading.class="loading">
            <div class="field required {{ $errors->has('user.first_name') ? 'error' : '' }}">
                <label>Nombre</label>
                <div class="ui left icon input">
                    <input id="first_name" name="first_name" wire:model="user.first_name" type="text"
                        placeholder="Nombre">
                    <i class="icon quote right "></i>
                </div>
            </div>
            <div class="field required {{ $errors->has('user.last_name') ? 'error' : '' }}">
                <label>Apellido</label>
                <div class="ui left icon input">
                    <input id="last_nama" name="last_name" wire:model="user.last_name" type="text"
                        placeholder="Apellido">
                    <i class="icon quote left"></i>
                </div>
            </div>
            <div class="field required {{ $errors->has('user.phone') ? 'error' : '' }}">
                <label>Número de teléfono</label>
                <div class="ui left icon input">
                    <input id="phone" name="phone" wire:model="user.phone" type="text" placeholder="Número de teléfono">
                    <i class="icon phone alternate"></i>
                </div>
            </div>
            <div class="field">
                <div class="ui toggle checkbox">
                    <input type="checkbox" name="edit_pass" id="edit_pass" wire:model="edit_pass">
                    <label>Modificar también la contraseña</label>
                </div>
            </div>

            @if($edit_pass)
            <div class="field required {{ $errors->has('password') ? 'error' : '' }}">
                <label>Contraseña</label>
                <div class="ui right action left icon input">
                    <input id="password" name="password" wire:model="password" type="password" placeholder="Contraseña">
                    <i class="icon lock"></i>
                    <div class="ui icon toggle button" data-inverted data-tooltip="Mostrar contraseña"
                        data-variation="tiny" data-position="bottom right">
                        <i class="eye slash icon"></i>
                    </div>
                </div>
            </div>

            <div class="field required {{ $errors->has('password_confirmation') ? 'error' : '' }}">
                <label>Confirmar contraseña</label>
                <div class="ui right action left icon input">
                    <input id="password_confirmation" name="password_confirmation" wire:model="password_confirmation"
                        type="password" placeholder="Confirmar contraseña">
                    <i class="icon unlock"></i>
                    <div class="ui icon toggle button" data-inverted data-tooltip="Mostrar contraseña"
                        data-variation="tiny" data-position="bottom right">
                        <i class="eye slash icon"></i>
                    </div>
                </div>
            </div>
            @endif
        </form>

        @include('layouts.partials.messages')

    </div>

    <div class="actions">
        <button class="ui cancel grey button" form="user-profile-form" type="reset">Cancelar</button>
        <button class="ui teal right labeled icon button" form="user-profile-form" type="submit"
            wire:loading.class="loading" wire:loading.attr="disabled" wire:target="editProfile">Guardar</button>
    </div>
</div>