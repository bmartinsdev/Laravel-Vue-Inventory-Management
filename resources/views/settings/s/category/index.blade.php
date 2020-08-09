@extends('layouts.master')

@section('content')
<div id="definicoes" class="content">
	<div id="elimodal" class="grid-modal align-items-center min-vh-100 justify-content-center">
		<div class="grid-modal-card">
			<h3 class="grid-modal-title text-center mb-4">Tem a certeza que deseja eliminar?</h3>
				<form id="formeliminar" action="/definicoes/s/produtos/" method="POST">
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
		<form action="/definicoes/s/categorias" method="GET" role="search">
			<div class="row">
				<div class="col-md-4 offset-md-8">
					<div class="input-group">
						<input type="text" class="form-control" name="nome" placeholder="Nome" value="{{ request()->get('nome') ?? '' }}">
					</div>
				</div>
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
					<li class="breadcrumb-item"><a href="{{ url('/definicoes') }}" class="ftc-yellow">Definições</a></li>
					<li class="breadcrumb-item active" aria-current="page">Categorias</li>
				</ol>
			</div>
			<div class="flex-shrink-1 pt-2">
				<a class="grid-btn bgc-yellow" href="{{ url('/definicoes/s/categorias/create') }}">Adicionar</a>
			</div>
	</div>
		<div class="table-responsive mt-4">
			<table class="table table-hover">
				<thead>
					<tr>
						<th class="brdc-yellow" scope="col">
							<a href="{{ route('categorias.index', ['order' => 'id']) }}" class="ftc-main">
								ID
								<i class="grid-sort"></i>
							</a>
						</th>
						<th class="brdc-yellow">
							<a href="{{ route('categorias.index', ['order' => 'nome']) }}" class="ftc-main">
								Nome
								<i class="grid-sort"></i>
							</a>
						</th>
						<th class="brdc-yellow">
							<a href="{{ route('categorias.index', ['order' => 'avgref']) }}" class="ftc-main">
								Referência média
								<i class="grid-sort"></i>
							</a>
						</th>
						<th class="brdc-yellow">
						</th>
					</tr>
				</thead>
				<tbody>
					@foreach($pcategories as $pcategory)
					<tr>
						<th scope="row">{{ $pcategory->id }}</th>
						<td>{{ $pcategory->nome }}</td>
						<td>{{ $pcategory->avgref }}</td>
						<td class="d-flex justify-content-end">
							<a href="{{ url('/definicoes/s/categorias/' . $pcategory->id . '/edit') }}">
								<i class="grid-editar btn-editar"></i>
							</a>
							<a onClick="abrirmodal({{ $pcategory->id }})">
								<i class="grid-apagar btn-eliminar"></i>
							</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="yellow-pagination d-flex justify-content-end">
			{{ $pcategories->appends(request()->query())->links() }}
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
		$('#formeliminar').attr('action', '/definicoes/s/categorias/' + id);
		$('#elimodal').addClass('show');
	};

	$('#fechar-elimodal').click(function(event) {
		event.preventDefault();
		$('#elimodal').removeClass('show');
	});
</script>
@endsection