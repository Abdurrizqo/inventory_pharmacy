<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SubCategories;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        if (empty($search)) {
            $subCategorires = SubCategories::select(['categories.category_name', 'sub_category_name', 'categories.id', 'sub_categories.category_id', 'sub_categories.id'])->orderBy('categories.category_name', 'asc')->leftJoin('categories', 'sub_categories.category_id', '=', 'categories.id')->get();
        } else {
            $subCategorires = SubCategories::select(['categories.category_name', 'sub_category_name', 'categories.id', 'sub_categories.category_id', 'sub_categories.id'])->where('sub_category_name', 'like', "%$search%")->orderBy('categories.category_name', 'asc')->leftJoin('categories', 'sub_categories.category_id', '=', 'categories.id')->get();
        }

        return view('subCategory.subCategory', ['subKategori' => $subCategorires]);
    }

    public function getAllSubKategori($idKategori, Request $request)
    {
        $search = $request->query('search');
        if (empty($search)) {
            $subCategorires = SubCategories::where('category_id', $idKategori)->get();
        } else {
            $subCategorires = SubCategories::where('category_id', $idKategori)->where('sub_category_name', 'like', "%$search%")->get();
        }
        return response()->json(['data' => $subCategorires], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sub_category_name' => 'string|required|min:3|max:240',
            'category_id' => 'string|required|exists:categories,id',
        ], [
            'required' => 'Form harus diisi',
            'string' => 'Nilai tidak valid',
            'min' => 'minimal 3 karakter',
            'max' => 'maksimal 240 karakter',
            'exists' => 'Kategori tidak valid'
        ]);

        try {
            SubCategories::create($validated);

            return redirect()->back()->with(['success' => 'Input Sub Kategori Berhasil']);
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with(['error' => 'Input Sub Kategori Gagal' . $th]);
        }
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'sub_category_name' => 'string|required|min:3|max:240',
            'category_id' => 'string|required|exists:categories,id',
            'idSubKategori' => 'string|required|exists:sub_categories,id',
        ], [
            'required' => 'Form harus diisi',
            'string' => 'Nilai tidak valid',
            'min' => 'minimal 3 karakter',
            'max' => 'maksimal 240 karakter',
            'category_id.exists' => 'Kategori tidak valid',
            'idSubKategori.exists' => 'Sub Kategori tidak valid',
        ]);

        try {
            SubCategories::where('id', $validated['idSubKategori'])->update(
                [
                    'sub_category_name' => $validated['sub_category_name'],
                    'category_id' => $validated['category_id']
                ]
            );

            return redirect()->back()->with(['success' => 'Edit Sub Kategori Berhasil']);
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with(['error' => 'Edit Sub Kategori Gagal' . $th]);
        }
    }

    public function destroy($id)
    {
        try {
            SubCategories::where('id', $id)->delete();
            return redirect()->back()->with(['success' => 'Hapus Sub Kategori Berhasil']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => 'Hapus Sub Kategori Gagal' . $th]);
        }
    }
}
