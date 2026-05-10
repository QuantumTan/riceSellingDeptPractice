<x-app-layout>
    <x-slot name="header">
        <h2 class="h5 mb-0">
            {{ __('Payment History') }}
        </h2>
    </x-slot>

    <div class="row justify-content-center my-5">
        <div class="col-lg-11">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="fw-bold fs-4 mb-1">Payment Transactions</h1>
                            <p class="text-muted mb-0">View all recorded payment transactions and update payment status if needed.</p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Customer</th>
                                    <th>Amount Paid</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments as $payment)
                                    <tr>
                                        <td>#{{ $payment->order?->id }}</td>
                                        <td>{{ $payment->order?->customer?->getFullName() ?? 'N/A' }}</td>
                                        <td>Php {{ number_format((float) $payment->amount_paid, 2) }}</td>
                                        <td>
                                            <span class="badge text-bg-{{ $payment->payment_status === 'paid' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($payment->payment_status) }}
                                            </span>
                                        </td>
                                        <td>{{ $payment->created_at->format('M d, Y h:i A') }}</td>
                                        <td class="d-flex gap-2">
                                            <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-outline-primary">View</a>

                                            <form method="POST" action="{{ route('payments.update', $payment) }}" class="d-inline-flex gap-2 align-items-center">
                                                @csrf
                                                @method('PUT')
                                                <select name="payment_status" class="form-select form-select-sm" style="width: auto;">
                                                    <option value="paid" @selected($payment->payment_status === 'paid')>Paid</option>
                                                    <option value="unpaid" @selected($payment->payment_status === 'unpaid')>Unpaid</option>
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">Update</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-muted">No payment history yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>