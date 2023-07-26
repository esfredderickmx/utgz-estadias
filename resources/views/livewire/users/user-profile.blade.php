<div class="ui modal" target-modal="user-profile-modal" wire:ignore.self>
    <div class="header">
        Editar Perfil
    </div>
    <div class="content">
        <div class="ui form">
            <div class="field">
                <label>Nombre</label>
                <input wire:model.defer="user.name" type="text" placeholder="Nombre">
                @error('user.name') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
                <label>Apellido</label>
                <input wire:model.defer="user.lastname" type="text" placeholder="Apellido">
                @error('user.lastname') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
                <label>Número de teléfono</label>
                <input wire:model.defer="user.phone" type="text" placeholder="Número de teléfono">
                @error('user.phone') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
                <label>Contraseña</label>
                <input wire:model.defer="user.password" type="password" placeholder="Contraseña">
                @error('user.password') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <div class="actions">
        <button class="ui primary button" wire:click="updateUser">Guardar</button>
        <button class="ui button" wire:click="$emit('closeModal')">Cancelar</button>
    </div>
</div>
