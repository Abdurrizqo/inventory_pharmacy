<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Stok;
use App\Models\TransaksiKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        if (empty($search)) {
            $stok = Stok::select(['stok.id', 'harga_satuan', 'jumlah_stok', 'exp_date', 'obat.nama_obat', 'suppliers.supplier_name'])
                ->leftJoin('obat', 'obat.id', '=', 'stok.obat_id')
                ->leftJoin('suppliers', 'suppliers.id', '=', 'stok.supplier_id')
                ->get();
        } else {
            $stok = Stok::select(['stok.id', 'harga_satuan', 'jumlah_stok', 'exp_date', 'obat.nama_obat', 'suppliers.supplier_name'])
                ->leftJoin('obat', 'obat.id', '=', 'stok.obat_id')
                ->leftJoin('suppliers', 'suppliers.id', '=', 'stok.supplier_id')
                ->where('obat.nama_obat', 'like', "%$search%")->get();
        }

        return view('stok.stok', ['stok' => $stok]);
    }

    public function getAllStok(Request $request)
    {
        $search = $request->query('search');
        if (empty($search)) {
            $stok = Stok::select(['stok.id', 'harga_satuan', 'jumlah_stok', 'exp_date', 'obat.nama_obat', 'suppliers.supplier_name'])
                ->leftJoin('obat', 'obat.id', '=', 'stok.obat_id')
                ->leftJoin('suppliers', 'suppliers.id', '=', 'stok.supplier_id')
                ->where('stok.jumlah_stok', '>', 0)
                ->get();
        } else {
            $stok = Stok::select(['stok.id', 'harga_satuan', 'jumlah_stok', 'exp_date', 'obat.nama_obat', 'suppliers.supplier_name'])
                ->leftJoin('obat', 'obat.id', '=', 'stok.obat_id')
                ->leftJoin('suppliers', 'suppliers.id', '=', 'stok.supplier_id')
                ->where('stok.jumlah_stok', '>', 0)
                ->where('obat.nama_obat', 'like', "%$search%")
                ->get();
        }

        return response()->json(['data' => $stok]);
    }

    public function createView()
    {
        return view('stok.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'obat_id' => 'string|required|exists:obat,id',
            'supplier_id' => 'string|required|exists:suppliers,id',
            'harga_satuan' => 'integer|required',
            'jumlah_stok' => 'integer|required',
            'exp_date' => 'date|required',
        ], [
            'required' => 'Form harus diisi',
            'string' => 'Nilai tidak valid',
            'integer' => 'Nilai tidak valid',
            'date' => 'Nilai tidak valid',
            'obat_id.exists' => 'Obat tidak valid',
            'supplier_id.exists' => 'Supplier Kategori tidak valid',
        ]);

        try {
            Stok::create($validated);

            return redirect('/stok')->with(['success' => 'Input Stok Berhasil']);
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with(['error' => 'Input Stok Gagal' . $th]);
        }
    }

    public function stokKeluar(Request $request)
    {
        try {
            $validated = $request->validate([
                'stok' => 'required|array',
                'stok.*.stokId' => 'required|exists:stok,id',
                'stok.*.jumlahItem' => 'required|integer|min:1',
            ], [
                'required' => 'Form wajib di isi',
                'array' => 'Data tidak valid',
                'exists' => 'Data stok tidak valid',
                'integer' => 'Data tidak valid',
                'min' => 'Jumlah minimal 1',
            ]);

            DB::transaction(function () use ($validated) {
                foreach ($validated['stok'] as $item) {
                    $stokSaatIni = Stok::where('id', $item['stokId'])->first();

                    if ($item['jumlahItem'] > $stokSaatIni->jumlah_stok) {
                        Stok::where('id', $item['stokId'])
                            ->update(['jumlah_stok' => 0]);
                    } else {
                        Stok::where('id', $item['stokId'])
                            ->decrement('jumlah_stok', $item['jumlahItem']);
                    }

                    TransaksiKeluar::create(
                        [
                            'stokId' => $stokSaatIni->id,
                            'jumlah' => $item['jumlahItem']
                        ]
                    );
                }
            });

            return response()->json(['success' => 'Stok berhasil dikurangi'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function editView($id)
    {
        $stok = Stok::where('stok.id', $id)
            ->select(['stok.id as stokId', 'obat.id as obatId', 'suppliers.id as suppliersId', 'harga_satuan', 'jumlah_stok', 'exp_date', 'obat.nama_obat', 'suppliers.supplier_name'])
            ->leftJoin('obat', 'obat.id', '=', 'stok.obat_id')
            ->leftJoin('suppliers', 'suppliers.id', '=', 'stok.supplier_id')->first();

        if (!$stok) {
            return abort(404);
        }

        return view("stok.edit", ['stok' => $stok]);
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'obat_id' => 'string|required|exists:obat,id',
            'supplier_id' => 'string|required|exists:suppliers,id',
            'harga_satuan' => 'integer|required',
            'jumlah_stok' => 'integer|required',
            'exp_date' => 'date|required',
        ], [
            'required' => 'Form harus diisi',
            'string' => 'Nilai tidak valid',
            'integer' => 'Nilai tidak valid',
            'date' => 'Nilai tidak valid',
            'obat_id.exists' => 'Obat tidak valid',
            'supplier_id.exists' => 'Supplier Kategori tidak valid',
        ]);

        try {
            Stok::where('id', $id)->update($validated);

            return redirect('/stok')->with(['success' => 'Edit Stok Berhasil']);
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with(['error' => 'Edit Stok Gagal' . $th]);
        }
    }
}
