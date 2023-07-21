<div class="ui tiny modal" id="edit-company-{{ $company->id }}-modal" modal-status="uninitialized" wire:ignore.self>
	<div class="ui vertical teal inverted segment huge header">Editar información de la empresa</div>
	<div class="scrolling content">
		<form class="ui form" id="edit-company-{{ $company->id }}-form" wire:submit.prevent="updateCompany" wire:reset="resetForm" wire:loading.class="loading">
			@csrf
      <div class="field required {{ $errors->has('company.name') ? 'error' : '' }}">
        <label>Nombre</label>
        <div class="ui left icon input">
          <input id="name" name="name" type="text" wire:model="company.name" autocomplete="off" placeholder="Nombre">
          <i class="quote left icon"></i>
        </div>
      </div>
			<div class="two fields">
        <div class="ten wide field required {{ $errors->has('company.email') ? 'error' : '' }}">
          <label>Correo electrónico</label>
          <div class="ui left icon input">
            <input id="email" name="email" type="text" wire:model="company.email" autocomplete="off" placeholder="Correo electrónico">
            <i class="envelope icon"></i>
          </div>
        </div>
				<div class="six wide field required {{ $errors->has('company.phone') ? 'error' : '' }}">
					<label>Teléfono</label>
					<div class="ui left icon input">
						<input id="phone" name="phone" type="text" maxlength="10" wire:model="company.phone" autocomplete="off" placeholder="Teléfono">
						<i class="phone alternate icon"></i>
					</div>
				</div>
			</div>
      <div class="field">
        <label>Dirección</label>
        <div class="two fields">
          <div class="eleven wide field required {{ $errors->has('company.street') ? 'error' : '' }}">
            <div class="ui left icon input">
              <input id="street" name="street" type="text" wire:model="company.street" autocomplete="off" placeholder="Calle">
              <i class="quote left icon"></i>
            </div>
          </div>
          <div class="five wide field required {{ $errors->has('company.number') ? 'error' : '' }}">
            <div class="ui left icon input">
              <input id="number" name="number" type="text" maxlength="10" wire:model="company.number" autocomplete="off" placeholder="Número">
              <i class="hashtag icon"></i>
            </div>
          </div>
        </div>
        <div class="two fields">
          <div class="five wide field required {{ $errors->has('company.zip') ? 'error' : '' }}">
            <div class="ui left icon input">
              <input id="zip" name="zip" type="number" wire:model="company.zip" autocomplete="off" placeholder="C.P.">
              <i class="hashtag icon"></i>
            </div>
          </div>
          <div class="eleven wide field required {{ $errors->has('company.division') ? 'error' : '' }}">
            <div class="ui left icon input">
              <input id="division" name="division" type="text" wire:model="company.division" autocomplete="off" placeholder="Colonia / fraccionamiento">
              <i class="quote left icon"></i>
            </div>
          </div>
        </div>
        <div class="two fields">
          <div class="field required {{ $errors->has('company.city') ? 'error' : '' }}">
            <div class="ui left icon input">
              <input id="city" name="city" type="text" wire:model="company.city" autocomplete="off" placeholder="Ciudad / municipio">
              <i class="quote left icon"></i>
            </div>
          </div>
          <div class="field required {{ $errors->has('company.state') ? 'error' : '' }}">
            <div class="ui left icon input">
              <input id="state" name="state" type="text" wire:model="company.state" autocomplete="off" placeholder="Estado">
              <i class="quote right icon"></i>
            </div>
          </div>
        </div>
      </div>
		</form>
		@include('layouts.partials.messages')
	</div>
	<div class="actions">
		<button class="ui cancel grey button" form="edit-company-{{ $company->id }}-form" type="reset">Cancelar</button>
		<button class="ui teal right labeled icon button" form="edit-company-{{ $company->id }}-form" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="updateCompany">Guardar cambios<i class="save icon"></i></button>
	</div>
</div>
