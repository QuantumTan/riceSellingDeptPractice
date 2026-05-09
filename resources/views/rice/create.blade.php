<x-app-layout>
    <x-slot name="header">
        <h2 class="h5 mb-0">
            {{ __('Add Rice Product') }}
        </h2>
    </x-slot>

    <div class="row justify-content-center my-5">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('rices.store') }}" method="POST">
                        @csrf

                        {{-- Rice Name (Dropdown for Enum) --}}
                        <div class="mb-3">
                            <label for="rice_name" class="form-label">Rice Name</label>
                            <select name="rice_name" id="rice_name"
                                class="form-select @error('rice_name') is-invalid @enderror">
                                <option value="">-- Select Rice --</option>
                                <option value="Jasmine" {{ old('rice_name') == 'Jasmine' ? 'selected' : '' }}>Jasmine</option>
                                <option value="Brown" {{ old('rice_name') == 'Brown' ? 'selected' : '' }}>Brown</option>
                                <option value="Dinorado" {{ old('rice_name') == 'Dinorado' ? 'selected' : '' }}>Dinorado</option>
                            </select>
                            @error('rice_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Price --}}
                        <div class="mb-3">
                            <label for="price" class="form-label">Price per KG (₱)</label>
                            <input type="number" step="0.01" name="price" id="price"
                                value="{{ old('price') }}"
                                class="form-control @error('price') is-invalid @enderror">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Quantity --}}
                        <div class="mb-3">
                            <label for="qty" class="form-label">Stock Quantity (kg)</label>
                            <input type="number" step="0.01" name="qty" id="qty"
                                value="{{ old('qty') }}"
                                class="form-control @error('qty') is-invalid @enderror">
                            @error('qty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="3"
                                class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                    <a href="{{ route('rices.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>