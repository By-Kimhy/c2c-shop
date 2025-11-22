@extends('backend.layout.master')

@section('title','Categories')

@section('content')
<div class="content-wrapper">
  <div class="content-header d-flex justify-content-between align-items-center">
    <h1 class="m-0">Categories</h1>
    <div>
      <form method="get" action="{{ route('admin.categories.index') }}" class="d-inline-block mr-2">
        <div class="input-group">
          <input name="q" class="form-control" placeholder="Search name or slug" value="{{ $q ?? '' }}">
          <div class="input-group-append">
            <button class="btn btn-secondary">Search</button>
          </div>
        </div>
      </form>
      <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Create Category</a>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      <div class="card">
        <div class="card-body p-0">
          @if($categories->count())
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Products</th>
                    <th class="text-right">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($categories as $cat)
                    <tr>
                      <td>{{ $cat->id }}</td>
                      <td>{{ $cat->name }}</td>
                      <td>{{ $cat->slug }}</td>
                      <td>{{ $cat->products()->count() }}</td>
                      <td class="text-right">
                        <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn-sm btn-primary">Edit</a>

                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="post" style="display:inline-block" onsubmit="return confirm('Delete category?');">
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

            <div class="card-footer clearfix">
              {{ $categories->links() }}
            </div>
          @else
            <div class="p-4">No categories found.</div>
          @endif
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
