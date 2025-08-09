<div>
    <flux:heading size="xl" level="1">Users</flux:heading>
    <div class="flex justify-end my-3">
        <flux:modal.trigger x-on:click="$wire.showModalCreate = true">
            <button
                class="outline-2 outline-pink-500 text-pink-500 rounded-lg py-2 px-5 font-medium hover:bg-pink-500 hover:text-zinc-800 transition duration-500 tracking-wider">Create</button>
        </flux:modal.trigger>
    </div>

    @if (session('success'))
        <div class="rounded-lg outline-2 outline-green-500 bg-green-500/30 text-green-500 px-3 py-2 my-4">
            {{ session('success') }}</div>
    @elseif(session('error'))
        <div class="rounded-lg outline-2 outline-red-500 bg-red-500/30 text-red-500 px-3 py-2 my-4">
            {{ session('error') }}
        </div>
    @endif

    <flux:modal wire:model.self="showModalCreate" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Create User</flux:heading>
            </div>
            <form wire:submit.prevent="store" class="space-y-4">
                <flux:input wire:model='name' label="Name" placeholder="Your name" />
                <flux:input type="email" wire:model='email' label="Email" placeholder="Your Email" />
                <flux:select wire:model='role_id' label="Role" placeholder="Choose Role_id...">
                    <flux:select.option value="1">Admin</flux:select.option>
                    <flux:select.option value="2">Student</flux:select.option>
                </flux:select>
                <flux:input type="password" wire:model='password' label="Password" placeholder="Your Password" />
                <flux:input type="password" wire:model='password_confirmation' label="Password Confirmation"
                    placeholder="Your Password Confirmation" />
                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Save changes</flux:button>
            </form>
        </div>
    </flux:modal>
    <flux:modal wire:model.self="showModalEdit" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Edit Users</flux:heading>
            </div>
            <form wire:submit.prevent="update" class="space-y-4">
                <flux:input wire:model='name' label="Name" placeholder="Your name" />
                <flux:input type="email" wire:model='email' label="Email" placeholder="Your Email" />
                <flux:select wire:model='role_id' placeholder="Choose Role...">
                    <flux:select.option value="1">Admin</flux:select.option>
                    <flux:select.option value="2">Student</flux:select.option>
                </flux:select>
                <flux:input type="password" wire:model='password' label="Password" placeholder="Your Password" />
                <flux:input type="password" wire:model='password_confirmation' label="Password Confirmation"
                    placeholder="Your Password Confirmation" />
                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Save changes</flux:button>
            </form>
        </div>
    </flux:modal>

    <div class="rounded-lg bg-zinc-900 p-4">
        <table id="table" wire:ignore.self>
            <thead>
                <tr>
                    <th>
                        <span class="flex items-center">
                            No
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Name
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Email
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Role
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Verified
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Created_at
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Action
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $key => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->roles->name }}</td>
                        <td>{{ $item->email_verified_at }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td class="flex gap-x-2 justify-center">
                            <button
                                class="rounded-lg outline-2 outline-gray-500 p-[5px] hover:bg-gray-500 transition duration-500">
                                <flux:icon.eye
                                    class="stroke-2 stroke-gray-500 hover:stroke-zinc-900 transform duration-500" />
                            </button>
                            <flux:modal.trigger wire:click='edit({{ $item->id }})'>
                                <button
                                    class="rounded-lg outline-2 outline-yellow-500 p-[5px] hover:bg-yellow-500 transition duration-500">
                                    <flux:icon.pencil-square
                                        class="stroke-2 stroke-yellow-500 hover:stroke-zinc-900 transform duration-500" />
                                </button>
                            </flux:modal.trigger>
                            <button wire:click='delete({{ $item->id }})'
                                wire:confirm='Apakah anda yakin ingin menghapus data id: {{ $key }}?'
                                class="rounded-lg  outline-2 outline-red-500 p-[5px] hover:bg-red-500 transition duration-500">
                                <flux:icon.trash
                                    class="stroke-2 stroke-red-500 hover:stroke-zinc-900 transform duration-500" />
                            </button>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</div>
