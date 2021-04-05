@extends('layouts.app')
@section('content')
<h5 class="text-center py-5 font-weight-bold">CATEGORY NAME : {{ Str::upper($category->name) }}</h5>

@if ($posts->count() <= 0)
    <h5 class="text-muted my-5 py-5 text-center">
      No results found for <b>{{ $category->name }}</b> category
    </h5>
@endif
@foreach ($posts as $post)
<div class="row mx-1 justify-content-center text-center mx-auto my-5">
  <div class="col-md-8">
    <div class="card my-3 shadow-lg">
      <div class="row no-gutters">
        <div class="col-md-5">
          <img class="w-100 h-100" src="{{ asset('/storage/' . $post->image) }}" alt="...">
        </div>
        <div class="col-md-7">
          <div class="card-body">
            <p class="text-primary">Author: {{ $post->user->name }}</p>
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text">{!! Str::words($post->body, 20, '...') !!}</p>
            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-primary my-3 px-3">Reade more ...</a>
            <p class="card-text"><small class="text-muted">Created at {{ $post->updated_at }}</small></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach
<div class="row justify-content-center cnt my-5">
    {{ $posts->appends([
      'search' => request()->query('search')
    ])->links() }}
  </div>
@endsection