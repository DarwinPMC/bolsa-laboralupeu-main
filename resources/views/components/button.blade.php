<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wider hover:from-indigo-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-indigo-700 disabled:opacity-50 transition-all ease-in-out duration-200 shadow-lg']) }}>
    {{ $slot }}
</button>
