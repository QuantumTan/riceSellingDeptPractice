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
                    <form action="{{ route('rice.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="rice_name" class="form-label">Rice Name</label>
                            <select name="rice_name" id="rice_name"
                                class="form-select @error('rice_name') is-invalid @enderror">
                                <option value="">-- Select Rice --</option>
                                <option value="Jasmine" {{ old('rice_name') == 'Jasmine' ? 'selected' : '' }}>Jasmine
                                </option>
                                <option value="Brown" {{ old('rice_name') == 'Brown' ? 'selected' : '' }}>Brown
                                </option>
                                <option value="Dinorado" {{ old('rice_name') == 'Dinorado' ? 'selected' : '' }}>Dinorado
                                </option>
                            </select>
                            @error('rice_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" id="price">
                        </div>
                        @error('price')
                            <div class="invalid-feedback">
                                {{ message }}
                            </div>
                        @enderror

                        <div class="mb-3">
                            <label for="qty" class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="qty" id="qty">
                        </div>
                        @error('qty')
                            <div class="invalid-feedback">
                                {{ message }}
                            </div>
                        @enderror

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ message }}
                            </div>
                        @enderror

                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
