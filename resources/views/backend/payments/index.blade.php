@extends('backend.layout.master')
@section('title','Payments')
@section('content')
<div class="content-wrapper">
  <div class="content-header d-flex justify-content-between align-items-center">
    <h1 class="m-0">Payments</h1>
    <div class="d-flex">
      <form method="get" action="{{ route('admin.payments.index') }}" class="mr-2">
        <div class="input-group">
          <input name="q" class="form-control" placeholder="Search provider/ref/id" value="{{ $q ?? '' }}">
          <select name="status" class="form-control ml-2">
            <option value="">All statuses</option>
            <option value="pending" {{ (request('status')=='pending')?'selected':'' }}>Pending</option>
            <option value="Paid" {{ (request('status')=='Paid')?'selected':'' }}>Paid</option>
            <option value="failed" {{ (request('status')=='failed')?'selected':'' }}>Failed</option>
          </select>
          <div class="input-group-append">
            <button class="btn btn-secondary">Filter</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
      @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

      <div class="card">
        <div class="card-body p-0">
          @if($payments->count())
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Order</th>
                    <th>Amount</th>
                    <th>Provider</th>
                    <th>Provider Ref</th>
                    <th>Status</th>
                    <th class="text-right">Created</th>
                    <th class="text-right">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($payments as $pay)
                    <tr>
                      <td>{{ $pay->id }}</td>
                      <td>
                        @if($pay->order)
                          <a href="{{ route('admin.orders.show', $pay->order->id) }}">#{{ $pay->order->order_number ?? $pay->order->id }}</a>
                        @else
                          —
                        @endif
                      </td>
                      <td class="text-right">{{ number_format($pay->amount,2) }} {{ $pay->currency ?? config('app.currency','KHR') }}</td>
                      <td>{{ $pay->provider ?? '-' }}</td>
                      <td>{{ $pay->provider_ref ?? '-' }}</td>
                      <td>{{ ucfirst($pay->status) }}</td>
                      <td class="text-right">{{ $pay->created_at->format('Y-m-d H:i') }}</td>
                      <td class="text-right">
                        <a href="{{ route('admin.payments.show', $pay->id) }}" class="btn btn-sm btn-outline-primary">View</a>

                        <form action="{{ route('admin.payments.destroy', $pay->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete payment?');">
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
          @else
            <div class="p-4">No payments found.</div>
          @endif
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
