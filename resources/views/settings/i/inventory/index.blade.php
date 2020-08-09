@extends('layouts.master')

@section('content')
<div id="definicoes" class="content">
	<div id="elimodal" class="grid-modal align-items-center min-vh-100 justify-content-center">
		<div class="grid-modal-card">
			<h3 class="grid-modal-title text-center mb-4">Tem a certeza que deseja eliminar?<br>Todas as unidades irão ser
				eliminadas.</h3>
			<form id="formeliminar" action="/definicoes/i/inventarios" method="POST">
				@method('DELETE')
				@csrf
				<div class="grid-modal-footer d-flex justify-content-center">
					<button id="fechar-elimodal" class="grid-button m-1 cancel">Cancelar</button>
					<button class="grid-button m-1 bgc-red">Eliminar</button>
				</div>
			</form>
		</div>
	</div>
	<a id="fixed-search" class="fixed-icon">
		<i class="grid-search"></i>
	</a>
	<div id="searchbar">
		<form action="/definicoes/i/inventarios" method="GET" role="search">
			<div class="col-md">
				<div class="input-group">
					<input type="text" class="form-control" name="nome" placeholder="Nome"
						value="{{ request()->get('nome') ?? '' }}">
				</div>
			</div>
			<div class="col-md">
				<select id="search-custo" class="custom-select" name="custo" value="{{ request()->get('custo') ?? '' }}">
					<option value="" selected> Custo </option>
					<option value="1">OBS</option>
					<option value="2">INV</option>
				</select>
				<label for="search-custo" class="input-group-prepend">
					<i class="grid-arrow-down"></i>
				</label>
			</div>
			<div class="submit-btn">
				<button type="submit" class="grid-btn-top"><i class="grid-search mr-1"></i> Pesquisar</button>
			</div>
		</form>
	</div>
	<div class="main">
		<div class="breadcrumb-holder d-flex">
			<div class="flex-grow-1">
				<ol class="breadcrumb pt-3">
					<li class="breadcrumb-item"><a href="{{ url('/definicoes') }}" class="ftc-red">Definições</a></li>
					<li class="breadcrumb-item active" aria-current="page">Inventário</li>
				</ol>
			</div>
			<div class="flex-shrink-1 pt-2">
				<a class="grid-btn bgc-red" href="{{ url('/definicoes/i/inventarios/create') }}">Adicionar</a>
			</div>
		</div>
		<div class="table-responsive mt-4">
			<table class="table table-hover">
				<thead>
					<tr>
						<th class="brdc-red" scope="col">
							<a href="{{ route('inventarios.index', ['order' => 'id']) }}" class="ftc-main">
								ID
								<i class="grid-sort"></i>
							</a>
						</th>
						<th class="brdc-red">
							<a href="{{ route('inventarios.index', ['order' => 'nome']) }}" class="ftc-main">
								Nome
								<i class="grid-sort"></i>
							</a>
						</th>
						<th class="brdc-red">
							Tipo de investimento
						</th>
						<th class="brdc-red">
							Número de unidades
						</th>
						<th class="brdc-red">
						</th>
					</tr>
				</thead>
				<tbody>
					@foreach($inventories as $inventory)
					<tr>
						<th scope="row">{{ $inventory->id }}</th>
						<td>{{ $inventory->nome }}</td>
						<td>{{ $inventory->custo == 1 ? "OBS" : "Investimento" }}</td>
						<td>{{ $inventory->count_unidades }}</td>
						<td class="d-flex justify-content-end">
							<a href="{{ url('/definicoes/i/inventarios/' . $inventory->id . '/edit') }}">
								<i class="grid-editar btn-editar"></i>
							</a>
							<a onClick="abrirmodal({{ $inventory->id }})">
								<i class="grid-apagar btn-eliminar"></i>
							</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="red-pagination d-flex justify-content-end">
			{{ $inventories->appends(request()->query())->links() }}
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	$('#fixed-search').click(function() {
		$('#searchbar').toggleClass('show');
	});

	function abrirmodal(id) {
		$('#formeliminar').attr('action', '/definicoes/i/inventarios/' + id);
		$('#elimodal').addClass('show');
	};

	$('#fechar-elimodal').click(function(event) {
		event.preventDefault();
		$('#elimodal').removeClass('show');
	});
</script>
@endsection