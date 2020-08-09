@extends('layouts.master')

@section('content')
<div id="definicoes" class="content">
	<div id="elimodal" class="grid-modal align-items-center min-vh-100 justify-content-center">
	<div class="grid-modal-card">
		<h3 class="grid-modal-title text-center mb-4">Tem a certeza que deseja apagar a sua conta? Não pode reverter este processo.</h3>
		<form id="formeliminar" action="/perfil" method="POST">
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
			</div>
			<div class="flex-shrink-1 pt-2">
				<a class="grid-btn bgc-red" onClick="abrirmodal()">Apagar conta</a>
			</div>
		</div>
		<div class="card p-4 mt-4">
			<h2 class="mb-3 border-bottom">Editar perfil</h2>
			<form action="/perfil" method="POST">
				@csrf
				@method('PUT')
				<div class="form-group">
					<label for="inputName">Nome</label>
				<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="inputName" aria-describedby="nameHelp" placeholder="Insira nome" value="{{ Auth::user()->name }}">
						@error('name')
						<span class="invalid-feedback" role="alert">
							<p>{{ $message }}</p>
						</span>
						@enderror
				</div>
				<div class="form-group">
					<label for="currentPass">Password atual*</label>
					<input type="password" name="password_antiga" class="form-control @error('password_antiga') is-invalid @enderror" id="currentPass" aria-describedby="passHelp" required>
						@error('password_antiga')
						<span class="invalid-feedback" role="alert">
							<p>{{ $message }}</p>
						</span>
						@enderror
				</div>
				<div class="form-group">
					<label for="inputPass">Nova password</label>
					<input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="inputPass" aria-describedby="passHelp">
						@error('password')
						<span class="invalid-feedback" role="alert">
							<p>{{ $message }}</p>
						</span>
						@enderror
				</div>
				<div class="form-group">
					<label for="inputPass">Repita a nova password</label>
					<input type="password" name="password_confirmation" class="form-control" id="inputPassRepeat" aria-describedby="passHelp">
				</div>
				<button type="submit" class="grid-btn bgc-main">Atualizar perfil</button>
			</form>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	function abrirmodal(id) {
		$('#elimodal').addClass('show');
	};

	$('#fechar-elimodal').click(function(event) {
		event.preventDefault();
		$('#elimodal').removeClass('show');
	});
</script>
@endsection