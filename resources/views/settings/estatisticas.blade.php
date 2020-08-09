@extends('layouts.master')

@section('content')
<div id="definicoes" class="content">
	<div class="main">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('/definicoes') }}" class="ftc-default">Definições</a></li>
				<li class="breadcrumb-item active" aria-current="page">Estatísticas</li>
			</ol>
		</nav>
		<div class="card p-4">
			<h2 class="mb-3 border-bottom ftc-default bdc-default">Baixas de inventário</h2>
			<stats-inv></stats-inv>
		</div>
		<div class="card p-4 mt-4">
			<h2 class="mb-3 border-bottom ftc-default bdc-default">Salas de baixas de inventário</h2>
			<stats-room></stats-room>
		</div>
		<div class="card p-4 mt-4">
			<h2 class="mb-3 border-bottom ftc-default bdc-default">Utilização mensal</h2>
			<stats-consumiveis></stats-consumiveis>
		</div>
		<div class="card p-4 mt-4">
			<h2 class="mb-3 border-bottom ftc-default bdc-default">Listagem de registos</h2>
			<logs-list></logs-list>
		</div>
	</div>
</div>
@endsection
@section('styles')
	<script src="{{ mix('js/stats.js') }}"></script>
@endsection