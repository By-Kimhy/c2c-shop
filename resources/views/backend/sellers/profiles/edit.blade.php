@extends('backend.layout.master')
@section('title','Edit Seller Profile')
@section('content')

<div class="content-wrapper">
  <div class="content-header d-flex justify-content-between align-items-center">
    <h1 class="m-0">Edit Seller Profile</h1>
    <a href="{{ route('admin.seller-profiles.index') }}" class="btn btn-secondary">Back</a>
  </div>

  <section class="content">
    <div class="container-fluid">

      @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
      @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

      @if($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
      @endif

      <div class="card">
        <div class="card-body">

          {{-- Show linked user or the "fix missing user" helper --}}
          <div class="mb-4">
            <h4>User</h4>

            @if($profile->user)
              <p>
                Linked User:<br>
                <strong>{{ $profile->user->name }}</strong><br>
                <small>{{ $profile->user->email }}</small>
              </p>
            @else
              <div class="alert alert-warning">
                <strong>No user linked!</strong><br>
                You can fix it by selecting a user below.
              </div>

              {{-- Link user form --}}
              <form method="POST" action="{{ route('admin.seller-profiles.link-user', $profile->id) }}" class="form-inline mb-3">
                @csrf
                <div class="form-group mr-2" style="min-width:320px;">
                  <select name="user_id" class="form-control w-100" required>
                    <option value="">Choose user...</option>
                    @foreach($allUsers as $u)
                      <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                    @endforeach
                  </select>
                </div>
                <button class="btn btn-info">Link User</button>
              </form>

              <div class="text-muted small">
                If the user already has a seller profile, the system will prevent linking.
              </div>
            @endif
          </div>

          {{-- Main update form --}}
          <form method="post" action="{{ route('admin.seller-profiles.update', $profile->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
              <label>Shop name</label>
              <input name="shop_name" class="form-control" required value="{{ old('shop_name', $profile->shop_name) }}">
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Phone</label>
                <input name="phone" class="form-control" value="{{ old('phone', $profile->phone) }}">
              </div>
              <div class="form-group col-md-6">
                <label>Address</label>
                <input name="address" class="form-control" value="{{ old('address', $profile->address) }}">
              </div>
            </div>

            <div class="form-group">
              <label>Description</label>
              <textarea name="description" rows="4" class="form-control">{{ old('description', $profile->description) }}</textarea>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Logo</label>
                <input type="file" name="logo" class="form-control-file">
                @if($profile->logo && file_exists(public_path('storage/'.$profile->logo)))
                  <div class="mt-2">
                    <img src="{{ asset('storage/'.$profile->logo) }}" alt="logo" style="width:160px;height:80px;object-fit:cover;border-radius:4px;">
                    <div class="mt-1">
                      <label class="mr-2">Replace logo to upload new one</label>
                      {{-- remove logo button (sends a flag handled server-side) --}}
                      <button type="submit" name="remove_logo" value="1" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove existing logo?')">Remove logo</button>
                    </div>
                  </div>
                @endif
              </div>

              <div class="form-group col-md-6">
                <label>Banner</label>
                <input type="file" name="banner" class="form-control-file">
                @if($profile->banner && file_exists(public_path('storage/'.$profile->banner)))
                  <div class="mt-2">
                    <img src="{{ asset('storage/'.$profile->banner) }}" alt="banner" style="width:240px;height:80px;object-fit:cover;border-radius:4px;">
                    <div class="mt-1">
                      <button type="submit" name="remove_banner" value="1" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove existing banner?')">Remove banner</button>
                    </div>
                  </div>
                @endif
              </div>
            </div>

            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="pending" {{ old('status', $profile->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ old('status', $profile->status) === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="suspended" {{ old('status', $profile->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
              </select>
            </div>

            <div class="form-group">
              <button class="btn btn-primary">Save</button>
              <a href="{{ route('admin.seller-profiles.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
          </form>

          {{-- Danger area: delete profile --}}
          <div class="mt-3">
            <form action="{{ route('admin.seller-profiles.destroy', $profile->id) }}" method="POST" onsubmit="return confirm('Delete this seller profile? This action cannot be undone.');">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger">Delete profile</button>
            </form>
          </div>

        </div>
      </div>

    </div>
  </section>
</div>

@endsection
