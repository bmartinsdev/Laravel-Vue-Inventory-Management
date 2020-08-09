@extends('layouts.master')

@section('content')
<div id="definicoes" class="content">
	<div id="elimodal" class="grid-modal align-items-center min-vh-100 justify-content-center">
		<div class="grid-modal-card">
			<h3 class="grid-modal-title text-center mb-4">Tem a certeza que deseja eliminar?</h3>
			<form id="formeliminar" action="/definicoes/c/formandos/" method="POST">
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
					<li class="breadcrumb-item"><a href="{{ url('/definicoes/c/formandos') }}" class="ftc-blue">Formandos</a></li>
					<li class="breadcrumb-item active" aria-current="page">Editar formando</li>
				</ol>
			</div>
			<div class="flex-shrink-1 pt-2">
				<a class="grid-btn bgc-red" onClick="abrirmodal({{ $student->id }})">Apagar</a>
			</div>
		</div>
		<div class="card p-4 mt-4">
			<h2 class="mb-3 border-bottom brdc-blue">Editar formando</h2>
			<form action="/definicoes/c/formandos/{{ $student->id }}" method="POST">
				@csrf
				@method('PUT')
				<div class="form-group">
					<label for="inputCodigo">Código</label>
					<input type="text" class="form-control" id="inputCodigo" name="codigo"
						value="{{ old('codigo', $student->codigo) }}" aria-describedby="nameHelp" placeholder="Insira código" disabled>
					@error('codigo')
					<span class="invalid-feedback" role="alert">
						<p>{{ $message }}</p>
					</span>
					@enderror
				</div>
				<div class="form-group">
					<label for="inputNome">Nome</label>
					<input type="text" class="form-control" id="inputNome" name="nome" value="{{ old('nome', $student->nome) }}"
						aria-describedby="nameHelp" placeholder="Insira nome" required>
					@error('codigo')
					<span class="invalid-feedback" role="alert">
						<p>{{ $message }}</p>
					</span>
					@enderror
				</div>
				<label for="selectTurma">Turma</label>
				<select id="selectTurma" class="form-control mb-3" name="course" required>
					@foreach($courses as $course)
					<option value="{{ $course->id }}" @if(old('course', $course->id) == $student->course) selected @endif>{{ $course->nome }}</option>
					@endforeach
				</select>
				@error('course')
				<span class="invalid-feedback" role="alert">
					<p>{{ $message }}</p>
				</span>
				@enderror
				<button type="submit" class="grid-button">Editar</button>
			</form>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	function abrirmodal(id) {
		$('#formeliminar').attr('action', '/definicoes/c/formandos/' + id);
		$('#elimodal').addClass('show');
	};

	$('#fechar-elimodal').click(function(event) {
		event.preventDefault();
		$('#elimodal').removeClass('show');
	});
</script>
@endsection