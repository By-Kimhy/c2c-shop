@extends('backend.layout.master')
@section('title','User Details')
@section('content')

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0">User #{{ $user->id }}</h1>
      <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary">← Back to Users</a>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <p><strong>Name:</strong> {{ $user->name }}</p>
          <p><strong>Email:</strong> {{ $user->email }}</p>
          <p><strong>Roles:</strong>
            @foreach($user->roles as $r)
              <span class="badge badge-info">{{ $r->name }}</span>
            @endforeach
          </p>
          <p><strong>Joined:</strong> {{ $user->created_at ? $user->created_at->format('Y-m-d H:i') : '-' }}</p>

          <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">Edit</a>

          <!-- AJAX Delete Button -->
          <button class="btn btn-danger js-delete-user" data-id="{{ $user->id }}">
            Delete
          </button>
        </div>
      </div>
    </div>
  </section>
</div>

@endsection
