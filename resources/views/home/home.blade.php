@extends('layouts.app')
@section('content')
    <div class="min-w-full">
        <div class="w-full p-2">
            <form id="formPencarianStok">
                <input type="text" name="search" id="searchStok" placeholder='Cari Stok Obat'
                    class='w-1/2 border px-5 py-1 h-10 border-gray-400 rounded-full outline-none focus:border-emerald-400' />
            </form>

            <div class="mt-5 w-full overflow-auto h-[28rem]">
                <h1 class="text-xl font-bold mb-2">Daftar Stok Obat</h1>
                <table class="table-auto border border-gray-400 w-full mb-8">
                    <thead class="border-b border-gray-400 text-sm">
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
                    <tbody class="text-sm" id="containerStok">
                    </tbody>
                </table>
                <div id="spinner" class="hidden spinner"></div>
                <div id="errorSearch" class="text-center text-gray-400 text-lg hidden">Terjadi Kesalahan, Mohon Coba Lagi
                </div>

            </div>

            <div class="w-full overflow-auto h-[28rem] mt-8">
                <h1 class="text-xl font-bold mb-2">Rencana Stok Keluar</h1>
                <table class="table-auto border border-gray-400 w-full">
                    <thead class="border-b border-gray-400 text-sm">
                        <tr>
                            <th class="border border-gray-400 px-4 py-2">#</th>
                            <th class="border border-gray-400 px-6 py-2">Nama Obat</th>
                            <th class="border border-gray-400 px-6 py-2">Nama Supplier</th>
                            <th class="border border-gray-400 px-6 py-2">Jumlah Stok</th>
                            <th class="border border-gray-400 px-6 py-2">Harga Satuan</th>
                            <th class="border border-gray-400 px-6 py-2">Expired</th>
                            <th class="border border-gray-400 px-6 py-2">Jumlah Keluar</th>
                            <th class="border border-gray-400 px-6 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm" id="containerKeluar">
                    </tbody>
                </table>

                <div class="flex justify-end mt-8 gap-8" id="containerToast">
                    <button id="removeButton" disabled onclick="resetData()"
                        class="py-[2px] px-8 bg-red-400 text-white rounded">Reset</button>
                    <button id="simpanButton" disabled onclick="simpanData()"
                        class="py-[2px] px-5 bg-emerald-400 text-white rounded flex items-center justify-center gap-3">
                        <span id="spinner-putih" class="spinner-putih hidden"></span>
                        <p>Simpan</p>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    @vite('resources/js/searchStok.js')
@endsection
