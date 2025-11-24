<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>{{ $profile->shop_name ?? 'Shop' }}</title>

  <!-- Basic CSS (Bootstrap from CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}" /> {{-- optional --}}
  <style>
    body { background:#f7f7f9; }
    .shop-banner { height:220px; object-fit:cover; width:100%; border-radius:6px; }
    .shop-logo { width:110px; height:110px; object-fit:cover; border-radius:8px; border:2px solid #fff; box-shadow:0 4px 12px rgba(0,0,0,.08); }
    .product-thumb { width:100%; height:220px; object-fit:cover; border-radius:6px; }
    .card-product { border:0; border-radius:8px; overflow:hidden; }
    .price { font-weight:700; color:#2c3e50; }
    .placeholder { background:#e9ecef; width:100%; height:220px; border-radius:6px; display:flex; align-items:center; justify-content:center; color:#6c757d; }
    .shop-head { margin-top:-56px; } /* lifts logo partly over banner */
  </style>
</head>
<body>

{{-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="{{ url('/') }}">C2C Shop</a>
</nav> --}}

<div class="container py-4">
  {{-- Banner --}}
  @php
    $hasBanner = !empty($profile->banner) && \Illuminate\Support\Facades\Storage::disk('public')->exists($profile->banner);
    $hasLogo = !empty($profile->logo) && \Illuminate\Support\Facades\Storage::disk('public')->exists($profile->logo);
  @endphp

  @if($hasBanner)
    <img src="{{ asset('storage/'.$profile->banner) }}" alt="banner" class="shop-banner mb-3">
  @else
    <div class="shop-banner mb-3 placeholder">No banner</div>
  @endif

  <div class="d-flex align-items-center shop-head">
    <div class="mr-3">
      @if($hasLogo)
        <img src="{{ asset('storage/'.$profile->logo) }}" alt="logo" class="shop-logo">
      @else
        <div class="shop-logo placeholder" style="display:flex;align-items:center;justify-content:center;">Logo</div>
      @endif
    </div>
    <div>
      <h2 class="mb-1">{{ $profile->shop_name ?? 'Unnamed Shop' }}</h2>
      <div class="text-muted">Seller: {{ optional($profile->user)->name ?? '—' }}</div>
      <div class="text-muted small">{{ $profile->phone ?? '' }}</div>
      <div class="mt-2">
        <span class="badge badge-{{ $profile->status === 'approved' ? 'success' : ($profile->status === 'pending' ? 'warning' : 'secondary') }}">
          {{ ucfirst($profile->status ?? 'pending') }}
        </span>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-lg-9">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Products</h4>

        <form class="form-inline" method="get" action="{{ url()->current() }}">
          <input name="q" class="form-control form-control-sm mr-2" placeholder="Search products..." value="{{ request('q') }}">
          <button class="btn btn-sm btn-outline-secondary">Search</button>
        </form>
      </div>

      @if($products->count())
        <div class="row">
          @foreach($products as $p)
            @php
              $thumb = is_array($p->images) && count($p->images) ? $p->images[0] : null;
              $imgExists = $thumb && \Illuminate\Support\Facades\Storage::disk('public')->exists($thumb);
              $imgUrl = $imgExists ? asset('storage/'.$thumb) : asset('frontend/assets/img/product/p4.jpg');
            @endphp

            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card card-product">
                @if($imgExists)
                  <img src="{{ $imgUrl }}" alt="{{ $p->name }}" class="product-thumb" onerror="this.onerror=null;this.src='{{ asset('frontend/assets/img/product/p4.jpg') }}'">
                @else
                  <div class="placeholder">No image</div>
                @endif

                <div class="card-body">
                  <h5 class="card-title" style="min-height:44px;">{{ \Illuminate\Support\Str::limit($p->name, 70) }}</h5>
                  <p class="mb-1 text-muted" style="min-height:38px;">{{ \Illuminate\Support\Str::limit($p->description ?? '', 80) }}</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="price">{{ number_format($p->price, 2) }} {{ config('app.currency','$') }}</div>
                    <div>
                      {{-- view product detail (adjust route/url if your detail route differs) --}}
                      <a href="{{ url('/productDetail?id='.$p->id) }}" class="btn btn-sm btn-outline-primary">View</a>

                      {{-- OPTIONAL: Add to cart (only if you enable cart route later). For now it's a safe link (no form) --}}
                      <a href="{{ url('/cart') }}" class="btn btn-sm btn-primary" onclick="return false;" title="Cart disabled">Add</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          @endforeach
        </div>

        {{-- <div class="mt-3">
          {{ $products->withQueryString()->links() }}
        </div> --}}

      @else
        <div class="alert alert-info">No products found for this shop.</div>
      @endif
    </div>

    <div class="col-lg-3">
      <div class="card mb-3">
        <div class="card-body">
          <h6>About this shop</h6>
          <p class="small">{{ $profile->description ? \Illuminate\Support\Str::limit($profile->description, 200) : 'No description' }}</p>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <h6>Contact seller</h6>
          <p class="small mb-1"><strong>Email:</strong> {{ optional($profile->user)->email ?? '—' }}</p>
          <p class="small mb-1"><strong>Phone:</strong> {{ $profile->phone ?? '—' }}</p>
          <a href="{{ url('/contact') }}" class="btn btn-sm btn-outline-primary">Contact</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- scripts -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
