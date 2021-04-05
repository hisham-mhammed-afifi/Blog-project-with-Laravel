@extends('layouts.app')
@section('content')
    <div class="row justify-content-center m-3 py-3">
      <div class="col-md-6">
        <a href="{{ route('posts.index') }}" class="text-secondary">
          <i class="fas fa-backward"></i>
          Back to home ...
        </a>
        <form
        action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($post))
            @method('PUT')
        @endif
          <div class="form-group my-3 pt-5">
            @error('image')
              <div class="text-danger">{{ $message }}</div>
            @enderror
            <div class="input-group mb-3">
              <div class="custom-file">
                <input name="image" type="file" class="custom-file-input" id="image"
                      value="{{ isset($post) ? $post->image : '' }}">
                <label class="custom-file-label" for="image">
                  {{ isset($post) ? 'Change the image ...' : 'Upload an Image ...' }}
                </label>
              </div>
            </div>
            <label for="title">Post title</label>
            <input name="title" type="text" class="form-control" id="title"
            value="{{ isset($post) ? $post->title : '' }}">
            @error('title')
              <div class="text-danger">{{ $message }}</div>
            @enderror
            <br>

            <label for="body">Post body</label>
            <input id="body" type="hidden" name="body" value="{{ isset($post) ? $post->body : '' }}">
            <trix-editor input="body"></trix-editor>
            @error('body')
              <div class="text-danger">{{ $message }}</div>
            @enderror
            <br>
          </div>
          <!--      select category        -->
          <div class="input-group mb-3">
            <select name="{{ isset($post) ? 'category_id' : 'category'}}"
            class="custom-select" id="category">
              <option value="1" disabled selected>Choose the Category ...</option>
              @foreach ($categories as $category)
                  <option value="{{ $category->id }}"
                    @if (isset($post))
                      @if ($category->id === $post->category_id)
                      selected
                      @endif
                    @endif
                    >{{ $category->name }}</option>
              @endforeach
            </select>
          </div>
          @error('category')
            <div class="text-danger">{{ $message }}</div>
          @enderror
          <button type="submit" class="btn btn-sm btn-dark btn-block my-5">
            {{ isset($post) ? 'Update post' : 'Add post' }}
          </button>
        </form>
      </div>
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css" crossorigin="anonymous" />
    <style>
      trix-toolbar .trix-button-row {
        flex-wrap: wrap !important;
      }
      trix-editor {
        background-color: #fff;
      }
      .trix-button-group--file-tools {
        display: none !important;
      }
      /* trix-editor {
        height: auto !important;
      } */
    </style>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js" crossorigin="anonymous"></script>
    <script>
      document.addEventListener("trix-file-accept", (e) => {
        e.preventDefault()
      })
    </script>
@endsection