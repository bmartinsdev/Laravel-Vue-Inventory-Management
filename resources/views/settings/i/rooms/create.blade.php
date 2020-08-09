@extends('layouts.master')

@section('content')
<div id="definicoes" class="content">
	<div class="main">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('/definicoes') }}" class="ftc-red">Definições</a></li>
				<li class="breadcrumb-item"><a href="{{ url('/definicoes/i/salas') }}" class="ftc-red">Salas</a></li>
				<li class="breadcrumb-item active" aria-current="page">Criar sala</li>
			</ol>
		</nav>
		<div class="card p-4 mt-4">
			<h2 class="mb-3 border-bottom brdc-red">Criar sala</h2>
			<form action="/definicoes/i/salas" method="POST">
				@csrf
				<div class="form-group">
					<label for="inputNome">Nome</label>
					<input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" id="inputNome" aria-describedby="nameHelp"	
					placeholder="Insira nome" value="{{ old('nome') }}" required>
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