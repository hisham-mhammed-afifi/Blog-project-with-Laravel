@extends('layouts.app')
@section('content')
<div class="card text-black mb-5">
    <img class="card-img" id="hero-img" src="{{ asset('imgs/image-heroo.jpg') }}" alt="Card image">
    <div class="card-img-overlay">
        <br>
        <br>
        <h1 class="font-weight-bold mt-md-5 pt-md-5 text-center">WELCOME TO MyBlog</h1>
        <h1 class="my-md-5 text-center">Lorem Ipsum is simply dummy</h1>
        <p class="mt-md-5 text-center px-md-5 mx-md-5 text-light">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
        <h1 class="text-center text-light pt-3"><i class="fas fa-chevron-down"></i></h1>
    </div>
</div>
<br>
<br>
<div class="row m-5">
    <div class="text-center col-md-4">
        <h1 class="text-danger"><i class="fas fa-bullseye"></i></h1>
        <h4 class="font-weight-bold mt-5">Lorem ipsum</h4>
        <p class="mx-5 mb-5">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Saepe iusto voluptatem soluta, ducimus alias, fugiat laborum.</p>
    </div>
    <div class="text-center col-md-4">
        <h1 class="text-danger"><i class="fas fa-heartbeat"></i></h1>
        <h4 class="font-weight-bold mt-5">Lorem ipsum</h4>
        <p class="mx-5 mb-5">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Saepe iusto voluptatem soluta, ducimus alias, fugiat laborum.</p>
    </div>
    <div class="text-center col-md-4">
        <h1 class="text-danger"><i class="far fa-eye"></i></h1>
        <h4 class="font-weight-bold mt-5">Lorem ipsum</h4>
        <p class="mx-5 mb-5">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Saepe iusto voluptatem soluta, ducimus alias, fugiat laborum.</p>
    </div>
</div>
<br>
<br>
@auth
    {{-- create new post --}}
<div class="text-center my-5">
  <h1>
    Thinking of somthing, Write it ...
    <i class="fas fa-pencil-alt pl-3"></i>
  </h1>
  <a href="{{ route('posts.create') }}" class="btn btn-primary shadow-sm px-5 my-5">
  <i class="fas fa-keyboard px-3"></i>
  Create your new post
  <i class="fas fa-keyboard px-3"></i>
  </a>
      {{-- -------link to trashed posts-------- --}}

  <a href="{{ route('trashed-posts.index') }}" class="text-secondary d-block text-center my-5">Link to trashed posts</a>
</div>
@endauth


{{-- -------all posts------- --}}

@forelse ($posts as $post)
<div class="row mx-1 justify-content-center text-center mx-auto my-5">
  <div class="col-md-9">
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
            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-outline-primary my-3 px-5 shadow-sm">Reade more ...</a>
            <p class="card-text"><small class="text-muted">Created at {{ $post->updated_at }}</small></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@empty
<h3 class="text-center">
  No result found for <b>{{ request()->query('search') }}</b>
</h3>
@endforelse
  <div class="row justify-content-center cnt my-5">
    {{ $posts->appends([
      'search' => request()->query('search')
    ])->links() }}
  </div>
@endsection