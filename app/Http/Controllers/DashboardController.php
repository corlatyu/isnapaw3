<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Mahasiswa::query();

        if ($search) {
            $query->where('nama', 'LIKE', "%{$search}%") 
                     ->orwhere('nbi', 'LIKE', "%{$search}%");
        }

        $mahasiswas = $query->paginate(5); // Menampilkan 5 mahasiswa per halaman
        return view('dashboard.index', compact('mahasiswas'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nbi' => 'required|unique:mahasiswas,nbi',
        ]);

        $validated = $request->all();

        Mahasiswa::create($validated);

        return redirect()->route('dashboard.index')->with('success', 'Mahasiswa created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mahasiswa = Mahasiswa::find($id);
        return view('dashboard.edit', compact('mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'nbi' => 'required|unique:mahasiswas,nbi,' . $id,
        ]);

        $mahasiswa = Mahasiswa::find($id);
        $validated = $request->all();
        $mahasiswa->update($validated);

        return redirect()->route('dashboard.index')->with('success', 'Mahasiswa updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mahasiswa = Mahasiswa::find($id);
        $mahasiswa->delete();

        return redirect()->route('dashboard.index')->with('success', 'Mahasiswa deleted successfully.');
    }
}
