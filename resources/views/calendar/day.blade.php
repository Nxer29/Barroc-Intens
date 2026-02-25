@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0b1220] px-4 py-6 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">

        {{-- HEADER WITH NAVIGATION --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                {{-- Previous Day Button --}}
                <a href="{{ route('calendar.day', ['date' => $previousDate->toDateString()]) }}"
                    class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-lg bg-slate-800 hover:bg-slate-700 transition text-yellow-400 hover:text-yellow-300">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>

                {{-- Date Display --}}
                <div class="text-center flex-1">
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white">
                        {{ $date->translatedFormat('dddd') }}
                    </h1>
                    <p class="text-base sm:text-lg text-gray-400 mt-1">
                        {{ $date->translatedFormat('d MMMM Y') }}
                    </p>
                </div>

                {{-- Next Day Button --}}
                <a href="{{ route('calendar.day', ['date' => $nextDate->toDateString()]) }}"
                    class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-lg bg-slate-800 hover:bg-slate-700 transition text-yellow-400 hover:text-yellow-300">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            {{-- View Toggle Buttons --}}
            <div class="flex justify-center gap-2">
                <button class="px-4 py-2 bg-yellow-400 text-gray-900 font-semibold rounded-lg text-xs sm:text-sm">
                    📅 Dag
                </button>
                <a href="{{ route('calendar.week', ['date' => $date->toDateString()]) }}"
                    class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-gray-300 font-semibold rounded-lg text-xs sm:text-sm transition">
                    📊 Week
                </a>
            </div>
        </div>

        {{-- APPOINTMENTS CONTAINER --}}
        <div class="space-y-4">
            @if($appointments->isEmpty())
            {{-- Empty State --}}
            <div class="bg-gradient-to-br from-slate-800/50 to-slate-900/50 border border-slate-700 rounded-2xl p-12 text-center">
                <div class="text-5xl mb-4">📭</div>
                <h2 class="text-xl sm:text-2xl font-bold text-white mb-2">Geen afspraken vandaag</h2>
                <p class="text-sm sm:text-base text-gray-400">
                    Je hebt geen geplande afspraken voor deze dag
                </p>
            </div>
            @else
            {{-- Appointments List --}}
            @foreach($appointments as $appointment)
            <button onclick="openAppointmentModal({{ $appointment->id }})"
                class="w-full text-left">
                <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 hover:border-yellow-400/50 rounded-xl p-4 sm:p-6 transition transform hover:scale-[1.02] hover:shadow-lg cursor-pointer">

                    {{-- Time --}}
                    <div class="flex items-start justify-between mb-3">
                        <div class="inline-flex items-center gap-2 bg-yellow-400/20 text-yellow-300 px-3 py-1 rounded-lg text-xs sm:text-sm font-semibold">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00-.293.707l-2.828 2.829a1 1 0 101.415 1.415L8 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            {{ $appointment->scheduled_at->format('H:i') }}
                        </div>

                        {{-- Status Badge --}}
                        <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-lg
                                    @if($appointment->status === 'completed')
                                        bg-green-900/50 text-green-300
                                    @elseif($appointment->status === 'planned')
                                        bg-blue-900/50 text-blue-300
                                    @elseif($appointment->status === 'cancelled')
                                        bg-red-900/50 text-red-300
                                    @else
                                        bg-gray-700 text-gray-300
                                    @endif
                                ">
                            @if($appointment->status === 'completed')
                            ✔ Voltooid
                            @elseif($appointment->status === 'planned')
                            📅 Gepland
                            @elseif($appointment->status === 'cancelled')
                            ✕ Geannuleerd
                            @else
                            {{ ucfirst($appointment->status) }}
                            @endif
                        </span>
                    </div>

                    {{-- Type --}}
                    <p class="text-xs sm:text-sm text-yellow-300 font-semibold mb-2">
                        {{ $appointment->type->name ?? 'Onbekend type' }}
                    </p>

                    {{-- Customer Name --}}
                    <h3 class="text-base sm:text-lg font-bold text-white mb-2">
                        {{ $appointment->customer->company_name ?? $appointment->customer->contact_name ?? 'Onbekende klant' }}
                    </h3>

                    {{-- Notes Preview --}}
                    @if($appointment->notes)
                    <p class="text-xs sm:text-sm text-gray-400 line-clamp-2 mb-3">
                        {{ $appointment->notes }}
                    </p>
                    @endif

                    {{-- Click to view details hint --}}
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">Tap voor details →</span>
                    </div>
                </div>
            </button>
            @endforeach
            @endif
        </div>

    </div>
</div>

{{-- APPOINTMENT DETAIL MODAL --}}
<div id="appointmentModal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4">
    <div class="w-full max-w-2xl max-h-[90vh] overflow-y-auto bg-gradient-to-br from-slate-800/95 to-slate-900/95 border border-slate-700 rounded-t-3xl sm:rounded-2xl shadow-2xl">

        {{-- Close Button --}}
        <button onclick="closeAppointmentModal()"
            class="absolute top-4 right-4 z-10 inline-flex items-center justify-center w-8 h-8 bg-slate-700 hover:bg-slate-600 rounded-lg text-gray-300 hover:text-white transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="p-6 sm:p-8">

            {{-- Loading State --}}
            <div id="modalLoading" class="text-center py-8">
                <div class="inline-block animate-spin">
                    <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
            </div>

            {{-- Content (Hidden by default) --}}
            <div id="modalContent" class="hidden space-y-6">

                {{-- Time & Status --}}
                <div class="flex items-center justify-between pb-4 border-b border-slate-700">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-400">Afspraak</p>
                        <p id="modalDateTime" class="text-lg sm:text-xl font-bold text-white mt-1"></p>
                    </div>
                    <span id="modalStatus" class="px-3 py-1 rounded-lg text-xs font-semibold"></span>
                </div>

                {{-- Type --}}
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Type werk</p>
                    <p id="modalType" class="text-base sm:text-lg font-semibold text-yellow-300"></p>
                </div>

                {{-- Customer Info --}}
                <div class="bg-slate-700/50 rounded-xl p-4 sm:p-6">
                    <h3 class="text-xs text-gray-400 uppercase tracking-wide mb-3">Klant</h3>
                    <p id="modalCustomerName" class="text-lg sm:text-xl font-bold text-white mb-2"></p>
                    <div class="space-y-2 text-sm text-gray-300">
                        <p id="modalContactName" class="text-xs sm:text-sm"></p>
                        <p id="modalContactEmail" class="text-xs sm:text-sm"></p>
                        <p id="modalContactPhone" class="text-xs sm:text-sm"></p>
                    </div>
                </div>

                {{-- Address --}}
                <div id="addressSection" class="bg-slate-700/50 rounded-xl p-4 sm:p-6">
                    <h3 class="text-xs text-gray-400 uppercase tracking-wide mb-3">Adres</h3>
                    <div class="space-y-1 text-sm text-gray-300">
                        <p id="modalStreet" class="text-sm"></p>
                        <p id="modalPostalCity" class="text-sm"></p>
                        <p id="modalCountry" class="text-sm text-gray-400"></p>
                    </div>
                </div>

                {{-- Contract Info --}}
                <div id="contractSection" class="bg-slate-700/50 rounded-xl p-4 sm:p-6">
                    <h3 class="text-xs text-gray-400 uppercase tracking-wide mb-3">Contract</h3>
                    <p id="modalContractName" class="text-base font-semibold text-white mb-2"></p>
                    <div class="space-y-1 text-xs sm:text-sm text-gray-400">
                        <p><span class="text-gray-300">Status:</span> <span id="modalContractStatus"></span></p>
                        <p><span class="text-gray-300">Van:</span> <span id="modalContractStart"></span></p>
                        <p><span class="text-gray-300">Tot:</span> <span id="modalContractEnd"></span></p>
                    </div>
                    <div id="productsDiv" class="mt-4">
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">Producten</p>
                        <div id="productsList" class="space-y-2"></div>
                    </div>
                </div>

                {{-- Notes --}}
                <div id="notesSection" class="bg-slate-700/50 rounded-xl p-4 sm:p-6">
                    <h3 class="text-xs text-gray-400 uppercase tracking-wide mb-3">Opmerkingen</h3>
                    <p id="modalNotes" class="text-sm text-gray-300"></p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-3 pt-4">
                    <button onclick="closeAppointmentModal()"
                        class="flex-1 bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 px-4 rounded-lg transition text-sm">
                        Sluiten
                    </button>
                    <a id="editLink" href="#"
                        class="flex-1 bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-semibold py-3 px-4 rounded-lg transition text-sm text-center">
                        ✏️ Bewerken
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script>
    let currentAppointmentId = null;

    function openAppointmentModal(appointmentId) {
        currentAppointmentId = appointmentId;
        const modal = document.getElementById('appointmentModal');
        const loading = document.getElementById('modalLoading');
        const content = document.getElementById('modalContent');

        // Show modal with loading state
        modal.classList.remove('hidden');
        loading.classList.remove('hidden');
        content.classList.add('hidden');

        // Fetch appointment details
        fetch(`{{ route('calendar.appointment-details', '') }}/${appointmentId}`)
            .then(response => {
                if (!response.ok) throw new Error('Failed to load appointment');
                return response.json();
            })
            .then(data => {
                populateModal(data);
                loading.classList.add('hidden');
                content.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                loading.innerHTML = '<p class="text-red-400">Fout bij laden van details</p>';
            });
    }

    function closeAppointmentModal() {
        document.getElementById('appointmentModal').classList.add('hidden');
    }

    function populateModal(data) {
        // DateTime
        const appointmentDate = new Date(data.scheduled_at);
        const dateStr = appointmentDate.toLocaleDateString('nl-NL', {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
        const timeStr = appointmentDate.toLocaleTimeString('nl-NL', {
            hour: '2-digit',
            minute: '2-digit'
        });
        document.getElementById('modalDateTime').textContent = `${dateStr} om ${timeStr}`;

        // Status
        const statusEl = document.getElementById('modalStatus');
        if (data.status === 'completed') {
            statusEl.className = 'px-3 py-1 rounded-lg text-xs font-semibold bg-green-900/50 text-green-300';
            statusEl.textContent = '✔ Voltooid';
        } else if (data.status === 'planned') {
            statusEl.className = 'px-3 py-1 rounded-lg text-xs font-semibold bg-blue-900/50 text-blue-300';
            statusEl.textContent = '📅 Gepland';
        } else {
            statusEl.className = 'px-3 py-1 rounded-lg text-xs font-semibold bg-gray-700 text-gray-300';
            statusEl.textContent = ucfirst(data.status);
        }

        // Type
        document.getElementById('modalType').textContent = data.type;

        // Customer
        document.getElementById('modalCustomerName').textContent = data.customer.name;
        document.getElementById('modalContactName').textContent = data.customer.contact_name || '';
        document.getElementById('modalContactEmail').textContent = data.customer.contact_email || '';
        document.getElementById('modalContactPhone').textContent = data.customer.contact_phone || '';

        // Address
        if (data.address) {
            document.getElementById('modalStreet').textContent = data.address.street || 'Geen straat';
            document.getElementById('modalPostalCity').textContent =
                (data.address.postal_code ? data.address.postal_code + ' ' : '') + (data.address.city || '');
            document.getElementById('modalCountry').textContent = data.address.country || '';
        } else {
            document.getElementById('addressSection').style.display = 'none';
        }

        // Contract
        if (data.contract) {
            document.getElementById('modalContractName').textContent = data.contract.name;
            document.getElementById('modalContractStatus').textContent = data.contract.status;
            document.getElementById('modalContractStart').textContent = formatDate(data.contract.start_date);
            document.getElementById('modalContractEnd').textContent = formatDate(data.contract.end_date);

            // Products
            const productsList = document.getElementById('productsList');
            productsList.innerHTML = '';
            if (data.contract.products && data.contract.products.length > 0) {
                data.contract.products.forEach(product => {
                    const productEl = document.createElement('div');
                    productEl.className = 'text-xs sm:text-sm text-gray-300 bg-slate-800 rounded px-2 py-1';
                    productEl.textContent = product.name;
                    productsList.appendChild(productEl);
                });
            } else {
                productsList.textContent = 'Geen producten';
            }
        } else {
            document.getElementById('contractSection').style.display = 'none';
        }

        // Notes
        if (data.notes) {
            document.getElementById('modalNotes').textContent = data.notes;
        } else {
            document.getElementById('notesSection').style.display = 'none';
        }

        // Edit link
        document.getElementById('editLink').href = `/appointments/${data.id}/edit`;
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('nl-NL', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
    }

    function ucfirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    // Close modal when clicking outside
    document.getElementById('appointmentModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeAppointmentModal();
        }
    });
</script>

<style>
    @media (max-width: 768px) {
        #appointmentModal {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            top: auto;
        }

        #appointmentModal>div {
            border-radius: 1.5rem 1.5rem 0 0;
        }
    }
</style>
@endsection