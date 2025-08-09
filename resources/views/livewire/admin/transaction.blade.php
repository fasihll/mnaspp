<div>
    <flux:heading size="xl" level="1">Transaction</flux:heading>
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
                <flux:heading size="lg">Create Transaction</flux:heading>
            </div>
            <form wire:submit.prevent="store" class="space-y-4">
                <flux:select wire:model='student_id'>
                    <flux:select.option value="" wire:key="">
                        Choose Student
                    </flux:select.option>
                    @foreach ($student as $item)
                        <flux:select.option value="{{ $item->id }}" wire:key="{{ $item->id }}">
                            {{ $item->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:select wire:model='departement_id'>
                    <flux:select.option value="" wire:key="" class="disabled">
                        Choose Departement
                    </flux:select.option>
                    @foreach ($departement as $item)
                        <flux:select.option value="{{ $item->id }}" wire:key="{{ $item->id }}">SMT -
                            {{ $item->semester }} |
                            {{ $item->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Save changes</flux:button>
            </form>
        </div>
    </flux:modal>
    <flux:modal wire:model.self="showModalEdit" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Edit Departemen</flux:heading>
            </div>
            <form wire:submit.prevent="update" class="space-y-4">
                <flux:select wire:model='student_id'>
                    <flux:select.option value="" wire:key="">
                        Choose Student
                    </flux:select.option>
                    @foreach ($student as $item)
                        <flux:select.option value="{{ $item->id }}" wire:key="{{ $item->id }}">
                            {{ $item->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:select wire:model='departement_id'>
                    <flux:select.option value="" wire:key="" class="disabled">
                        Choose Departement
                    </flux:select.option>
                    @foreach ($departement as $item)
                        <flux:select.option value="{{ $item->id }}" wire:key="{{ $item->id }}">
                            SMT -
                            {{ $item->semester }} |
                            {{ $item->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Save changes</flux:button>
            </form>
        </div>
    </flux:modal>

    <flux:modal wire:model.self="showModalCheckPayment" class="md:w-full">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Edit Departemen</flux:heading>
            </div>
            <form wire:submit.prevent="confirmPayment" class="space-y-4">
                <flux:input type="text" wire:model='student.name' label="Student Name" placeholder="Student Name"
                    disabled />
                <flux:input type="text" wire:model='departement.name' label="Departement Name"
                    placeholder="Departement Name" disabled />
                <flux:select wire:model='transaction_type' label="Transaction Type"
                    placeholder="Choose transaction type...">
                    <flux:select.option value="cash">Cash</flux:select.option>
                    <flux:select.option value="transfer">Transfer</flux:select.option>
                </flux:select>
                <flux:select wire:model='status' label="Status" placeholder="Choose status...">
                    <flux:select.option value="0">Unpaid</flux:select.option>
                    <flux:select.option value="1">Paid</flux:select.option>
                </flux:select>
                <div class="flex items-center border border-zinc-300 rounded-lg p-2">
                    <a href="{{ asset('storage/' . $bukti) }}" target="_blank">
                        <img src="{{ asset('storage/' . $bukti) }}" alt="bukti"
                            class="h-48 w-48 object-cover rounded-lg cursor-pointer">
                    </a>
                </div>
                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Confirm</flux:button>
            </form>
        </div>
    </flux:modal>

    <div class="rounded-lg bg-zinc-900 p-4">
        <table id="table" wire:ignore.self>
            <thead>
                <tr>
                    <th rowspan="2">
                        <span class="flex items-center">
                            No
                        </span>
                    </th>
                    <th rowspan="2">
                        <span class="flex items-center">
                            Name
                        </span>
                    </th>
                    <th colspan="2" class="">
                        <span class="flex items-center">
                            Departement/Semester
                        </span>
                    </th>
                    <th rowspan="2">
                        <span class="flex items-center">
                            Cost
                        </span>
                    </th>
                    <th rowspan="2">
                        <span class="flex items-center">
                            Status
                        </span>
                    </th>
                    <th rowspan="2">
                        <span class="flex items-center">
                            Action
                        </span>
                    </th>
                </tr>
                <tr>
                    <th>Departement</th>
                    <th>Semester</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction as $key => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $item->student->name }}</td>
                        <td>{{ $item->departement->name }}</td>
                        <td>{{ $item->departement->semester }}</td>
                        <td>{{ 'Rp.' . number_format($item->departement->cost, 0, ',', '.') }}</td>
                        <td>
                            @if ($item->status)
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full  bg-green-100 text-green-800 ">
                                    Paid
                                </span>
                            @elseif($item->transaction_type != null)
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full  bg-yellow-100 text-yellow-800 ">
                                    Pending
                                </span>
                            @else
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full  bg-red-100 text-red-800 ">
                                    Unpaid
                                </span>
                            @endif
                        </td>
                        <td class="flex gap-x-2 justify-center">
                            <flux:modal.trigger wire:click='paymentCheck({{ $item->id }})'>
                                <button
                                    class="rounded-lg outline-2 outline-gray-500 p-[5px] hover:bg-gray-500 transition duration-500">
                                    <flux:icon.eye
                                        class="stroke-2 stroke-gray-500 hover:stroke-zinc-900 transform duration-500" />
                                </button>
                            </flux:modal.trigger>

                            <flux:modal.trigger wire:click='edit({{ $item->id }})'>
                                <button
                                    class="rounded-lg outline-2 outline-yellow-500 p-[5px] hover:bg-yellow-500 transition duration-500">
                                    <flux:icon.pencil-square
                                        class="stroke-2 stroke-yellow-500 hover:stroke-zinc-900 transform duration-500" />
                                </button>
                            </flux:modal.trigger>
                            @if ($item->deleted_at == null)
                                <button wire:click='delete({{ $item->id }})'
                                    wire:confirm='Apakah anda yakin ingin menghapus data id: {{ $item->id }}?'
                                    class="rounded-lg  outline-2 outline-red-500 p-[5px] hover:bg-red-500 transition duration-500">
                                    <flux:icon.trash
                                        class="stroke-2 stroke-red-500 hover:stroke-zinc-900 transform duration-500" />
                                </button>
                            @else
                                <button wire:click='restore({{ $item->id }})'
                                    wire:confirm='Apakah anda yakin ingin menghapus data id: {{ $item->id }}?'
                                    class="rounded-lg  outline-2 outline-green-500 p-[5px] hover:bg-green-500 transition duration-500">
                                    <flux:icon.arrow-path-rounded-square
                                        class="stroke-2 stroke-green-500 hover:stroke-zinc-900 transform duration-500" />
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
