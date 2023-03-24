<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaction &raquo; {{ $item->food->name }} by {{ $item->user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full md:w-1/6 px-4 mb-4 md:mb-8">
                    <img src="{{ $item->food->picturePath }}" alt="" class="w-full rounded">
                </div>
                <div class="w-full md:w-5/6 px-4 mb-4 md:mb-0">
                 <div class="flex flex-wrap mb-3">
                        <div class="w-2/6">
                            <div class="text-sm">Product Name</div>
                            <div class="text-xl font-bold">{{ $item->food->name }}</div>
                        </div>
                        <div class="w-1/6">
                            <div class="text-sm">Quantity</div>
                            <div class="text-xl font-bold">{{ number_format($item->quantity) }}</div>
                        </div>
                        <div class="w-1/6">
                            <div class="text-sm">Total</div>
                            <div class="text-xl font-bold">{{ number_format($item->total) }}</div>
                        </div>
                        <div class="w-1/6">
                            <div class="text-sm">Status</div>
                            <div class="text-xl font-bold">{{ $item->status }}</div>
                        </div>
                </div>

                {{-- Kolom User --}}
                  <div class="flex flex-wrap mb-3">
                        <div class="w-2/6">
                            <div class="text-sm">User Name</div>
                            <div class="text-xl font-bold">{{ $item->user->name }}</div>
                        </div>
                        <div class="w-3/6">
                            <div class="text-sm">Email</div>
                            <div class="text-xl font-bold">{{ $item->user->email }}</div>
                        </div>
                        <div class="w-1/6">
                            <div class="text-sm">City</div>
                            <div class="text-xl font-bold">{{ $item->user->city }}</div>
                        </div>
                </div>
            </div>

            {{-- Buat Link/Pagination --}}
            <div class="text-center mt-5">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
