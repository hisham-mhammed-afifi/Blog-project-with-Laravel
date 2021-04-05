@extends('layouts.app')
@section('content')
    <div class="row justify-content-center mx-1 my-5">
      <div class="col-md-6">
        <ul class="list-group list-group-flush shadow-lg">
          <li class="list-group-item py-3 px-5 text-center pt-5">
            <form action="{{ route('categories.store') }}" method="POST">
              @csrf
              <input type="text" class="form-control form-control-sm" name="name" id="name">
              @error('name')
                <div class="text-danger">{{ $message }}</div>
              @enderror
              <button type="submit" class="btn btn-sm btn-success px-3 my-3 shadow-sm">Add Category</button>
            </form>
          </li>
          @foreach ($categories as $category)
            <li class="list-group-item py-3">
              <a href="{{ route('categories.show', $category->id) }}">
                {{ Str::upper($category->name) }}
              </a>
              <div class="text-muted d-inline float-right">{{ $category->posts->count() }} Posts</div>
              <form action="{{ route('categories.destroy',$category->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-link text-danger float-right shadow-0">
                  <i class="far fa-trash-alt"></i>
                </button>
              </form>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
@endsection