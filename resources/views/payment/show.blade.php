<x-app-layout>
    <x-slot name="header">
        <h2 class="h5 mb-0">
            {{ __('Payment Details') }}
        </h2>
    </x-slot>

    <div class="row justify-content-center my-5">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h1 class="fw-bold fs-4 mb-1">Payment #{{ $payment->id }}</h1>
                            <div class="text-muted">Order #{{ $payment->order?->id }}</div>
                        </div>
                        <a href="{{ route('payments.index') }}" class="btn btn-outline-primary">Back to History</a>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="border rounded p-3">
                                <div class="text-muted small">Customer</div>
                                <div class="fw-semibold">{{ $payment->order?->customer?->getFullName() ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded p-3">
                                <div class="text-muted small">Status</div>
                                <div class="fw-semibold">{{ ucfirst($payment->payment_status) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="border rounded p-3">
                        <div class="text-muted small">Amount Paid</div>
                        <div class="fw-semibold fs-5">Php {{ number_format((float) $payment->amount_paid, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>