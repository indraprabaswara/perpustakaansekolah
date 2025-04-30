@extends('layouts.member')

@section('title', 'Dashboard Member')

@section('content')
<div class="py-8 max-w-6xl mx-auto px-6">
    
   
    <div class="bg-gradient-to-r from-indigo-500 to-green-600 text-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-3xl font-semibold">Halo, {{ auth()->user()->name }}!</h2>
        <p class="mt-2 text-lg">NIK: {{ auth()->user()->nik }} | Jurusan: {{ auth()->user()->jurusan }} | Kelas: {{ auth()->user()->kelas }}</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
        @foreach([
            ['Peminjaman Buku', 'Ajukan peminjaman buku untuk keperluan baca buku.', 'member.borrow.index', 'bg-purple-600', 'Pinjam Sekarang'],
            ['Pengembalian Buku', 'Laporkan pengembalian buku.', 'member.return.index', 'bg-teal-600', 'Kembalikan Sekarang']
        ] as $action)
        <div class="p-6 rounded-lg shadow-md bg-white border border-gray-200">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $action[0] }}</h3>
            <p class="text-gray-600 mb-4">{{ $action[1] }}</p>
            <a href="{{ route($action[2]) }}" class="px-5 py-2 text-white font-semibold rounded-md {{ $action[3] }} hover:opacity-90">{{ $action[4] }}</a>
        </div>
        @endforeach
    </div>

   
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Peminjaman Aktif</h3>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        @foreach(['ID Transaksi', 'Buku', 'Tanggal Pinjam', 'Status'] as $header)
                            <th class="border border-gray-300 px-4 py-2 text-gray-700 text-left">{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($activeTransactions as $borrowing)
                        <tr class="border-t border-gray-300">
                            <td class="px-4 py-3">#{{ $borrowing->id }}</td>
                            <td class="px-4 py-3">{{ $borrowing->book->judul }} ({{ $borrowing->book->book_code }})</td>
                            <td class="px-4 py-3">{{ $borrowing->borrow_date->format('d M Y H:i') }}</td>
                            <td class="px-4 py-3">
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-200 text-yellow-800">{{ $borrowing->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-center text-gray-500">Tidak ada peminjaman aktif saat ini</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
