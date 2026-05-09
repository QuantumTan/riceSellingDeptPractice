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

                    <h1 class="fw-bold fs-4">Rice Items</h1>
                    <a href="{{ route('rices.create') }}" class="btn btn-primary  mb-3">Add a Product</a>

                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($rices as $r)
                                <tr>
                                    <td>{{ $r->rice_name }}</td>
                                    <td>Php {{ $r->price }}</td>
                                    <td>{{ $r->qty }}</td>
                                    <td>{{ $r->description }}</td>
                                    <td>
                                        <a href="{{ route('rices.edit', $r) }}" class="btn btn-outline-warning">Edit</a>
                                        <form action="{{ route('rices.destroy', $r) }}" method="POST"
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
                                    <td colspan="5">No Rice Available</td>
                                </tr>
                            @endforelse
                        </tbody>


                    </table>

                                        {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-3">
                        {{ $rices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
