@extends('frontend.layout.master')

@section('title', 'Seller Dashboard')

@section('content')

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>ប្រភេទផលិតផល</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">ទំព័រដើម<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">ហាង<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">ប្រភេទ</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<div class="container py-4">

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Top stats widget --}}
    @php
    $prodCount = \App\Models\Product::where('user_id', auth()->id())->count();
    $published = \App\Models\Product::where('user_id', auth()->id())->where('status','published')->count();
    $drafts = \App\Models\Product::where('user_id', auth()->id())->where('status','draft')->count();
    @endphp

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h6 class="mb-1">Total Products</h6>
                <h2 class="mb-2">{{ $prodCount }}</h2>
                <small class="text-muted">Count all products you created</small>
    </div>

</div>

<div class="col-md-4">
    <div class="card text-center p-3">
        <h6 class="mb-1">Published</h6>
        <h2 class="mb-2 text-success">{{ $published }}</h2>
<small class="text-muted">Visible on frontend</small>
</div>
</div>

<div class="col-md-4">
    <div class="card text-center p-3">
        <h6 class="mb-1">Drafts</h6>
        <h2 class="mb-2 text-secondary">{{ $drafts }}</h2>
        <small class="text-muted">Not visible yet</small>
    </div>
</div>
</div>


{{-- Shop profile card --}}
<div class="card mb-4">
    <div class="card-body d-flex">
        <div class="mr-3">
            @if(optional($profile)->logo)
            <img src="{{ asset('storage/' . $profile->logo) }}" alt="logo" style="width:100px;height:100px;object-fit:cover;border-radius:8px;">
            @else
            <div style="width:100px;height:100px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;border-radius:8px;">
                No Logo
            </div>
            @endif
        </div>

        <div class="flex-fill">
            <h4 class="mb-1">{{ $profile->shop_name ?? auth()->user()->name . '\'s Shop' }}</h4>
            <p class="mb-1">
                <strong>Status:</strong>
                <span class="badge badge-{{ ($profile->status == 'approved') ? 'success' : (($profile->status == 'pending') ? 'warning' : 'secondary') }}">
                    {{ ucfirst($profile->status ?? 'pending') }}
                </span>
            </p>
            <p class="mb-2 text-muted">{{ Str::limit($profile->description ?? 'No description yet.', 180) }}</p>

            <div class="btn-group">
                @if(isset($profile->slug))
                <a href="{{ route('shop.show', $profile->slug) }}" target="_blank" class="btn btn-outline-primary btn-sm">View Shop</a>
                @endif
                <a href="{{ route('seller.profile.edit') }}" class="btn btn-primary btn-sm">Edit Profile</a>
                <a href="{{ route('seller.products.index') }}" class="btn btn-secondary btn-sm">My Products</a>
            </div>
        </div>
    </div>
</div>

{{-- Recent products quick list (5 latest) --}}
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Recent Products</h5>
    </div>
    <div class="card-body">
        @php
        $recent = \App\Models\Product::where('user_id', auth()->id())->orderBy('created_at','desc')->limit(5)->get();
        @endphp

        @if($recent->count())
        <ul class="list-group">
            @foreach($recent as $p)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ Str::limit($p->name, 60) }}</strong>
                    <div class="text-muted small">{{ Str::limit($p->description ?? '-', 80) }}</div>
                </div>
                <div class="text-right">
                    <div>{{ number_format($p->price,2) }}</div>
                    <div class="mt-1">
                        <a href="{{ route('seller.products.edit', $p->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('seller.products.destroy', $p->id) }}" method="post" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete product?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        @else
        <div class="alert alert-info mb-0">You have no products yet. <a href="{{ route('seller.products.create') }}">Create your first product</a>.</div>
        @endif
    </div>
</div>

</div>
@endsection
