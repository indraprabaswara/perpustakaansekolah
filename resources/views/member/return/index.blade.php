@extends('layouts.member')

@section('title', 'Pengembalian Kendaraan')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    Pengembalian buku
                </h2>
                <p class="mt-1 text-gray-600">
                    Daftar buku yang sedang Anda pinjam
                </p>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Active Borrowings List -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                @if($activeTransactions->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($activeTransactions as $transaction)
                            <div class="bg-white border rounded-lg shadow-sm overflow-hidden">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            {{ $transaction->book->judul }}
                                        </h3>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Sedang Dipinjam
                                        </span>
                                    </div>
                                    
                                    <div class="space-y-2 text-sm text-gray-600">
                                        <p>No. Buku: {{ $transaction->book->book_code }}</p>
                                        <p>Tanggal Pinjam: {{ \Carbon\Carbon::parse($transaction->borrow_date)->format('d M Y H:i') }}</p>
                                        <p>Rencana Kembali: {{ \Carbon\Carbon::parse($transaction->return_date)->format('d M Y H:i') }}</p>
                                    </div>

                                    <form action="{{ route('member.return.store') }}" method="POST" class="mt-4">
                                        @csrf
                                        <input type="hidden" name="transaksi_id" value="{{ $transaction->id }}">
                                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                            Kembalikan Buku
                                        </button>
                                    </form>
                                    
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-gray-500 mb-4">Tidak ada buku yang sedang dipinjam</div>
                        <a href="{{ route('member.borrow.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                            Pinjam Buku
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection