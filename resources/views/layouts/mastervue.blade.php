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
	<title>atecGRID</title>

	<!-- Fonts -->
	<link rel="dns-prefetch" href="https://fonts.googleapis.com/css?family=Nunito">

	<!-- Styles -->
	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
	<link href="{{ mix('css/vue.css') }}" rel="stylesheet">
	<link href="{{ mix('css/custom.css') }}" rel="stylesheet">

	@yield('styles')
</head>

<body>
	<div id="logoutmodal" class="grid-modal align-items-center min-vh-100 justify-content-center">
		<div class="grid-modal-card">
			<h3 class="grid-modal-title text-center mb-4">Tem a certeza que deseja fazer logout?</h3>
			<form action="{{ route('logout') }}" method="POST">
				@csrf
				<div class="grid-modal-footer d-flex justify-content-center">
					<button id="fechar-logoutmodal" class="grid-button m-1 cancel">Cancelar</button>
					<button class="grid-button m-1 bgc-red">Logout</button>
				</div>
			</form>
		</div>
	</div>
	<div id="app" class="vue">
		<a class="logo" href="/">
			<svg>
				<g transform="matrix(0.23330039,0,0,0.23330039,-0.11665009,-0.11664866)" style="fill:#999">
					<path
						d="m 50.996,31.987993 q 17.856,0 30.144,9.6 12.48,9.6 16.704,25.152 v -33.408 h 3.648 V 137.01199 h -3.648 v -33.408 q -4.224,15.552 -16.704,25.152 -12.288,9.6 -30.144,9.6 -14.784,0 -26.304,-6.336 -11.52,-6.528 -17.8560005,-18.432 -6.33599996,-12.096 -6.33599996,-28.415997 0,-16.32 6.33599996,-28.224 6.3360005,-12.096 17.8560005,-18.432 11.52,-6.528 26.304,-6.528 z m 0,3.456 q -14.208,0 -24.768,5.952 -10.368,5.952 -16.128,17.28 -5.7600005,11.136 -5.7600005,26.496 0,15.359997 5.7600005,26.687997 5.76,11.136 16.128,17.088 10.56,5.952 24.768,5.952 13.44,0 24,-6.144 10.752,-6.336 16.704,-17.472 6.144,-11.327997 6.144,-26.111997 0,-14.784 -6.144,-25.92 -5.952,-11.328 -16.704,-17.472 -10.56,-6.336 -24,-6.336 z" />
					<path
						d="m 142.556,37.171993 v 72.575997 q 0,9.408 2.112,14.4 2.112,4.992 6.72,7.104 4.608,1.92 12.864,1.92 h 10.944 v 3.84 h -11.328 q -13.44,0 -19.392,-6.144 -5.76,-6.144 -5.76,-21.12 V 37.171993 H 121.82 v -3.84 h 16.896 V 6.8359934 h 3.84 V 33.331993 h 32.64 v 3.84 z" />
					<path
						d="m 244.295,134.89999 q 17.472,0 29.376,-8.832 11.904,-8.832 14.4,-24.192 h 3.84 q -2.688,16.32 -15.36,26.496 -12.48,9.984 -32.256,9.984 -14.4,0 -25.728,-6.336 -11.328,-6.336 -17.856,-18.432 -6.336,-12.096 -6.336,-28.415997 0,-16.32 6.336,-28.416 6.528,-12.096 17.856,-18.432 11.328,-6.336 25.728,-6.336 15.168,0 25.92,6.528 10.752,6.336 16.128,16.512 5.568,10.176 5.568,21.504 0,5.76 -0.768,10.368 h -92.928 q 0.192,15.935997 6.528,26.687997 6.528,10.752 16.896,16.128 10.368,5.184 22.656,5.184 z m 0,-99.455997 q -12.288,0 -22.656,5.376 -10.368,5.184 -16.896,15.936 -6.336,10.752 -6.528,26.688 h 90.24 q 0.96,-15.936 -5.184,-26.688 -5.952,-10.752 -16.512,-15.936 -10.368,-5.376 -22.464,-5.376 z" />
					<path
						d="m 365.045,31.987993 q 19.776,0 32.256,10.176 12.672,9.984 15.36,26.304 h -3.84 q -2.496,-15.36 -14.4,-24.192 -11.904,-8.832 -29.376,-8.832 -12.48,0 -23.04,5.568 -10.368,5.376 -16.704,16.512 -6.336,11.136 -6.336,27.648 0,16.511997 6.336,27.647997 6.336,11.136 16.704,16.704 10.56,5.376 23.04,5.376 17.472,0 29.376,-8.832 11.904,-8.832 14.4,-24.192 h 3.84 q -2.688,16.32 -15.36,26.496 -12.48,9.984 -32.256,9.984 -14.4,0 -25.728,-6.336 -11.328,-6.336 -17.856,-18.432 -6.336,-12.096 -6.336,-28.415997 0,-16.32 6.336,-28.416 6.528,-12.096 17.856,-18.432 11.328,-6.336 25.728,-6.336 z" />
				</g>
				<g transform="matrix(0.23330039,0,0,0.23330039,-0.11665009,-0.11664866)" class="logofill">
					<path
						d="m 500.003,0.49999341 q 23.04,0 38.976,11.51999959 15.936,11.52 21.888,31.296 h -14.016 q -5.184,-13.632 -17.664,-22.08 -12.288,-8.448 -29.184,-8.448 -14.592,0 -26.496,6.912 -11.712,6.912 -18.432,19.776 -6.72,12.864 -6.72,29.952 0,17.472 6.72,30.336 6.912,12.863997 18.816,19.775997 12.096,6.912 27.456,6.912 13.632,0 24.96,-5.952 11.328,-6.144 18.24,-17.664 7.104,-11.519997 8.256,-27.071997 h -56.256 v -10.176 h 67.968 v 11.904 q -1.344,17.28 -9.792,31.103997 -8.256,13.824 -22.464,21.888 -14.016,7.872 -32.064,7.872 -19.2,0 -34.176,-8.64 -14.976,-8.832 -23.232,-24.576 -8.256,-15.743997 -8.256,-35.711997 0,-19.968 8.256,-35.712 8.256,-15.744 23.04,-24.3839996 14.976,-8.83199999 34.176,-8.83199999 z" />
					<path	d="M 661.523,137.01199 624.467,80.563993 H 602.579 V 137.01199 H 588.947 V 1.6519934 h 41.472 q 22.848,0 33.984,10.7519996 11.328,10.752 11.328,28.992 0,16.896 -9.6,26.88 -9.408,9.984 -27.456,11.904 l 38.208,56.831997 z M 602.579,70.387993 h 26.88 q 32.64,0 32.64,-28.224 0,-28.8 -32.64,-28.8 h -26.88 z" />
					<path d="M 711.704,1.6519934 V 137.01199 H 698.072 V 1.6519934 Z" />
					<path	d="m 852.95,69.235993 q 0,20.928 -8.256,36.287997 -8.256,15.168 -24.384,23.424 -15.936,8.064 -38.592,8.064 H 740.822 V 1.6519934 h 40.896 q 34.176,0 52.608,18.0479996 18.624,17.856 18.624,49.536 z m -72.192,55.679997 q 28.608,0 43.584,-14.592 14.976,-14.783997 14.976,-41.087997 0,-26.304 -14.976,-40.896 -14.976,-14.784 -43.584,-14.784 H 754.454 V 124.91599 Z" />
				</g>
			</svg>
		</a>
		<nav id="mobile-nav">
			<router-link to="/" class="single-menu">
				<i class="grid-inventario"></i><span>Inventário</span>
			</router-link>
			<router-link to="/consumiveis" class="single-menu">
				<i class="grid-consumiveis"></i><span>Consumíveis</span>
			</router-link>
			<router-link to="/cacifos" class="single-menu">
				<i class="grid-cacifos"></i><span>Cacifos</span>
			</router-link>
			@if(auth()->user()->isAdmin())
				<a href="{{ url('/definicoes') }}" class="single-menu">
					<i class="grid-definicoes"></i><span>Definições</span>
				</a>
			@else
				<a href="{{ url('/perfil') }}" class="single-menu">
					<i class="grid-utilizador"></i><span>Perfil</span>
				</a>
			@endif
			<a class="single-menu logout-link">
				<i class="grid-logout ftc-red"></i><span>Logout</span>
			</a>
		</nav>
		<aside id="side-bar">
			<nav id="main-menu">
				<router-link to="/" class="single-menu">
					<i class="grid-inventario align-middle"></i><span class="align-middle">Inventário</span>
				</router-link>
				<router-link to="/consumiveis" class="single-menu">
					<i class="grid-consumiveis align-middle"></i><span class="align-middle">Consumíveis</span>
				</router-link>
				<router-link to="/cacifos" class="single-menu">
					<i class="grid-cacifos align-middle"></i><span class="align-middle">Cacifos</span>
				</router-link>
				@if(auth()->user()->isAdmin())
					<a href="{{ url('/definicoes') }}" class="single-menu">
						<i class="grid-definicoes align-middle"></i><span class="align-middle">Definições</span>
					</a>
				@else
					<a href="{{ url('/perfil') }}" class="single-menu">
						<i class="grid-utilizador align-middle"></i><span class="align-middle">Perfil</span>
					</a>
				@endif
				<a class="single-menu logout-link">
					<i class="grid-logout align-middle ftc-red"></i><span class="align-middle">Logout</span>
				</a>
			</nav>
		</aside>
		<div class="topbar">
		</div>
		<div id="wrapper">
			<router-view></router-view>
			<vue-progress-bar></vue-progress-bar>
			<notifications :max="10" :duration="8000"></notifications>
			@yield('content')
		</div>
	</div>
	<script src="{{ mix('js/app.js') }}"></script>
	<script src="{{ mix('js/vue.js') }}"></script>
	<script type="text/javascript">
		var prevScrollpos = window.pageYOffset;
		window.onscroll = function () {
			var currentScrollPos = window.pageYOffset;
			if (prevScrollpos > currentScrollPos) {
				document.getElementById("mobile-nav").style.bottom = "0";
			} else {
				document.getElementById("mobile-nav").style.bottom = "-70px";
			}
			prevScrollpos = currentScrollPos;
		}
		$(document).ready(function () {
			$(".logout-link").click(function () {
				$('#logoutmodal').addClass("show");
			});

			$("#fechar-logoutmodal").click(function (event) {
				event.preventDefault();
				$("#logoutmodal").removeClass("show");
			});
		});
	</script>
	@yield('scripts')
</body>

</html>