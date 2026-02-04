@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Nieuwe factuur</h2>
        <a href="{{ route('invoices.overview') }}" class="text-yellow-400 hover:underline">Terug naar overzicht</a>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded border border-red-500/30 bg-red-500/10 text-red-200 px-4 py-3">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('invoices.store') }}" class="bg-white/5 border border-yellow-400/30 rounded p-6 space-y-6">
        @csrf

        <div>
            <label for="customer_id" class="block mb-2 text-sm text-gray-200">Klant</label>
            <select id="customer_id" name="customer_id" class="w-full form-input bg-gray-900 text-white border border-yellow-400/40" required>
                <option value="">Selecteer klant</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>
                        {{ $customer->company_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="issue_date" class="block mb-2 text-sm text-gray-200">Factuurdatum</label>
                <input type="date" id="issue_date" name="issue_date" class="w-full form-input bg-gray-900 text-white border border-yellow-400/40" value="{{ old('issue_date') }}" required>
            </div>

            <div>
                <label for="omschrijving" class="block mb-2 text-sm text-gray-200">Omschrijving</label>
                <input type="text" id="omschrijving" name="omschrijving" class="w-full form-input bg-gray-900 text-white border border-yellow-400/40" value="{{ old('omschrijving') }}" required placeholder="Bijv. onderhoudsbeurt januari">
            </div>
        </div>

        <div class="space-y-4" id="lines-wrapper">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 line-item">
                <div>
                    <label class="block mb-2 text-sm text-gray-200">Product</label>
                    <select name="lines[0][product_id]" class="w-full form-input bg-gray-900 text-white border border-yellow-400/40 product-select" required>
                        <option value="">Selecteer product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm text-gray-200">Aantal</label>
                    <input type="number" min="1" name="lines[0][quantity]" class="w-full form-input bg-gray-900 text-white border border-yellow-400/40 quantity-input" value="1" required>
                </div>

                <div>
                    <label class="block mb-2 text-sm text-gray-200">Prijs p/st</label>
                    <input type="number" step="0.01" class="w-full form-input bg-gray-900 text-white border border-yellow-400/40 unit-price" readonly>
                </div>

                <div>
                    <label class="block mb-2 text-sm text-gray-200">Regel totaal</label>
                    <input type="number" step="0.01" class="w-full form-input bg-gray-900 text-white border border-yellow-400/40 line-total" readonly>
                </div>

                <div class="flex items-end">
                    <button type="button" class="remove-line w-full px-3 py-2 rounded border border-red-500/50 text-red-300 hover:bg-red-500/10">
                        Verwijder
                    </button>
                </div>
            </div>
        </div>

        <button type="button" id="add-line" class="px-4 py-2 rounded border border-yellow-400/50 text-yellow-300 hover:bg-yellow-400/10">
            + Productregel toevoegen
        </button>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
            <div>
                <label class="block mb-2 text-sm text-gray-200">Subtotaal</label>
                <input type="number" step="0.01" id="subtotal" class="w-full form-input bg-gray-900 text-white border border-yellow-400/40" readonly>
            </div>
            <div>
                <label class="block mb-2 text-sm text-gray-200">BTW (21%)</label>
                <input type="number" step="0.01" id="btw" class="w-full form-input bg-gray-900 text-white border border-yellow-400/40" readonly>
            </div>
            <div>
                <label class="block mb-2 text-sm text-gray-200">Totaal</label>
                <input type="number" step="0.01" id="totaal" class="w-full form-input bg-gray-900 text-white border border-yellow-400/40" readonly>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('invoices.overview') }}" class="px-4 py-2 rounded border border-yellow-400/50 text-yellow-300 hover:bg-yellow-400/10">
                Annuleren
            </a>
            <button type="submit" class="bg-yellow-400 text-black px-5 py-2 rounded font-semibold hover:bg-yellow-300">
                Factuur opslaan
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const wrapper = document.getElementById('lines-wrapper');
    const addLineBtn = document.getElementById('add-line');

    function updateLine(line) {
        const productSelect = line.querySelector('.product-select');
        const quantityInput = line.querySelector('.quantity-input');
        const unitPrice = line.querySelector('.unit-price');
        const lineTotal = line.querySelector('.line-total');

        const price = parseFloat(productSelect.selectedOptions[0]?.dataset.price || 0);
        const qty = parseInt(quantityInput.value || 0, 10);

        unitPrice.value = price ? price.toFixed(2) : '';
        lineTotal.value = price && qty ? (price * qty).toFixed(2) : '';
    }

    function updateTotals() {
        let subtotal = 0;
        document.querySelectorAll('.line-total').forEach(input => {
            subtotal += parseFloat(input.value || 0);
        });

        const btw = +(subtotal * 0.21).toFixed(2);
        const totaal = +(subtotal + btw).toFixed(2);

        document.getElementById('subtotal').value = subtotal ? subtotal.toFixed(2) : '';
        document.getElementById('btw').value = subtotal ? btw : '';
        document.getElementById('totaal').value = subtotal ? totaal : '';
    }

    function bindLineEvents(line) {
        line.querySelector('.product-select').addEventListener('change', () => {
            updateLine(line);
            updateTotals();
        });

        line.querySelector('.quantity-input').addEventListener('input', () => {
            updateLine(line);
            updateTotals();
        });

        line.querySelector('.remove-line').addEventListener('click', () => {
            const allLines = wrapper.querySelectorAll('.line-item');
            if (allLines.length > 1) {
                line.remove();
                updateTotals();
            }
        });
    }

    bindLineEvents(wrapper.querySelector('.line-item'));

    addLineBtn.addEventListener('click', () => {
        const index = wrapper.querySelectorAll('.line-item').length;
        const newLine = wrapper.querySelector('.line-item').cloneNode(true);

        newLine.querySelectorAll('select, input').forEach(el => {
            if (el.name) {
                el.name = el.name.replace(/\[\d+\]/, `[${index}]`);
            }
            if (el.classList.contains('quantity-input')) {
                el.value = 1;
            } else {
                el.value = '';
            }
        });

        wrapper.appendChild(newLine);
        bindLineEvents(newLine);
    });
});
</script>
@endsection