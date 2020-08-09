@extends('layouts.master')

@section('content')
<div id="definicoes" class="content">
	<div id="elimodal" class="grid-modal align-items-center min-vh-100 justify-content-center">
		<div class="grid-modal-card">
			<h3 class="grid-modal-title text-center mb-4">Tem a certeza que deseja eliminar?</h3>
			<form id="formeliminar" action="/definicoes/c/cacifos/" method="POST">
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
		<form action="/definicoes/c/cacifos" method="GET" role="search">
			<div class="row">
				<div class="col-md">
					<div class="input-group">
						<input type="text" class="form-control" name="nome" placeholder="Nome" value="{{ request()->get('nome') ?? '' }}">
					</div>
				</div>
				<div class="col-md">
					<select id="search-local" class="custom-select" name="local">
						<option value="">Local</option>
						@foreach($areas as $area)
						<option value="{{ $area->id }}" @if(request()->get('local') == $area->id) selected @endif>{{ $area->nome }}</option>
						@endforeach
					</select>
					<label for="search-local" class="input-group-prepend">
						<i class="grid-arrow-down"></i>
					</label>
				</div>
				<div class="col-md">
					<select id="search-topologia" class="custom-select" name="topologia">
						<option value="">Topologia</option>
						@foreach($typologies as $typology)
						<option value="{{ $typology->id }}" @if(request()->get('topologia') == $typology->id) selected @endif>{{ $typology->nome }}</option>
						@endforeach
					</select>
					<label for="search-topologia" class="input-group-prepend">
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
					<li class="breadcrumb-item"><a href="{{ url('/definicoes') }}" class="ftc-blue">Definições</a></li>
					<li class="breadcrumb-item active" aria-current="page">Cacifos</li>
				</ol>
			</div>
			<div class="flex-shrink-1 pt-2">
				<a class="grid-btn bgc-blue" href="{{ url('/definicoes/c/cacifos/create') }}">Adicionar</a>
			</div>
	</div>
		<div class="table-responsive mt-4">
			<table class="table table-hover">
				<thead>
					<tr>
						<th class="brdc-blue" scope="col">
							<a href="{{ route('cacifos.index', ['order' => 'id']) }}" class="ftc-main">
								ID
								<i class="grid-sort"></i>
							</a>
						</th>
						<th class="brdc-blue">
							<a href="{{ route('cacifos.index', ['order' => 'nome']) }}" class="ftc-main">
								Nome
								<i class="grid-sort"></i>
							</a>
						</th>
						<th class="brdc-blue">
							<a href="{{ route('cacifos.index', ['order' => 'local']) }}" class="ftc-main">
								Local
								<i class="grid-sort"></i>
							</a>
						</th>
						<th class="brdc-blue">
							<a href="{{ route('cacifos.index', ['order' => 'topologia']) }}" class="ftc-main">
								Topologia
								<i class="grid-sort"></i>
							</a>
						</th>
						<th class="brdc-blue">
						</th>
					</tr>
				</thead>
				<tbody>
					@foreach($lockers as $locker)
					<tr>
						<th scope="row">{{ $locker->id }}</th>
						<td>{{ $locker->nome }}</td>
						<td>{{ $locker->local ?? " " }}</td>
						<td>{{ $locker->topologia ?? " " }}</td>
						<td class="d-flex justify-content-end">
							<a href="{{ url('/definicoes/c/cacifos/' . $locker->id . '/edit') }}">
								<i class="grid-editar btn-editar"></i>
							</a>
							<a onClick="abrirmodal({{ $locker->id }})">
								<i class="grid-apagar btn-eliminar"></i>
							</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="blue-pagination d-flex justify-content-end">
			{{ $lockers->appends(request()->query())->links() }}
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
		$('#formeliminar').attr('action', '/definicoes/c/cacifos/' + id);
		$('#elimodal').addClass('show');
	};

	$('#fechar-elimodal').click(function(event) {
		event.preventDefault();
		$('#elimodal').removeClass('show');
	});
</script>
@endsection

{{-- @extends('layouts.master')

@section('content')
<div class="content">
    <a id="fixed-search" class="fixed-icon">
        <i class="grid-search"></i>
    </a>
    <div id="searchbar" class="row">
      <div class="col">
        <div class="input-group mb-2">
          <input
            type="text"
            id="search-nome"
            class="form-control"
            placeholder="Nome"
          />
          <label for="search-nome" class="input-group-prepend">
            <i class="grid-search"></i>
          </label>
        </div>
      </div>
      </div>
      <div class="col">
        <div class="input-group mb-2">
          <select id="search-local" class="custom-select">
          <option selected>Locais</option>
          @foreach($areas as $area)
            <option>{{ $area->nome }}</option>
@endforeach
</select>
<label for="search-local" class="input-group-prepend">
	<i class="grid-arrow-down"></i>
</label>
</div>
</div>
<div class="col">
	<div class="input-group mb-2">
		<select id="search-topologia" class="custom-select">
			<option selected>Topologia</option>
			@foreach($typologies as $typology)
			<option>{{ $typology->nome }}</option>
			@endforeach
		</select>
		<label for="search-topologia" class="input-group-prepend">
			<i class="grid-arrow-down"></i>
		</label>
	</div>
</div>
</div>
<div class="main">
	<div class="row">
		<div class="col">
			<h3>Cacifos</h3>
		</div>
		<div class="col text-right">
			<a class="btn" href="{{ url('/definicoes/c/cacifos/create') }}">Adicionar</a>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th scope="col">ID</th>
					<th scope="col">Nome</th>
					<th scope="col">Local</th>
					<th scope="col">Topologia</th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
				@foreach($lockers as $locker)
				<tr>
					<th scope="row">{{ $locker->id }}</th>
					<td>{{ $locker->nome }}</td>
					<td>{{ $locker->area->nome }}</td>
					<td>{{ $locker->typology->nome }}</td>
					<td><a href="{{ url('/definicoes/c/zonas/' . $locker->id . '/edit') }}"><i class="grid-editar"></i></a><i
							class="grid-apagar"></i></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
</div>
@endsection --}}