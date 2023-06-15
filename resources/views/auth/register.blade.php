<div class="ui tiny test modal" id="register-modal">
	<div class="header">Solictar registro</div>
	<div class="ui justified content container">
		<p>¿Tu cuenta no existe? No te preocupes, estamos aquí para ayudarte a acceder a la plataforma. Ingresa tu dirección de correo institucional para que nuestros administradores se encarguen. Más tarde, recibirás un correo con los detalles de tu situación.</p>
		<form class="ui form" id="register-form">
			<div class="field required">
				<label>Matrícula / número de control</label>
				<div class="ui left icon right labeled input">
					<input id="control-number" name="control-number" type="text" required autocomplete="off" placeholder="Completa tu correo">
					<div class="ui basic label">@utgz.edu.mx</div>
					<i class="envelope icon outline"></i>
				</div>
			</div>
		</form>
	</div>
	<div class="actions">
		<button class="ui icon button left floated login-toggler pop" data-content="Volver" data-variation="basic inverted" form="register-form" type="reset">
			<i class="arrow left icon"></i>
		</button>

		<button class="ui cancel grey button" form="register-form" type="reset">Cancelar</button>
		<button class="ui teal right labeled icon button" form="register-form" type="submit">Solicitar<i class="paper plane icon"></i></button>
	</div>
</div>
