@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 px-2 py-4 sm:px-6 sm:py-6">
    <div class="max-w-7xl mx-auto">

        {{-- HEADER WITH NAVIGATION --}}
        <div class="mb-6 sm:mb-8">
            <div class="flex items-center justify-between mb-4 gap-2">
                {{-- Previous Week Button --}}
                <a href="{{ route('calendar.week', ['date' => $previousWeekStart->toDateString()]) }}"
                    class="inline-flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-slate-700 hover:bg-yellow-400 transition text-yellow-400 hover:text-slate-900 font-bold text-xl">
                    ←
                </a>

                {{-- Week Display --}}
                <div class="text-center flex-1 px-2">
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white leading-tight">
                        Week {{ $weekStart->copy()->weekOfYear }}
                    </h1>
                    <p class="text-xs sm:text-sm text-yellow-400 font-semibold mt-1">
                        {{ $weekStart->format('d F') }} - {{ $weekEnd->format('d F Y') }}
                    </p>
                </div>

                {{-- Next Week Button --}}
                <a href="{{ route('calendar.week', ['date' => $nextWeekStart->toDateString()]) }}"
                    class="inline-flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-slate-700 hover:bg-yellow-400 transition text-yellow-400 hover:text-slate-900 font-bold text-xl">
                    →
                </a>
            </div>

            {{-- View Toggle Buttons --}}
            <div class="flex justify-center gap-3">
                <a href="{{ route('calendar.day', ['date' => $weekStart->toDateString()]) }}"
                    class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-yellow-400 font-bold rounded-xl text-xs sm:text-base transition">
                    Dag
                </a>
                <button class="px-6 py-3 bg-yellow-400 text-slate-900 font-bold rounded-xl text-xs sm:text-base transition hover:shadow-lg">
                    Week
                </button>
            </div>
        </div>

        {{-- WEEK GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            @php
            $daysOfWeek = [
            0 => ['name' => 'Maandag', 'abbr' => 'Ma'],
            1 => ['name' => 'Dinsdag', 'abbr' => 'Di'],
            2 => ['name' => 'Woensdag', 'abbr' => 'Wo'],
            3 => ['name' => 'Donderdag', 'abbr' => 'Do'],
            4 => ['name' => 'Vrijdag', 'abbr' => 'Vr'],
            5 => ['name' => 'Zaterdag', 'abbr' => 'Za'],
            6 => ['name' => 'Zondag', 'abbr' => 'Zo'],
            ];
            @endphp

            @for ($i = 0; $i < 7; $i++)
                @php
                $currentDay=$weekStart->copy()->addDays($i);
                $dayAppointments = $appointmentsByDay[$currentDay->toDateString()] ?? collect();
                $isToday = $currentDay->isToday();
                @endphp
                <div class="flex flex-col">
                    {{-- Day Header --}}
                    <div class="@if($isToday) bg-yellow-400 @else bg-slate-700 @endif rounded-t-2xl p-3 sm:p-4 text-center mb-0">
                        <p class="text-xs font-bold @if($isToday) text-slate-900 @else text-gray-300 @endif uppercase tracking-widest">
                            {{ $daysOfWeek[$i]['abbr'] }}
                        </p>
                        <p class="text-lg sm:text-xl font-bold @if($isToday) text-slate-900 @else text-white @endif">
                            {{ $currentDay->format('d') }}
                        </p>
                    </div>

                    {{-- Appointments Container --}}
                    <div class="bg-slate-800/60 border-x-2 border-b-2 border-slate-700 rounded-b-2xl p-2 sm:p-3 flex-1 space-y-2 overflow-y-auto max-h-80 sm:max-h-96">
                        @if($dayAppointments->isEmpty())
                        <div class="h-full flex items-center justify-center">
                            <p class="text-xs text-gray-500 text-center">Geen afspraken</p>
                        </div>
                        @else
                        @foreach($dayAppointments as $appointment)
                        <button onclick="openAppointmentModal({{ $appointment->id }})"
                            class="w-full text-left touch-manipulation focus:outline-none">
                            <div class="bg-gradient-to-br from-slate-700/80 to-slate-800 border border-slate-600 hover:border-yellow-400 rounded-lg p-2 sm:p-3 transition hover:scale-[1.02] active:scale-95 cursor-pointer">

                                {{-- Time --}}
                                <div class="flex items-center gap-1 mb-1">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00-.293.707l-2.828 2.829a1 1 0 101.415 1.415L8 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs sm:text-sm font-bold text-yellow-300">{{ $appointment->scheduled_at->format('H:i') }}</span>
                                </div>

                                {{-- Customer Name (truncated) --}}
                                <p class="text-xs sm:text-sm font-semibold text-white truncate">
                                    {{ Str::limit($appointment->customer->company_name ?? $appointment->customer->contact_name ?? 'Onbekend', 20) }}
                                </p>

                                {{-- Status Badge --}}
                                <div class="mt-1">
                                    @if($appointment->status === 'completed')
                                    <span class="inline-block text-xs px-2 py-1 bg-green-900/60 text-green-200 rounded font-bold">OK</span>
                                    @elseif($appointment->status === 'cancelled')
                                    <span class="inline-block text-xs px-2 py-1 bg-red-900/60 text-red-200 rounded font-bold">X</span>
                                    @endif
                                </div>
                            </div>
                        </button>
                        @endforeach
                        @endif
                    </div>
                </div>
                @endfor
        </div>

        {{-- Stats --}}
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-slate-800/60 border-2 border-slate-700 rounded-2xl p-5 sm:p-6 text-center">
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">Totaal afspraken</p>
                <p class="text-3xl sm:text-4xl font-bold text-yellow-400">{{ $appointments->count() }}</p>
            </div>
            <div class="bg-slate-800/60 border-2 border-slate-700 rounded-2xl p-5 sm:p-6 text-center">
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">Klaar</p>
                <p class="text-3xl sm:text-4xl font-bold text-green-400">{{ $appointments->where('status', 'completed')->count() }}</p>
            </div>
            <div class="bg-slate-800/60 border-2 border-slate-700 rounded-2xl p-5 sm:p-6 text-center">
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">Gepland</p>
                <p class="text-3xl sm:text-4xl font-bold text-blue-400">{{ $appointments->where('status', 'planned')->count() }}</p>
            </div>
        </div>

    </div>
</div>

{{-- APPOINTMENT DETAIL MODAL (same as day view) --}}
<div id="appointmentModal" class="hidden fixed inset-0 bg-black/85 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4">
    <div class="w-full sm:max-w-2xl max-h-[95vh] overflow-y-auto bg-gradient-to-br from-slate-800/98 to-slate-900/98 border-2 border-slate-700 rounded-t-3xl sm:rounded-2xl shadow-2xl">

        {{-- Close Button --}}
        <button onclick="closeAppointmentModal()"
            class="absolute top-4 right-4 z-10 inline-flex items-center justify-center w-10 h-10 bg-slate-700 hover:bg-red-600 rounded-lg text-gray-300 hover:text-white transition font-bold text-lg">
            ✕
        </button>

        <div class="p-5 sm:p-8 pt-12 sm:pt-8">

            {{-- Loading State --}}
            <div id="modalLoading" class="text-center py-12">
                <div class="inline-block animate-spin mb-4">
                    <svg class="w-10 h-10 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
                <p class="text-gray-300">Details laden...</p>
            </div>

            {{-- Content (Hidden by default) --}}
            <div id="modalContent" class="hidden space-y-5 sm:space-y-6">

                {{-- Time & Status --}}
                <div class="flex items-center justify-between pb-4 sm:pb-5 border-b-2 border-slate-700">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Werkbezoek</p>
                        <p id="modalDateTime" class="text-xl sm:text-2xl font-bold text-white mt-1"></p>
                    </div>
                    <span id="modalStatus" class="px-4 py-2 rounded-lg text-xs font-bold"></span>
                </div>

                {{-- Type --}}
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-2 font-bold">Type werk</p>
                    <p id="modalType" class="text-lg sm:text-xl font-bold text-yellow-300"></p>
                </div>

                {{-- Customer Info --}}
                <div class="bg-slate-700/40 rounded-2xl p-5 sm:p-6 border border-slate-600">
                    <h3 class="text-xs text-gray-300 uppercase tracking-wide mb-3 font-bold">Klant</h3>
                    <p id="modalCustomerName" class="text-xl sm:text-2xl font-bold text-white mb-3"></p>
                    <div class="space-y-2 text-sm text-gray-200">
                        <p id="modalContactName" class="text-xs sm:text-sm leading-relaxed"></p>
                        <p id="modalContactEmail" class="text-xs sm:text-sm text-blue-300 break-all"></p>
                        <p id="modalContactPhone" class="text-xs sm:text-sm text-yellow-300"></p>
                    </div>
                </div>

                {{-- Address --}}
                <div id="addressSection" class="bg-slate-700/40 rounded-2xl p-5 sm:p-6 border border-slate-600">
                    <h3 class="text-xs text-gray-300 uppercase tracking-wide mb-3 font-bold">Adres</h3>
                    <div class="space-y-2 text-sm text-gray-200">
                        <p id="modalStreet" class="text-sm sm:text-base font-semibold"></p>
                        <p id="modalPostalCity" class="text-sm sm:text-base"></p>
                        <p id="modalCountry" class="text-xs text-gray-400"></p>
                    </div>
                </div>

                {{-- Problem/Issue --}}
                <div id="issueSection" class="bg-slate-700/40 rounded-2xl p-5 sm:p-6 border border-slate-600">
                    <h3 class="text-xs text-gray-300 uppercase tracking-wide mb-3 font-bold">Probleem</h3>
                    <p id="modalIssue" class="text-sm sm:text-base text-gray-200 leading-relaxed"></p>
                </div>

                {{-- Contract Info --}}
                <div id="contractSection" class="bg-slate-700/40 rounded-2xl p-5 sm:p-6 border border-slate-600">
                    <h3 class="text-xs text-gray-300 uppercase tracking-wide mb-3 font-bold">Contract</h3>
                    <p id="modalContractName" class="text-lg sm:text-xl font-bold text-white mb-3"></p>
                    <div class="space-y-2 text-xs sm:text-sm text-gray-200 mb-4">
                        <p><span class="text-gray-300 font-semibold">Status:</span> <span id="modalContractStatus" class="text-yellow-300 font-bold"></span></p>
                        <p><span class="text-gray-300 font-semibold">Van:</span> <span id="modalContractStart"></span></p>
                        <p><span class="text-gray-300 font-semibold">Tot:</span> <span id="modalContractEnd"></span></p>
                    </div>
                    <div id="productsDiv" class="">
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-2 font-bold">Producten onder contract</p>
                        <div id="productsList" class="space-y-2"></div>
                    </div>
                </div>

                {{-- Notes --}}
                <div id="notesSection" class="bg-slate-700/40 rounded-2xl p-5 sm:p-6 border border-slate-600">
                    <h3 class="text-xs text-gray-300 uppercase tracking-wide mb-3 font-bold">Opmerkingen</h3>
                    <p id="modalNotes" class="text-sm sm:text-base text-gray-200 leading-relaxed"></p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col gap-3 pt-4 sm:flex-row">
                    <button onclick="closeAppointmentModal()"
                        class="flex-1 bg-slate-700 hover:bg-slate-600 text-white font-bold py-4 px-4 rounded-xl transition text-base sm:text-lg">
                        Sluiten
                    </button>
                    <a id="editLink" href="#"
                        class="flex-1 bg-yellow-400 hover:bg-yellow-300 text-slate-900 font-bold py-4 px-4 rounded-xl transition text-base sm:text-lg text-center">
                        Bewerk
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
        fetch(`/calendar/appointment/${appointmentId}`)
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
                loading.innerHTML = '<p class="text-red-400 text-lg">Fout bij laden van details</p>';
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
            statusEl.className = 'px-4 py-2 rounded-lg text-xs font-bold bg-green-900/60 text-green-200';
            statusEl.textContent = 'Voltooid';
        } else if (data.status === 'planned') {
            statusEl.className = 'px-4 py-2 rounded-lg text-xs font-bold bg-blue-900/60 text-blue-200';
            statusEl.textContent = 'Gepland';
        } else if (data.status === 'cancelled') {
            statusEl.className = 'px-4 py-2 rounded-lg text-xs font-bold bg-red-900/60 text-red-200';
            statusEl.textContent = 'Geannuleerd';
        } else {
            statusEl.className = 'px-4 py-2 rounded-lg text-xs font-bold bg-gray-700 text-gray-200';
            statusEl.textContent = ucfirst(data.status);
        }

        // Type
        document.getElementById('modalType').textContent = data.type;

        // Customer
        document.getElementById('modalCustomerName').textContent = data.customer.name;
        document.getElementById('modalContactName').textContent = data.customer.contact_name || 'Geen contactpersoon';
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

        // Issue/Problem
        if (data.maintenance_request && data.maintenance_request.issue_description) {
            document.getElementById('modalIssue').textContent = data.maintenance_request.issue_description;
        } else if (data.notes) {
            document.getElementById('modalIssue').textContent = data.notes;
        } else {
            document.getElementById('issueSection').style.display = 'none';
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
                    productEl.className = 'text-xs sm:text-sm text-gray-200 bg-slate-800/50 rounded-lg px-3 py-2 border border-slate-600';
                    productEl.textContent = product.name;
                    productsList.appendChild(productEl);
                });
            } else {
                productsList.innerHTML = '<p class="text-xs text-gray-400">Geen producten</p>';
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
        if (!dateString) return '';
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

    // Disable scroll on body when modal is open
    const modal = document.getElementById('appointmentModal');
    const originalOpen = window.openAppointmentModal;
    window.openAppointmentModal = function(id) {
        originalOpen(id);
        document.body.style.overflow = 'hidden';
    };

    const originalClose = window.closeAppointmentModal;
    window.closeAppointmentModal = function() {
        originalClose();
        document.body.style.overflow = '';
    };
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
            max-height: 95vh;
        }
    }

    /* Touch-friendly adjustments */
    button {
        min-height: 48px;
    }

    @media (max-width: 640px) {
        button {
            min-height: 44px;
        }
    }
</style>
@endsection