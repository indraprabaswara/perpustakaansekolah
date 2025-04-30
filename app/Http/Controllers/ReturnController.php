<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use DB;

class ReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activeTransactions = Transaksi::where('user_id', auth()->id())
            ->whereIn('status', ['ongoing'])
            ->with(['book'])
            ->get();
            
        return view('member.return.index', compact('activeTransactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaksi_id' => 'required|exists:transaksis,id'
        ]);
    
        $transaction = Transaksi::with('book')
            ->where('user_id', auth()->id())
            ->findOrFail($validated['transaksi_id']);
    
        if ($transaction->status !== 'ongoing') {
            return back()->with('error', 'Status transaksi tidak valid untuk pengembalian');
        }
    
        // Mulai transaksi database
        \DB::beginTransaction();
        try {
            // Update status transaksi menjadi completed
            $transaction->update([
                'status' => 'completed'
            ]);
    
            // Update status buku menjadi available
            $transaction->book->update(['status' => 'available']);
    
            \DB::commit();
            return redirect()->route('member.return.index')->with('success', 'Buku berhasil dikembalikan dan tersedia untuk dipinjam lagi');
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
