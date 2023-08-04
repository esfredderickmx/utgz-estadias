@section('title', 'Información del proceso')

<div>
	<div class="ui vertical basic segment">
		<div class="ui container">
			<h1 class="ui header">Información del proceso</h1>
      
      <form class="ui form" wire:submit.prevent="handleSearch">
        <div class="fields">
          <div class="field">
            <div class="ui fluid teal button" target-modal="create-review-modal"><i class="plus icon"></i>Añadir</div>
          </div>
        </div>
      </form>

			<h2 class="ui header">Revisiones agendadas</h2>
			<div class="ui vertical basic segment">
				<table class="ui selectable very basic celled table">
					<thead>
						<tr class="center aligned">
							<th>Número</th>
							<th>Estado</th>
							<th>Fecha límite</th>
							@if (Auth::user()->role !== 'student')
								<th></th>
							@endif
						</tr>
					</thead>
					<tbody>
						@forelse ($reviews as $review)
							<tr class="center aligned">
								<td>{{ $review->number }}</td>
								<td class="{{$review->status === 'approved' ? 'positive' : ($review->status === 'reviewing' ? 'warning' : ($review->status === 'rejected' ? 'negative' : ''))}}">{{$review->status === 'Aprobada' ? 'positive' : ($review->status === 'reviewing' ? 'En revisión' : ($review->status === 'Rechazada' ? 'negative' : 'Sin entregar'))}}</td>
								<td>{{ $review->limit_date }}</td>
								@if (Auth::user()->role !== 'student')
									<td class="collapsing right aligned">
										<div class="ui teal icon button" target-modal="edit-review-{{ $review->id }}-modal"><i class="pen icon"></i></div>
										<div class="ui red icon button" target-modal="delete-review-{{ $review->id }}-modal"><i class="trash icon"></i></div>
									</td>
								@endif
							</tr>
						@empty
              </tbody>
              </table>
              <div class="ui placeholder segment" wire:loading.class="loading">
                <div class="ui icon header">
                  <i class="exclamation icon"></i>
                  @if (Auth::user()->role !== 'student')
                    Aún no hay revisiones agendadas, intente añadir algunas.
                  @else
                    Aún no existen revisiones vinculadas con este proceso.
                  @endif
                </div>
                @if (Auth::user()->role !== 'student')
                  <div class="ui teal button" target-modal="create-review-modal">
                    <i class="plus icon"></i>Agendar una revisión
                  </div>
                @endif
              </div>
				@endforelse
				</tbody>
				</table>
			</div>

			<div class="ui comments">
				<h3 class="ui dividing header">Comentarios</h3>
				@forelse ($comments as $comment)
					<div class="comment">
						<div class="avatar">
              <i class="big black {{ $comment->user->role === 'super' ? 'user astronaut' : ($comment->user->role === 'admin' ? 'user cog' : ($comment->user->role === 'manager' ? 'user tie' : ($comment->user->role === 'adviser' ? 'chalkboard teacher' : 'user graduate'))) }} icon"></i>
						</div>
						<div class="content">
							<span class="author">{{ strtok($comment->user->first_name, ' ') . ' ' . strtok($comment->user->last_name, ' ') }}</span>
							<div class="metadata">
								<span class="date">{{ $comment->date }} a las {{ $comment->time }}</span>
							</div>
							<div class="text">
								{{ $comment->message }}
							</div>
							{{-- @if ($comment->user->id === Auth::user()->id)
								<div class="actions">
									<a><i class="edit icon"></i>Editar comentario</a>
									<a><i class="trash icon"></i>Eliminar comentario</a>
								</div>
							@endif --}}
						</div>
					</div>
					@empty
						<div class="ui placeholder segment">
							<div class="ui icon header">
								<i class="comments icon"></i>
								Aún no hay comentarios para este proceso, si es necesario, puede añadir alguno(s).
							</div>
						</div>
					@endforelse
					<form class="ui reply form" id="add-comment-form" wire:submit.prevent="addComment" wire:loading.class="loading">
						<div class="field">
							<div class="field required {{ $errors->has('message') ? 'error' : '' }}">
								<div class="ui left icon input">
									<textarea id="message" name="message" wire:model.lazy="message" autocomplete="off" placeholder="Comentario..."></textarea>
									<i class="comment alternate icon"></i>
								</div>
								@error('message')
									<span class="ui error text">{{ $message }}</span>
								@enderror
							</div>
							<button class="ui teal labeled submit icon button" type="submit" wire:loading.class="loading" wire:loading.attr="disabled" wire:target="addComment">
								<i class="comment alternate icon outline"></i> Añadir comentario
							</button>
					</form>
				</div>
			</div>
		</div>

		@foreach ($reviews as $review)
			@livewire('processes.reviews.edit-review', ['review' => $review], key('edit-review-' . $review->id))
			@livewire('processes.reviews.delete-review', ['review' => $review], key('delete-review-' . $review->id))
		@endforeach

		@livewire('processes.reviews.create-review', ['process' => $process])
	</div>
