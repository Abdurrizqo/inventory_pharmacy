<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Suppliers;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        if (empty($search)) {
            $suppliers = Suppliers::all();
        } else {
            $suppliers = Suppliers::where('supplier_name', 'like', "%$search%")->get();
        }

        return view('supplier.supplier', ['suppliers' => $suppliers]);
    }

    public function getAllSupplier(Request $request)
    {
        $search = $request->query('search');
        if (empty($search)) {
            $suppliers = Suppliers::all();
        } else {
            $suppliers = Suppliers::where('supplier_name', 'like', "%$search%")->get();
        }
        return response()->json(['data' => $suppliers], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_name' => 'string|required|min:3|max:240',
            'contact' => 'string|required|min:3|max:20',
            'address' => 'string|required'
        ], [
            'required' => 'Form harus diisi',
            'string' => 'Nilai tidak valid',
            'min' => 'minimal 3 karakter',
            'max:240' => 'maksimal 240 karakter',
            'max:20' => 'maksimal 20 karakter',
        ]);

        try {
            Suppliers::create($validated);

            return redirect()->back()->with(['success' => 'Input Supplier Berhasil']);
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with(['error' => 'Input Supplier Gagal' . $th]);
        }
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'idSupplier' => 'string|required|exists:suppliers,id',
            'supplier_name' => 'string|required|min:3|max:240',
            'contact' => 'string|required|min:3|max:20',
            'address' => 'string|required'
        ], [
            'required' => 'Form harus diisi',
            'string' => 'Nilai tidak valid',
            'min' => 'minimal 3 karakter',
            'max:240' => 'maksimal 240 karakter',
            'max:20' => 'maksimal 20 karakter',
            'exists' => 'Supplier tidak valid'
        ]);

        try {
            Suppliers::where('id', $validated['idSupplier'])->update(
                [
                    'supplier_name' => $validated['supplier_name'],
                    'contact' => $validated['contact'],
                    'address' => $validated['address'],
                ]
            );

            return redirect()->back()->with(['success' => 'Edit Supplier Berhasil']);
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with(['error' => 'Edit Supplier Gagal' . $th]);
        }
    }
}
