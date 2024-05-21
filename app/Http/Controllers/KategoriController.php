<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        if (empty($search)) {
            $categorires = Categories::all();
        } else {
            $categorires = Categories::where('category_name', 'like', "%$search%")->get();
        }

        return view('kategori.kategori', ['kategori' => $categorires]);
    }

    public function getAllKategori(Request $request)
    {
        $search = $request->query('search');
        if (empty($search)) {
            $categorires = Categories::all();
        } else {
            $categorires = Categories::where('category_name', 'like', "%$search%")->get();
        }
        return response()->json(['data' => $categorires], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'string|required|min:3|max:240',
        ], [
            'required' => 'Form harus diisi',
            'string' => 'Nilai tidak valid',
            'min' => 'minimal 3 karakter',
            'max' => 'maksimal 240 karakter'
        ]);

        try {
            Categories::create($validated);

            return redirect()->back()->with(['success' => 'Input Kategori Berhasil']);
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with(['error' => 'Input Kategori Gagal' . $th]);
        }
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'idKategori' => 'string|required|exists:categories,id',
                'category_name' => 'string|required|min:3|max:240',
            ], [
                'idKategori.exists' => 'kategori Tidak Ditemukan',
                'required' => 'Form harus diisi',
                'string' => 'Nilai tidak valid',
                'min' => 'minimal 3 karakter',
                'max' => 'maksimal 240 karakter'
            ]);

            Categories::where('id', $validated['idKategori'])->update(['category_name' => $validated['category_name']]);
            return redirect()->back()->with(['success' => 'Input Kategori Berhasil']);
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with(['error' => 'Input Kategori Gagal' . $th]);
        }
    }

    public function destroy($id)
    {
        try {
            Categories::where('id', $id)->delete();
            return redirect()->back()->with(['success' => 'Hapus Kategori Berhasil']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => 'Hapus Kategori Gagal' . $th]);
        }
    }
}
