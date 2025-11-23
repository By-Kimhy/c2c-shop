@extends('backend.layout.master')
@section('title','Sellers')
@section('content')

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0">Sellers</h1>

      <div class="d-flex">
        <form method="get" action="{{ route('admin.sellers.index') }}" class="form-inline mr-2">
          <div class="input-group">
            <input name="q" class="form-control" placeholder="Search name or email">
            <div class="input-group-append">
              <button class="btn btn-secondary">Search</button>
            </div>
          </div>
        </form>

        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Create Seller (user)</a>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
      @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

      <div class="card">
        <div class="card-body p-0">
          @if($sellers->count())
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Approved</th>
                  <th>Joined</th>
                  <th class="text-right">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($sellers as $seller)
                <tr data-id="{{ $seller->id }}">
                  <td>{{ $seller->id }}</td>
                  <td>{{ $seller->name }}</td>
                  <td>{{ $seller->email }}</td>
                  <td>
                    @if($seller->is_approved)
                      <span class="badge badge-success">Approved</span>
                    @else
                      <span class="badge badge-secondary">Pending</span>
                    @endif
                  </td>
                  <td>{{ $seller->created_at?->format('Y-m-d') }}</td>
                  <td class="text-right">
                    <a href="{{ route('admin.sellers.show', $seller->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                    <button class="btn btn-sm btn-info js-toggle-approve" data-id="{{ $seller->id }}">
                      {{ $seller->is_approved ? 'Suspend' : 'Approve' }}
                    </button>
                    <form action="{{ route('admin.sellers.destroy', $seller->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete seller?');">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          {{-- <div class="card-footer clearfix">
            {{ $sellers->links() }}
          </div> --}}
          @else
          <div class="p-4">No sellers found.</div>
          @endif
        </div>
      </div>
    </div>
  </section>
</div>

@endsection
