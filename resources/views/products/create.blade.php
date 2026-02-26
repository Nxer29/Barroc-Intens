@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-4xl font-bold text-white mb-2">Nieuw Product</h1>
            <p class="text-gray-400">Voeg een nieuw product toe aan je catalogus</p>
        </div>
        <a href="{{ route('products.index') }}"
            class="px-6 py-2.5 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Terug naar lijst
        </a>
    </div>

    @if ($errors->any())
    <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-500 shadow-lg">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <strong class="block text-red-300 font-semibold mb-2">Er zijn fouten opgetreden:</strong>
                <ul class="list-disc list-inside text-sm space-y-1 text-red-200">
                    @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Linker kolom: Basis informatie --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Basis gegevens --}}
                <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 shadow-xl p-8">
                    <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Basis Informatie
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-2">
                                SKU
                            </label>
                            <input
                                type="text"
                                name="sku"
                                value="{{ old('sku') }}"
                                class="w-full px-4 py-3 bg-slate-700/50 border {{ $errors->has('sku') ? 'border-red-500' : 'border-slate-600' }} rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400/50 focus:border-yellow-400 transition"
                                placeholder="Bijv. PROD-001">
                            @error('sku')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-2">
                                Naam <span class="text-red-400">*</span>
                            </label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                class="w-full px-4 py-3 bg-slate-700/50 border {{ $errors->has('name') ? 'border-red-500' : 'border-slate-600' }} rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400/50 focus:border-yellow-400 transition"
                                placeholder="Productnaam">
                            @error('name')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-300 mb-2">
                                Brand
                            </label>
                            <input
                                type="text"
                                name="brand"
                                value="{{ old('brand') }}"
                                class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400/50 focus:border-yellow-400 transition"
                                placeholder="Merknaam">
                            @error('brand')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-300 mb-2">
                                Beschrijving
                            </label>
                            <textarea
                                name="description"
                                rows="4"
                                class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400/50 focus:border-yellow-400 transition resize-none"
                                placeholder="Voeg een beschrijving toe...">{{ old('description') }}</textarea>
                            @error('description')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Prijzen en voorraad --}}
                <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 shadow-xl p-8">
                    <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Prijzen & Voorraad
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-2">
                                Unit Prijs (€) <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">€</span>
                                <input
                                    type="number"
                                    name="unit_price"
                                    step="0.01"
                                    value="{{ old('unit_price') }}"
                                    required
                                    class="w-full pl-8 pr-4 py-3 bg-slate-700/50 border {{ $errors->has('unit_price') ? 'border-red-500' : 'border-slate-600' }} rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400/50 focus:border-yellow-400 transition"
                                    placeholder="0.00">
                            </div>
                            @error('unit_price')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-2">
                                Verkoopprijs (€) <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">€</span>
                                <input
                                    type="number"
                                    name="price"
                                    step="0.01"
                                    value="{{ old('price') }}"
                                    required
                                    class="w-full pl-8 pr-4 py-3 bg-slate-700/50 border {{ $errors->has('price') ? 'border-red-500' : 'border-slate-600' }} rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400/50 focus:border-yellow-400 transition"
                                    placeholder="0.00">
                            </div>
                            @error('price')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-2">
                                Voorraad <span class="text-red-400">*</span>
                            </label>
                            <input
                                type="number"
                                name="stock"
                                step="1"
                                min="0"
                                value="{{ old('stock') }}"
                                required
                                class="w-full px-4 py-3 bg-slate-700/50 border {{ $errors->has('stock') ? 'border-red-500' : 'border-slate-600' }} rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400/50 focus:border-yellow-400 transition"
                                placeholder="0">
                            @error('stock')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>

            {{-- Rechter kolom: Extra instellingen --}}
            <div class="space-y-6">

                {{-- Categorie --}}
                <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 shadow-xl p-6">
                    <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Categorie
                    </h2>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300 mb-2">
                            Selecteer Categorie <span class="text-red-400">*</span>
                        </label>
                        <select
                            name="category_id"
                            required
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-yellow-400/50 focus:border-yellow-400 transition">
                            <option value="" class="text-slate-400">-- Kies een categorie --</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id')==$category->id)>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="text-sm text-red-400 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Zichtbaarheid --}}
                <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 shadow-xl p-6">
                    <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Zichtbaarheid
                    </h2>

                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input
                            type="checkbox"
                            name="is_visible_to_customers"
                            value="1"
                            @checked(old('is_visible_to_customers', true))
                            class="w-5 h-5 rounded border-slate-600 text-yellow-400 focus:ring-2 focus:ring-yellow-400/50 bg-slate-700/50">
                        <span class="text-sm text-slate-300 group-hover:text-white transition">
                            Zichtbaar voor klanten
                        </span>
                    </label>
                </div>

                {{-- Foto's --}}
                <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 shadow-xl p-6">
                    <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Foto's <span class="text-red-400">*</span>
                    </h2>

                    <div class="relative">
                        <input
                            id="photos"
                            name="photos[]"
                            type="file"
                            accept="image/*"
                            multiple
                            required
                            class="hidden"
                            onchange="updateFileList(this)">
                        <label
                            for="photos"
                            class="block cursor-pointer p-6 border-2 border-dashed border-slate-600 rounded-lg hover:border-yellow-400 transition text-center group">
                            <svg class="w-12 h-12 mx-auto mb-3 text-slate-500 group-hover:text-yellow-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="text-sm text-slate-400 group-hover:text-slate-300 transition">
                                <span class="font-semibold">Klik om bestanden te uploaden</span><br>
                                of sleep ze hierheen
                            </p>
                            <p class="text-xs text-slate-500 mt-2">PNG, JPG tot 10MB</p>
                        </label>
                        <div id="file-list" class="mt-3 text-sm text-slate-400"></div>
                    </div>

                    @error('photos')
                    <p class="text-sm text-red-400 mt-2">{{ $message }}</p>
                    @enderror
                    @error('photos.*')
                    <p class="text-sm text-red-400 mt-2">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Actie knoppen --}}
        <div class="mt-8 flex justify-end gap-4">
            <a href="{{ route('products.index') }}"
                class="px-6 py-3 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">
                Annuleren
            </a>
            <button
                type="submit"
                class="px-8 py-3 rounded-lg bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-semibold transition shadow-lg hover:shadow-yellow-400/50 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Product Aanmaken
            </button>
        </div>
    </form>

</div>

<script>
    function updateFileList(input) {
        const fileList = document.getElementById('file-list');
        if (input.files.length > 0) {
            const fileNames = Array.from(input.files).map(f => f.name).join(', ');
            fileList.innerHTML = `<span class="text-green-400">✓</span> ${input.files.length} bestand(en) geselecteerd`;
        } else {
            fileList.innerHTML = '';
        }
    }
</script>
@endsection