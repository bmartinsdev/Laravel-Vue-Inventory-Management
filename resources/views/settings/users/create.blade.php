@extends('layouts.master')

@section('content')
<div id="definicoes" class="content">
	<div class="main">
		<div class="breadcrumb-holder d-flex">
			<div class="flex-grow-1">
				<ol class="breadcrumb pt-3">
					<li class="breadcrumb-item"><a href="{{ url('/definicoes') }}" class="ftc-default">Definições</a></li>
					<li class="breadcrumb-item"><a href="{{ url('/definicoes/utilizadores') }}" class="ftc-default">Utilizadores</a></li>
					<li class="breadcrumb-item active" aria-current="page">Criar utilizador</li>
				</ol>
			</div>
		</div>
		<div class="card p-4 mt-4">
			<h2 class="mb-3 border-bottom">Criar utilizador</h2>
			<form action="/definicoes/utilizadores" method="POST">
				@csrf
				<div class="form-group">
					<label for="inputName">Nome</label>
					<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="inputName" aria-describedby="nameHelp"	
						placeholder="Insira nome" value="{{ old('name') }}" required>
						@error('name')
						<span class="invalid-feedback" role="alert">
							<p>{{ $message }}</p>
						</span>
						@enderror
				</div>
				<div class="form-group">
					<label for="inputEmail">Email</label>
					<input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" aria-describedby="emailHelp" 
						placeholder="Insira email" value="{{ old('email') }}" required>
						@error('email')
						<span class="invalid-feedback" role="alert">
							<p>{{ $message }}</p>
						</span>
						@enderror
				</div>
				<div class="form-group">
					<label for="inputPass">Password</label>
					<input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="inputPass" aria-describedby="passHelp" 
						placeholder="Insira password" required>
						@error('password')
						<span class="invalid-feedback" role="alert">
							<p>{{ $message }}</p>
						</span>
						@enderror
				</div>
				<div class="form-group">
					<label for="inputPass">Repita a password</label>
					<input type="password" name="password_confirmation" class="form-control" id="inputPassRepeat" aria-describedby="passHelp" placeholder="Insira password">
				</div>
				<div class="form-group">
					<label for="selectPerms">Permissões</label>
					<select id="selectPerms" class="form-control mb-3" name="perms" required>
						<option value="1" {{ (old("perms") == 1 ? "selected":"") }}>Utilizador</option>
						<option value="2" {{ (old("perms") == 2 ? "selected":"") }}>Administrador</option>
					</select>
				</div>
				<button type="submit" class="grid-button">Criar</button>
			</form>
		</div>
	</div>
</div>
@endsection