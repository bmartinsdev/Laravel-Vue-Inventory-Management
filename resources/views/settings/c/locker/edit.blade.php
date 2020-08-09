@extends('layouts.master')

@section('content')
<div id="definicoes" class="content">
	<div id="elimodal" class="grid-modal align-items-center min-vh-100 justify-content-center">
		<div class="grid-modal-card">
			<h3 class="grid-modal-title text-center mb-4">Tem a certeza que deseja eliminar?</h3>
			<form id="formeliminar" action="/definicoes/c/cacifos/" method="POST">
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
					<li class="breadcrumb-item"><a href="{{ url('/definicoes/c/cacifos') }}" class="ftc-blue">Cacifos</a></li>
					<li class="breadcrumb-item active" aria-current="page">Editar cacifo</li>
				</ol>
			</div>
			<div class="flex-shrink-1 pt-2">
				<a class="grid-btn bgc-red" onClick="abrirmodal({{ $locker->id }})">Apagar</a>
			</div>
		</div>
		<div class="card p-4 mt-4">
			<h2 class="mb-3 border-bottom brdc-blue">Editar cacifo</h2>
			<form action="/definicoes/c/cacifos/{{ $locker->id }}" method="POST">
				@csrf
				@method('PUT')
				<div class="form-group">
					<label for="inputNome">Nome</label>
					<input type="text" class="form-control" id="inputNome" name="nome" value="{{ old('nome', $locker->nome) }}"
						aria-describedby="nomeHelp" placeholder="Insira nome" required>
					@error('nome')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
				<label for="search-local">Selecionar local</label>
				<select id="search-local" class="form-control mb-3 @error('area') is-invalid @enderror" name="area" required>
					@foreach($areas as $area)
					<option value="{{ $area->id }}" @if(old('area', $area->id) == $locker->area_id) selected @endif>{{ $area->nome }}
					</option>
					@endforeach
				</select>
				@error('area')
				<span class="invalid-feedback" role="alert">
					<p>{{ $message }}</p>
				</span>
				@enderror
				<label for="search-typology">Selecionar topologia</label>
				<select id="search-typology" class="form-control mb-3 @error('typology') is-invalid @enderror" name="typology" required>
					@foreach($typologies as $typologies)
					<option value="{{ $typologies->id }}" @if(old('typology', $typologies->id) == $locker->typologies_id) selected @endif>{{ $typologies->nome }}</option>
					@endforeach
				</select>
				@error('typology')
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
		$('#formeliminar').attr('action', '/definicoes/c/cacifos/' + id);
		$('#elimodal').addClass('show');
	};

	$('#fechar-elimodal').click(function(event) {
		event.preventDefault();
		$('#elimodal').removeClass('show');
	});
</script>
@endsection