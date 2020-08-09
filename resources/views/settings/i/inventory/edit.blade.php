@extends('layouts.master')
@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div id="definicoes" class="content">
	<div id="elimodal" class="grid-modal align-items-center min-vh-100 justify-content-center">
		<div class="grid-modal-card">
			<h3 id="modal-text" class="grid-modal-title text-center mb-4">Tem a certeza que deseja eliminar?<br>Todas as	unidades irão ser eliminadas.</h3>
			<form id="formeliminar" action="/definicoes/i/salas/" method="POST">
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
					<li class="breadcrumb-item"><a href="{{ url('/definicoes') }}" class="ftc-red">Definições</a></li>
					<li class="breadcrumb-item"><a href="{{ url('/definicoes/i/inventarios') }}" class="ftc-red">Inventário</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Editar inventário</li>
				</ol>
			</div>
			<div class="flex-shrink-1 pt-2">
				<a class="grid-btn bgc-red" onClick="abrirmodal({{ $inventory->id }})">Apagar</a>
			</div>
		</div>
		<div class="card p-4 mt-4">
			<h2 class="mb-3 border-bottom brdc-red">Editar inventário</h2>
			<form action="/definicoes/i/inventarios/{{ $inventory->id }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row mb-2">
					<div class="form-group col-md-6">
						<label for="inputName">Nome</label>
						<input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" id="inputName"	aria-describedby="nameHelp" 
							placeholder="Insira o nome" value="{{ old('nome', $inventory->nome) }}" required>
						@error('nome')
						<span class="invalid-feedback" role="alert">
							<p>{{ $message }}</p>
						</span>
						@enderror
					</div>
					<div class="form-group col-md-6">
						<label for="custoselect">Tipo de imobilizado</label>
						<select name="custo" class="form-control @error('custo') is-invalid @enderror" id="custoselect" required>
							<option> Selecione o tipo de imobilizado </option>
							<option value="1" {{ (old("custo", $inventory->custo) == 1 ? "selected":"") }}>OBS</option>
							<option value="2" {{ (old("custo", $inventory->custo) == 2 ? "selected":"") }}>Investimento</option>
						</select>
						@error('custo')
						<span class="invalid-feedback" role="alert">
							<p>{{ $message }}</p>
						</span>
						@enderror
					</div>
				</div>
				<div class="row mb-2">
					<div class="form-group col-lg-3 col-md-6">
						<label for="inputAltura">Altura</label>
						<input type="number" name="altura" class="form-control @error('altura') is-invalid @enderror"
							id="inputAltura" aria-describedby="alturaHelp" placeholder="Insira altura"
							value="{{ old('altura', $inventory->altura) }}">
						@error('altura')
						<span class="invalid-feedback" role="alert">
							<p>{{ $message }}</p>
						</span>
						@enderror
					</div>
					<div class="form-group col-lg-3 col-md-6">
						<label for="inputLargura">Largura</label>
						<input type="number" name="largura" class="form-control @error('largura') is-invalid @enderror"	id="inputLargura" aria-describedby="larguraHelp" placeholder="Insira largura" value="{{ old('largura', $inventory->largura) }}">
						@error('largura')
						<span class="invalid-feedback" role="alert">
							<p>{{ $message }}</p>
						</span>
						@enderror
					</div>
					<div class="form-group col-lg-3 col-md-6">
						<label for="inputComprimento">Comprimento</label>
						<input type="number" name="comprimento" class="form-control @error('comprimento') is-invalid @enderror"
							id="inputComprimento" aria-describedby="comprimentoHelp" placeholder="Insira comprimento"
							value="{{ old('comprimento', $inventory->comprimento) }}">
						@error('comprimento')
						<span class="invalid-feedback" role="alert">
							<p>{{ $message }}</p>
						</span>
						@enderror
					</div>
					<div class="form-group col-lg-3 col-md-6">
						<label for="selectUnidadeMedida">Unidade de medida</label>
						<select name="unidade_medida" class="form-control @error('unidade_medida') is-invalid @enderror"
							id="selectUnidadeMedida">
							<option> Selecionar unidade de medida </option>
							<option value="mm" {{ (old("unidade_medida", $inventory->unidade_medida) == "mm" ? "selected":"") }}>
								Milímetros</option>
							<option value="cm" {{ (old("unidade_medida", $inventory->unidade_medida) == "cm" ? "selected":"") }}>
								Centímetros</option>
							<option value="m" {{ (old("unidade_medida", $inventory->unidade_medida) == "m" ? "selected":"") }}>Metros
							</option>
						</select>
						@error('unidade_medida')
						<span class="invalid-feedback" role="alert">
							<p>{{ $message }}</p>
						</span>
						@enderror
					</div>
				</div>
				<button type="submit" class="grid-button">Editar</button>
			</form>
		</div>
		<div class="card p-4 mt-4">
			<h2 class="mb-3 border-bottom bdc-red">Adicionar unidades</h2>
			<form action="/definicoes/i/inventarios/{{ $inventory->id }}/unidades" method="POST">
				@csrf
				<div id="lista-unidades">
					<select class="select2-unidades" multiple="multiple" name="unidades[]" required></select>
				</div>
				<div class="row mt-4">
					<div class="col-6 text-left">
						<button type="submit" class="grid-button">Adicionar</button>
					</div>
					<div class="col-6 text-right">
						<div class="red-pagination d-flex justify-content-end">
							{{ $unidades->links() }}
						</div>
					</div>
				</div>
			</form>
			<div class="row p-2">
				@foreach($unidades as $unidade)
				<div class="col-lg-3 col-md-4 col-sm-6 p-2">
					<div class="card d-flex p-2 justify-content-between flex-row">
						<div class="m-2 flex-grow-1">{{ $unidade->codigo }}</div>
						<a class="m-2 flex-shrink-1" onClick="abrirmodalUnidades({{ $inventory->id }}, {{ $unidade->id }})">
							<i class="grid-apagar btn-eliminar"></i>
						</a>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script type="text/javascript">
	function abrirmodal(id) {
		$('#formeliminar').attr('action', '/definicoes/i/inventarios/' + id);
		$('#modal-text').text('Tem a certeza que deseja eliminar? Todas as unidades irão ser eliminadas.');
		$('#elimodal').addClass('show');
	};
	function abrirmodalUnidades(inventoryID, id) {
		$('#formeliminar').attr('action', '/definicoes/i/inventarios/' + inventoryID + '/unidades/' + id);
		$('#modal-text').text('Tem a certeza que deseja eliminar esta unidade?');
		$('#elimodal').addClass('show');
	};

	$('#fechar-elimodal').click(function(event) {
		event.preventDefault();
		$('#elimodal').removeClass('show');
	});

	$(document).ready(function() {
		$('.select2-unidades').select2({
			tags: true,
			placeholder: "Insira unidades",
			tokenSeparators: [',', ' '],
			selectOnClose: true
		})
	});
</script>
@endsection