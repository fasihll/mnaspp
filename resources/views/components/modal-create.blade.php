<div x-show="showModalCreate" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 bg-opacity-60" style="display: none;">
    <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <flux:icon name="x-mark" variant="solid"
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 cursor-pointer" x-show="showModalCreate"
            @click="showModalCreate = false" />
        {{ $slot }}
    </div>
</div>