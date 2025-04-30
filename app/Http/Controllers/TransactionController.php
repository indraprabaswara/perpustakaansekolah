<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $transactions = Transaksi::with(['user', 'book'])->get();
            return view('admin.transactions.index', compact('transactions'));
        } else {
            $transactions = Transaksi::with(['user', 'book'])
                ->where('user_id', auth()->id())
                ->get();
            return view('member.dashboard', compact('transactions'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    
    $borrowedBookIds = Transaksi::whereIn('status', ['pending', 'ongoing'])
        ->pluck('book_id')
        ->toArray();

    
    $books = Book::whereNotIn('id', $borrowedBookIds)
        ->where('status', 'available')
        ->get();

    
    $borrowedUserIds = Transaksi::whereIn('status', ['pending', 'ongoing'])
        ->pluck('user_id')
        ->toArray();

    
    $users = User::where('role', 'member')
        ->whereNotIn('id', $borrowedUserIds)
        ->get();

    return view('admin.transactions.create', compact('books', 'users'));
}

    /**
     * Store a newly created resource in storage.
     */

     public function show(Transaksi $transaction)
     {
         $transaction->load(['user', 'book']);
         if (auth()->user()->role === 'admin') {
             return view('admin.transactions.show', compact('transaction'));
         }
         return back();
     }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'nullable|date',
            'return_date' => 'required|date|after:borrow_date',
            'status' => 'required|in:pending,ongoing,completed'
        ]);

        // Pastikan user tidak sedang meminjam buku lain
        $hasActiveTransaction = Transaksi::where('user_id', $validated['user_id'])
            ->whereIn('status', ['pending', 'ongoing'])
            ->exists();

        if ($hasActiveTransaction) {
            return back()->with('error', 'User ini sudah meminjam buku lain.');
        }

        $validated['borrow_date'] = $validated['borrow_date'] ?? now();

        $book = Book::findOrFail($validated['book_id']);
        if ($book->status !== 'available') {
            return back()->with('error', 'Buku tidak tersedia.');
        }

        $transaction = Transaksi::create($validated);
        $book->update(['status' => 'borrowed']);

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan')
            ->with('newTransaction', $transaction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaction)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,ongoing,completed'
        ]);

        $transaction->update(['status' => $validated['status']]);

        // Jika transaksi selesai, ubah status buku menjadi tersedia kembali
        if ($validated['status'] === 'completed' && $transaction->book) {
            $transaction->book->update(['status' => 'available']);
        }

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Status transaksi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaction)
    {
        if ($transaction->book) {
            $transaction->book->update(['status' => 'available']);
        }

        $transaction->delete();

        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
