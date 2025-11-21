@extends('backend.layout.master')
@section('title','Seller Details')
@section('content')

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0">Seller: {{ $seller->name }}</h1>
      <a href="{{ route('admin.sellers.index') }}" class="btn btn-sm btn-secondary">← Back to Sellers</a>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <p><strong>Name:</strong> {{ $seller->name }}</p>
          <p><strong>Email:</strong> {{ $seller->email }}</p>
          <p><strong>Approved:</strong> {{ $seller->is_approved ? 'Yes' : 'No' }}</p>
          <p><strong>Joined:</strong> {{ $seller->created_at?->format('Y-m-d H:i') }}</p>

          <button class="btn btn-info js-toggle-approve" data-id="{{ $seller->id }}">
            {{ $seller->is_approved ? 'Suspend' : 'Approve' }}
          </button>

          <form action="{{ route('admin.sellers.destroy', $seller->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete seller?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Delete</button>
          </form>

        </div>
      </div>
    </div>
  </section>
</div>

@endsection
