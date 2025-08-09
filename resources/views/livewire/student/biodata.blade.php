<div>
    <flux:heading size="xl" level="1" class="mb-5">Biodata</flux:heading>

    @if (session('error'))
        <div class="rounded-lg outline-2 outline-red-500 bg-red-500/30 text-red-500 px-3 py-2 my-4">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="rounded-lg outline-2 outline-green-500 bg-green-500/30 text-green-500 px-3 py-2 my-4">
            {{ session('success') }}
        </div>
    @endif


    <form wire:submit.prevent='store' enctype="multipart/form-data">
        <div class="flex flex-col gap-5">
            <section class="flex flex-wrap">
                <div class="w-full md:w-1/5 relative">
                    <div class="relative w-[200px] h-[300px] ">
                        <img src="{{ $image instanceof \Illuminate\Http\UploadedFile ? $image->temporaryUrl() : (asset('storage/' . $image) ?: 'https://picsum.photos/300/400') }}"
                            alt="Preview"
                            class="rounded-lg w-full h-full object-cover @error('image') outline-2 outline-red-500 @enderror"
                            id="previewImage">
                        <input wire:model='image' type="file" accept="image/*"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" id="fileInput">
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <flux:icon.camera variant="solid"
                                class="text-white bg-black bg-opacity-50 rounded-full p-5 w-20 h-20" />
                        </div>
                    </div>
                    @error('image')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="w-full md:w-4/5">
                    <flux:input wire:model='name' type="text" size="lg" label="Name" class="py-3"
                        disabled />
                    <flux:input wire:model='email' type="email" size="lg" label="Email" class="py-3"
                        disabled />
                    <flux:input type="number" wire:model="phone" size="lg" label="No Telephone/Wathsapp"
                        class="py-3" />
                </div>
            </section>

            <div id="image-preview"
                class="w-full sm p-6 mb-4 bg-zinc-700 border-dashed border-2 border-zinc-700 rounded-lg items-center mx-auto text-center cursor-pointer">
                <input wire:model='certificate' id="upload" type="file" class="hidden" accept=".pdf" />
                <label for="upload" class="cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 h-8 text-gray-400 mx-auto mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-400">Upload picture</h5>
                    <p class="font-normal text-sm text-gray-400 md:px-6">Choose photo size should be less than
                        <b class="text-gray-600">2mb</b>
                    </p>
                    <p class="font-normal text-sm text-gray-400 md:px-6">and should be in <b class="text-gray-400">JPG,
                            PNG,
                            or GIF</b> format.</p>
                    <span id="filename" class="text-gray-500  z-50">{{ $certificate ?: 'No file chosen' }}</span>
                </label>
            </div>
            <div class="flex items-center justify-center">
                <div class="w-full">
                    <button type="submit"
                        class="w-full hover:bg-pink-500 hover:text-zinc-800 outline-2 outline-pink-500 text-pink-500 transition duration-500 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center justify-center mr-2 mb-2 cursor-pointer">
                        <span class="text-center ml-2">Upload</span>
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>
