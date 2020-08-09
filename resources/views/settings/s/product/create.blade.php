@extends('layouts.master')

@section('content')
<div id="definicoes" class="content">
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
					<li class="breadcrumb-item active" aria-current="page">Criar produto</li>
				</ol>
			</div>
		</div>
		<div class="card p-4 mt-4">
		<h2 class="mb-3 border-bottom brdc-yellow">Criar produto</h2>
		<form action="/definicoes/s/produtos" method="POST">
			@csrf
			<div class="form-group">
				<label for="inputName">Nome</label>
				<input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" id="inputName" aria-describedby="nameHelp"
					placeholder="Insira nome" value="{{ old('nome') }}" required>
				@error('nome')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			<div class="form-group">
				<label for="inputQuantidade">Quantidade</label>
				<input type="text" name="quantidade" class="form-control @error('quantidade') is-invalid @enderror" id="inputQuantidade" aria-describedby="quantidadeHelp"
					placeholder="Insira quantidade" value="{{ old('quantidade') }}" required>
				@error('quantidade')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			<div class="form-group">
				<label for="search-categoria">Categoria</label>
				<select id="search-categoria" class="form-control mb-3 @error('category') is-invalid @enderror" name="category" required>
					<option selected> Categoria </option>
					@foreach($pcategories as $pcategory)
					<option value="{{ $pcategory->id }}" @if(old('category') == $pcategory->id) selected @endif>{{ $pcategory->nome }}
					</option>
					@endforeach
				</select>
				@error('category')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			<button type="submit" class="grid-button">Criar</button>
		</form>
		</div>
	</div>
</div>
@endsection
