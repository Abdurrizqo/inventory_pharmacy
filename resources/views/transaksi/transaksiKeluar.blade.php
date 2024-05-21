@extends('layouts.app')
@section('content')
    <div class="mt-4 mb-28">
        <table class="table-auto border border-gray-400 min-w-[50%]">
            <thead class="border-b border-gray-400">
                <tr>
                    <th class="border border-gray-400 px-4 py-2">#</th>
                    <th class="border border-gray-400 px-6 py-2">Nama Obat</th>
                    <th class="border border-gray-400 px-6 py-2">Nama Supplier</th>
                    <th class="border border-gray-400 px-6 py-2">Expired Obat</th>
                    <th class="border border-gray-400 px-6 py-2">Jumlah Keluar</th>
                    <th class="border border-gray-400 px-6 py-2">Tanggal Transaksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi as $index => $item)
                    <tr class="hover:bg-gray-100 cursor-default">
                        <td class="border border-gray-400 px-3 py-2 text-center">{{ ++$index }}</td>
                        <td class="border border-gray-400 px-3 py-2">{{ $item->nama_obat }}</td>
                        <td class="border border-gray-400 px-3 py-2">{{ $item->supplier_name }}</td>
                        <td class="border border-gray-400 px-3 py-2">{{ $item->exp_date }}</td>
                        <td class="border border-gray-400 px-3 py-2">{{ $item->jumlah }}</td>
                        <td class="border border-gray-400 px-3 py-2">{{ $item->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="fixed bg-white bottom-0 left-0 right-0 px-4 border-t border-t-gray-300 py-4">
        <form method="GET" class="mb-0 flex items-center gap-4">
            <input type="date" name="tanggalAwal"
                class="w-64 border rounded-full border-gray-400 focus:border-emerald-400 py-1 px-6 h-10 outline-none"
                value="{{ request()->query('tanggalAwal') }}">

            <h1 class="text-xl font-medium">-</h1>

            <input type="date" name="tanggalAkhir"
                class="w-64 border rounded-full border-gray-400 focus:border-emerald-400 py-1 px-6 h-10 outline-none"
                value="{{ request()->query('tanggalAkhir') }}">

            <button type="submit" class="bg-emerald-400 text-white px-6 py-[2px] rounded">Cari</button>
        </form>
    </div>
@endsection
