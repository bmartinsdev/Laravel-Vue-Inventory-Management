@extends('layouts.master')

@section('content')
<div id="definicoes" class="content">
	<div id="elimodal" class="grid-modal align-items-center min-vh-100 justify-content-center">
		<div class="grid-modal-card">
			<h3 class="grid-modal-title text-center mb-4">Tem a certeza que deseja eliminar?</h3>
			<div class="grid-modal-footer d-flex justify-content-center">
				<form id="formeliminar" action="/definicoes/utilizadores/" method="POST">
					@method('DELETE')
					@csrf
					<div class="grid-modal-footer d-flex justify-content-center">
						<button id="fechar-elimodal" class="grid-button m-1 cancel">Cancelar</button>
						<button class="grid-button m-1 bgc-red">Eliminar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<a id="fixed-search" class="fixed-icon">
		<i class="grid-search"></i>
	</a>
	<div id="searchbar">
		<form action="/definicoes/utilizadores" method="GET" role="search">
			<div class="row">
				<div class="col-md">
					<div class="input-group">
						<input type="text" class="form-control" name="nome" placeholder="Nome"
							value="{{ request()->get('nome') ?? '' }}">
					</div>
				</div>
				<div class="col-md">
					<div class="input-group">
						<input type="text" class="form-control" name="email" placeholder="Email"
							value="{{ request()->get('email') ?? '' }}">
					</div>
				</div>
				<div class="col-md">
					<select id="search-admin" name="perms" class="custom-select">
						<option value="" selected>Permissões</option>
						<option value="1" @if(request()->get('perms') == 1) selected @endif>Utilizador</option>
						<option value="2" @if(request()->get('perms') == 2) selected @endif>Administrador</option>
					</select>
					<label for="search-admin" class="input-group-prepend">
						<i class="grid-arrow-down"></i>
					</label>
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
					<li class="breadcrumb-item"><a href="{{ url('/definicoes') }}" class="ftc-default">Definições</a></li>
					<li class="breadcrumb-item active" aria-current="page">Utilizadores</li>
				</ol>
			</div>
			<div class="flex-shrink-1 pt-2">
				<a class="grid-btn bgc-main" href="{{ url('/definicoes/utilizadores/create') }}">Adicionar</a>
			</div>
		</div>
		<div class="table-responsive mt-3">
			<table class="table table-hover">
				<thead>
					<tr>
						<th class="brdc-main" scope="col">
							<a href="{{ route('utilizadores.index', ['order' => 'id']) }}" class="ftc-default">
								ID
								<i class="grid-sort"></i>
							</a>
						</th>
						<th class="brdc-main">
							<a href="{{ route('utilizadores.index', ['order' => 'name']) }}" class="ftc-default">
								Nome
								<i class="grid-sort"></i>
							</a>
						</th>
						<th class="brdc-main">
							<a href="{{ route('utilizadores.index', ['order' => 'email']) }}" class="ftc-default">
								Email
								<i class="grid-sort"></i>
							</a>
						</th>
						<th class="brdc-main">
							<a href="" class="ftc-default">
								Permissões
								<i class="grid-sort"></i>
							</a>
						</th>
						<th class="brdc-main">
						</th>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $user)
					<tr>
						<th scope="row">{{ $user->id }}</th>
						<td>{{ $user->name }}</td>
						<td>{{ $user->email }}</td>
						@if($user->perms == 2)
							<td>Administrador</td>
						@else
							<td>Utilizador</td>
						@endif
						<td class="d-flex justify-content-end">
							@if($user->id != Auth::user()->id)
							<a href="{{ url('/definicoes/utilizadores/' . $user->id . '/edit') }}">
								<i class="grid-editar btn-editar"></i>
							</a>
							<a onClick="abrirmodal({{ $user->id }})">
								<i class="grid-apagar btn-eliminar"></i>
							</a>
							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="main-pagination d-flex justify-content-end">
			{{ $users->appends(request()->query())->links() }}
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
		$('#formeliminar').attr('action', '/definicoes/utilizadores/' + id);
		$('#elimodal').addClass('show');
	};

	$('#fechar-elimodal').click(function(event) {
		event.preventDefault();
		$('#elimodal').removeClass('show');
	});
</script>
@endsection