<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TransaksiKeluar;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransaksiKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = TransaksiKeluar::select(
            [
                'transaksi_keluar.id',
                'transaksi_keluar.stokId',
                'transaksi_keluar.jumlah',
                'transaksi_keluar.created_at',
                'stok.obat_id',
                'stok.supplier_id',
                'stok.exp_date',
                'obat.nama_obat',
                'suppliers.supplier_name',
            ]
        )
            ->leftJoin('stok', 'stok.id', 'transaksi_keluar.stokId')
            ->leftJoin('obat', 'obat.id', 'stok.obat_id')
            ->leftJoin('suppliers', 'suppliers.id', 'stok.supplier_id');

        // Ambil tanggal dari query params, jika tidak ada, gunakan tanggal hari ini
        $tanggalAwal = $request->query('tanggalAwal') ? Carbon::parse($request->query('tanggalAwal')) : Carbon::today();
        $tanggalAkhir = $request->query('tanggalAkhir') ? Carbon::parse($request->query('tanggalAkhir')) : Carbon::today();

        // Validasi tanggal, jika tidak valid, gunakan tanggal hari ini
        if (!$tanggalAwal->isValid() || !$tanggalAkhir->isValid() || $tanggalAwal->greaterThan($tanggalAkhir)) {
            $tanggalAwal = $tanggalAkhir = Carbon::today();
        }

        // Filter berdasarkan tanggal
        $query->whereDate('transaksi_keluar.created_at', '>=', $tanggalAwal)
            ->whereDate('transaksi_keluar.created_at', '<=', $tanggalAkhir);

        $transaksiKeluar = $query->get();

        return view('transaksi.transaksiKeluar', ['transaksi' => $transaksiKeluar]);
    }
}
