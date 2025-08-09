<div>
    <flux:heading size="xl" class="pb-5">Dashboard</flux:heading>
    {{-- modal bayar --}}
    <flux:modal wire:model.self="showModalBayar" class="md:w-full">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Payment Information</flux:heading>
            </div>
            <form wire:submit.prevent="bayar" class="space-y-4" enctype="multipart/form-data">
                <flux:input wire:model='name' label="Name" placeholder="Your name" disabled />
                <flux:input wire:model='departement' label="departement" placeholder="Your departement" disabled />
                <flux:input wire:model='semester' label="Semester" placeholder="Your semester" disabled />
                <flux:select wire:model='transaction_type' label="Transaction Type"
                    placeholder="Choose transaction type...">
                    <flux:select.option value="cash">Cash</flux:select.option>
                    <flux:select.option value="transfer">Transfer</flux:select.option>
                </flux:select>
                <flux:input type="file" wire:model='bukti' label="Bukti" placeholder="Upload Bukti" />
                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Make Payment</flux:button>
            </form>
        </div>
    </flux:modal>

    <div class="grid grid-cols-5 grid-rows-5 gap-4">
        <div class="col-span-3">
            <div class="rounded-lg bg-zinc-900 p-7 font-medium text-zinc-400 tracking-wider">
                <h3 class="text-5xl pb-5">
                    @if ($transaction->count() > 0)
                        Rp. {{ number_format($transaction->last()->departement->cost, 0, ',', '.') }}
                    @else
                        ~
                    @endif
                </h3>
                <p>Bill to be paid</p>
            </div>
        </div>
        <div class="col-start-5 row-start-1">
            @if ($transaction->last()->status)
                <div
                    class="rounded-lg bg-zinc-900 p-7 font-medium text-zinc-400 tracking-wider outline-2 outline-green-500">
                    <h3 class="text-5xl pb-5 text-green-500">
                        Paid
                    </h3>
                    <p class="text-green-500">Status</p>
                </div>
            @elseif ($transaction->last()->transaction_type != null)
                <div
                    class="rounded-lg bg-zinc-900 p-7 font-medium text-zinc-400 tracking-wider outline-2 outline-yellow-500">
                    <h3 class="text-5xl pb-5 text-yellow-500">
                        Pending
                    </h3>
                    <p class="text-yellow-500">Status</p>
                </div>
            @else
                <div
                    class="rounded-lg bg-zinc-900 p-7 font-medium text-zinc-400 tracking-wider outline-2 outline-red-500">
                    <h3 class="text-5xl pb-5 text-red-500">
                        Unpaid
                    </h3>
                    <p class="text-red-500">Status</p>
                </div>
            @endif
        </div>
        <div class="col-span-5 row-span-4 col-start-1 row-start-2">
            <div class="rounded-lg bg-zinc-900 p-4">
                <table class="min-w-full divide-y divide-zinc-700 rounded-lg" id="table">
                    <thead class="bg-zinc-800">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-zinc-400 uppercase tracking-wider">
                                No
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-zinc-400 uppercase tracking-wider">
                                Nama
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-zinc-400 uppercase tracking-wider">
                                Departement
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-zinc-400 uppercase tracking-wider">
                                Semester
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-zinc-400 uppercase tracking-wider">
                                Bill
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-zinc-400 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-zinc-400 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-zinc-900 divide-y divide-zinc-800">
                        <!-- Example row -->
                        @foreach ($transaction as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-zinc-400">
                                        {{ $item->student->name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-zinc-400">
                                        {{ $item->departement->name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-zinc-400">{{ $item->departement->semester }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-zinc-400">Rp.
                                        {{ number_format($item->departement->cost, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if ($item->status)
                                        <flux:modal.trigger wire:click='openModalBayar({{ $item->id }})'>
                                            <button
                                                class="rounded-lg outline-2 outline-green-500 hover:bg-green-500  p-[5px]  transition duration-500">
                                                <flux:icon.banknotes
                                                    class="stroke-2 stroke-green-500 hover:stroke-zinc-900 transform duration-500" />
                                            </button>
                                        </flux:modal.trigger>
                                    @elseif ($item->transaction_type)
                                        <flux:modal.trigger wire:click='openModalBayar({{ $item->id }})'>
                                            <button
                                                class="rounded-lg outline-2 outline-yellow-500 hover:bg-yellow-500  p-[5px]  transition duration-500">
                                                <flux:icon.banknotes
                                                    class="stroke-2 stroke-yellow-500 hover:stroke-zinc-900 transform duration-500" />
                                            </button>
                                        </flux:modal.trigger>
                                    @else
                                        <button
                                            class="rounded-lg outline-2 outline-red-500 hover:bg-red-500  p-[5px]  transition duration-500">
                                            <flux:icon.banknotes
                                                class="stroke-2 stroke-red-500 hover:stroke-zinc-900 transform duration-500" />
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <!-- More rows... -->
                    </tbody>
                </table>

            </div>
        </div>
        <div class="col-start-4 row-start-1">
            <div class="rounded-lg bg-zinc-900 p-5 font-medium text-zinc-400 tracking-wider">
                <h3 class="text-5xl pb-5">
                    {{ $transaction->where('status', false)->count() }}x
                </h3>
                <p>Number of Dependents</p>
            </div>
        </div>
    </div>

</div>
