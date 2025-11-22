@extends('backend.layout.master')

@section('title', ($mode === 'create' ? 'Create Category' : 'Edit Category'))

@section('content')
<div class="content-wrapper">
  <div class="content-header d-flex justify-content-between align-items-center">
    <h1 class="m-0">{{ $mode === 'create' ? 'Create Category' : 'Edit Category' }}</h1>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back to list</a>
  </div>

  <section class="content">
    <div class="container-fluid">
      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="card">
        <div class="card-body">
          @if($mode === 'create')
            <form method="post" action="{{ route('admin.categories.store') }}">
          @else
            <form method="post" action="{{ route('admin.categories.update', $category->id) }}">
              @method('PUT')
          @endif
            @csrf

            <div class="form-group">
              <label for="name">Name</label>
              <input id="name" name="name" class="form-control" required value="{{ old('name', $category->name) }}">
            </div>

            <div class="form-group">
              <label for="slug">Slug (optional)</label>
              <input id="slug" name="slug" class="form-control" value="{{ old('slug', $category->slug) }}">
              <small class="form-text text-muted">Leave empty to generate automatically from name.</small>
            </div>

            <div class="form-group">
              <button class="btn btn-primary">{{ $mode === 'create' ? 'Create' : 'Save' }}</button>
              <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
