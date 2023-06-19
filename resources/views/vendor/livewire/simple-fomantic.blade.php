<div>
  @if ($paginator->hasPages())
      <div class="ui pagination menu">
          {{-- Previous Page Link --}}
          @if ($paginator->onFirstPage())
              <div class="disabled item" aria-disabled="true">
                  <span>@lang('pagination.previous')</span>
              </div>
          @else
              @if (method_exists($paginator, 'getCursorName'))
                  <a class="item" wire:click="setPage('{{ $paginator->previousCursor()->encode() }}','{{ $paginator->getCursorName() }}')" wire:loading.attr="disabled" rel="prev">
                      <span>@lang('pagination.previous')</span>
                  </a>
              @else
                  <a class="item" wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="prev">
                      <span>@lang('pagination.previous')</span>
                  </a>
              @endif
          @endif

          {{-- Next Page Link --}}
          @if ($paginator->hasMorePages())
              @if (method_exists($paginator, 'getCursorName'))
                  <a class="item" wire:click="setPage('{{ $paginator->nextCursor()->encode() }}','{{ $paginator->getCursorName() }}')" wire:loading.attr="disabled" rel="next">
                      <span>@lang('pagination.next')</span>
                  </a>
              @else
                  <a class="item" wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="next">
                      <span>@lang('pagination.next')</span>
                  </a>
              @endif
          @else
              <div class="disabled item" aria-disabled="true">
                  <span>@lang('pagination.next')</span>
              </div>
          @endif
      </div>
  @endif
</div>
