@extends('backend.layout.master')
@section('title','Seller Profiles')
@section('content')

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0">Seller Profiles</h1>
      <form method="get" action="{{ route('admin.seller-profiles.index') }}" class="form-inline">
        <div class="input-group">
          <input name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="search shop, owner">
          <div class="input-group-append">
            <button class="btn btn-secondary">Search</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
      <div class="card">
        <div class="card-body p-0">
          <table class="table mb-0">
            <thead>
              <tr>
                <th>ID</th><th>Shop</th><th>Owner</th><th>Status</th><th>Joined</th><th class="text-right">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($profiles as $p)
              <tr>
                <td>{{ $p->id }}</td>
                <td>
                  <strong>{{ $p->shop_name }}</strong><br>
                  <a href="{{ route('shop.show', $p->slug) }}" target="_blank">{{ url('/shop/'.$p->slug) }}</a>
                </td>
                <td>{{ $p->user->name }}<br><small>{{ $p->user->email }}</small></td>
                <td>
                  <span class="badge badge-{{ $p->status === 'approved' ? 'success' : ($p->status==='pending' ? 'secondary' : 'warning') }}">
                    {{ ucfirst($p->status) }}
                  </span>
                </td>
                <td>{{ $p->created_at->format('Y-m-d') }}</td>
                <td class="text-right">
                  <a href="{{ route('admin.seller-profiles.edit', $p->id) }}" class="btn btn-sm btn-primary">Edit</a>
                  <form action="{{ route('admin.seller-profiles.destroy', $p->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete profile?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="card-footer clearfix">
          {{ $profiles->links() }}
        </div>
      </div>
    </div>
  </section>
</div>

@endsection
