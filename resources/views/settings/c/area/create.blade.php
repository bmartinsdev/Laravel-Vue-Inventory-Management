@extends('layouts.master')

@section('content')
<div id="definicoes" class="content">
	<div class="main">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item d-sm-block"><a href="{{ url('/definicoes') }}" class="ftc-blue">Definições</a></li>
				<li class="breadcrumb-item"><a href="{{ url('/definicoes/c/locais') }}" class="ftc-blue">Locais</a></li>
				<li class="breadcrumb-item active" aria-current="page">Criar local</li>
			</ol>
		</nav>
		<div class="card p-4 mt-4">
			<h2 class="mb-3 border-bottom brdc-blue">Criar local</h2>
			<form action="/definicoes/c/locais" method="POST">
				@csrf
				<div class="form-group">
					<label for="inputNome">Nome</label>
					<input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" id="inputNome"	aria-describedby="nameHelp" placeholder="Insira nome" value="{{ old('nome') }}" required>
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