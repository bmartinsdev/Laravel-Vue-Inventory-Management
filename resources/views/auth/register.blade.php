@extends('layouts.masterlogin')

@section('content')
@if(!App\User::adminExists())
<form method="POST" action="{{ route('register') }}">
	@csrf
	<div class="form-group row mt-4">
		<label for="name" class="col-md-12 text-left">Nome</label>
		<div class="col-md-12">
			<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
			@error('name')
			<span class="invalid-feedback" role="alert">
				<p>{{ $message }}</p>
			</span>
			@enderror
		</div>
	</div>

	<div class="form-group row">
		<label for="email" class="col-md-12 text-left">Email</label>
		<div class="col-md-12">
			<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
			@error('email')
			<span class="invalid-feedback" role="alert">
				<p>{{ $message }}</p>
			</span>
			@enderror
		</div>
	</div>

	<div class="form-group row">
		<label for="password" class="col-md-12 text-left">Password</label>

		<div class="col-md-12">
			<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

			@error('password')
			<span class="invalid-feedback" role="alert">
				<p>{{ $message }}</p>
			</span>
			@enderror
		</div>
	</div>

	<div class="form-group row">
		<label for="password-confirm" class="col-md-12 text-left">Repetir password</label>
		<div class="col-md-12">
			<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
				autocomplete="new-password">
		</div>
	</div>

	<div class="form-group row mt-4 mb-0">
		<div class="col-md-12">
			<button type="submit" class="grid-button">
				Criar conta
			</button>
		</div>
	</div>
</form>
@else
<h2 class="mt-4 mb-4">Apenas o administrador pode criar contas.</h2>
<p>Por favor contacte o administrador.</p>
<a href="{{ url('/') }}">
	<button class="grid-button">
		Voltar
	</button>
</a>
@endif
@endsection