<div id="obatModal" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
            <div class="bg-white px-4 pb-4 h-96 overflow-auto relative">

                <div class="sticky top-0 bg-white p-2">
                    <input type="text" id="searchObat"
                        class="w-full rounded-full border border-gray-300 px-3 py-2 outline-none focus:border-emerald-300">
                </div>

                <div id="modal-content-obat">
                    <div id="spinner-obat" class="hidden spinner"></div>
                </div>
            </div>

            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm"
                    id="closeModal-obat">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<div id="supplierModal" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
            <div class="bg-white px-4 pb-4 h-96 overflow-auto relative">

                <div class="sticky top-0 bg-white p-2">
                    <input type="text" id="searchSupplier"
                        class="w-full rounded-full border border-gray-300 px-3 py-2 outline-none focus:border-emerald-300">
                </div>

                <div id="modal-content-supplier">
                    <div id="spinner-supplier" class="hidden spinner"></div>
                </div>
            </div>

            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm"
                    id="closeModal-supplier">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

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

    <div class="flex justify-center items-center">
        <div class="w-[32rem]">
            <span
                class="inline-flex gap-4 border border-gray-300 bg-white shadow px-4 py-2 rounded-full mb-10 text-sm text-gray-800">
                <a href="/stok" class="roboto-medium hover:text-emerald-400">Stok</a>
                <p>/</p>
                <a href="#">Create</a>
            </span>

            <div class="bg-white border rounded p-3">
                <form method="POST">
                    @csrf
                    <div class="flex items-center gap-3">
                        <div class="flex-1">
                            <input type="hidden" name="obat_id" id="obat_id">
                            <label for="obatName" class="block text-sm ml-2 mb-1">Nama Obat</label>
                            <input type="text" readonly name="obatName" id="obatName"
                                class="border border-gray-300 rounded-md outline-none focus:border-emerald-400 px-3 py-1 h-10 w-full">
                        </div>

                        <div class="w-24">
                            <label for="jumlah_stok" class="block text-sm ml-2 mb-1">Jumlah Obat</label>
                            <input type="number" name="jumlah_stok" id="jumlah_stok"
                                class="border border-gray-300 rounded-md outline-none focus:border-emerald-400 px-3 py-1 h-10 w-full">
                        </div>

                        <div class="w-24">
                            <label for="harga_satuan" class="block text-sm ml-2 mb-1">Harga Satuan</label>
                            <input type="number" name="harga_satuan" id="harga_satuan"
                                class="border border-gray-300 rounded-md outline-none focus:border-emerald-400 px-3 py-1 h-10 w-full">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mt-10">
                        <div>
                            <label for="exp_date" class="block text-sm ml-2 mb-1">Tanggal Expire</label>
                            <input type="date" name="exp_date" id="exp_date"
                                class="border border-gray-300 rounded-md outline-none px-3 py-1 h-10 w-full">
                        </div>

                        <div>
                            <input type="hidden" name="supplier_id" id="supplier_id">
                            <label for="supplierName" class="block text-sm ml-2 mb-1">Supplier</label>
                            <input type="text" readonly name="supplierName" id="supplierName"
                                class="border border-gray-300 rounded-md outline-none focus:border-emerald-400 px-3 py-1 h-10 w-full">
                        </div>
                    </div>

                    <div class="flex justify-end mt-8">
                        <button type="submit"
                            class="bg-emerald-400 text-white py-[3px] px-8 rounded hover:bg-emerald-500">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    @vite('resources/js/obatModal.js')
    @vite('resources/js/supplierModal.js')
@endsection
