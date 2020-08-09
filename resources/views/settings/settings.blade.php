@extends('layouts.master')

@section('content')
<div id="definicoes" class="content">
	<div class="main">
		<h3>Inventário</h3>
		<div class="row">
			<div class="col-md-4 col-sm-6">
				<a href="{{ url('/definicoes/i/inventarios') }}">
					<div class="cardlink brdc-red align-items-center">
						<div class="cardlink-icon"><i class="grid-inventario ftc-red"></i></div>
						<div class="cardlink-title">
							<h3>Gerir inventário</h3>
							<span>{{ $counts['inventarios'] ?? 0 }}</span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-4 col-sm-6">
				<a href="{{ url('/definicoes/i/salas') }}">
					<div class="cardlink brdc-red align-items-center">
						<div class="cardlink-icon"><i class="grid-salas ftc-red"></i></div>
						<div class="cardlink-title">
							<h3>Gerir salas</h3>
							<span>{{ $counts['salas'] ?? 0 }}</span>
						</div>
					</div>
				</a>
			</div>
		</div>
		<h3 class="mt-4">Consumíveis</h3>
		<div class="row">
			<div class="col-md-4 col-sm-6">
				<a href="{{ url('/definicoes/s/produtos') }}">
					<div class="cardlink brdc-yellow align-items-center">
						<div class="cardlink-icon"><i class="grid-consumiveis ftc-yellow"></i></div>
						<div class="cardlink-title">
							<h3>Gerir produtos</h3>
							<span>{{ $counts['produtos'] ?? 0 }}</span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-4 col-sm-6">
				<a href="{{ url('/definicoes/s/categorias') }}">
					<div class="cardlink brdc-yellow align-items-center">
						<div class="cardlink-icon"><i class="grid-categorias ftc-yellow"></i></div>
						<div class="cardlink-title">
							<h3>Gerir categorias</h3>
							<span>{{ $counts['categorias'] ?? 0 }}</span>
						</div>
					</div>
				</a>
			</div>
		</div>
		<h3 class="mt-4">Cacifos</h3>
		<div class="row">
			<div class="col-md-4 col-sm-6">
				<a href="{{ url('/definicoes/c/cacifos') }}">
					<div class="cardlink brdc-blue align-items-center">
						<div class="cardlink-icon"><i class="grid-cacifos ftc-blue"></i></div>
						<div class="cardlink-title">
							<h3>Gerir cacifos</h3>
							<span>{{ $counts['cacifos'] ?? 0 }}</span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-4 col-sm-6">
				<a href="{{ url('/definicoes/c/formandos') }}">
					<div class="cardlink brdc-blue align-items-center">
						<div class="cardlink-icon"><i class="grid-formandos ftc-blue"></i></div>
						<div class="cardlink-title">
							<h3>Gerir formandos</h3>
							<span>{{ $counts['formandos'] ?? 0 }}</span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-4 col-sm-6">
				<a href="{{ url('/definicoes/c/turmas') }}">
					<div class="cardlink brdc-blue align-items-center">
						<div class="cardlink-icon"><i class="grid-turmas ftc-blue"></i></div>
						<div class="cardlink-title">
							<h3>Gerir turmas</h3>
							<span>{{ $counts['turmas'] ?? 0 }}</span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-4 col-sm-6">
				<a href="{{ url('/definicoes/c/locais') }}">
					<div class="cardlink brdc-blue align-items-center">
						<div class="cardlink-icon"><i class="grid-areas ftc-blue"></i></div>
						<div class="cardlink-title">
							<h3>Gerir locais</h3>
							<span>{{ $counts['locais'] ?? 0 }}</span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-4 col-sm-6">
				<a href="{{ url('/definicoes/c/topologias') }}">
					<div class="cardlink brdc-blue align-items-center">
						<div class="cardlink-icon"><i class="grid-topologias ftc-blue"></i></div>
						<div class="cardlink-title">
							<h3>Gerir topologias</h3>
							<span>{{ $counts['topologias'] ?? 0 }}</span>
						</div>
					</div>
				</a>
			</div>
		</div>
		<h3 class="mt-4">Geral</h3>
		<div class="row">
			<div class="col-md-4 col-sm-6">
				<a href="{{ url('/definicoes/utilizadores') }}">
					<div class="cardlink brdc-main align-items-center">
						<div class="cardlink-icon"><i class="grid-utilizadores"></i></div>
						<div class="cardlink-title">
							<h3>Gerir utilizadores</h3>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-4 col-sm-6">
				<a href="{{ url('/definicoes/estatisticas') }}">
					<div class="cardlink brdc-main align-items-center">
						<div class="cardlink-icon"><i class="grid-grafico"></i></div>
						<div class="cardlink-title">
							<h3>Estatísticas</h3>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-4 col-sm-6">
				<a href="{{ url('/perfil') }}">
					<div class="cardlink brdc-main align-items-center">
						<div class="cardlink-icon"><i class="grid-utilizador"></i></div>
						<div class="cardlink-title">
							<h3>Editar perfil</h3>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>
</div>
@endsection