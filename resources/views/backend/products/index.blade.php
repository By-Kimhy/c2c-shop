@extends('backend.layout.master')
@section('title','Products')
@section('content')
<div class="content-wrapper">
    <div class="content-header d-flex justify-content-between align-items-center">
        <h1 class="m-0">Products</h1>
        <div>
            <form method="get" action="{{ route('admin.products.index') }}" class="d-inline-block mr-2">
                <div class="input-group">
                    <input name="q" class="form-control" placeholder="Search name, slug or description" value="{{ $q ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn-secondary">Search</button>
                    </div>
                </div>
            </form>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Create product</a>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
            @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

            <div class="card">
                <div class="card-body p-0">
                    @if($products->count())
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Thumb</th>
                                    <th>Name</th>
                                    <th>Seller</th>
                                    <th>Category</th>
                                    <th class="text-right">Price</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $p)
                                <tr>
                                    <td>{{ $p->id }}</td>

                                    <td style="width:80px">
                                        @php
                                            $thumb = $p->images[0] ?? null;
                                        @endphp

                                        @if($thumb && \Illuminate\Support\Facades\Storage::disk('public')->exists($thumb))
                                            <img src="{{ asset('storage/'.$thumb) }}" style="width:64px;height:48px;object-fit:cover;border-radius:4px;">
                                        @else
                                            <div style="width:64px;height:48px;background:#f0f0f0;border-radius:4px;"></div>
                                        @endif
                                    </td>

                                    <td>{{ $p->name }}</td>
                                    <td>{{ optional($p->user)->name ?? '—' }}</td>
                                    <td>{{ optional($p->category)->name ?? '—' }}</td>
                                    <td class="text-right">{{ number_format($p->price,2) }}</td>
                                    <td class="text-center">{{ $p->stock }}</td>
                                    <td class="text-center">{{ ucfirst($p->status) }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.products.show', $p->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        <a href="{{ route('admin.products.edit', $p->id) }}" class="btn btn-sm btn-primary">Edit</a>

                                        <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST"
                                              onsubmit="return confirm('Delete product?');" style="display:inline-block;">
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
                        {{ $products->links() }}
                    </div> --}}
                    @else
                    <div class="p-4">No products found.</div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
