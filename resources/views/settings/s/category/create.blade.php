@extends('layouts.master')

@section('content')
<div id="definicoes" class="content">
	<div class="main">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('/definicoes') }}" class="ftc-yellow">Definições</a></li>
				<li class="breadcrumb-item"><a href="{{ url('/definicoes/s/categorias') }}" class="ftc-yellow">Categorias</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Criar categoria</li>
			</ol>
		</nav>
		<div class="card p-4 mt-4">
			<h2 class="mb-3 border-bottom brdc-yellow">Criar categoria</h2>
			<form action="/definicoes/s/categorias" method="POST">
				@csrf
				<div class="form-group">
					<label for="inputNome">Nome</label>
					<input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" id="inputNome"	aria-describedby="nameHelp" 
					placeholder="Insira nome" value="{{ old('nome') }}" required>
					@error('nome')
					<span class="invalid-feedback" role="alert">
						<p>{{ $message }}</p>
					</span>
					@enderror
				</div>
				<div class="form-group">
					<label for="inputName">Referência média</label>
					<input type="number" name="avgref" class="form-control @error('avgref') is-invalid @enderror" id="inputAvgref"	aria-describedby="avgrefHelp" placeholder="Insira referência média" value="{{ old('avgref') }}" required>
					@error('avgref')
					<span class="invalid-feedback" role="alert">
						<p>{{ $message }}</p>
					</span>
					@enderror
				</div>
				<button type="submit" class="grid-button">Criar</button>
			</form>
		</div>
	</div>
</div>
@endsection