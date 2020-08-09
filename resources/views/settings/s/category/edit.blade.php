@extends('layouts.master')

@section('content')
<div id="definicoes" class="content">
<div id="elimodal" class="grid-modal align-items-center min-vh-100 justify-content-center">
		<div class="grid-modal-card">
			<h3 class="grid-modal-title text-center mb-4">Tem a certeza que deseja eliminar?</h3>
			<form id="formeliminar" action="/definicoes/s/categorias/" method="POST">
				@method('DELETE')
				@csrf
				<div class="grid-modal-footer d-flex justify-content-center">
					<button id="fechar-elimodal" class="grid-button m-1 cancel">Cancelar</button>
					<button class="grid-button m-1 bgc-red">Eliminar</button>
				</div>
			</form>
		</div>
	</div>
	<a id="fixed-search" class="fixed-icon">
		<i class="grid-search"></i>
	</a>
	<div id="searchbar" class="row">
	</div>
<div class="main">
		<div class="breadcrumb-holder d-flex">
			<div class="flex-grow-1">
				<ol class="breadcrumb pt-3">
					<li class="breadcrumb-item"><a href="{{ url('/definicoes') }}" class="ftc-yellow">Definições</a></li>
					<li class="breadcrumb-item"><a href="{{ url('/definicoes/s/categorias') }}" class="ftc-yellow">Categorias</a></li>
					<li class="breadcrumb-item active" aria-current="page">Editar categoria</li>
				</ol>
			</div>
			<div class="flex-shrink-1 pt-2">
				<a class="grid-btn bgc-red" onClick="abrirmodal({{ $pcategory->id }})">Apagar</a>
			</div>
		</div>
		<div class="card p-4 mt-4">
			<h2 class="mb-3 border-bottom brdc-yellow">Editar categoria</h2>
			<form action="/definicoes/s/categorias/{{ $pcategory->id }}" method="POST">
				@csrf
				@method('PUT')
				<div class="form-group">
					<label for="inputNome">Nome</label>
					<input type="text" class="form-control @error('nome') is-invalid @enderror" id="inputNome" name="nome" value="{{ old('nome', $pcategory->nome) }}"
					aria-describedby="nameHelp" placeholder="Insira nome" required>
					@error('nome')
						<span class="invalid-feedback" role="alert">
							<p>{{ $message }}</p>
						</span>
					@enderror
				</div>
					<div class="form-group">
					<label for="inputAvgref">Referência média</label>
					<input type="number" class="form-control" id="inputAvgref" name="avgref" value="{{ $pcategory->avgref }}"
						aria-describedby="avgrefHelp" placeholder="Insira referência média" required>
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
		$('#formeliminar').attr('action', '/definicoes/s/categorias/' + id);
		$('#elimodal').addClass('show');
	};

	$('#fechar-elimodal').click(function(event) {
		event.preventDefault();
		$('#elimodal').removeClass('show');
	});
</script>
@endsection