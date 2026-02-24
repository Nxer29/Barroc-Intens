<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-10">

        {{-- HEADER --}}
        <div class="mb-12">
            <h1 class="text-4xl font-bold text-white">Profiel</h1>
            <p class="text-gray-400 mt-2">
                Beheer je accountinstellingen en voorkeuren
            </p>
        </div>

        <div class="space-y-6">
            <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 shadow-xl p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 shadow-xl p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 shadow-xl p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>