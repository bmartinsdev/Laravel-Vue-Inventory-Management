@extends('layouts.master')

@section('content')
<div id="definicoes" class="content">
	<div id="elimodal" class="grid-modal align-items-center min-vh-100 justify-content-center">
	<div class="grid-modal-card">
		<h3 class="grid-modal-title text-center mb-4">Tem a certeza que deseja eliminar?</h3>
		<form id="formeliminar" action="/definicoes/c/turmas/" method="POST">
			@method('DELETE')
			@csrf
			<div class="grid-modal-footer d-flex justify-content-center">
				<button id="fechar-elimodal" class="grid-button m-1 cancel">Cancelar</button>
				<button class="grid-button m-1 bgc-red">Eliminar</button>
			</div>
		</form>
	</div>
</div>
	<div class="main">
		<div class="breadcrumb-holder d-flex">
			<div class="flex-grow-1">
				<ol class="breadcrumb pt-3">
					<li class="breadcrumb-item"><a href="{{ url('/definicoes') }}" class="ftc-default">Definições</a></li>
					<li class="breadcrumb-item"><a href="{{ url('/definicoes/utilizadores') }}" class="ftc-default">Utilizadores</a></li>
					<li class="breadcrumb-item active" aria-current="page">Editar utilizador</li>
				</ol>
			</div>
			<div class="flex-shrink-1 pt-2">
				<a class="grid-btn bgc-red" onClick="abrirmodal({{ $user->id }})">Apagar</a>
			</div>
		</div>
		<div class="card p-4 mt-4">
			<h2 class="mb-3 border-bottom">Editar utilizador</h2>
			<form action="/definicoes/utilizadores/{{ $user->id }}" method="POST">
				@csrf
				@method('PUT')
				<div class="form-group">
					<label for="inputName">Nome</label>
				<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="inputName" aria-describedby="nameHelp" 
					placeholder="Insira nome" value="{{ old('name', $user->name) }}" required>
						@error('name')
						<span class="invalid-feedback" role="alert">
							<p>{{ $message }}</p>
						</span>
						@enderror
				</div>
				<div class="form-group">
					<label for="inputEmail">Email</label>
				<input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" aria-describedby="emailHelp" 
					placeholder="Insira email" value="{{ old('email', $user->email) }}" required>
						@error('email')
						<span class="invalid-feedback" role="alert">
							<p>{{ $message }}</p>
						</span>
						@enderror
				</div>
				<div class="form-group">
					<label for="inputPass">Nova password</label>
					<input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="inputPass" aria-describedby="passHelp" 
						placeholder="Insira password">
						@error('password')
						<span class="invalid-feedback" role="alert">
							<p>{{ $message }}</p>
						</span>
						@enderror
				</div>
				<div class="form-group">
					<label for="inputPass">Repita a password</label>
					<input type="password" name="password_confirmation" class="form-control" id="inputPassRepeat" aria-describedby="passHelp" 
						placeholder="Insira password">
				</div>
				<div class="form-group">
					<label for="selectPerms">Permissões</label>
					<select id="selectPerms" class="form-control mb-3" name="perms" required>
						<option value="1" @if(old('perms', $user->perms) == 1) selected @endif>Utilizador</option>
						<option value="2" @if(old('perms', $user->perms) == 2) selected @endif>Administrador</option>
					</select>
					@error('perms')
					<span class="invalid-feedback" role="alert">
						<p>{{ $message }}</p>
					</span>
					@enderror
				</div>
				<button type="submit" class="grid-button">Editar</button>
			</form>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	function abrirmodal(id) {
		$('#formeliminar').attr('action', '/definicoes/utilizadores/' + id);
		$('#elimodal').addClass('show');
	};

	$('#fechar-elimodal').click(function(event) {
		event.preventDefault();
		$('#elimodal').removeClass('show');
	});
</script>
@endsection