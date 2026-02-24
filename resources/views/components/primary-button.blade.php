<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-6 py-3 rounded-lg font-semibold transition']) }}>
    {{ $slot }}
</button>