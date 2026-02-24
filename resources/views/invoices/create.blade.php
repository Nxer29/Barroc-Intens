@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- HEADER --}}
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-white">Nieuwe factuur</h1>
        <p class="text-gray-400 mt-2">
            Maak een nieuwe factuur voor een klant
        </p>
    </div>

    @if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-500 bg-red-900/20 px-4 py-3 text-red-300">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('invoices.store') }}" class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-8 shadow-xl space-y-6">
        @csrf

        <div>
            <label for="customer_id" class="block mb-2 text-sm font-semibold text-slate-300">Klant</label>
            <select id="customer_id" name="customer_id" class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent" required>
                <option value="">Selecteer klant</option>
                @foreach ($customers as $customer)
                <option value="{{ $customer->id }}" @selected(old('customer_id')==$customer->id)>
                    {{ $customer->company_name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="issue_date" class="block mb-2 text-sm font-semibold text-slate-300">Factuurdatum</label>
                <input type="date" id="issue_date" name="issue_date" class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent" value="{{ old('issue_date') }}" required>
            </div>

            <div>
                <label for="omschrijving" class="block mb-2 text-sm font-semibold text-slate-300">Omschrijving</label>
                <input type="text" id="omschrijving" name="omschrijving" class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent" value="{{ old('omschrijving') }}" required placeholder="Bijv. onderhoudsbeurt januari">
            </div>
        </div>

        <div class="space-y-4" id="lines-wrapper">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 line-item">
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-300">Product</label>
                    <select name="lines[0][product_id]" class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white product-select focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent" required>
                        <option value="">Selecteer product</option>
                        @foreach ($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-300">Aantal</label>
                    <input type="number" min="1" name="lines[0][quantity]" class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white quantity-input focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent" value="1" required>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-300">Prijs p/st</label>
                    <input type="number" step="0.01" class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white unit-price focus:outline-none" readonly>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-300">Regel totaal</label>
                    <input type="number" step="0.01" class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white line-total focus:outline-none" readonly>
                </div>

                <div class="flex items-end">
                    <button type="button" class="remove-line w-full px-3 py-3 rounded-lg border border-red-500/50 text-red-300 hover:bg-red-500/10 transition">
                        Verwijder
                    </button>
                </div>
            </div>
        </div>

        <button type="button" id="add-line" class="px-6 py-3 rounded-lg border border-slate-600 text-yellow-400 hover:bg-slate-700 transition font-medium">
            + Productregel toevoegen
        </button>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-300">Subtotaal</label>
                <input type="number" step="0.01" id="subtotal" class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none" readonly>
            </div>
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-300">BTW (21%)</label>
                <input type="number" step="0.01" id="btw" class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none" readonly>
            </div>
            <div>
                <label class="block mb-2 text-sm font-semibold text-slate-300">Totaal</label>
                <input type="number" step="0.01" id="totaal" class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none" readonly>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 pt-4">
            <a href="{{ route('invoices.overview') }}" class="px-6 py-3 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">
                Annuleren
            </a>
            <button type="submit" class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-6 py-3 rounded-lg font-semibold transition">
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