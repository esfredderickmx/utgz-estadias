<div class="ui tiny test modal" id="login-modal" data-open-modal="{{ session('openLoginModal', false) }}">
	<div class="header">Iniciar sesión</div>
	<div class="content">
		<form class="ui form" id="login-form" action="{{ route('auth.login') }}" method="POST">
      @csrf
			<div class="field required">
				<label>Matrícula / número de control</label>
				<div class="ui left icon right labeled input">
					<input id="login_username" name="login_username" type="text" required autocomplete="off" placeholder="Completa tu correo">
					<div class="ui basic label">@utgz.edu.mx</div>
					<i class="envelope icon outline"></i>
				</div>
			</div>
			<div class="field required">
				<label>Contraseña</label>
				<div class="ui action left icon input">
					<input id="login_password" name="login_password" type="password" required autocomplete="off" placeholder="Ingresa tu contraseña de acceso">
					<div class="ui icon toggle button pop password state" data-content="Alternar visibilidad" data-variation="basic inverted">
						<i class="eye slash icon"></i>
					</div>
					<button class="ui red icon button pop forgot-toggler" data-content="Olvidé mi contraseña" data-variation="basic inverted" form="login-form" type="reset">
						<i class="question icon"></i>
					</button>
					<i class="circle icon outline"></i>
				</div>
			</div>
			<div class="field">
				<div class="ui checkbox">
					<input id="login_remember" name="login_remember" type="checkbox">
					<label>Recordar en este navegador</label>
				</div>
			</div>
		</form>
	</div>
	<div class="actions">
		<button class="ui icon button left floated register-toggler pop" data-content="Mi cuenta no existe" data-variation="basic inverted" form="login-form" type="reset">
			<i class="user left icon"></i>
		</button>

		<button class="ui cancel grey button" form="login-form" type="reset">Cancelar</button>
		<button class="ui teal right labeled icon button" form="login-form" type="submit">Acceder<i class="sign in icon"></i></button>
	</div>
</div>
