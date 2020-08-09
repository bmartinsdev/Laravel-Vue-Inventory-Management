@extends('layouts.master')

@section('content')
<div id="definicoes" class="content">
	<a id="fixed-search" class="fixed-icon">
		<i class="grid-search"></i>
	</a>
	<div id="searchbar" class="row">
	</div>
	<div class="main">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('/definicoes') }}" class="ftc-blue">Definições</a></li>
				<li class="breadcrumb-item"><a href="{{ url('/definicoes/c/topologias') }}" class="ftc-blue">Topologias</a></li>
				<li class="breadcrumb-item active" aria-current="page">Criar topologia</li>
			</ol>
		</nav>
		<div class="card p-4 mt-4">
			<h2 class="mb-3 border-bottom brdc-blue">Criar topologia</h2>
			<form action="/definicoes/c/topologias" method="POST">
				@csrf
				<div class="form-group">
					<label for="inputNome">Nome</label>
					<input type="text" class="form-control @error('nome') is-invalid @enderror" id="inputNome" name="nome"
						aria-describedby="nameHelp" placeholder="Insira nome" value="{{ old('nome') }}" required>
					@error('nome')
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