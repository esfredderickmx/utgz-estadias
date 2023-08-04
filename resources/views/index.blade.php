@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
	<div>
		<div class="ui vertical stripe segment very padded">
			<div class="ui middle aligned stackable container grid">
				<div class="sixteen wide column">
					@include('layouts.partials.messages')
				</div>
				<div class="row">
					<div class="seven wide column">
						<h3 class="ui header">Bienvenidos al programa de estadías</h3>
						<p>Nuestro programa de estadías ofrece una oportunidad única para aplicar los conocimientos teóricos adquiridos en el aula en un entorno laboral real.</p>
						<h3 class="ui header">¿De qué se trata?</h3>
						<p>La estadía es un periodo de tiempo en el que los estudiantes tienen la oportunidad de trabajar en empresas e instituciones del sector tecnológico, desarrollando proyectos y adquiriendo experiencia práctica. Durante esta etapa, los estudiantes fotalecen sus habilidades técnicas y competencias profesionales.</p>
					</div>
					<div class="eight wide right floated column">
						<img class="ui large bordered centered image rounded" src="{{ asset('img/practices.jpg') }}">
					</div>
				</div>
				<div class="row">
					<div class="center aligned column">
						<div class="ui huge grey animated fade button" target-modal="verify-access-modal">
							<div class="content visible">¿Ya es mi turno?</div>
							<div class="content hidden">Comprobar</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="ui vertical stripe segment padded">
			<div class="ui middle aligned equal width stackable divided container grid">
				<div class="center aligned row">
					<div class="column">
						<img class="ui tiny centered circular image" src="{{ asset('img/tics.png') }}">
						<h2>"La estadía me permitió aplicar mis conocimientos en un entorno real y descubrir mi pasión por la programación web."</h2>
						<p><b>Jesús Isaías</b>, Ingeniería en Desarrollo y Gestión de Software.</p>
					</div>
					<div class="column">
						<img class="ui tiny centered circular image" src="{{ asset('img/oci.png') }}">
						<h2>"Esta estadía consolidó mi interés en el comercio internacional y me brindó una perspectiva práctica invaluable que complementa mis estudios académicos."</h2>
						<p><b>Nadir Luna</b>, Ingeniería en Logística Internacional.</p>
					</div>
					{{-- <div class="column">
          <img class="ui small centered circular image" src="{{asset('img/tics.jpg')}}">
					<h2>"La estadía me permitió coger a madres, engañar a mi vieja y hacerme pero re-bien pendejo, sin duda alguna, mi mejor momento."</h2>
					<p><b>Jesús Isaías</b>, Ingeniería en Desarrollo y Gestión de Software.</p>
				</div>
				<div class="column">
          <img class="ui small centered circular image" src="{{asset('img/oci.jpg')}}">
					<h2>"Esta estadía consolidó los pensamientos que tenía acerca de la poca verga que valgo. Lo único que me dejo fue un engaño."</h2>
					<p><b>Nadir Luna</b>, Ingeniería en Logística Internacional.</p>
				</div> --}}
				</div>
			</div>
		</div>
		<div class="ui vertical stripe segment very padded">
			<div class="ui text container">
				<h3 class="ui header">Compromiso con la calidad y el aprendizaje continuo</h3>
				<p>En nuestra Universidad Tecnológica, nos comprometemos a brindar a nuestros estudiantes una experiencia de estadía de calidad, donde puedan alcanzar sus metas académicas y profesionales. Para lograrlo, contamos con un equipo de profesionales altamente capacitados que supervisan y apoyan a los estudiantes a lo largo de todo el proceso.</p>
				<a class="ui teal large button">Saber más</a>
				<div class="ui horizontal divider">
					<h2>INTERESES</h2>
				</div>
				<h3 class="ui header">Oportunidades de networking y desarrollo profesional</h3>
				<p>Una de las ventajas más destacadas de participar en nuestro Programa de Estadías es la amplia red de contactos que nuestros estudiantes pueden establecer en la industria tecnológica. Durante su estadía, tendrán la oportunidad de interactuar con profesionales, expertos y líderes de diferentes empresas e instituciones.</p>
				<a class="ui teal large button">Me interesa</a>
			</div>
		</div>

	
	
		@guest
			@livewire('authentication.login')
			@livewire('authentication.verify-access')
			@livewire('authentication.password.forgot')
			@livewire('authentication.password.reset', ['token' => session('token', null), 'username' => session('username', null)])
		@endguest
	</div>
@endsection
