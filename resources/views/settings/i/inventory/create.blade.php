@extends('layouts.master')

@section('content')
<div id="definicoes" class="content">
	<div class="main">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('/definicoes') }}" class="ftc-red">Definições</a></li>
				<li class="breadcrumb-item"><a href="{{ url('/definicoes/i/inventarios') }}" class="ftc-red">Inventário</a></li>
				<li class="breadcrumb-item active" aria-current="page">Criar inventário</li>
			</ol>
		</nav>
		<div class="card p-4 mt-4">
			<h2 class="mb-3 border-bottom brdc-red">Criar inventário</h2>
			<form action="/definicoes/i/inventarios" method="POST">
				@csrf
				<div class="row mb-2">
					<div class="form-group col-md-6">
						<label for="inputName">Nome</label>
						<input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" id="inputName"	aria-describedby="nameHelp" 
							placeholder="Insira o nome" value="{{ old('nome') }}" required>
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
							<option value="1" {{ (old("custo") == 1 ? "selected":"") }}>OBS</option>
							<option value="2" {{ (old("custo") == 2 ? "selected":"") }}>Investimento</option>
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
							id="inputAltura" aria-describedby="alturaHelp" placeholder="Insira altura" value="{{ old('altura') }}">
						@error('altura')
						<span class="invalid-feedback" role="alert">
							<p>{{ $message }}</p>
						</span>
						@enderror
					</div>
					<div class="form-group col-lg-3 col-md-6">
						<label for="inputLargura">Largura</label>
						<input type="number" name="largura" class="form-control @error('largura') is-invalid @enderror"	id="inputLargura" aria-describedby="larguraHelp" 
							placeholder="Insira largura" value="{{ old('largura') }}">
						@error('largura')
						<span class="invalid-feedback" role="alert">
							<p>{{ $message }}</p>
						</span>
						@enderror
					</div>
					<div class="form-group col-lg-3 col-md-6">
						<label for="inputComprimento">Comprimento</label>
						<input type="number" name="comprimento" class="form-control @error('comprimento') is-invalid @enderror"	id="inputComprimento" aria-describedby="comprimentoHelp" 
							placeholder="Insira comprimento" value="{{ old('comprimento') }}">
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
							<option value="mm" {{ (old("unidade_medida") == "mm" ? "selected":"") }}>Milímetros</option>
							<option value="cm" {{ (old("unidade_medida") == "cm" ? "selected":"") }}>Centímetros</option>
							<option value="m" {{ (old("unidade_medida") == "m" ? "selected":"") }}>Metros</option>
						</select>
						@error('unidade_medida')
						<span class="invalid-feedback" role="alert">
							<p>{{ $message }}</p>
						</span>
						@enderror
					</div>
				</div>
				<button type="submit" class="grid-button">Criar</button>
			</form>
		</div>
	</div>
</div>
@endsection