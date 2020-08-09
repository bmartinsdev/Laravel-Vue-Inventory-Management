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
				<li class="breadcrumb-item"><a href="{{ url('/definicoes/c/formandos') }}" class="ftc-blue">Cacifos</a></li>
				<li class="breadcrumb-item active" aria-current="page">Criar cacifo</li>
			</ol>
		</nav>
		<div class="card p-4 mt-4">
			<h2 class="mb-3 border-bottom brdc-blue">Criar formando</h2>
			<form action="/definicoes/c/formandos" method="POST">
				@csrf
				<div class="form-group">
					<label for="inputCodigo">Código</label>
					<input type="text" class="form-control @error('codigo') is-invalid @enderror" id="inputCodigo" name="codigo" aria-describedby="nameHelp" 
					placeholder="Insira código" value="{{ old('codigo') }}" required>
					@error('codigo')
					<span class="invalid-feedback" role="alert">
						<p>{{ $message }}</p>
					</span>
					@enderror
				</div>
				<div class="form-group">
					<label for="inputNome">Nome</label>
					<input type="text" class="form-control @error('nome') is-invalid @enderror" id="inputNome" name="nome" aria-describedby="nameHelp" 
						placeholder="Insira nome" value="{{ old('nome') }}" required>
					@error('nome')
					<span class="invalid-feedback" role="alert">
						<p>{{ $message }}</p>
					</span>
					@enderror
				</div>
				<label for="search-local">Selecionar local</label>
				<select id="search-local" class="form-control mb-3 @error('course') is-invalid @enderror" name="course" required>
					<option selected> Local </option>
					@foreach($courses as $course)
					<option value="{{ $course->id }}" @if(old('course')==$course->id) selected @endif>{{ $course->nome }}
					</option>
					@endforeach
				</select>
				@error('course')
				<span class="invalid-feedback" role="alert">
					<p>{{ $message }}</p>
				</span>
				@enderror
				<button type="submit" class="grid-button">Criar</button>
			</form>
		</div>
	</div>
</div>
@endsection