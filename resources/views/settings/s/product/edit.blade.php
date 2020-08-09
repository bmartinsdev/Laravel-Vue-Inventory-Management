@extends('layouts.master')

@section('content')
<div id="definicoes" class="content">
<div id="elimodal" class="grid-modal align-items-center min-vh-100 justify-content-center">
		<div class="grid-modal-card">
			<h3 class="grid-modal-title text-center mb-4">Tem a certeza que deseja eliminar?</h3>
			<form id="formeliminar" action="/definicoes/s/produtos/" method="POST">
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
					<li class="breadcrumb-item"><a href="{{ url('/definicoes/s/produtos') }}" class="ftc-yellow">Produtos</a></li>
					<li class="breadcrumb-item active" aria-current="page">Editar produto</li>
				</ol>
			</div>
			<div class="flex-shrink-1 pt-2">
				<a class="grid-btn bgc-red" onClick="abrirmodal({{ $product->id }})">Apagar</a>
			</div>
		</div>
		<div class="card p-4 mt-4">
		<h2 class="mb-3 border-bottom brdc-yellow">Editar produto</h2>
		<form action="/definicoes/s/produtos/{{ $product->id }}" method="POST">
			@csrf
			@method('PUT')
			<div class="form-group">
				<label for="inputName">Nome</label>
				<input type="text" class="form-control @error('nome') is-invalid @enderror" id="inputName" name="nome" value="{{ old('nome', $product->nome) }}"
					aria-describedby="nameHelp" placeholder="Insira nome" required>
					@error('nome')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
			</div>
			<div class="form-group">
				<label for="inputQuantidade">Quantidade</label>
				<input type="text" name="quantidade" class="form-control @error('quantidade') is-invalid @enderror" id="inputQuantidade"
					value="{{ old('quantidade', $product->quantidade) }}" aria-describedby="quantidadeHelp" placeholder="Insira quantidade." required>
					@error('quantidade')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
			</div>
			<div class="form-group">
				<label for="selectCategoria">Categoria</label>
				<select id="selectCategoria" class="form-control mb-3 @error('category') is-invalid @enderror" name="category" required>	
					@foreach($pcategories as $pcategory)
					<option value="{{ $pcategory->id }}" @if(old('pcategory', $pcategory->id) === $product->category_id) selected @endif>{{ $pcategory->nome }}
					</option>
					@endforeach
				</select>
				@error('category')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
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
		$('#formeliminar').attr('action', '/definicoes/s/produtos/' + id);
		$('#elimodal').addClass('show');
	};

	$('#fechar-elimodal').click(function(event) {
		event.preventDefault();
		$('#elimodal').removeClass('show');
	});
</script>
@endsection