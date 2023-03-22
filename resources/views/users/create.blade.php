<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {!! __('User &raquo; Create') !!}
            {{-- raquo adalah semacam panah kekanan --}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                {{-- Untuk Bagian errir --}}
                @if($errors->any())
                <div class="mb-5" role="alert">
                    <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                        There's Something Wrong
                    </div>
                    <div class="border border-t-8 border-red-400 rounded-b bg-red-100
                            px-4 py-3 text-red-700 ">
                        <p>
                            <ul>
                                {{-- Untuk Bagian Error nya --}}
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
