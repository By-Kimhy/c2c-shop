@extends('backend.layout.master')
@section('title', 'Seller Profiles')
@section('content')

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-between align-items-center">
        <h1 class="m-0">Seller Profiles</h1>

        <div class="d-flex">
            <form method="get" action="{{ route('admin.seller-profiles.index') }}" class="form-inline mr-2">
                <div class="input-group">
                    <input name="q" class="form-control" placeholder="Search shop name or slug" value="{{ $q ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn-secondary">Search</button>
                    </div>
                </div>
            </form>

            <form method="get" action="{{ route('admin.seller-profiles.index') }}" class="form-inline">
                <select name="status" class="form-control" onchange="this.form.submit()">
                    <option value="">All statuses</option>
                    <option value="pending" {{ (request('status')=='pending') ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ (request('status')=='approved') ? 'selected' : '' }}>Approved</option>
                    <option value="suspended" {{ (request('status')=='suspended') ? 'selected' : '' }}>Suspended</option>
                </select>
            </form>

            <form action="{{ route('admin.seller-profiles.fix-missing') }}" method="POST" class="ml-2">
                @csrf
                <button class="btn btn-warning" onclick="return confirm('Run fix? This will create profiles for seller-role users who are missing profiles.')">
                    Fix Missing Profiles
                </button>
            </form>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
            @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

            <div class="card">
                <div class="card-body p-0">
                    @if($profiles->count())
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Logo</th>
                                    <th>Shop Name</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($profiles as $profile)
                                <tr>
                                    <td>{{ $profile->id }}</td>

                                    <td style="width:100px">
                                        @if($profile->logo && file_exists(public_path('storage/'.$profile->logo)))
                                        <img src="{{ asset('storage/'.$profile->logo) }}" alt="logo" style="width:72px;height:48px;object-fit:cover;border-radius:4px;">
                                        @else
                                        <div style="width:72px;height:48px;background:#f0f0f0;border-radius:4px;"></div>
                                        @endif
                                    </td>

                                    <td>
                                        <strong>{{ $profile->shop_name }}</strong><br>
                                        <small class="text-muted">{{ $profile->slug }}</small>
                                        @if(empty($profile->shop_name))
                                        <div class="text-danger small">Missing shop name</div>
                                        @endif
                                    </td>

                                    <td>
                                        @if($profile->user)
                                        {{ $profile->user->name }}<br>
                                        <small class="text-muted">{{ $profile->user->email }}</small>
                                        @else
                                        <em class="text-warning">No user linked</em>
                                        <div class="small text-muted">This seller role exists in pivot but no profile user found.</div>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="badge badge-{{ $profile->status === 'approved' ? 'success' : ($profile->status === 'pending' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($profile->status) }}
                                        </span>
                                    </td>

                                    <td>{{ optional($profile->created_at)->format('Y-m-d') }}</td>

                                    <td class="text-right">
                                        <a href="{{ route('admin.seller-profiles.edit', $profile->id) }}" class="btn btn-sm btn-primary">Edit</a>

                                        @if(!empty($profile->slug))
                                        <a href="{{ route('shop.show', $profile->slug) }}" class="btn btn-sm btn-info" target="_blank">View shop</a>
                                        @endif

                                        <form action="{{ route('admin.seller-profiles.destroy', $profile->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete this seller profile? This cannot be undone.');">
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
                        {{ $profiles->withQueryString()->links() }}
                    </div>
                    @else
                    <div class="p-4">No seller profiles found.</div>
                    @endif
                </div>
            </div>

        </div>
    </section>
</div>

@endsection
