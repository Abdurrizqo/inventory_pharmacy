@extends('layouts.app')
@section('content')
    @if (session('success'))
        <div class="bg-green-300 text-green-700 w-full rounded p-2 mb-12 text-sm font-medium">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-300 text-red-700 w-full rounded p-2 mb-12 text-sm font-medium">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="mb-10">
        <a href="stok/create" class="bg-emerald-400 hover:bg-emerald-500 text-white py-2 px-8 rounded">Add Stok Obat</a>
    </div>

    <div class="mt-4 mb-28">
        <table class="table-auto border border-gray-400 min-w-[50%]">
            <thead class="border-b border-gray-400">
                <tr>
                    <th class="border border-gray-400 px-4 py-2">#</th>
                    <th class="border border-gray-400 px-6 py-2">Nama Obat</th>
                    <th class="border border-gray-400 px-6 py-2">Nama Supplier</th>
                    <th class="border border-gray-400 px-6 py-2">Jumlah Stok</th>
                    <th class="border border-gray-400 px-6 py-2">Harga Satuan</th>
                    <th class="border border-gray-400 px-6 py-2">Expired</th>
                    <th class="border border-gray-400 px-6 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stok as $index => $item)
                    <tr class="hover:bg-gray-100 cursor-default">
                        <td class="border border-gray-400 px-3 py-2 text-center">{{ ++$index }}</td>
                        <td class="border border-gray-400 px-3 py-2">{{ $item->nama_obat }}</td>
                        <td class="border border-gray-400 px-3 py-2">{{ $item->supplier_name }}</td>
                        <td class="border border-gray-400 px-3 py-2">{{ $item->jumlah_stok }}</td>
                        <td class="border border-gray-400 px-3 py-2">{{ $item->harga_satuan }}</td>
                        <td class="border border-gray-400 px-3 py-2">{{ $item->exp_date }}</td>
                        <td class="border border-gray-400 px-3 py-2">
                            <div class="flex items-center gap-4 justify-center">
                                <a href="stok/edit/{{ $item->id }}"
                                    class="px-8 py-[2px] text-white bg-emerald-400 rounded">Edit</a>
                                <button class="px-8 py-[2px] text-white bg-red-400 rounded">Delete</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="fixed bg-white bottom-0 left-0 right-0 px-4 border-t border-t-gray-300 py-4">
        <form method="GET" class="mb-0">
            <input type="text" placeholder="Search" name="search"
                class="w-80 border rounded-full border-gray-400 focus:border-emerald-400 py-1 px-6 h-10 outline-none">
        </form>
    </div>
@endsection
