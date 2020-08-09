<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/apple-touch-icon.png')}}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/favicon-32x32.png')}}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/favicon-16x16.png')}}">
	<link rel="manifest" href="{{asset('assets/site.webmanifest')}}">
	<link rel="mask-icon" href="{{asset('assets/safari-pinned-tab.svg')}}" color="#f8f8f8">
	<meta name="msapplication-TileColor" content="#f8f8f8">
	<meta name="theme-color" content="#f8f8f8">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>atecGRID - Créditos</title>

	<!-- Fonts -->
	<link rel="dns-prefetch" href="https://fonts.googleapis.com/css?family=Nunito">

	<!-- Styles -->
	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
	<link href="{{ mix('css/custom.css') }}" rel="stylesheet">

	@yield('styles')
</head>

<body>
	<div id="loadingoverlay">
		<div class="loadingcontainer">
			<svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 100 100" version="1.1" class="loadinglogo">
				<g transform="matrix(1.7259084,0,0,1.7259084,-1.2769168e-6,-1.1632367e-5)">
					<path
						style="fill:#cd9f63;fill-opacity:1;stroke:none;stroke-width:0.19842638px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
						d="M 0,0 V 18.25523 H 38.097866 V 0 Z" class="yellow" />
					<path
						style="fill:#c94731;fill-opacity:1;stroke:none;stroke-width:0.19842638px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
						d="M 39.685277,0 H 57.940504 V 57.940516 H 39.685277 Z" class="red" />
					<path
						style="fill:#414141;fill-opacity:1;stroke:none;stroke-width:0.19842638px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
						d="M 0,39.685279 H 18.255228 V 57.940516 H 0 Z" class="black" />
					<path
						style="fill:#4e6e7d;fill-opacity:1;stroke:none;stroke-width:0.19842638px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
						d="M 19.84264,57.940516 H 38.097866 V 19.842635 H 0 v 18.255231 h 19.84264 z" class="blue" />
				</g>
			</svg>
		</div>
	</div>
	@if ($message = Session::get('success'))
	<div class="grid-notification success" onclick="removeNotifications()">
		<div class="grid-notification-template">{{ $message }}
		</div>
	</div>
	@endif
	@if ($message = Session::get('warning'))
	<div class="grid-notification fail" onclick="removeNotifications()">
		<div class="grid-notification-template">{{ $message }}
		</div>
	</div>
	@endif
	<div class="content mb-4">
		<div class="creditos mt-4 mb-4 text-center">
			<h1 class="mt-4">Criado por</h1>
			<p class="mt-4"><a href="https://www.linkedin.com/in/brunorodrigues355/">Bruno Rodrigues</a></p>
			<p><a href="https://www.linkedin.com/in/spgcastro/">Sónia Castro</a></p>
			<h1 class="mt-4">Dependências</h1>
			<p class="mt-4"><a href="https://laravel.com/">Laravel</a></p>
			<p><a href="https://getbootstrap.com/">Bootstrap</a></p>
			<p><a href="https://github.com/lodash/lodash">Lodash</a></p>
			<p><a href="https://developers.google.com/web/tools/workbox">WorkBox</a></p>
			<p><a href="https://github.com/vuejs/vue">Vue Js</a></p>
			<p><a href="https://github.com/vuejs/vue-router">Vue Router</a></p>
			<p><a href="https://github.com/SortableJS/Vue.Draggable">Vue Draggable</a></p>
			<p><a href="https://github.com/euvl/vue-notification">Vue Notification</a></p>
			<p><a href="https://github.com/hilongjw/vue-progressbar">Vue Progressbar</a></p>
			<p><a href="https://github.com/mercs600/vue2-perfect-scrollbar">Vue2 Perfect Scrollbar</a></p>
			<p><a href="https://github.com/paulcollett/vue-masonry-css">Vue Masonry Css</a></p>
			<p><a href="https://github.com/paliari/v-autocomplete">V-Autocomplete</a></p>
			<p><a href="https://github.com/apertureless/vue-chartjs">Vue Chartjs</a></p>
			<p class="mb-4"><a href="https://github.com/select2/select2">Select2</a></p>
			<h3><a href="{{ URL::previous() }}" class="mt-4 mb-4 ftc-red">VOLTAR</a></h3>
		</div>
	</div>
	<script src="{{ mix('js/app.js') }}"></script>
	<script src="{{ mix('js/settings.js') }}"></script>
	<script type="text/javascript">
		function removeNotifications(){
			$('.grid-notification').fadeOut(300, function(){ 
				$(this).remove();
			});
		}
		$(document).ready(function () {
			setTimeout(function() { removeNotifications() }, 6000);
		});
	</script>
</body>

</html>