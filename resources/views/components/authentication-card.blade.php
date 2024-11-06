<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div>
        <!-- Mostramos el logo pasado como slot -->
        {{ $logo ?? '' }}
    </div>

    <div class="w-full sm:max-w-5xl mt-6 px-20 py-20 bg-white shadow-2xl sm:rounded-4xl"> <!-- Aumentamos sm:max-w-2xl y padding -->
        {{ $slot }}
    </div>
</div>
