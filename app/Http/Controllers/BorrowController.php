<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class BorrowController extends Controller
{
    public function index()
{
    $hasActiveTransaction = false;
    
    if (auth()->user()->role === 'member') {
        // Hitung jumlah transaksi yang masih aktif
        $activeTransactions = Transaksi::where('user_id', auth()->id())
            ->whereIn('status', ['ongoing', 'pending'])
            ->count();
        
        // Jika user memiliki 2 buku dipinjam, batasi peminjaman
        $hasActiveTransaction = $activeTransactions >= 2;

        $availableBooks = Book::where('status', 'available')->get();
        $userTransactions = Transaksi::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'ongoing'])
            ->get();

        return view('member.borrow.index', compact('availableBooks', 'userTransactions', 'hasActiveTransaction'));
    }

    $transactions = Transaksi::with(['user', 'book'])->get();
    return view('admin.transactions.index', compact('transactions'));
}


    public function create()
    {
        $books = Book::where('status', 'available')->get();
        $users = User::where('role', 'member')->get();
        return view('admin.transactions.create', compact('books', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);
    
        if (auth()->user()->role === 'member') {
            // Cek jumlah buku yang sedang dipinjam user
            $activeTransactions = Transaksi::where('user_id', auth()->id())
                ->whereIn('status', ['ongoing', 'pending'])
                ->count();
    
            // Jika sudah 2 buku, batasi peminjaman
            if ($activeTransactions >= 2) {
                return back()->with('error', 'Anda hanya dapat meminjam maksimal 2 buku dalam satu waktu.');
            }
    
            // Cek apakah buku tersedia
            $book = Book::findOrFail($validated['book_id']);
            if ($book->status !== 'available') {
                return back()->with('error', 'Buku sudah tidak tersedia.');
            }
    
            // Buat transaksi peminjaman baru
            Transaksi::create([
                'user_id' => auth()->id(),
                'book_id' => $validated['book_id'],
                'borrow_date' => now(),
                'return_date' => now()->addDays(7), // Contoh: pinjaman 7 hari
                'status' => 'ongoing',
            ]);
    
            // Perbarui status buku menjadi 'borrowed'
            $book->update(['status' => 'borrowed']);
    
            return redirect()->route('member.dashboard')->with('success', 'Buku berhasil dipinjam.');
        }
    
        // Jika admin menambahkan transaksi
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after:borrow_date',
            'status' => 'required|in:pending,ongoing,completed',
        ]);
    
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
    

    public function show(Transaksi $transaction)
    {
        $transaction->load(['user', 'book']);
        if (auth()->user()->role === 'admin') {
            return view('admin.transactions.show', compact('transaction'));
        }
        return back();
    }

    public function update(Request $request, Transaksi $transaction)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,ongoing,completed',
        ]);

        if ($validated['status'] === 'completed') {
            $transaction->book->update(['status' => 'available']);
        } elseif ($validated['status'] === 'ongoing') {
            $transaction->book->update(['status' => 'borrowed']);
        }

        $transaction->update($validated);

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Status transaksi berhasil diupdate');
    }

    public function destroy(Transaksi $transaction)
    {
        $transaction->book->update(['status' => 'available']);
        $transaction->delete();

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }
}
