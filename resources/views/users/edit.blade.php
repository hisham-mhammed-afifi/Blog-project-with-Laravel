@extends('layouts.app')
@section('content')
    <div class="row justify-content-center mx-1 mt-5">
      <div class="col-md-6">
        <div class="card card-defult shadow-lg">
          <div class="card-header">
            <div class="row">
              <div class="col-md-4">
                <img height="100px" width="100px" src="{{ asset('/storage/' . $user->image) }}" alt="">
              </div>
              <div class="col-md-8">
                <h3 class="font-weight-bold pt-3">{{ $user->name }}</h3>
                <h5 class="text-primary">
                  {{ $user->email }}
                </h5>
              </div>
            </div>
          </div>
          <div class="card-body">
            
            <form action="{{ route('users.update-profile') }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="input-group mb-3">
                <div class="custom-file">
                  <input name="image" type="file" class="custom-file-input" id="image">
                  <label class="custom-file-label" for="image">
                    upload a profile photo
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}">
              </div>

              <div class="form-group">
                <label for="about">About Me</label>
                <textarea name="about" id="about" cols="30" rows="5" class="form-control">{{ $user->about }}</textarea>
              </div>

              <button type="submit" class="btn btn-sm btn-block btn-primary">Update</button>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection