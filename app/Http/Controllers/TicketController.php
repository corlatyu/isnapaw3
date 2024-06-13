<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Ticket::query();

        if ($search) {
            $query->where('nama_ticket', 'LIKE', "%{$search}%") 
                     ->orwhere('harga_ticket', 'LIKE', "%{$search}%");
        }

        $tickets = $query->paginate(5); // Menampilkan 5 mahasiswa per halaman
        return view('ticket.index', compact('tickets'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ticket.add');
    }
    

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'nama_ticket' => 'required|unique:tickets,nama_ticket',
            'harga_ticket' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
    
        $validated = $request->all();
    
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $namaGambar = Str::random(20).'.'.$gambar->getClientOriginalExtension();
            $filePath = 'gambar_tickets/' . $namaGambar;
            $gambar->move(public_path('gambar_tickets'), $namaGambar);
            $validated['gambar'] = $filePath;
        }
    
        Ticket::create($validated);
    
        return redirect()->route('ticket.index')->with('success', 'Ticket created successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = Ticket::find($id);
    
        return view('ticket.show', compact('ticket'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ticket = Ticket::find($id);
    
        return view('ticket.edit', compact('ticket'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'nama_ticket' => 'required|unique:tickets,nama_ticket,' . $id,
            'harga_ticket' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
    
        $ticket = Ticket::find($id);
                $validated = $request->all();
            if ($request->hasFile('gambar')) {
            if ($ticket->gambar) {
                $oldImagePath = public_path($ticket->gambar);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
    
            $gambar = $request->file('gambar');
            $filePath = 'gambar_tickets/' . time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('gambar_tickets'), $filePath);
            $validated['gambar'] = $filePath;
        } else {
            unset($validated['gambar']);
        }
    
        $ticket->update($validated);
    
        return redirect()->route('ticket.index')->with('success', 'Ticket updated successfully.');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = Ticket::find($id);
        
        if ($ticket->gambar) {
            $oldImagePath = public_path($ticket->gambar);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
    
        $ticket->delete();
    
        return redirect()->route('ticket.index')->with('success', 'Ticket deleted successfully.');
    }
    
}
