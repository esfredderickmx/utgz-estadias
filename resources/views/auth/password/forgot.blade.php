<div class="ui tiny test modal" id="forgot-modal">
	<div class="header">Solictar restablecimiento</div>
	<div class="ui justified content container">
		<p>¿Olvidaste tu contraseña? No te preocupes, estamos aquí para ayudarte a recuperar el acceso a tu cuenta. Ingresa tu dirección de correo institucional asociada con tu cuenta y te enviaremos un enlace para restablecer tu contraseña.</p>
		<form class="ui form" id="forgot-form" action="{{ route('password.forgot') }}" method="POST">
      @csrf
			<div class="field required">
				<label>Matrícula / número de control</label>
				<div class="ui left icon right labeled input">
					<input id="forgot_email" name="forgot_email" type="text" required autocomplete="off" placeholder="Completa tu correo">
					<div class="ui basic label">@utgz.edu.mx</div>
					<i class="envelope icon outline"></i>
				</div>
			</div>
		</form>
	</div>
	<div class="actions">
		<button class="ui icon button left floated login-toggler pop" data-content="Volver" data-variation="basic inverted" form="forgot-form" type="reset">
			<i class="arrow left icon"></i>
		</button>

		<button class="ui cancel grey button" form="forgot-form" type="reset">Cancelar</button>
		<button class="ui teal right labeled icon button" form="forgot-form" type="submit">Solicitar<i class="paper plane icon"></i></button>
	</div>
</div>
