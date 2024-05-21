<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        if (empty($search)) {
            $obats = Obat::all();
        } else {
            $obats = Obat::where('nama_obat', 'like', "%$search%")->get();
        }
        return view('obat.obat', ['obat' => $obats]);
    }

    public function getAllObat(Request $request)
    {
        $search = $request->query('search');
        if (empty($search)) {
            $obats = Obat::all();
        } else {
            $obats = Obat::where('nama_obat', 'like', "%$search%")->get();
        }
        return response()->json(['data' => $obats], 200);
    }

    public function createView()
    {
        return view('obat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'string|required|min:3|max:240',
            'kategori' => 'string|required|exists:categories,category_name',
            'sub_category_name' => 'string|required|exists:sub_categories,sub_category_name',
        ], [
            'required' => 'Form harus diisi',
            'string' => 'Nilai tidak valid',
            'min' => 'minimal 3 karakter',
            'max:240' => 'maksimal 240 karakter',
            'kategori.exists' => 'Kategori tidak valid',
            'sub_category_name.exists' => 'Sub Kategori tidak valid',
        ]);

        try {
            Obat::create(
                [
                    'nama_obat' => $validated['nama_obat'],
                    'kategori' => $validated['kategori'],
                    'sub_kategori' => $validated['sub_category_name']
                ]
            );

            return redirect('/obat')->with(['success' => 'Input Obat Berhasil']);
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->withInput()->with(['error' => 'Input Obat Gagal' . $th]);
        }
    }

    public function editView($id)
    {
        $obat = Obat::where('id', $id)->first();

        if (!$obat) {
            return abort(404);
        }
        return view('obat.edit', ['obat' => $obat]);
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'string|required|min:3|max:240',
            'kategori' => 'string|required|exists:categories,category_name',
            'sub_category_name' => 'string|required|exists:sub_categories,sub_category_name',
        ], [
            'required' => 'Form harus diisi',
            'string' => 'Nilai tidak valid',
            'min' => 'minimal 3 karakter',
            'max:240' => 'maksimal 240 karakter',
            'kategori.exists' => 'Kategori tidak valid',
            'sub_category_name.exists' => 'Sub Kategori tidak valid',
        ]);

        try {
            Obat::where('id', $id)->update(
                [
                    'nama_obat' => $validated['nama_obat'],
                    'kategori' => $validated['kategori'],
                    'sub_kategori' => $validated['sub_category_name']
                ]
            );

            return redirect('/obat')->with(['success' => 'Input Obat Berhasil']);
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with(['error' => 'Input Obat Gagal' . $th]);
        }
    }
}
