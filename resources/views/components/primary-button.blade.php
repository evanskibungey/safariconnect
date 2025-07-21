<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gradient-to-r from-brown-custom to-amber-700 hover:from-amber-700 hover:to-brown-custom border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-orange-custom focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg hover:shadow-xl']) }}>
    {{ $slot }}
</button>
