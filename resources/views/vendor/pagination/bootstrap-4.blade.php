@if ($paginator->hasPages())
<ul class="pagination" role="navigation">
	{{-- Previous Page Link 
        @if (!$paginator->onFirstPage())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="grid-arrow-down"></i></a>
            </li>
				@endif  --}}
	@php 
		$firstPage = false;
	@endphp
	@foreach ($elements as $element)
		@if (is_array($element))
			@foreach ($element as $page => $url)
				@if($page == $paginator->currentPage())
					<li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
				@elseif($page < 2 && !$firstPage)
					<li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
						@if($paginator->currentPage() > 3)
							<li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
						@endif
					@php $firstPage = true; @endphp
				@elseif($page == $paginator->lastPage())
					@if($paginator->currentPage() < $paginator->lastPage()-2)
						<li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
					@endif
					<li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
				@elseif($page == $paginator->currentPage() - 1 || $page == $paginator->currentPage() + 1)
					<li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
				@endif
			@endforeach
		@endif
	@endforeach

	
	{{--@foreach ($elements as $element)
	@if (is_string($element))
	<li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
	@endif

	@if (is_array($element))
	@foreach ($element as $page => $url)
	@if ($page == $paginator->currentPage())
	<li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
	@else
	<li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
	@endif
	@endforeach
	@endif
	@endforeach
	{{-- Next Page Link 
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="grid-arrow-down"></i></a>
            </li>
        @endif --}}
</ul>
@endif