@extends('layouts.app')
@section('content')
    <div class="row justify-content-center m-1 mt-5">
      <div class="col-md-8">
        <ul class="list-group list-group-flush shadow-lg">
          @foreach ($users as $user)
              <li class="list-group-item py-3">
                @if ($user->name !== 'admin')
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-link text-danger float-right">
                        <i class="fas fa-times"></i>
                      </button>
                    </form>
                  @endif
                <div class="row">
                  <div class="col-md-4 m-auto">
                    <img height="50px" width="50px" class="rounded-circle"
                    src="{{ asset('/storage/' . $user->image) }}" alt="">
                    <h5 class="mt-3">
                      {{ Str::upper($user->name) }} - <small>{{ $user->gender }}</small>
                    </h5>
                      <p class="text-primary">
                        {{ $user->email }}
                      </p>
                  </div>
                  <div class="col-md-8">
                    <p>{{ $user->about }}</p>
                    <a href="{{ route('users.posts', $user->id) }}">{{ $user->posts()->count() }} Posts</a>
                    @if ($user->role !== 'admin')
                        <form action="{{ route('users.make-admin', $user->id) }}" method="POST">
                          @csrf
                          <button type="submit" class="btn btn-sm btn-success float-right">
                            <i class="fas fa-user-tie"></i>
                            Add to Admin
                          </button>
                        </form>
                    @endif
                    @if ($user->name !== 'admin' && $user->role === 'admin')
                        <form action="{{ route('users.make-user', $user->id) }}" method="POST">
                          @csrf
                          <button type="submit" class="btn btn-sm btn-danger float-right">
                            <i class="fas fa-user-tie pr-1"></i>
                            Back to User
                          </button>
                        </form>
                    @endif
                  </div>
                </div>
              </li>
          @endforeach
        </ul>
      </div>
    </div>
@endsection