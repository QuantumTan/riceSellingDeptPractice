<x-app-layout>
    <x-slot name="header">
        <h2 class="h5 mb-0">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="row justify-content-center my-5">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <h1 class="fw-bold fs-4">Customer Directory</h1>
                    <a href="{{ route('customer.create') }}" class="btn btn-primary  mb-3">Add a Customer</a>

                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Contact Number</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($customers as $c)
                                <tr>
                                    <td>{{ $c->first_name }}</td>
                                    <td>{{ $c->last_name }}</td>
                                    <td>{{ $c->contact_number }}</td>
                                    <td>
                                        <a href="{{ route('customer.edit', $c) }}" class="btn btn-outline-warning">Edit</a>
                                        <form action="{{ route('customer.destroy', $c) }}" method="POST"
                                            style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger"
                                                onclick="return confirm('Delete')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No Customers yet</td>
                                </tr>
                            @endforelse
                        </tbody>


                    </table>

                                        {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-3">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
