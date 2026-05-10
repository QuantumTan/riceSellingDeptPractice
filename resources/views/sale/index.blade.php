<x-app-layout>
    <x-slot name="header">
        <h2 class="h5 mb-0">
            {{ __('New Order') }}
        </h2>
    </x-slot>

    <div class="row justify-content-center my-5">
        <div class="col-lg-11">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <div class="fw-semibold mb-1">Please fix the highlighted errors.</div>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
                        <div>
                            <h1 class="fw-bold fs-4 mb-1">Create a New Order</h1>
                            <p class="text-muted mb-0">Enter customer details, select rice items, and save the order record.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('sale.store') }}" id="order-form">
                        @csrf

                        <div class="border rounded p-3 mb-4 bg-white">
                            <div class="fw-semibold mb-3">Customer Details</div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="customer_first_name" class="form-label">First Name</label>
                                    <input type="text" name="customer_first_name" id="customer_first_name" value="{{ old('customer_first_name') }}" class="form-control @error('customer_first_name') is-invalid @enderror" placeholder="Juan" required>
                                    @error('customer_first_name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="customer_last_name" class="form-label">Last Name</label>
                                    <input type="text" name="customer_last_name" id="customer_last_name" value="{{ old('customer_last_name') }}" class="form-control @error('customer_last_name') is-invalid @enderror" placeholder="Dela Cruz" required>
                                    @error('customer_last_name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="customer_contact_number" class="form-label">Contact Number</label>
                                    <input type="text" name="customer_contact_number" id="customer_contact_number" value="{{ old('customer_contact_number') }}" class="form-control @error('customer_contact_number') is-invalid @enderror" placeholder="09XXXXXXXXX" required>
                                    @error('customer_contact_number')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mb-3">
                            <table class="table align-middle" id="order-items-table">
                                <thead>
                                    <tr>
                                        <th style="min-width: 260px;">Rice Name</th>
                                        <th style="min-width: 160px;">Quantity (kg)</th>
                                        <th style="min-width: 140px;">Price</th>
                                        <th style="min-width: 150px;">Total Amount</th>
                                        <th style="width: 1%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $orderRows = old('items');
                                        if (! is_array($orderRows) || $orderRows === []) {
                                            $orderRows = [['rice_id' => '', 'qty' => '']];
                                        }
                                    @endphp

                                    @foreach ($orderRows as $index => $orderRow)
                                        @php
                                            $selectedRice = $rices->firstWhere('id', (int) ($orderRow['rice_id'] ?? 0));
                                            $rowPrice = $selectedRice?->price ?? 0;
                                            $rowQty = old('items.' . $index . '.qty', $orderRow['qty'] ?? '');
                                            $rowSubtotal = is_numeric($rowQty) ? round((float) $rowQty * (float) $rowPrice, 2) : 0;
                                        @endphp
                                        <tr data-order-row>
                                            <td>
                                                <select name="items[{{ $index }}][rice_id]" class="form-select rice-select @error('items.' . $index . '.rice_id') is-invalid @enderror" required>
                                                    <option value="">Select rice</option>
                                                    @foreach ($rices as $rice)
                                                        <option value="{{ $rice->id }}" data-price="{{ $rice->price }}" @selected((string) ($orderRow['rice_id'] ?? '') === (string) $rice->id)>
                                                            {{ $rice->rice_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('items.' . $index . '.rice_id')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" min="0.01" name="items[{{ $index }}][qty]" value="{{ $rowQty }}" class="form-control qty-input @error('items.' . $index . '.qty') is-invalid @enderror" placeholder="0.00" required>
                                                @error('items.' . $index . '.qty')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text" class="form-control rice-price" value="{{ number_format((float) $rowPrice, 2) }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control row-subtotal" value="{{ number_format((float) $rowSubtotal, 2) }}" readonly>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-outline-danger remove-row">Remove</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                            <button type="button" class="btn btn-outline-secondary" id="add-row">Add Rice Item</button>

                            <div class="fs-5 fw-semibold">
                                Total: <span id="order-total">Php 0.00</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('rices.index') }}" class="btn btn-light">Back to Rice List</a>
                            <button type="submit" class="btn btn-primary">Save Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <template id="order-row-template">
        <tr data-order-row>
            <td>
                <select name="items[__INDEX__][rice_id]" class="form-select rice-select" required>
                    <option value="">Select rice</option>
                    @foreach ($rices as $rice)
                        <option value="{{ $rice->id }}" data-price="{{ $rice->price }}">
                            {{ $rice->rice_name }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" step="0.01" min="0.01" name="items[__INDEX__][qty]" class="form-control qty-input" placeholder="0.00" required>
            </td>
            <td>
                <input type="text" class="form-control rice-price" value="0.00" readonly>
            </td>
            <td>
                <input type="text" class="form-control row-subtotal" value="0.00" readonly>
            </td>
            <td>
                <button type="button" class="btn btn-outline-danger remove-row">Remove</button>
            </td>
        </tr>
    </template>

    @push('scripts')
        <script>
            (function () {
                const tableBody = document.querySelector('#order-items-table tbody');
                const template = document.querySelector('#order-row-template');
                const totalDisplay = document.querySelector('#order-total');
                const addRowButton = document.querySelector('#add-row');

                function formatMoney(value) {
                    return `Php ${Number(value || 0).toFixed(2)}`;
                }

                function getRowPrice(row) {
                    const selectedOption = row.querySelector('.rice-select option:checked');
                    return Number(selectedOption?.dataset.price || 0);
                }

                function updateRow(row) {
                    const priceInput = row.querySelector('.rice-price');
                    const subtotalInput = row.querySelector('.row-subtotal');
                    const qtyInput = row.querySelector('.qty-input');
                    const price = getRowPrice(row);
                    const qty = Number(qtyInput.value || 0);
                    const subtotal = price * qty;

                    priceInput.value = price.toFixed(2);
                    subtotalInput.value = subtotal.toFixed(2);

                    updateTotal();
                }

                function updateTotal() {
                    const total = [...document.querySelectorAll('.row-subtotal')].reduce((sum, input) => {
                        return sum + Number(input.value || 0);
                    }, 0);

                    totalDisplay.textContent = formatMoney(total);
                }

                function bindRow(row) {
                    row.querySelector('.rice-select')?.addEventListener('change', () => updateRow(row));
                    row.querySelector('.qty-input')?.addEventListener('input', () => updateRow(row));
                    row.querySelector('.remove-row')?.addEventListener('click', () => {
                        if (document.querySelectorAll('[data-order-row]').length === 1) {
                            row.querySelector('.rice-select').value = '';
                            row.querySelector('.qty-input').value = '';
                            row.querySelector('.rice-price').value = '0.00';
                            row.querySelector('.row-subtotal').value = '0.00';
                            updateTotal();
                            return;
                        }

                        row.remove();
                        updateTotal();
                    });
                    updateRow(row);
                }

                addRowButton.addEventListener('click', () => {
                    const index = document.querySelectorAll('[data-order-row]').length;
                    const rowHtml = template.innerHTML.replaceAll('__INDEX__', index);
                    const wrapper = document.createElement('tbody');
                    wrapper.innerHTML = rowHtml.trim();
                    const row = wrapper.firstElementChild;
                    tableBody.appendChild(row);
                    bindRow(row);
                });

                document.querySelectorAll('[data-order-row]').forEach((row) => bindRow(row));
                updateTotal();
            })();
        </script>
    @endpush
</x-app-layout>