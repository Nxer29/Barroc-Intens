<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 rounded-lg bg-red-500/90 text-white font-semibold hover:bg-red-500 transition']) }}>
    {{ $slot }}
</button>