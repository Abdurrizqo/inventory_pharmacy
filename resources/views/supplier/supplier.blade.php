<div id="modalDelete" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
            <div class="bg-white px-4 pb-4 overflow-auto relative">
                <div class=" text-center pt-10 pb-3">
                    <h1 class="text-xl font-medium mb-4" id="peringatanModal"></h1>
                    <h1 class="text-lg" id="tittleModalDelete"></h1>
                </div>
            </div>

            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row sm:justify-end gap-4">
                <button type="button" onclick="batalDelete()"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                    Batal
                </button>

                <a id="linkDelete"
                    class="mt-3 w-full inline-flex bg-red-400 justify-center rounded-md border border-red-400 shadow-sm px-4 py-2 text-base font-medium text-white hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm">
                    Hapus
                </a>
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

    <div class="mb-10">
        <form class='mb-0' method="POST" id="formSupplier">
            @csrf
            <div class="flex gap-x-8 gap-y-5 items-center flex-wrap w-full">
                <div>
                    <label for="supplier_name" class="mr-4 text-sm">Nama Supplier</label>
                    <input type="text" name="supplier_name" id="supplier_name" placeholder='Nama Supplier'
                        class='w-80 border px-5 py-1 h-10 border-gray-400 rounded-full outline-none focus:border-emerald-400' />
                    @error('supplier_name')
                        <p class="text-xs text-red-400">*{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="contact" class="mr-4 text-sm">Kontak Supplier</label>
                    <input type="text" name="contact" id="contact" placeholder='Kontak'
                        class='w-80 border px-5 py-1 h-10 border-gray-400 rounded-full outline-none focus:border-emerald-400' />
                    @error('contact')
                        <p class="text-xs text-red-400">*{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="mr-4 text-sm">Alamat</label>
                    <input type="text" name="address" id="address" placeholder='Alamat'
                        class='w-[28rem] border px-5 py-1 h-10 border-gray-400 rounded-full outline-none focus:border-emerald-400' />
                    @error('address')
                        <p class="text-xs text-red-400">*{{ $message }}</p>
                    @enderror
                </div>

                <button id="submitSupplier" class="text-white bg-emerald-400 hover:bg-emerald-500 py-1 px-7 rounded"
                    type="input">Simpan</button>
            </div>
        </form>
    </div>

    <div class="mt-4 mb-28">
        <table class="table-auto border border-gray-400 min-w-[50%]">
            <thead class="border-b border-gray-400">
                <tr>
                    <th class="border border-gray-400 px-4 py-2">#</th>
                    <th class="border border-gray-400 px-6 py-2">Nama Supplier</th>
                    <th class="border border-gray-400 px-6 py-2">Kontak</th>
                    <th class="border border-gray-400 px-6 py-2">Alamat</th>
                    <th class="border border-gray-400 px-6 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $index => $item)
                    <tr class="hover:bg-gray-100 cursor-default">
                        <td class="border border-gray-400 px-3 py-2 text-center">{{ ++$index }}</td>
                        <td class="border border-gray-400 px-3 py-2">{{ $item->supplier_name }}</td>
                        <td class="border border-gray-400 px-3 py-2">{{ $item->contact }}</td>
                        <td class="border border-gray-400 px-3 py-2">{{ $item->address }}</td>
                        <td class="border border-gray-400 px-3 py-2">
                            <div class="flex items-center gap-4 justify-center">
                                <button
                                    onclick="clickEdit('{{ $item->id }}','{{ $item->supplier_name }}','{{ $item->contact }}','{{ $item->address }}')"
                                    class="px-8 py-[2px] text-white bg-emerald-400 rounded">Edit</button>
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

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script>
        function clickEdit(idSupplier, supplier, kontak, alamat) {
            $('#supplier_name').val('');
            $('#contact').val('');
            $('#address').val('');
            $('#idSupplier').val('');
            $('#batalEditSupplier').remove();

            $('#supplier_name').val(supplier);
            $('#contact').val(kontak);
            $('#address').val(alamat);
            $('#formSupplier').append(
                `<input type="hidden" value="${idSupplier}" id="hiddenIdSupplier" name="idSupplier"/>`);

            $('#submitSupplier').after(
                '<button id="batalEditSupplier" class="text-white bg-red-400 hover:bg-red-500 py-1 px-7 rounded" type="button" onclick="batalEdit()">Batal</button>'
            );
            $('#submitSupplier').text('Edit');
            $('#formSupplier').attr('action', '/supplier/edit');
        }

        function batalEdit() {
            $('#formSupplier').removeAttr('action');
            $('#submitSupplier').text('Simpan');
            $('#supplier_name').val('');
            $('#contact').val('');
            $('#address').val('');
            $('#batalEditSupplier').remove();
            $('#hiddenIdSupplier').remove();
        }
    </script>
@endsection
