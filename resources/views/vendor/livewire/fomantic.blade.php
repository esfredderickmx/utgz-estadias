<div>
	@if ($paginator->hasPages())
		@php(isset($this->numberOfPaginatorsRendered[$paginator->getPageName()]) ? $this->numberOfPaginatorsRendered[$paginator->getPageName()]++ : ($this->numberOfPaginatorsRendered[$paginator->getPageName()] = 1))

		<div class="ui pagination menu">
			{{-- Previous Page Link --}}
			@if ($paginator->onFirstPage())
				<div class="disabled item" aria-disabled="true" aria-label="@lang('pagination.previous')">
					<i class="angle left icon"></i>
				</div>
			@else
				<a class="item" aria-label="@lang('pagination.previous')" wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="prev">
					<i class="angle left icon"></i>
				</a>
			@endif

			{{-- Pagination Elements --}}
			@foreach ($elements as $element)
				{{-- "Three Dots" Separator --}}
				@if (is_string($element))
					<div class="disabled item" aria-disabled="true"><span>{{ $element }}</span></div>
				@endif

				{{-- Array Of Links --}}
				@if (is_array($element))
					@foreach ($element as $page => $url)
						@if ($page == $paginator->currentPage())
							<div class="active item" aria-current="page" wire:key="paginator-{{ $paginator->getPageName() }}-{{ $this->numberOfPaginatorsRendered[$paginator->getPageName()] }}-page-{{ $page }}"><span>{{ $page }}</span></div>
						@else
							<a class="item" wire:key="paginator-{{ $paginator->getPageName() }}-{{ $this->numberOfPaginatorsRendered[$paginator->getPageName()] }}-page-{{ $page }}" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')">{{ $page }}</a>
						@endif
					@endforeach
				@endif
			@endforeach

			{{-- Next Page Link --}}
			@if ($paginator->hasMorePages())
				<a class="item" aria-label="@lang('pagination.next')" wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="next">
					<i class="angle right icon"></i>
				</a>
			@else
				<div class="disabled item" aria-disabled="true" aria-label="@lang('pagination.next')">
					<i class="angle right icon"></i>
				</div>
			@endif
		</div>
	@endif
</div>
