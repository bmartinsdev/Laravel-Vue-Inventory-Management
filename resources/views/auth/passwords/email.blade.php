@extends('layouts.masterlogin')

@section('content')
<form method="POST" action="{{ route('password.email') }}">
	@csrf

	@if (session('status'))
	<div class="alert alert-success" role="alert">
		{{ session('status') }}
	</div>
	@endif
	<div class="form-group row mt-4">
		<label for="email" class="col-12">Email</label>

		<div class="col-md-12">
			<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
				value="{{ old('email') }}" required autocomplete="email" autofocus>

			@error('email')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
			@enderror
		</div>
	</div>

	<div class="form-group row mt-4 mb-0">
		<div class="col-12">
			<button type="submit" class="grid-button">
				Recuperar password
			</button>
		</div>
	</div>
</form>
@endsection