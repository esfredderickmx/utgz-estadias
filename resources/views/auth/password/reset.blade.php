<div class="ui tiny test modal" id="reset-modal" data-open-modal="{{ session('openResetModal', false) }}">
	<div class="header">Restablecer contraseña</div>
	<div class="ui justified content container">
		<p>¡Genial, has llegado al paso final para restablecer tu contraseña! Ingresa una nueva contraseña segura y confírmala para completar el proceso y recuperar el acceso a tu cuenta.</p>
		<form class="ui form" id="reset-form" action="{{ route('password.reset') }}" method="POST">
			@csrf
			<input class="hide" name="token" type="hidden" value="{{ session('token', null) }}">
			<div class="field required">
				<label>Matrícula / número de control</label>
				<div class="ui left icon input">
					<input id="reset_email" name="reset_email" type="text" value="{{ session('email', null) }}" readonly required autocomplete="off">
					<i class="envelope icon outline"></i>
				</div>
			</div>
			<div class="field required">
				<label>Contraseña</label>
				<div class="ui action left icon input">
					<input id="reset_password" name="reset_password" type="password" autofocus required autocomplete="off" placeholder="Ingresa una contraseña">
					<div class="ui icon toggle button pop password state" data-content="Alternar visibilidad" data-variation="basic inverted">
						<i class="eye slash icon"></i>
					</div>
					<i class="circle icon outline"></i>
				</div>
			</div>
			<div class="field required">
				<label>Confirmar contraseña</label>
				<div class="ui action left icon input">
					<input id="reset_password_confirmation" name="reset_password_confirmation" type="password" required autocomplete="off" placeholder="Confirma tu contraseña">
					<div class="ui icon toggle button pop password state" data-content="Alternar visibilidad" data-variation="basic inverted">
						<i class="eye slash icon"></i>
					</div>
					<i class="check circle icon outline"></i>
				</div>
			</div>
		</form>
	</div>
	<div class="actions">
		<button class="ui icon button left floated login-toggler pop" data-content="Iniciar sesión" data-variation="basic inverted" form="reset-form" type="reset">
			<i class="sign in icon"></i>
		</button>

		<button class="ui cancel grey button" form="reset-form" type="reset">Cancelar</button>
		<button class="ui teal right labeled icon button" form="reset-form" type="submit">Restablecer<i class="undo icon"></i></button>
	</div>
</div>
