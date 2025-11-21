@extends('backend.layout.master')
@section('title','Users')
@section('content')

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0">Users</h1>

      <div class="d-flex">
        <form method="get" action="{{ route('admin.users.index') }}" class="form-inline mr-2">
          <div class="input-group">
            <input name="q" class="form-control" placeholder="Search name or email" value="{{ $q ?? '' }}">
            <div class="input-group-append">
              <button class="btn btn-secondary">Search</button>
            </div>
          </div>
        </form>

        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Create user</a>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body p-0">
          @if($users->count())
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Roles</th>
                  <th>Joined</th>
                  <th class="text-right">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                <tr data-user-id="{{ $user->id }}">
                  <td>{{ $user->id }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>
                    @foreach($user->roles as $r)
                      <span class="badge badge-info">{{ $r->name }}</span>
                    @endforeach
                  </td>
                  <td>{{ $user->created_at ? $user->created_at->format('Y-m-d') : '-' }}</td>
                  <td class="text-right">
                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>

                    <!-- AJAX Delete Button -->
                    <button class="btn btn-sm btn-danger js-delete-user" data-id="{{ $user->id }}">
                      Delete
                    </button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="card-footer clearfix">
            {{ $users->links() }}
          </div>
          @else
          <div class="p-4">No users found.</div>
          @endif
        </div>
      </div>
    </div>
  </section>
</div>

@endsection
