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
				<li class="breadcrumb-item"><a href="{{ url('/definicoes/c/cacifos') }}" class="ftc-blue">Cacifos</a></li>
				<li class="breadcrumb-item active" aria-current="page">Criar cacifo</li>
			</ol>
		</nav>
		<div class="card p-4 mt-4">
			<h2 class="mb-3 border-bottom brdc-blue">Criar cacifo</h2>
			<form action="/definicoes/c/cacifos" method="POST">
				@csrf
				<div class="form-group">
					<label for="inputName">Nome</label>
					<input type="text" class="form-control @error('nome') is-invalid @enderror" id="inputName" name="nome"
						aria-describedby="nameHelp" placeholder="Insira nome" value="{{ old('nome') }}" required>
					@error('nome')
					<span class="invalid-feedback" role="alert">
						<p>{{ $message }}</p>
					</span>
					@enderror
				</div>
				<div class="form-group">
					<label for="areaselect">Selecionar local</label>
					<select name="area" class="form-control mb-3 @error('area') is-invalid @enderror" id="areaselect" required>
						<option selected> Local </option>
						@foreach($areas as $area)
						<option value="{{ $area->id }}" @if(old('area')==$area->id) selected @endif>{{ $area->nome }}</option>
						@endforeach
					</select>
					@error('area')
					<span class="invalid-feedback" role="alert">
						<p>{{ $message }}</p>
					</span>
					@enderror
				</div>
				<div class="form-group">
					<label for="typologyselect">Selecionar topologia</label>
					<select name="typology" class="form-control mb-3 @error('typology') is-invalid @enderror" id="typologyselect" required>
						<option selected> Topologia </option>
						@foreach($typologies as $typology)
						<option value="{{ $typology->id }}" @if(old('typology')==$typology->id) selected
							@endif>{{ $typology->nome }}</option>
						@endforeach
					</select>
					@error('typology')
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