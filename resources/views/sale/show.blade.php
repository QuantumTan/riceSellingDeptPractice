<x-app-layout>
    <x-slot name="header">
        <h2 class="h5 mb-0">
            {{ __('Order Details') }}
        </h2>
    </x-slot>

    <div class="row justify-content-center my-5">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-4">
                        <div>
                            <h1 class="fw-bold fs-4 mb-1">Order #{{ $order->id }}</h1>
                            <div class="text-muted">Created {{ $order->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                        <a href="{{ route('sale.index') }}" class="btn btn-outline-primary align-self-start">Create Another Order</a>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="border rounded p-3 h-100">
                                <div class="text-muted small">Customer</div>
                                <div class="fw-semibold">{{ $order->customer?->getFullName() ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-3 h-100">
                                <div class="text-muted small">Handled By</div>
                                <div class="fw-semibold">{{ $order->user?->name ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-3 h-100">
                                <div class="text-muted small">Total Amount</div>
                                <div class="fw-semibold fs-5">Php {{ number_format((float) $order->total_amount, 2) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Rice Name</th>
                                    <th>Quantity (kg)</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->order_items as $item)
                                    <tr>
                                        <td>{{ $item->rices?->rice_name }}</td>
                                        <td>{{ number_format((float) $item->qty, 2) }}</td>
                                        <td>Php {{ number_format((float) $item->rices?->price, 2) }}</td>
                                        <td>Php {{ number_format((float) $item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row g-4 mt-2">
                        <div class="col-lg-5">
                            <div class="border rounded p-3 h-100 bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h2 class="h6 mb-0">Process Payment</h2>
                                    <a href="{{ route('payments.index') }}" class="btn btn-sm btn-outline-secondary">Payment History</a>
                                </div>

                                @php
                                    $paidAmount = (float) $order->payments->sum('amount_paid');
                                    $balance = max((float) $order->total_amount - $paidAmount, 0);
                                @endphp

                                <div class="mb-3">
                                    <div class="small text-muted">Paid Amount</div>
                                    <div class="fw-semibold">Php {{ number_format($paidAmount, 2) }}</div>
                                </div>
                                <div class="mb-3">
                                    <div class="small text-muted">Balance</div>
                                    <div class="fw-semibold">Php {{ number_format($balance, 2) }}</div>
                                </div>

                                <form method="POST" action="{{ route('payments.store') }}" class="vstack gap-3">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                                    <div>
                                        <label for="amount_paid" class="form-label">Amount Paid</label>
                                        <input type="number" step="0.01" min="0.01" name="amount_paid" id="amount_paid" class="form-control @error('amount_paid') is-invalid @enderror" placeholder="0.00" required>
                                        @error('amount_paid')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    @error('order_id')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror

                                    <button type="submit" class="btn btn-primary">Record Payment</button>
                                </form>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="border rounded p-3 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h2 class="h6 mb-0">Payment History</h2>
                                    <span class="badge text-bg-{{ $balance <= 0 ? 'success' : 'warning' }}">
                                        {{ $balance <= 0 ? 'Paid' : 'Unpaid' }}
                                    </span>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-sm align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($order->payments->sortByDesc('created_at') as $payment)
                                                <tr>
                                                    <td>{{ $payment->created_at->format('M d, Y h:i A') }}</td>
                                                    <td>Php {{ number_format((float) $payment->amount_paid, 2) }}</td>
                                                    <td>
                                                        <span class="badge text-bg-{{ $payment->payment_status === 'paid' ? 'success' : 'secondary' }}">
                                                            {{ ucfirst($payment->payment_status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-muted">No payments recorded yet.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>