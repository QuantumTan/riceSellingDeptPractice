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
                    <h1 class="fw-bold fs-4">Rice Items</h1>
                    <a href="{{ route('rice.create') }}" class="btn btn-primary  mb-3">Add a Product</a>

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
                            @forelse ($rice as $r)
                                <td>{{ $r->name }}</td>
                                <td>Php {{ $r->price }}</td>
                                <td>{{ $r->qty }}</td>
                                <td>{{ $r->description }}</td>
                                <td>
                                    <a href="{{ route('rice.edit') }}" class="btn btn-outline-warning">
                                        Edit
                                    </a>
                                    <form action="{{ route('rice.destroy') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" onclick="return confirm('Delete')"> Delete</button>
                                    </form>
                                </td>
                            @empty
                                <tr>
                                    <td colspan="5">No Rice Available</td>
                                </tr>
                            @endforelse
                        </tbody>


                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
