@extends('layouts.masterlogin')

@section('content')
@if(App\User::adminExists())
<form method="POST" class="login" action="{{ route('login') }}">
	@csrf

	<div class="form-group row">
		<label for="email" class="col-form-label col-12">
			Email
		</label>

		<div class="col-md-12">
			<div class="input-group">
				<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"	value="{{ old('email') }}" required autocomplete="email" autofocus />
				<label for="email" class="input-group-prepend">
					<i class="grid-utilizador"></i>
				</label>
				@error('email')
				<span class="invalid-feedback" role="alert">
					<p>{{ $message }}</p>
				</span>
				@enderror
			</div>
			<small>admin@admin.com | user@user.com</small>
		</div>
	</div>

	<div class="form-group row">
		<label for="password" class="col-form-label col-12">{{ __('Password') }}</label>

		<div class="col-md-12">
			<div class="input-group">
			<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"/>
				<label for="password" class="input-group-prepend">
					<i class="grid-password"></i>
				</label>
			@error('password')
			<span class="invalid-feedback" role="alert">
				<p>{{ $message }}</p>
			</span>
			@enderror
			</div>
			<small>atec+123</small>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-md-12 text-left">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="remember" id="remember"
					{{ old('remember') ? 'checked' : '' }}>

				<label class="form-check-label" for="remember">
					Lembrar-me
				</label>
			</div>
		</div>
	</div>

	<div class="form-group row mb-0">
		<div class="col-md-12 flex-box-container">
			<button type="submit" class="grid-button">
				{{ __('Login') }}
			</button>

			@if (Route::has('password.request'))
			<div class="d-flex justify-content-center mt-2">
				<a class="btn btn-link ftc-default" href="{{ route('password.request') }}">
					Esqueceu a password?
				</a>
			</div>
			@endif
		</div>
	</div>
</form>
@else
	<h2 class="mt-4 mb-4">Bem vindo à configuração de atecGRID!</h2>
	<p>Para começar precisamos de uma conta de administração.</p>
	<p>Por favor clique no seguinte link para passar à página de registro.</p>
	<a href="{{ route('register') }}">
		<button class="grid-button">
			Criar conta
		</button>
	</a>
@endif

@endsection