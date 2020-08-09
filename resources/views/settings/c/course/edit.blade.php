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
					<li class="breadcrumb-item"><a href="{{ url('/definicoes') }}" class="ftc-blue">Definições</a></li>
					<li class="breadcrumb-item"><a href="{{ url('/definicoes/c/turmas') }}" class="ftc-blue">Turmas</a></li>
					<li class="breadcrumb-item active" aria-current="page">Editar turma</li>
				</ol>
			</div>
			<div class="flex-shrink-1 pt-2">
				<a class="grid-btn bgc-red" onClick="abrirmodal({{ $course->id }})">Apagar</a>
			</div>
		</div>
		<div class="card p-4 mt-4">
			<h2 class="mb-3 border-bottom brdc-blue">Editar turma</h2>
			<form action="/definicoes/c/turmas/{{ $course->id }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="form-group">
					<label for="inputName">Nome</label>
					<input type="text" class="form-control @error('nome') is-invalid @enderror" id="inputName" name="nome"
						value="{{ old('nome', $course->nome) }}" aria-describedby="nameHelp" placeholder="Insira nome" required>
					@error('nome')
					<span class="invalid-feedback" role="alert">
						<p>{{ $message }}</p>
					</span>
					@enderror
				</div>
				<div class="form-group">
					<label for="formandos">CSV com alunos</label>
					<input type="file" class="form-control @error('formandos') is-invalid @enderror" name="formandos"
						id="formandos" aria-describedby="formandosHelp">
					@error('formandos')
					<span class="invalid-feedback" role="alert">
						<p>{{ $message }}</p>
					</span>
					@enderror
					<small>Para importar uma turma através de um ficheiro excel, por favor crie uma tabela com as seguintes
						colunas "codigo do aluno | nome do aluno" e guarde como CSV UTF-8.</small>
				</div>
				<button type="submit" class="grid-button">Editar</button>
			</form>
			@if (session('error'))
				<div class="alert alert-danger">{{ session('error') }}</div>
			@endif
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	function abrirmodal(id) {
		$('#formeliminar').attr('action', '/definicoes/c/turmas/' + id);
		$('#elimodal').addClass('show');
	};

	$('#fechar-elimodal').click(function(event) {
		event.preventDefault();
		$('#elimodal').removeClass('show');
	});
</script>
@endsection