@extends('layouts.app')
@section('content')
<div class="row justify-content-center m-1">
  <div class="col-md-8">
    <div class="card my-3 shadow-lg">
      <img id="post-img" src="{{ asset('/storage/' . $post->image) }}" class="card-img-top" alt="...">
      <div class="card-body mx-md-5 pb-5">
        <div class="text-center">
          <img height="50px" width="50px" class="rounded-circle"
              src="{{ asset('/storage/' . $post->user->image) }}" alt="">
          <p class="text-primary py-3">
            <a href="{{ route('users.posts', $post->user->id) }}">
              Created by {{ $post->user->name }}
            </a>
          </p>
        </div>
        <a href="{{ route('categories.show', $post->category->id) }}">
          {{ Str::upper($post->category->name) }}
        </a>
        <h5 class="card-title my-3">{{ Str::upper($post->title) }}</h5>
        <p class="card-text py-3">{!! $post->body !!}</p>
        <p class="card-text"><small class="text-muted">Created at {{ $post->updated_at }}</small></p>
      </div>
    </div>
    <div class="d-flex justify-content-end">
      @if (Auth::id() === $post->user_id)
        @if (!$post->trashed())
            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-info text-white px-3 shadow">
              <i class="fas fa-pen pr-3"></i>
              Edite
            </a>
        @else
            <form action="{{ route('restore-posts', $post->id) }}" method="POST" class="d-inline">
              @csrf
              @method('PUT')
              <button type="submit" class="btn btn-sm btn-info text-white px-3 shadow">
                <i class="fas fa-undo pr-3"></i>
                Restore
              </button>
            </form>
        @endif
          <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger mx-3 px-3 shadow">
              <i class="far fa-trash-alt pr-3"></i>
              {{ $post->trashed() ? 'Delete' : 'Trash' }}
            </button>
          </form>
      @endif
    </div>
  </div>
</div>
<br>
<br>
@if (!$post->trashed())
          <!-- ================ comments section  =========== -->
          <!-- ================ comments section  =========== -->
          <!-- ================ comments section  =========== -->
<div class="row justify-content-center mx-1 my-3">
  @if ($post->hasComments())
  <a data-toggle="collapse" class="btn btn-outline-secondary px-md-5 border-0"
  href="#collapseExample" role="button" aria-expanded="false" id="hide-btn"
  aria-controls="collapseExample">Tap to see all Comments</a>
  @else
  @auth
      <p class="text-muted">Leave the first comment</p>
  @endauth
  @endif
</div>
<div class="row justify-content-center mx-1">
  <div class="col-md-8">
<div class="card mb-5 shadow-lg">
      <ul class="list-group list-group-flush mx-md-5">
        
        <!-- loop through all comments -->
        <!-- loop through all comments -->
        <!-- loop through all comments -->

        @foreach ($post->comments as $comment)
            <li class="list-group-item collapse" id="collapseExample">
              <div class="mx-1">
                <img height="30px" width="30px" class="rounded-circle d-inline"
                    src="{{ asset('/storage/' . $comment->user->image) }}" alt="">
                    <span class="text-primary pt-3 pl-3">{{ $comment->user->name }}</span>
              </div>
              <p id="{{ $comment->id }}" class="pl-5">{{ $comment->content }}</p>

          @if (Auth::id() === $comment->user->id)
              <!--delete comment button-->
              <form action="{{ route('comments.destroy',$comment->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-link text-danger float-right shadow-0">
                  delete
                </button>
              </form>
          @endif

          @if (Auth::id() === $comment->user->id)
              <!--edit comment button-->
              <button class="btn btn-link text-primary float-right shadow-0"
                 onclick="editcomment({{ $comment->id }})">
                <i class="fas fa-pen"></i>
              </button>
              <!--  edit comment Modal -->
          <div class="modal fade" id="editComment" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <form action="" method="POST" id="edit-form">
                @csrf
                @method('PUT')
                <div class="modal-content p-md-3">
                <div class="modal-body">
                  <input type="hidden" name="post_id" value="{{ $post->id }}">
                  <textarea name="content" cols="100" rows="5" class="form-control mb-3 shadow-lg" id="comment-content"></textarea>
                  <button type="submit" class="btn btn-sm btn-primary float-right ml-3">
                    Update
                  </button>
                  <button type="button" class="btn btn-sm btn-secondary float-right" data-dismiss="modal">Back</button>
                </div>
              </div>
              </form>
            </div>
          </div>
        @endif
            </li>

        @endforeach
      </ul>
    </div>
    </div>
</div>


<!-- ================ comments section for authinticated  =========== -->


@auth
<div class="row justify-content-center m-1">
  <div class="col-md-8">
    <button class="btn btn-block btn-outline-secondary float-right my-3"
            onclick="postcomment()">
      <i class="far fa-comment-dots px-3"></i>
      Write Your Comment
    </button>
    <!--  create comment Modal -->
    <div class="modal fade" id="createComment" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('comments.store') }}" 
              method="POST" id="edit">
          @csrf
          <div class="modal-content p-md-3">
          <div class="modal-body">
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <textarea name="content" cols="100" rows="5" class="form-control mb-3 shadow-lg"></textarea>
            <button type="submit" class="btn btn-sm btn-primary float-right ml-3 px-3">
              Comment
            </button>
            <button type="button" class="btn btn-sm btn-secondary float-right px-3" data-dismiss="modal">Back</button>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endauth
@endif
@endsection




@section('scripts')
    <script>
      function postcomment() {
        $('#createComment').modal('show')
      }
      function editcomment(id) {
        var form = document.getElementById('edit-form')
        var v1 = document.getElementById(id).innerHTML
        var v2 = document.getElementById('comment-content').innerHTML = v1
        form.action = '/comments/' + id
        $('#editComment').modal('show')
      }

      $('#hide-btn').on('click', function() {
        $('#hide-btn').hide();
      });
    </script>
@endsection