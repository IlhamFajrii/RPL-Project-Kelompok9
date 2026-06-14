@extends('layouts.app')

@section('title', 'Approval Peminjaman')
@section('page-title', 'Approval Peminjaman')

@section('content')
<div class="space-y-6">
    <!-- Filter Status -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="GET" action="{{ route('approval.index') }}" class="flex gap-4">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Semua Status --</option>
                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
                <option value="returned" @selected(request('status') === 'returned')>Returned</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-all">
                Filter
            </button>
            <a href="{{ route('approval.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded-lg hover:bg-gray-500">
                Reset
            </a>
        </form>
    </div>

    <!-- Peminjaman List -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($peminjaman as $item)
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $item->user->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $item->user->email }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    @if($item->status_approval === 'approved')
                        bg-green-100 text-green-700
                    @elseif($item->status_approval === 'pending')
                        bg-yellow-100 text-yellow-700
                    @elseif($item->status_approval === 'rejected')
                        bg-red-100 text-red-700
                    @else
                        bg-blue-100 text-blue-700
                    @endif
                ">
                    {{ ucfirst($item->status_approval) }}
                </span>
            </div>

            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                <p class="font-semibold text-gray-800">{{ $item->alat->nama_alat }}</p>
                <p class="text-sm text-gray-600">Kode: {{ $item->alat->kode_alat }}</p>
                <div class="grid grid-cols-2 gap-2 mt-3 text-sm">
                    <div>
                        <p class="text-gray-600">Tanggal Pinjam</p>
                        <p class="font-semibold">{{ $item->tanggal_pinjam->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Rencana Kembali</p>
                        <p class="font-semibold">{{ $item->tanggal_rencana_kembali->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            @if($item->status_approval === 'pending')
                <div class="flex gap-2 mb-4">
                    <button 
                        class="btn-approve flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 font-semibold text-sm"
                        data-id="{{ $item->id }}"
                    >
                        Setuju
                    </button>
                    <button 
                        class="btn-reject flex-1 bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 font-semibold text-sm"
                        data-id="{{ $item->id }}"
                    >
                        Tolak
                    </button>
                </div>
            @elseif($item->status_approval === 'approved' && !$item->tanggal_kembali)
                <button 
                    class="btn-return w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold text-sm mb-4"
                    data-id="{{ $item->id }}"
                >
                    Proses Pengembalian
                </button>
            @endif

            <a href="{{ route('approval.show', $item) }}" class="w-full text-center text-blue-600 font-semibold hover:underline text-sm">
                Lihat Detail →
            </a>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500 text-lg">Tidak ada peminjaman</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($peminjaman->hasPages())
        <div class="flex justify-center mt-8">
            {{ $peminjaman->links() }}
        </div>
    @endif
</div>

<script>
function approveModal(id) {
    if (confirm('Setuju dengan peminjaman ini?')) {
        fetch('/approval/' + id + '/approve', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(() => location.reload());
    }
}

function rejectModal(id) {
    const reason = prompt('Alasan penolakan:');
    if (reason) {
        fetch('/approval/' + id + '/reject', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ alasan_reject: reason })
        }).then(() => location.reload());
    }
}

function returnModal(id) {
    const date = prompt('Tanggal pengembalian (YYYY-MM-DD):', new Date().toISOString().split('T')[0]);
    if (date) {
        fetch('/approval/' + id + '/return', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ tanggal_kembali: date, catatan: '' })
        }).then(() => location.reload());
    }
}
</script>

@endsection
